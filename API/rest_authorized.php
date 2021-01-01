<?php
//require('Handlers.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];
//$lh = new LoginHandler();
/*methods getCourses-return all courses from table, addCourses($course_name,$ect) add new course, deleteCourse($course_name) delete course with code=$course_name, updateCourse($course, $model, $year, $id) update car with id= $id*/
switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        session_start();
        $test = true;
    
        if($test == true) {
            http_response_code(200); //ok
             echo json_encode(array(
                "message" => $data->email
            ));
        } else if($test == false) {
            http_response_code(401);
            echo json_encode(array(
                "message" => "Access denied.",
            ));

        } else {
            http_response_code(500);
            echo json_encode(array(
                "message" => "Access denied."
            ));
        }

    break;
}

