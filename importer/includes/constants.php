<?php
define('ASSEMBLY_PREFIX', '1.01_');
define('DB_ORGANISM_ID', '13');
define('DUMMY', 123);
define('CV_ANNOTATION_REPEATMASKER', DUMMY);
define('CV_ANNOTATION_INTERPRO', DUMMY);
define('CV_ANNOTATION_BLAST2GO', DUMMY);

define('CV_INTERPRO_ID', DUMMY);

define('CV_UNIGENE', 1080); #CVTERM 1080: "predicted gene" or 780: "gene_with_recorded_mRNA' ?
define('CV_ISOFORM', 2191); #CVTERM 2191: alternatively_spliced_transcript
define('CV_RELATIONSHIP_UNIGENE_ISOFORM', 962); #CVTERM 962: alternatively_spliced  

define('CV_ISOFORM_PATH', 775); #CVTERM 775: golden_path
define('CV_PREDPEP', 192);#CVTERM 192: polypeptide

#versions of databases for interpro import
global $dbrefx_versions;
$dbrefx_versions = array('HMMPIR' => '1.0');
?>
