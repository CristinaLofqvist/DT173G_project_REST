<?php

/*********************************************************************
 * Portfolio 
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/

class LoginHandler {
    private $database;
    private $last_retrieved_result;

    function __construct() 
    {
         /*Initialize the class Database object*/
         $this->database = new Database();
    }

    public function getLastRetrievedResult()
    {
        return $this->last_retrieved_result;
    }

    public function login(string $email, string $password) {
        
        $this->database->connect();
        $this->database->make_query("SELECT id, first_name, last_name, password FROM " . "users" . " WHERE email = " . '"' . $email . '"' . " LIMIT 0,1");


        if ($this->database->get_last_query_result()->num_rows > 0) {
            $row = $this->database->get_last_query_result()->fetch_assoc();
            $id = $row['id'];
            $firstname = $row['first_name'];
            $lastname = $row['last_name'];
            $password2 = $row['password'];

            if($password == $password2)
            {
                session_start();
                $_SESSION["EMAIL"] = $email;
               
                return true;
            }
        }
        return false;
    }
    public function toString() {
        return "LoginHandler";
    }
}
