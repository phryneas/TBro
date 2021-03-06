<?php

namespace cli_db\propel\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use cli_db\propel\BiomaterialRelationship;
use cli_db\propel\Biomaterialprop;
use cli_db\propel\Contact;
use cli_db\propel\Cv;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermPeer;
use cli_db\propel\CvtermQuery;
use cli_db\propel\Feature;
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermprop;
use cli_db\propel\Protocol;
use cli_db\propel\Pub;
use cli_db\propel\PubRelationship;
use cli_db\propel\Pubprop;
use cli_db\propel\Synonym;

/**
 * Base class that represents a query for the 'cvterm' table.
 *
 *
 *
 * @method CvtermQuery orderByCvtermId($order = Criteria::ASC) Order by the cvterm_id column
 * @method CvtermQuery orderByCvId($order = Criteria::ASC) Order by the cv_id column
 * @method CvtermQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method CvtermQuery orderByDefinition($order = Criteria::ASC) Order by the definition column
 * @method CvtermQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 * @method CvtermQuery orderByIsObsolete($order = Criteria::ASC) Order by the is_obsolete column
 * @method CvtermQuery orderByIsRelationshiptype($order = Criteria::ASC) Order by the is_relationshiptype column
 *
 * @method CvtermQuery groupByCvtermId() Group by the cvterm_id column
 * @method CvtermQuery groupByCvId() Group by the cv_id column
 * @method CvtermQuery groupByName() Group by the name column
 * @method CvtermQuery groupByDefinition() Group by the definition column
 * @method CvtermQuery groupByDbxrefId() Group by the dbxref_id column
 * @method CvtermQuery groupByIsObsolete() Group by the is_obsolete column
 * @method CvtermQuery groupByIsRelationshiptype() Group by the is_relationshiptype column
 *
 * @method CvtermQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CvtermQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CvtermQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CvtermQuery leftJoinCv($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cv relation
 * @method CvtermQuery rightJoinCv($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cv relation
 * @method CvtermQuery innerJoinCv($relationAlias = null) Adds a INNER JOIN clause to the query using the Cv relation
 *
 * @method CvtermQuery leftJoinBiomaterialRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the BiomaterialRelationship relation
 * @method CvtermQuery rightJoinBiomaterialRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BiomaterialRelationship relation
 * @method CvtermQuery innerJoinBiomaterialRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the BiomaterialRelationship relation
 *
 * @method CvtermQuery leftJoinBiomaterialprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biomaterialprop relation
 * @method CvtermQuery rightJoinBiomaterialprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biomaterialprop relation
 * @method CvtermQuery innerJoinBiomaterialprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Biomaterialprop relation
 *
 * @method CvtermQuery leftJoinContact($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contact relation
 * @method CvtermQuery rightJoinContact($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contact relation
 * @method CvtermQuery innerJoinContact($relationAlias = null) Adds a INNER JOIN clause to the query using the Contact relation
 *
 * @method CvtermQuery leftJoinFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Feature relation
 * @method CvtermQuery rightJoinFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Feature relation
 * @method CvtermQuery innerJoinFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Feature relation
 *
 * @method CvtermQuery leftJoinFeatureCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvterm relation
 * @method CvtermQuery rightJoinFeatureCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvterm relation
 * @method CvtermQuery innerJoinFeatureCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvterm relation
 *
 * @method CvtermQuery leftJoinFeatureCvtermprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvtermprop relation
 * @method CvtermQuery rightJoinFeatureCvtermprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvtermprop relation
 * @method CvtermQuery innerJoinFeatureCvtermprop($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvtermprop relation
 *
 * @method CvtermQuery leftJoinProtocol($relationAlias = null) Adds a LEFT JOIN clause to the query using the Protocol relation
 * @method CvtermQuery rightJoinProtocol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Protocol relation
 * @method CvtermQuery innerJoinProtocol($relationAlias = null) Adds a INNER JOIN clause to the query using the Protocol relation
 *
 * @method CvtermQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method CvtermQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method CvtermQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method CvtermQuery leftJoinPubRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the PubRelationship relation
 * @method CvtermQuery rightJoinPubRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PubRelationship relation
 * @method CvtermQuery innerJoinPubRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the PubRelationship relation
 *
 * @method CvtermQuery leftJoinPubprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pubprop relation
 * @method CvtermQuery rightJoinPubprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pubprop relation
 * @method CvtermQuery innerJoinPubprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Pubprop relation
 *
 * @method CvtermQuery leftJoinSynonym($relationAlias = null) Adds a LEFT JOIN clause to the query using the Synonym relation
 * @method CvtermQuery rightJoinSynonym($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Synonym relation
 * @method CvtermQuery innerJoinSynonym($relationAlias = null) Adds a INNER JOIN clause to the query using the Synonym relation
 *
 * @method Cvterm findOne(PropelPDO $con = null) Return the first Cvterm matching the query
 * @method Cvterm findOneOrCreate(PropelPDO $con = null) Return the first Cvterm matching the query, or a new Cvterm object populated from the query conditions when no match is found
 *
 * @method Cvterm findOneByCvId(int $cv_id) Return the first Cvterm filtered by the cv_id column
 * @method Cvterm findOneByName(string $name) Return the first Cvterm filtered by the name column
 * @method Cvterm findOneByDefinition(string $definition) Return the first Cvterm filtered by the definition column
 * @method Cvterm findOneByDbxrefId(int $dbxref_id) Return the first Cvterm filtered by the dbxref_id column
 * @method Cvterm findOneByIsObsolete(int $is_obsolete) Return the first Cvterm filtered by the is_obsolete column
 * @method Cvterm findOneByIsRelationshiptype(int $is_relationshiptype) Return the first Cvterm filtered by the is_relationshiptype column
 *
 * @method array findByCvtermId(int $cvterm_id) Return Cvterm objects filtered by the cvterm_id column
 * @method array findByCvId(int $cv_id) Return Cvterm objects filtered by the cv_id column
 * @method array findByName(string $name) Return Cvterm objects filtered by the name column
 * @method array findByDefinition(string $definition) Return Cvterm objects filtered by the definition column
 * @method array findByDbxrefId(int $dbxref_id) Return Cvterm objects filtered by the dbxref_id column
 * @method array findByIsObsolete(int $is_obsolete) Return Cvterm objects filtered by the is_obsolete column
 * @method array findByIsRelationshiptype(int $is_relationshiptype) Return Cvterm objects filtered by the is_relationshiptype column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseCvtermQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCvtermQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Cvterm', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CvtermQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CvtermQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CvtermQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CvtermQuery) {
            return $criteria;
        }
        $query = new CvtermQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Cvterm|Cvterm[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CvtermPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Cvterm A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByCvtermId($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Cvterm A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "cvterm_id", "cv_id", "name", "definition", "dbxref_id", "is_obsolete", "is_relationshiptype" FROM "cvterm" WHERE "cvterm_id" = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Cvterm();
            $obj->hydrate($row);
            CvtermPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Cvterm|Cvterm[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Cvterm[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CvtermPeer::CVTERM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CvtermPeer::CVTERM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the cvterm_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCvtermId(1234); // WHERE cvterm_id = 1234
     * $query->filterByCvtermId(array(12, 34)); // WHERE cvterm_id IN (12, 34)
     * $query->filterByCvtermId(array('min' => 12)); // WHERE cvterm_id >= 12
     * $query->filterByCvtermId(array('max' => 12)); // WHERE cvterm_id <= 12
     * </code>
     *
     * @param     mixed $cvtermId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByCvtermId($cvtermId = null, $comparison = null)
    {
        if (is_array($cvtermId)) {
            $useMinMax = false;
            if (isset($cvtermId['min'])) {
                $this->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cvtermId['max'])) {
                $this->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermId, $comparison);
    }

    /**
     * Filter the query on the cv_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCvId(1234); // WHERE cv_id = 1234
     * $query->filterByCvId(array(12, 34)); // WHERE cv_id IN (12, 34)
     * $query->filterByCvId(array('min' => 12)); // WHERE cv_id >= 12
     * $query->filterByCvId(array('max' => 12)); // WHERE cv_id <= 12
     * </code>
     *
     * @see       filterByCv()
     *
     * @param     mixed $cvId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByCvId($cvId = null, $comparison = null)
    {
        if (is_array($cvId)) {
            $useMinMax = false;
            if (isset($cvId['min'])) {
                $this->addUsingAlias(CvtermPeer::CV_ID, $cvId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cvId['max'])) {
                $this->addUsingAlias(CvtermPeer::CV_ID, $cvId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermPeer::CV_ID, $cvId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CvtermPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the definition column
     *
     * Example usage:
     * <code>
     * $query->filterByDefinition('fooValue');   // WHERE definition = 'fooValue'
     * $query->filterByDefinition('%fooValue%'); // WHERE definition LIKE '%fooValue%'
     * </code>
     *
     * @param     string $definition The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByDefinition($definition = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($definition)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $definition)) {
                $definition = str_replace('*', '%', $definition);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CvtermPeer::DEFINITION, $definition, $comparison);
    }

    /**
     * Filter the query on the dbxref_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDbxrefId(1234); // WHERE dbxref_id = 1234
     * $query->filterByDbxrefId(array(12, 34)); // WHERE dbxref_id IN (12, 34)
     * $query->filterByDbxrefId(array('min' => 12)); // WHERE dbxref_id >= 12
     * $query->filterByDbxrefId(array('max' => 12)); // WHERE dbxref_id <= 12
     * </code>
     *
     * @param     mixed $dbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(CvtermPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(CvtermPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermPeer::DBXREF_ID, $dbxrefId, $comparison);
    }

    /**
     * Filter the query on the is_obsolete column
     *
     * Example usage:
     * <code>
     * $query->filterByIsObsolete(1234); // WHERE is_obsolete = 1234
     * $query->filterByIsObsolete(array(12, 34)); // WHERE is_obsolete IN (12, 34)
     * $query->filterByIsObsolete(array('min' => 12)); // WHERE is_obsolete >= 12
     * $query->filterByIsObsolete(array('max' => 12)); // WHERE is_obsolete <= 12
     * </code>
     *
     * @param     mixed $isObsolete The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByIsObsolete($isObsolete = null, $comparison = null)
    {
        if (is_array($isObsolete)) {
            $useMinMax = false;
            if (isset($isObsolete['min'])) {
                $this->addUsingAlias(CvtermPeer::IS_OBSOLETE, $isObsolete['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isObsolete['max'])) {
                $this->addUsingAlias(CvtermPeer::IS_OBSOLETE, $isObsolete['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermPeer::IS_OBSOLETE, $isObsolete, $comparison);
    }

    /**
     * Filter the query on the is_relationshiptype column
     *
     * Example usage:
     * <code>
     * $query->filterByIsRelationshiptype(1234); // WHERE is_relationshiptype = 1234
     * $query->filterByIsRelationshiptype(array(12, 34)); // WHERE is_relationshiptype IN (12, 34)
     * $query->filterByIsRelationshiptype(array('min' => 12)); // WHERE is_relationshiptype >= 12
     * $query->filterByIsRelationshiptype(array('max' => 12)); // WHERE is_relationshiptype <= 12
     * </code>
     *
     * @param     mixed $isRelationshiptype The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByIsRelationshiptype($isRelationshiptype = null, $comparison = null)
    {
        if (is_array($isRelationshiptype)) {
            $useMinMax = false;
            if (isset($isRelationshiptype['min'])) {
                $this->addUsingAlias(CvtermPeer::IS_RELATIONSHIPTYPE, $isRelationshiptype['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isRelationshiptype['max'])) {
                $this->addUsingAlias(CvtermPeer::IS_RELATIONSHIPTYPE, $isRelationshiptype['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermPeer::IS_RELATIONSHIPTYPE, $isRelationshiptype, $comparison);
    }

    /**
     * Filter the query by a related Cv object
     *
     * @param   Cv|PropelObjectCollection $cv The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCv($cv, $comparison = null)
    {
        if ($cv instanceof Cv) {
            return $this
                ->addUsingAlias(CvtermPeer::CV_ID, $cv->getCvId(), $comparison);
        } elseif ($cv instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CvtermPeer::CV_ID, $cv->toKeyValue('PrimaryKey', 'CvId'), $comparison);
        } else {
            throw new PropelException('filterByCv() only accepts arguments of type Cv or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Cv relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCv($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Cv');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Cv');
        }

        return $this;
    }

    /**
     * Use the Cv relation Cv object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvQuery A secondary query class using the current class as primary query
     */
    public function useCvQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCv($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cv', '\cli_db\propel\CvQuery');
    }

    /**
     * Filter the query by a related BiomaterialRelationship object
     *
     * @param   BiomaterialRelationship|PropelObjectCollection $biomaterialRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterialRelationship($biomaterialRelationship, $comparison = null)
    {
        if ($biomaterialRelationship instanceof BiomaterialRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $biomaterialRelationship->getTypeId(), $comparison);
        } elseif ($biomaterialRelationship instanceof PropelObjectCollection) {
            return $this
                ->useBiomaterialRelationshipQuery()
                ->filterByPrimaryKeys($biomaterialRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiomaterialRelationship() only accepts arguments of type BiomaterialRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BiomaterialRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinBiomaterialRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BiomaterialRelationship');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'BiomaterialRelationship');
        }

        return $this;
    }

    /**
     * Use the BiomaterialRelationship relation BiomaterialRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\BiomaterialRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useBiomaterialRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiomaterialRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BiomaterialRelationship', '\cli_db\propel\BiomaterialRelationshipQuery');
    }

    /**
     * Filter the query by a related Biomaterialprop object
     *
     * @param   Biomaterialprop|PropelObjectCollection $biomaterialprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterialprop($biomaterialprop, $comparison = null)
    {
        if ($biomaterialprop instanceof Biomaterialprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $biomaterialprop->getTypeId(), $comparison);
        } elseif ($biomaterialprop instanceof PropelObjectCollection) {
            return $this
                ->useBiomaterialpropQuery()
                ->filterByPrimaryKeys($biomaterialprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiomaterialprop() only accepts arguments of type Biomaterialprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Biomaterialprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinBiomaterialprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Biomaterialprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Biomaterialprop');
        }

        return $this;
    }

    /**
     * Use the Biomaterialprop relation Biomaterialprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\BiomaterialpropQuery A secondary query class using the current class as primary query
     */
    public function useBiomaterialpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiomaterialprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Biomaterialprop', '\cli_db\propel\BiomaterialpropQuery');
    }

    /**
     * Filter the query by a related Contact object
     *
     * @param   Contact|PropelObjectCollection $contact  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContact($contact, $comparison = null)
    {
        if ($contact instanceof Contact) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $contact->getTypeId(), $comparison);
        } elseif ($contact instanceof PropelObjectCollection) {
            return $this
                ->useContactQuery()
                ->filterByPrimaryKeys($contact->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContact() only accepts arguments of type Contact or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Contact relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinContact($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Contact');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Contact');
        }

        return $this;
    }

    /**
     * Use the Contact relation Contact object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ContactQuery A secondary query class using the current class as primary query
     */
    public function useContactQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinContact($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contact', '\cli_db\propel\ContactQuery');
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeature($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $feature->getTypeId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            return $this
                ->useFeatureQuery()
                ->filterByPrimaryKeys($feature->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeature() only accepts arguments of type Feature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Feature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinFeature($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Feature');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Feature');
        }

        return $this;
    }

    /**
     * Use the Feature relation Feature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureQuery A secondary query class using the current class as primary query
     */
    public function useFeatureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Feature', '\cli_db\propel\FeatureQuery');
    }

    /**
     * Filter the query by a related FeatureCvterm object
     *
     * @param   FeatureCvterm|PropelObjectCollection $featureCvterm  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvterm($featureCvterm, $comparison = null)
    {
        if ($featureCvterm instanceof FeatureCvterm) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $featureCvterm->getCvtermId(), $comparison);
        } elseif ($featureCvterm instanceof PropelObjectCollection) {
            return $this
                ->useFeatureCvtermQuery()
                ->filterByPrimaryKeys($featureCvterm->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureCvterm() only accepts arguments of type FeatureCvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvterm relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinFeatureCvterm($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvterm');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'FeatureCvterm');
        }

        return $this;
    }

    /**
     * Use the FeatureCvterm relation FeatureCvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvterm($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvterm', '\cli_db\propel\FeatureCvtermQuery');
    }

    /**
     * Filter the query by a related FeatureCvtermprop object
     *
     * @param   FeatureCvtermprop|PropelObjectCollection $featureCvtermprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvtermprop($featureCvtermprop, $comparison = null)
    {
        if ($featureCvtermprop instanceof FeatureCvtermprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $featureCvtermprop->getTypeId(), $comparison);
        } elseif ($featureCvtermprop instanceof PropelObjectCollection) {
            return $this
                ->useFeatureCvtermpropQuery()
                ->filterByPrimaryKeys($featureCvtermprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureCvtermprop() only accepts arguments of type FeatureCvtermprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvtermprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinFeatureCvtermprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvtermprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'FeatureCvtermprop');
        }

        return $this;
    }

    /**
     * Use the FeatureCvtermprop relation FeatureCvtermprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermpropQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvtermprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvtermprop', '\cli_db\propel\FeatureCvtermpropQuery');
    }

    /**
     * Filter the query by a related Protocol object
     *
     * @param   Protocol|PropelObjectCollection $protocol  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProtocol($protocol, $comparison = null)
    {
        if ($protocol instanceof Protocol) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $protocol->getTypeId(), $comparison);
        } elseif ($protocol instanceof PropelObjectCollection) {
            return $this
                ->useProtocolQuery()
                ->filterByPrimaryKeys($protocol->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProtocol() only accepts arguments of type Protocol or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Protocol relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinProtocol($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Protocol');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Protocol');
        }

        return $this;
    }

    /**
     * Use the Protocol relation Protocol object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProtocolQuery A secondary query class using the current class as primary query
     */
    public function useProtocolQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProtocol($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Protocol', '\cli_db\propel\ProtocolQuery');
    }

    /**
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $pub->getTypeId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            return $this
                ->usePubQuery()
                ->filterByPrimaryKeys($pub->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPub() only accepts arguments of type Pub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinPub($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pub');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Pub');
        }

        return $this;
    }

    /**
     * Use the Pub relation Pub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubQuery A secondary query class using the current class as primary query
     */
    public function usePubQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pub', '\cli_db\propel\PubQuery');
    }

    /**
     * Filter the query by a related PubRelationship object
     *
     * @param   PubRelationship|PropelObjectCollection $pubRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPubRelationship($pubRelationship, $comparison = null)
    {
        if ($pubRelationship instanceof PubRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $pubRelationship->getTypeId(), $comparison);
        } elseif ($pubRelationship instanceof PropelObjectCollection) {
            return $this
                ->usePubRelationshipQuery()
                ->filterByPrimaryKeys($pubRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPubRelationship() only accepts arguments of type PubRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PubRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinPubRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PubRelationship');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PubRelationship');
        }

        return $this;
    }

    /**
     * Use the PubRelationship relation PubRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubRelationshipQuery A secondary query class using the current class as primary query
     */
    public function usePubRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPubRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PubRelationship', '\cli_db\propel\PubRelationshipQuery');
    }

    /**
     * Filter the query by a related Pubprop object
     *
     * @param   Pubprop|PropelObjectCollection $pubprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPubprop($pubprop, $comparison = null)
    {
        if ($pubprop instanceof Pubprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $pubprop->getTypeId(), $comparison);
        } elseif ($pubprop instanceof PropelObjectCollection) {
            return $this
                ->usePubpropQuery()
                ->filterByPrimaryKeys($pubprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPubprop() only accepts arguments of type Pubprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pubprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinPubprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pubprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Pubprop');
        }

        return $this;
    }

    /**
     * Use the Pubprop relation Pubprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubpropQuery A secondary query class using the current class as primary query
     */
    public function usePubpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPubprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pubprop', '\cli_db\propel\PubpropQuery');
    }

    /**
     * Filter the query by a related Synonym object
     *
     * @param   Synonym|PropelObjectCollection $synonym  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySynonym($synonym, $comparison = null)
    {
        if ($synonym instanceof Synonym) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $synonym->getTypeId(), $comparison);
        } elseif ($synonym instanceof PropelObjectCollection) {
            return $this
                ->useSynonymQuery()
                ->filterByPrimaryKeys($synonym->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySynonym() only accepts arguments of type Synonym or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Synonym relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinSynonym($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Synonym');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Synonym');
        }

        return $this;
    }

    /**
     * Use the Synonym relation Synonym object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\SynonymQuery A secondary query class using the current class as primary query
     */
    public function useSynonymQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSynonym($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Synonym', '\cli_db\propel\SynonymQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Cvterm $cvterm Object to remove from the list of results
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function prune($cvterm = null)
    {
        if ($cvterm) {
            $this->addUsingAlias(CvtermPeer::CVTERM_ID, $cvterm->getCvtermId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
