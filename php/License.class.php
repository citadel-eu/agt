<?php

/**
 * The Licsense of the dataset
 */
class License {
    /*
     * Member variables are public in order
     * to be serialized properly by json_encode
     */

    public $href;
    public $term;

    /**
     * Creates a new instance of the License object
     * @param string $href
     * @param string $term
     */
    public function __construct($href, $term) {
        $this->href = $href;
        $this->term = $term;
    }

    /**
     * Saves the License instance to the database
     * @param int $datasetId the id of the dataset
     * @return true on success of false otherwise
     */
    public function save($datasetId) {
        $sql = "INSERT INTO licenses VALUES(null, :dataset_id, :href, :term)";
        $sqlParams = array(':dataset_id' => $datasetId,
            ':href' => $this->href,
            ':term' => $this->term);

        try {
            $sth = Database::$dbh->prepare($sql);
            $sth->execute($sqlParams);
        } catch (Exception $e) {
            if (DEBUG)
                $sth->debugDumpParams();
            Util::throwException(__FILE__, __LINE__, __METHOD__, "insert failed", $e->getMessage(), $e);
            return false;
        }
        return true;
    }

    /**
     * Fetches a license instance from database based on the dataset id
     * @param int $datasetId the id of the dataset
     * @return License|boolean a new License object or false if not found
     */
    public static function createFromDb($datasetId) {
        $sql = "SELECT * FROM licenses where dataset_id = :datasetId";
        $sqlParams[":datasetId"] = $datasetId;

        try {
            $sth = Database::$dbh->prepare($sql);
            $sth->execute($sqlParams);
            if ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
                return new License($result['href'], $result['term']);
            }
        } catch (Exception $e) {
            if (DEBUG)
                $sth->debugDumpParams();
            Util::throwException(__FILE__, __LINE__, __METHOD__, "select from licenses failed", $e->getMessage(), $e);
        }
        return false;
    }

    /**
     * Factory method that returns a new instance of License
     * @param array $assocArray an associative array representation of the object
     * @return License|boolean a License instance or false on failure
     */
    public static function createFromArray($assocArray) {
        if (isset($assocArray['href']) && isset($assocArray['term']))
            return new License($assocArray['href'], $assocArray['term']);
        return false;
    }

}

?>