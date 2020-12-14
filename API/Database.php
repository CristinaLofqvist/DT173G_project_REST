<?php

/*********************************************************************
 * Portfolio
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/

require('../config/database_config.php');

class Database
{
    /**
     * The mysqli connection itself
     */
    private $db;
    /**
     * Last result returnd from the function make_query
     */
    private $last_query_result;

    function __construct()
    {
        /**
         * Make a new connection to the sql database with 
         * arguments defined in ../config/database_config.php
         */

        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        //controll of connection
        if ($this->db->connect_error) {
            die("Conection failure!:" . $this->db->connect_error);
        }
    }


    /**
     * Implicit method to establish a connection
     * NOTE: $some_variable_name = new Database() does not
     * creat a connection before $some_variable_name->connect()
     * is called
     */
    public function connect()
    {

        /**
         * If a current connection is in use do nothing
         */

        if ($this->db->ping()) {
            /* do nothing*/
        } else {
            /**
             * Make a new connection to the sql database with 
             * arguments defined in ../config/database_config.php
             */
            $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

            //controll of connection
            if ($this->db->connect_error) {
                die("Conection failure!:" . $this->db->connect_error);
            }
        }

    }

    /**
     * Implicit method to disconnect the database
     * NOTE: if this method is not called e.i: 
     * $some_variable_name->disconnect()
     * the connection to the database (the real sql database)
     * is never closed
     */
    public function disconnect()
    {

        /* check if the connection is alive */
        if ($this->db->ping()) {
            /**do nothing */
        } else {
            printf("Error: %s\n", $this->db->error);
        }
        /*Close it */
        $this->db->close();
    }

    /**
     * Function to query the database (the real sql database)
     * query can be insert, select and so forth.
     * 
     * This function returns the result if there is any of
     * the made query
     * 
     * NOTE: if no current connection is in use this function
     * will create one so do not forget to call 
     * $some_variable_name->disconnect() when all queries are done
     * $some_variable_name->free_last_query_result() can also be called to ensure 
     * that memory does not run out
     */
    public function make_query(string $query)
    {

        if ($this->db->ping()) {
            /* do nothing*/
        } else {
            /**
             * Call connect method 
             * to establish a new connection
             */
            $this->connect();
            /**
             * Query the sql database
             */
        }
        $this->last_query_result = $this->db->query($query);
        return $this->last_query_result;
    }

    /**
     * Function that returns the last result given from the call of
     * $some_variable_name->make_query("<some query>")
     */
    public function get_last_query_result()
    {   

        return $this->last_query_result;
    }

    /**
     * Frees the memory allocated for the result returned from 
     * $some_variable_name->make_query("<some query>")
     * 
     * NOTE: to call this function is not neccessary. It
     * only needs to be called if you are concerned about 
     * how much memory is being used for queries that 
     * return large result sets.
     * All associated result memory is automatically freed 
     * at the end of the script's execution
     */
    public function free_last_query_result()
    {
        if(!empty($this->last_query_result)) {
            $this->last_query_result->free_result();
        }

    }
}
?>