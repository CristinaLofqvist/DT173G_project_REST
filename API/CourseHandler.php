<?php

/*********************************************************************
 * Portfolio 
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/

require('../data_classes/Course.php');


class CourseHandler
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

    public function getCourses()
    {

        /**
         * Open the connection to the sql database
         */
        $this->database->connect();

        /**
         * Initialize empty array to fill with Course objects
         * that will later be returned
         */
        $courses = [];

        /**
         * Query the sql database for everything regarding courses
         */
        $this->database->make_query("SELECT * FROM courses");

        /**
         * Parse result from query into Course objects and add the to the
         * $courses array
         */
        if ($this->database->get_last_query_result()->num_rows > 0) {
            while ($row = $this->database->get_last_query_result()->fetch_assoc()) {
                $course_name = $row['course_name'];
                $university = $row['university'];
                $start_date = $row['start_date'];
                $end_date = $row['end_date'];
                $course = new Course( $university,$course_name, $start_date, $end_date);
                array_push($courses, $course);
            }
            $this->database->free_last_query_result();
            $this->database->disconnect();
        }
        $this->last_retrieved_result = $courses;
        return $courses;
    }

    public function insertCourseByValues(string $course_name, string $university, string $start_date, string $end_date)
    {
        $this->database->connect();
        $this->last_retrieved_result = $this->database->make_query("INSERT INTO " .
         "`courses` (`course_name`, `university`, `start_date`, `end_date`)" . " VALUES (" . '"' .
            $course_name . '"' . "," . '"' . $university . '"' . "," . '"' .  $start_date . '"' . "," . '"' . $end_date . '"' . ")");
        $this->database->free_last_query_result();
        $this->database->disconnect();
        return true;
    }

    public function deleteCourse(string $course_name, bool $updateInternalCourseList, string $university ="")
    {
        $this->database->connect();
        $this->last_retrieved_result = $this->database->make_query("DELETE FROM courses WHERE course_name=" . '"' . $course_name . '" AND university=' . '"' . $university . '"');
        $this->database->free_last_query_result();
        if ($updateInternalCourseList) {
            $this->getCourses();
        }
        $this->database->disconnect();
        return true;
    }

    /*updates values to course*/
    public function updateCourseValues(
        string $course_nameToBeUpdated,
        string $universityToBeUpdated,
        string $newcourse_name = "",
        string $newuniversity = "",
        string $newstart_date = "",
        string $newend_date = ""
    ) {
        if (empty($course_nameToBeUpdated) && empty($univesityToBeUpdated)) {
            return false;
        }
        $field = 0;
        if (!empty($newcourse_name) && !empty($newuniversity) && !empty($newstart_date) && !empty($newend_date)) {
            $this->database->connect();
            $this->last_retrieved_result = $this->database->make_query(
                "UPDATE courses SET" .
                    " course_name=" . '"' . $newcourse_name . '",' .
                    " university=" . '"'.  $newuniversity .'",'.
                    " start_date=" . '"'. $newstart_date .'",'.
                    " end_date=" . '"'. $newend_date .'"'.
                    " WHERE course_name=" . '"'. $course_nameToBeUpdated .
                    '" AND university=' . '"' . $universityToBeUpdated . '"'
            );

            $this->database->free_last_query_result();
            $this->database->disconnect();

            return true;
        } else if (empty($newcourse_name) && empty($newuniversity) && !empty($newstart_date) && !empty($newend_date)) {
            $this->database->connect();
            $this->last_retrieved_result = $this->database->make_query(
                "UPDATE courses SET" .
                " start_date=" . '"'. $newstart_date .'",'.
                " end_date=" . '"'. $newend_date .'"'.
                " WHERE course_name=" . '"'. $course_nameToBeUpdated .
                '" AND university=' . '"' . $universityToBeUpdated . '"'
            );
            $this->database->free_last_query_result();
            $this->database->disconnect();
            return true;
        }
        return false;
    }
    public function toString() {
        return "CourseHandler";
    }
}
?>