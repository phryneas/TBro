<?php

namespace cli_import;
use \PDO;

require_once ROOT . 'classes/AbstractImporter.php';
require_once ROOT . 'commands/Importer_Sequence_Ids.php';

/**
 * importer for fasta files. created predicted peptides.
 */
class Importer_Sequences_FASTA extends AbstractImporter {

    /**
     * reads the next fasta sequence from file handle $fasta_handle and returns a list of description and sequence (without whitespace and newlines)
     * @param resource $fasta_handle
     * @return list($description,$sequence)
     * @throws ErrorException with ErrorMsg ERRCODE_ILLEGAL_FILE_FORMAT: next non-empty line has to start with '>'
     */
    static function read_fasta($fasta_handle) {
        $description = '';
        while (empty($description) && !feof($fasta_handle))
            $description = trim(fgets($fasta_handle));
        if (strpos($description, '>') !== 0)
            throw new ErrorException(ERR_ILLEGAL_FILE_FORMAT);


        $sequence = '';
        while (!feof($fasta_handle)) {
            $pos = ftell($fasta_handle);
            $line = fgets($fasta_handle);
            if (strpos($line, '>') === 0) {
                fseek($fasta_handle, $pos, SEEK_SET);
                break;
            }
            $sequence .= trim($line);
        }
        return array($description, $sequence);
    }

    /**
     * Converts values to String that would be stored as Name (Suffix of UniqueName) in DB
     * @param string $isoform_name
     * @param int $left
     * @param int $right
     * @param char $direction [+-]
     * @return string
     */
    static function prepare_predpep_name($isoform_name, $left, $right, $direction) {
        return $isoform_name . ':' . ($direction == '+' ? "$left-$right" : "$right-$left");
    }

    /**
     * @inheritDoc
     */
    static function import($options) {
        $filename = $options['file'];
        $lines_total = trim(`grep -c '>' $filename`);
        self::setLineCount($lines_total);

        global $db;
        $lines_imported = 0;
        $isoforms_updated = 0;
        $predpeps_added = 0;

        #pre-initialize variables to bind statement parameters
        $param_isoform_uniq = null;
        $param_isoform_seqlen = null;
        $param_isoform_residues = null;

        $param_predpep_name = null;
        $param_predpep_uniq = null;
        $param_predpep_seqlen = null;
        $param_predpep_residues = null;
        $param_predpep_feature_id = null;
        $param_predpep_fmin = null;
        $param_predpep_fmax = null;
        $param_predpep_strand = null;
        $param_predpep_srcfeature_uniq = null;

        try {
            $db->beginTransaction();
            $import_prefix_id = Importer_Sequence_Ids::get_import_dbxref();
            # prepare statements
            #
            #insert sequence into existing isoform
            $statement_update_isoform = $db->prepare('UPDATE feature SET (seqlen, residues) = (:seqlen, :residues) WHERE uniquename=:uniquename AND organism_id=:organism RETURNING feature_id');
            $statement_update_isoform->bindParam('uniquename', $param_isoform_uniq, PDO::PARAM_STR);
            $statement_update_isoform->bindParam('seqlen', $param_isoform_seqlen, PDO::PARAM_INT);
            $statement_update_isoform->bindParam('residues', $param_isoform_residues, PDO::PARAM_STR);
            $statement_update_isoform->bindValue('organism', DB_ORGANISM_ID, PDO::PARAM_INT);


            #create predicted peptide
            $statement_insert_predpep = $db->prepare('INSERT INTO feature  (type_id, organism_id, name, uniquename, seqlen, residues, dbxref_id) '
                    . 'VALUES (:type_id, :organism_id, :name, :uniquename, :seqlen, :residues, :dbxref_id) RETURNING feature_id');
            $statement_insert_predpep->bindValue('type_id', CV_PREDPEP, PDO::PARAM_INT);
            $statement_insert_predpep->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);
            $statement_insert_predpep->bindParam('name', $param_predpep_name, PDO::PARAM_STR);
            $statement_insert_predpep->bindParam('uniquename', $param_predpep_uniq, PDO::PARAM_STR);
            $statement_insert_predpep->bindParam('seqlen', $param_predpep_seqlen, PDO::PARAM_INT);
            $statement_insert_predpep->bindParam('residues', $param_predpep_residues, PDO::PARAM_STR);
            $statement_insert_predpep->bindValue('dbxref_id', $import_prefix_id, PDO::PARAM_INT);

            #link predpep to parent isoform
            $statement_insert_predpep_location = $db->prepare(sprintf('INSERT INTO featureloc (fmin, fmax, strand, feature_id, srcfeature_id) VALUES (:fmin, :fmax, :strand, :feature_id, (%s))', 'SELECT feature_id FROM feature WHERE uniquename=:srcfeature_uniquename LIMIT 1'));
            $statement_insert_predpep_location->bindParam('fmin', $param_predpep_fmin, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('fmax', $param_predpep_fmax, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('strand', $param_predpep_strand, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('feature_id', $param_predpep_feature_id, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('srcfeature_uniquename', $param_predpep_srcfeature_uniq, PDO::PARAM_STR);

            #read file and execute statements

            $file = fopen($filename, 'r');
            while (!feof($file)) {
                #read next fasta entry
                list($description, $sequence) = self::read_fasta($file);

                $matches = array();
                #predicted peptide header like this:
                #>m.1812924 g.1812924  ORF g.1812924 m.1812924 type:5prime_partial len:376 (+) comp224705_c0_seq18:3-1130(+)
                if (preg_match('/^>(?<id>[^\s]+) .* (?<name>[^\s]+):(?<from>\d+)-(?<to>\d+)\((?<dir>[+-])\)$/', $description, $matches)) {
                    $param_predpep_name = $matches['id'];
                    $param_predpep_uniq = IMPORT_PREFIX . "_" . self::prepare_predpep_name($matches['name'], $matches['from'], $matches['to'], $matches['dir']);
                    $param_predpep_seqlen = strlen($sequence);
                    $param_predpep_residues = $sequence;
                    //create predpep
                    $statement_insert_predpep->execute();
                    //link to parent feature
                    $param_predpep_feature_id = $statement_insert_predpep->fetchColumn();
                    $param_predpep_srcfeature_uniq = IMPORT_PREFIX . "_" . $matches['name'];
                    $param_predpep_fmin = min($matches['from'], $matches['to']);
                    $param_predpep_fmax = max($matches['from'], $matches['to']);
                    $param_predpep_strand = $matches['dir'] == '+' ? 1 : -1;
                    $statement_insert_predpep_location->execute();
                    $predpeps_added+=$statement_insert_predpep->rowCount();
                }

                #isoform header like this:
                #>comp173079_c0_seq1 len=2161 path=[2139:0-732 2872:733-733 2873:734-1159 3299:1160-1160 3300:1161-1513 3653:1514-1517 3657:1518-2160]
                else if (preg_match('/^>(?<name>[^\s]+) .*$/', $description, $matches)) {
                    $param_isoform_uniq = IMPORT_PREFIX . "_" . $matches['name'];
                    $param_isoform_seqlen = strlen($sequence);
                    $param_isoform_residues = $sequence;
                    //update isoform with values
                    $statement_update_isoform->execute();

                    $isoforms_updated+=$statement_update_isoform->rowCount();
                }


                self::updateProgress(++$lines_imported);
            }
            self::preCommitMsg();
            if (!$db->commit()) {
                $err = $db->errorInfo();
                throw new ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
            }
        } catch (\Exception $error) {
            $db->rollback();
            throw $error;
        }
        return array(LINES_IMPORTED => $lines_imported, 'isoforms_updated' => $isoforms_updated, 'predpeps_added' => $predpeps_added);
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return "Sequence File Importer";
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return 'sequences_fasta';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF
   
File Format has to be a typical fasta file.
isoform headers have to look like
>comp173079_c0_seq1 <comment>

predpep headers have to look like
>m.1812924 <comments> comp173079_c0_seq1:3-1130(+)

\033[0;31mThis import requires a successful Sequence ID Import for the isoforms that should be imported!\033[0m
EOF;
    }

}

?>