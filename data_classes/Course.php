<?php

/*********************************************************************
 * Portfolio
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/


class Course {
    private $course_name; // course_name
    private $university; //univiresety
    private $start_date; //star_date
    private $end_date;//end_date

    public function __construct(string $university, string $course_name, string $start_date, string $end_date) {
        $this->course_name=$course_name; 
        $this->university=$university;
        $this->start_date=$start_date;
        $this->end_date=$end_date;
    }

    /*getters*/

    public function getCourse() {
       $course = (object)array();
       $course->course_name = $this->course_name;
       $course->university = $this->university;
       $course->start_date = $this->start_date;
       $course->end_date = $this->end_date;
       return $course;
    }

    public function getName(){
        return $this->course_name;
    }

    public function getUniv(){
        return $this->university;
    }

    public function getSdate(){
        return $this->start_date;
    }

    public function getEdate(){
        return $this->end_date;
    }
    
    /*setters*/
    
    public function setName(string $course_name){
        $this->course_name = $course_name; 
    }
    public function setUniv(string $university){
        $this->university = $university;
    }
    public function setSdate(string $start_date){
        $this->start_date = $start_date;
    }
    public function setEdate(string $end_date){
        $this->end_date = $end_date;
    }

    public function setCourse(Course $course){
        $this->setName($course->getName());
        $this->setUniv($course->getUniv());
        $this->setSdate($course->getSdate());
        $this->setEdate($course->getEdate());
    }
}
?>