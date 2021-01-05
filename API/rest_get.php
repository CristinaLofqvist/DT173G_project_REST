<?php

/*********************************************************************
 * Portfolio
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/

require('Handlers.php');



/* Headers to make webbservice available from all domains*/

header('Content-Type: application/json'); //this is a webbservice that sends and recieves data in JSON format
header('Access-Control-Allow-Origin: *'); // allows all domains to access this webbserver
header('Access-Control-Allow-Methods: GET'); // actively allowing methods delete and put
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
$method = $_SERVER['REQUEST_METHOD']; /*För variablen input och delete finns 
ingen färdig metod därför görs att: I variablen method lagras 
metoden som är medskickad i anropet till webbtjänsten.*/


$wph = new WpHandler();
$xh = new XpHandler();
$ch = new CourseHandler();
//$lh = new LoginHandler();
switch ($method) {
    case 'GET':
        $result = [];
        $webpages = $wph->getWp();
        $wp_result = [];
        $xp_result = [];
        $course_result = [];
        /*Control if result contains any rows*/
        if (sizeof($webpages) > 0) {
            
            http_response_code(200); //ok
            for ($i = 0; $i < count($webpages); $i++) {
                array_push($wp_result, $webpages[$i]->getWp());
            }
          
        } 
        $xp = $xh->getXp();

        /*Control if result contains any rows*/
        if (sizeof($xp) > 0) {
            http_response_code(200); //ok
         
            for ($i = 0; $i < count($xp); $i++) {
                array_push($xp_result, $xp[$i]->getXp());
            }
        } 
        $courses = $ch->getCourses();
        /*Control if result contains any rows*/
        if (sizeof($courses) > 0) {
            http_response_code(200); //ok
           
            for ($i = 0; $i < count($courses); $i++) {
                array_push($course_result, $courses[$i]->getCourse());
            }
        }
        array_push($result, $course_result);
        array_push($result, $xp_result);
        array_push($result, $wp_result);
        break;
}
/* return the result as JSON*/
echo json_encode($result);
?>