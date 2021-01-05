<?php

/*********************************************************************
 * Portfolio
 * Written by Cristina Löfqvist/ Mid Swewden University in Oct-2020.
 *********************************************************************/
require('Handlers.php');


/* Headers to make webbservice available from all domains*/

header('Content-Type: application/json'); //this is a webbservice that sends and recieves data in JSON format
header('Access-Control-Allow-Origin: *'); // allows all domains to access this webbserver
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE'); // actively allowing methods delete and put
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$method = $_SERVER['REQUEST_METHOD']; /*För variablen input och delete finns 
ingen färdig metod därför görs att: I variablen method lagras 
metoden som är medskickad i anropet till webbtjänsten.*/


$ch = new CourseHandler();
//$lh = new LoginHandler();

switch ($method) {
    case 'GET':

        $courses = $ch->getCourses();
        /*Control if result contains any rows*/
        if (sizeof($courses) > 0) {
            http_response_code(200); //ok
            $result = [];
            for ($i = 0; $i < count($courses); $i++) {
                array_push($result, $courses[$i]->getCourse());
            }
        } else {
            http_response_code(404); //Not found
            $result = array("message" => "No courses found");
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
         //echo json_encode(array("message" => $email));
          //echo json_encode(array("message" => $_SESSION["EMAIL"]));
            /*function to create row*/
            $test = $ch->insertCourseByValues($data->course_name, $data->university, $data->start_date, $data->end_date);
            if ($test) {
                http_response_code(201); //created
                $result = array("message" => "Course created");
            } else {
                http_response_code(503); /* server error */
                $result = array("message" => "Course not created");
            }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input")); /*"data" is a json object that is reieved from the front end when it does a put request.*/
         
         //echo json_encode(array("message" => $email));
          //echo json_encode(array("message" => $_SESSION["EMAIL"]));
            /*If no code is sent, send error*/
            if (empty($data->course_name) && empty($data->university)) {
                http_response_code(510); /* Not extended */
                $result = array("message" => "No key is sent");
            } else {
                /* function to update a row */
                if ($ch->updateCourseValues($data->course_name, $data->university, $data->new_course_name, $data->new_university, $data->new_start_date, $data->new_end_date)) { /* Object CH is a courshandler and has a function "updatecourse" that takes five arguments, fist which coursecode in databas do I want to update and secondly 
                        and so fort which new values for the columns code, name syllabus, progresion do I want to update."data" is a json object that is reieved from the front end when it does a put request.*/
                    http_response_code(200); //OK
                    $result = array("message" => "Course updated");
                } else {
                    http_response_code(503); /* server error */
                    $result = array("message" => "Course not updated");
                }
            }
        break;
    case 'DELETE':
        /* if no id is sent, send error*/
        $data = json_decode(file_get_contents("php://input"));
            if (empty($data->course_name) && empty($data->university)) {
                http_response_code(510); //Not Extended
                $result = array("message" => "No  key is sent");
                /* If id is sent*/
            } else {
                /* function to delete a row*/
                if ($ch->deleteCourse($data->course_name, true, $data->university)) {
                    http_response_code(200); //ok
                    $result = array("message" => "Course deleted");
                } else {
                    http_response_code(503); //Server error
                    $result = array("message" => "Course not deleted");
                }
            }
        break;
}
/* return the result as JSON*/

echo json_encode($result);
?>