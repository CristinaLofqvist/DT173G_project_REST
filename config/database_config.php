<?php
    $devMode=false;
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
        define ("DBHOST","localhost");
        define ("DBUSER","uhlbzpyg_dt173g");
        define ("DBPASS","~Z(8_}N0wB44");
        define ("DBDATABASE","uhlbzpyg_dt173gproject");
    }
?>
