<?php

/*********************************************************************
 * Portfolio
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/


class Webpage {
    private $url; 
    private $title; 
    private $desc; 
    public function __construct(string $url, string $title, string $desc) {
        $this->url=$url; 
        $this->title=$title;
        $this->desc=$desc;
    }

    /*getters*/

    public function getWp() {
       $page = (object)array();
       $page->url = $this->url;
       $page->title = $this->title;
       $page->desc = $this->desc;
       return $page;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getUrl(){
        return $this->url;
    }

    public function getDesc(){
        return $this->desc;
    }
    
    /*setters*/
    
    public function setTitle(string $title){
        $this->title = $title; 
    }
    public function setUrl(string $url){
        $this->url = $url;
    }
    public function setDesc(string $desc){
        $this->desc = $desc;
    }

    public function setWp(Webpage $wp){
        $this->setTitle($wp->getTitle());
        $this->setUrl($wp->getUrl());
        $this->setDesc($wp->getDesc());
    }
}
?>