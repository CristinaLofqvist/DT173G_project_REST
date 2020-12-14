<?php require_once("configue.php");
/*********************************************************************
 * Portfolio
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/
?>

<?php
/*installing a new instance of mysqli*/
$db=new mysqli(DBHOST,DBUSER,DBPASS,DBDATABASE);
    if($db->connect_errno>0){
        die('fel vid anslutning ['. $db->connect_error. ']');
        exit();
    }

    $sql="DROP TABLE IF EXISTS courses;";
    $sql.="CREATE TABLE courses(
        university VARCHAR(255) NOT NULL, 
        course_name VARCHAR(255) NOT NULL, 
        start_date DATE NOT NULL,
        end_date DATE NOT NULL
        );";
        if($devMode) {
            echo "<pre>$sql<pre>";
        }

if ($db->multi_query($sql)){
    if($devMode) {
        echo "DB installed.";
    }
} else {
    if($devMode) {
        echo"DB installation error.";
    }
}
$db->close();/*closes the conection*/
?>