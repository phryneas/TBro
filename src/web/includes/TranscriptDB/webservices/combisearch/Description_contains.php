<?php

namespace webservices\combisearch;

use \PDO as PDO;

/**
 * WebService.
 * Searches for Features which description contains a phrase.
 */
class Description_contains extends \WebService {

    /**
     * @param $querydata[species] organism id
     * @param $querydata[release] release name
     * @param $querydata[term] term to search for
     * @returns array of feature ids
     */
    public function execute($querydata) {
        global $db;
        $constant = 'constant';

        $species = $querydata['species'];
        $release = $querydata['release'];

        $term = sprintf('%%%s%%', trim($querydata['term']));

        $query_get_features = <<<EOF
           
SELECT featureprop.feature_id 
    FROM 
        featureprop,
        (SELECT feature_id FROM feature WHERE feature.type_id={$constant('CV_ISOFORM')} AND feature.organism_id = :species AND feature.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id={$constant('DB_ID_IMPORTS')} AND accession=:release LIMIT 1)) as feature        
    WHERE 
        featureprop.type_id={$constant('CV_ANNOTATION_DESC')} 
        AND featureprop.value LIKE :term
        AND featureprop.feature_id = feature.feature_id
EOF;
        
//        $query = "SELECT name FROM feature WHERE id=?";
//        $stm = $db->prepare($query);
//        $stm->execute(array(12));

        $stm_get_features = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_features->execute(array(
            'term' => $term,
            'species' => $species,
            'release' => $release
        ));
        
        while ($row = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][] = $row['feature_id'];
        }

        return $data;
    }

}

?>
