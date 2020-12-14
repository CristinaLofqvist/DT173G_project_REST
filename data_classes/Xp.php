<?php

/*********************************************************************
 * Portfolio
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/


class Xp {
    private $work_place; 
    private $position; 
    private $start_date; //star_date
    private $end_date;//end_date

    public function __construct(string $work_place, string $position, string $start_date, string $end_date) {
        $this->work_place=$work_place; 
        $this->position=$position;
        $this->start_date=$start_date;
        $this->end_date=$end_date;
    }

    /*getters*/

    public function getXp() {
       $xp = (object)array();
       $xp->work_place = $this->work_place;
       $xp->position = $this->position;
       $xp->start_date = $this->start_date;
       $xp->end_date = $this->end_date;
       return $xp;
    }

    public function getPlace(){
        return $this->work_place;
    }

    public function getPosit(){
        return $this->position;
    }

    public function getSdate(){
        return $this->start_date;
    }

    public function getEdate(){
        return $this->end_date;
    }
    
    /*setters*/
    
    public function setPlace(string $work_place){
        $this->work_place = $work_place; 
    }
    public function setPosit(string $position){
        $this->position = $position;
    }
    public function setSdate(string $start_date){
        $this->start_date = $start_date;
    }
    public function setEdate(string $end_date){
        $this->end_date = $end_date;
    }

    public function setXp(Xp $xp){
        $this->setPlace($xp->getPlace());
        $this->setPosit($xp->getPosit());
        $this->setSdate($xp->getSdate());
        $this->setEdate($xp->getEdate());
    }
}
?>