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


$wph = new WpHandler();
//$lh = new LoginHandler();
http_response_code(404); //Not found
$result = array("message" => "No");
switch ($method) {
    case 'GET':

        $webpages = $wph->getWp();
       
        
        /*Control if result contains any rows*/
        if (sizeof($webpages) > 0) {
           
            http_response_code(200); //ok
            $result = [];
            for ($i = 0; $i < count($webpages); $i++) {
                array_push($result, $webpages[$i]->getWp());
            }
             
        } else {
           
            http_response_code(404); //Not found
            $result = array("message" => "No webpages found");
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        session_start();
       if($_SESSION["EMAIL"] == $data->email){
            /*function to create row*/
            $test = $wph->insertWebpageByValues($data->title, $data->url, $data->description);
            if ($test) {
                http_response_code(201); //created
                $result = array("message" => "Webpage created");
            } else {
                http_response_code(503); /* server error */
                $result = array("message" => "Webpage not created");
            }
        } else {
            http_response_code(401);
            $result =array(
                "message" => "Access denied.",
            );
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input")); /*"data" is a json object that is reieved from the front end when it does a put request.*/
        /*If no code is sent, send error*/
         session_start();
       if($_SESSION["EMAIL"] == $data->email){
            if (empty($data->title) && empty($data->url)) {
                http_response_code(510); /* Not extended */
                $result = array("message" => "No key is sent");
            } else {
                /* function to update a row */
                if ($wph->updateWpByValues($data->title, $data->url, $data->new_title, $data->new_url, $data->new_description)) { /* Object CH is a courshandler and has a function "updatecourse" that takes five arguments, fist which coursecode in databas do I want to update and secondly 
                    http_response_code(200); //OK
                    $result = array("message" => "Webpage updated");
                } else {
                    http_response_code(503); /* server error */
                    $result = array("message" => "Webpage not updated");
                }
            }
        } else {
            http_response_code(401);
            $result =array(
                "message" => "Access denied.",
            );
        }
        break;
    case 'DELETE':
        /* if no id is sent, send error*/
        $data = json_decode(file_get_contents("php://input"));
        session_start();
       if($_SESSION["EMAIL"] == $data->email){
            if (empty($data->title) && empty($data->url)) {
                http_response_code(510); //Not Extended
                $result = array("message" => "No  key is sent");
                /* If id is sent*/
            } else {
                /* function to delete a row*/
                if ($wph->deleteWp($data->title, true, $data->url)) {
                    http_response_code(200); //ok
                    $result = array("message" => "Webpage deleted");
                } else {
                    http_response_code(503); //Server error
                    $result = array("message" => "Webpage not deleted");
                }
            }
        } else {
            http_response_code(401);
            $result =array(
                "message" => "Access denied.",
            );
        }
        break;
}
/* return the result as JSON*/
echo json_encode($result);
?>