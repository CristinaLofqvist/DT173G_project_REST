<?php

/*********************************************************************
 * Portfolio 
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/

require('../data_classes/Xp.php');

class XpHandler
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

    public function getXp()
    {
        /**
         * Open the connection to the sql database
         */
        $this->database->connect();
        /**
         * Initialize empty array to fill with Xp objects
         * that will later be returned
         */
        $experiences = [];

        /**
         * Query the sql database for everything regarding experiences
         */
        $this->database->make_query("SELECT * FROM experience");

        /**
         * Parse result from query into Xp objects and add the to the
         * $experience array
         */
        if ($this->database->get_last_query_result()->num_rows > 0) {
            while ($row = $this->database->get_last_query_result()->fetch_assoc()) {
                $work_place = $row['workplace'];
                $position = $row['position'];
                $start_date = $row['start_date'];
                $end_date = $row['end_date'];
                $experience = new Xp($work_place, $position, $start_date, $end_date);
                array_push($experiences, $experience);
            }
            

        }
        $this->database->free_last_query_result();
        $this->database->disconnect();
        $this->last_retrieved_result = $experiences;
        return $experiences;
    }

    public function insertXpByValues(string $work_place, string $position, string $start_date, string $end_date)
    {
        $this->database->connect();
        $this->last_retrieved_result = $this->database->make_query("INSERT INTO " .
         "`experience` (`workplace`, `position`, `start_date`, `end_date`)" . " VALUES (" . '"' .
            $work_place . '"' . "," . '"' . $position . '"' . "," . '"' .  $start_date . '"' . "," . '"' . $end_date . '"' . ")");
        $this->database->free_last_query_result();
        $this->database->disconnect();
        return true;
    }

    public function deleteXp(string $work_place, bool $updateInternalXpList, string $position ="")
    {
        $this->database->connect();
        $this->last_retrieved_result = $this->database->make_query("DELETE FROM experience WHERE workplace=" . '"' . $work_place . '" AND position=' . '"' . $position . '"');
        $this->database->free_last_query_result();
        if ($updateInternalXpList) {
            $this->getXp();
        }
        $this->database->disconnect();
        return $this->getLastRetrievedResult();
    }

    /*updates values to course*/
    public function updateXpByValues(
        string $workplaceToBeUpdated,
        string $positionToBeUpdated,
        string $newPosition = "",
        string $newWorkplace = "",
        string $newstart_date = "",
        string $newend_date = ""
    ) {
        if (empty($workplaceToBeUpdated) && empty($positionToBeUpdated)) {
            return false;
        }
        $field = 0;
        if (!empty($newPosition) && !empty($newWorkplace) && !empty($newstart_date) && !empty($newend_date)) {
            $this->database->connect();
            $this->last_retrieved_result = $this->database->make_query(
                "UPDATE experience SET" .
                    " workplace=" . '"' . $newWorkplace . '",' .
                    " position=" . '"'.  $newPosition .'",'.
                    " start_date=" . '"'. $newstart_date .'",'.
                    " end_date=" . '"'. $newend_date .'"'.
                    " WHERE position=" . '"'. $positionToBeUpdated .
                    '" AND workplace=' . '"' . $workplaceToBeUpdated . '"'
            );

            $this->database->free_last_query_result();
            $this->database->disconnect();
            return true;
        } else if (empty($newPosition) && empty($newWorkplace) && !empty($newstart_date) && !empty($newend_date)) {
            $this->database->connect();
            $this->last_retrieved_result = $this->database->make_query(
                "UPDATE experience SET" .
                " start_date=" . '"'. $newstart_date .'",'.
                " end_date=" . '"'. $newend_date .'"'.
                " WHERE position=" . '"'. $positionToBeUpdated .
                '" AND workplace=' . '"' . $workplaceToBeUpdated . '"'
            );
            $this->database->free_last_query_result();
            $this->database->disconnect();
            return true;
        }
        return false;
    }
    public function toString() {
        return "XpHandler";
    }
}
?>