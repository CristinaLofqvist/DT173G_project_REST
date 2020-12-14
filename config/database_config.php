<?php
    $devMode=true;
    session_start();
    //Enable error reporting
    error_reporting(-0);//Report all detected errors
    ini_set("display_errors",1);//Display all errors

    /*********************************************************************
 * Portfolio
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/


    if ($devMode){
    /*DB settings (localHost) */
        define ("DBHOST","localhost");
        define ("DBUSER","dt173g");
        define ("DBPASS","pass");
        define ("DBDATABASE","DT173GProject");
    } else {
        /*DB settings (miunserver) */
        define ("DBHOST","studentmysql.miun.se");
        define ("DBUSER","crlo1900");
        define ("DBPASS","glw52zrb");
        define ("DBDATABASE","crlo1900");
    }
?>
