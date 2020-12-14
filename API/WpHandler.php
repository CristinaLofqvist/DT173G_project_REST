<?php

/*********************************************************************
 * Portfolio 
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/

require('../data_classes/Webpage.php');

class WpHandler
{
    private $database;
    private $last_retrieved_result;

    public function __construct()
    {
        /*Initialize the class Database object*/
        $this->database = new Database();
    }

    public function getLastRetrievedResult()
    {
        return $this->last_retrieved_result;
    }

    public function getWp()
    {
        /**
         * Open the connection to the sql database
         */
        $this->database->connect();
        /**
         * Initialize empty array to fill with Webpage objects
         * that will later be returned
         */
        $webpages = [];

        /**
         * Query the sql database for everything regarding Webpages
         */
        $this->database->make_query("SELECT * FROM webpages");

        /**
         * Parse result from query into Webpage objects and add the to the
         * $webpages array
         */
        if ($this->database->get_last_query_result()->num_rows > 0) {
            while ($row = $this->database->get_last_query_result()->fetch_assoc()) {
                $title = $row['title'];
                $url = $row['url'];
                $desc = $row['description'];
                $webpage = new Webpage($url, $title, $desc);
                array_push($webpages, $webpage);
            }

        }
        $this->database->free_last_query_result();
        $this->database->disconnect();
        $this->last_retrieved_result = $webpages;
        return $webpages;
    }

    public function insertWebpageByValues(string $title, string $url, string $desc)
    {
        $this->database->connect();
        $this->last_retrieved_result = $this->database->make_query("INSERT INTO" .
         "`webpages` (`title`, `url`, `description`)" . " VALUES (" . '"' .
            $title . '"' . "," . '"' . $url . '"' . "," . '"' .  $desc . '"' . ")");
        $this->database->free_last_query_result();
        $this->database->disconnect();
        return true;
    }

    public function deleteWp(string $title, bool $updateInternalWpList, string $url ="")
    {
        $this->database->connect();
        $this->last_retrieved_result = $this->database->make_query("DELETE FROM webpages WHERE title=" . '"' . $title . '" AND url=' . '"' . $url . '"');
        $this->database->free_last_query_result();
        if ($updateInternalWpList) {
            $this->getWp();
        }
        $this->database->disconnect();
        return true;
    }

    /*updates values to course*/
    public function updateWpByValues(
        string $titleToBeUpdated,
        string $urlToBeUpdated,
        string $newTitle = "",
        string $newUrl = "",
        string $newDesc = ""
    ) {
        if (empty($url) && empty($titleToBeUpdated)) {
            return false;
        }
        $field = 0;
        if (!empty($newTitle) && !empty($newUrl) && !empty($newDesc)) {
            $this->database->connect();
            $this->last_retrieved_result = $this->database->make_query(
                "UPDATE webpages SET" .
                    " url=" . '"' . $newUrl . '",' .  
                    " title=" . '"'.  $newTitle .'",'.
                    " description=" . '"'.  $newDesc .'"'.
                    " WHERE title=" . '"'. $titleToBeUpdated .
                    '" AND url=' . '"' . $urlToBeUpdated . '"'
            );

            $this->database->free_last_query_result();
            $this->database->disconnect();

            return true;
        } else if (empty($newTitle) && empty($newUrl) && !empty($newDesc)) {
            $this->database->connect();
            $this->last_retrieved_result = $this->database->make_query(
                "UPDATE webpages SET" .
                " description=" . '"'. $newDesc .'",'.
                " WHERE title=" . '"'. $titleToBeUpdated .
                '" AND url=' . '"' . $urlToBeUpdated . '"'
            );
            $this->database->free_last_query_result();
            $this->database->disconnect();
            return true;
        }
        return false;
    }
    public function toString() {
        return "WpHandler";
    }
}
?>