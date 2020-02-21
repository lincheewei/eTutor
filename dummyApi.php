<?php
    $data = array();

    $data['admin1@gmail.com'] = array(
        "id" => 20,
        "email" => 'admin1@gmail.com',
        "entity" => "admin",
        "name" => "admin1"
    );

    $data["student5@gmail.com"] = array(
        "id" => 1,
        "email" => "student5@gmail.com",
        "entity" => "student",
        "name" => "jinho"
    );

    $data["jinhomobile@gmail.com"] = array(
        "id" => 1,
        "email" => "jinhomobile@gmail.com",
        "entity" => "student",
        "name" => "jinho"
    );

    $data["student1@gmail.com"] = array(
        "id" => 1,
        "email" => "student1@gmail.com",
        "entity" => "student",
        "name" => "user1"
    );

    $data["student2@gmail.com"] = array(
        "id" => 2,
        "email" => "student2@gmail.com",
        "entity" => "student",
        "name" => "user2"
    );

    $data["student3@gmail.com"] = array(
        "id" => 3,
        "email" => "student3@gmail.com",
        "entity" => "student",
        "name" => "user3"
    );

    $data["rockjiann@gmail.com"] = array(
        "id" => 4,
        "email" => "rockjiann@gmail.com",
        "entity" => "tutor",
        "name" => "user4"
    );

    $data["tutor1@gmail.com"] = array(
        "id" => 5,
        "email" => "tutor1@gmail.com",
        "entity" => "tutor",
        "name" => "user7"
    );

    $data["tutor2@gmail.com"] = array(
        "id" => 5,
        "email" => "tutor2@gmail.com",
        "entity" => "tutor",
        "name" => "user5"
    );

    $data["tutor3@gmail.com"] = array(
        "id" => 6,
        "email" => "tutor3@gmail.com",
        "entity" => "tutor",
        "name" => "user6"
    );

    if(empty($_POST['function'])){
        $_POST['function'] = "";
    }

    switch($_POST['function']) {
        case 'getStudentWihtoutTutor':
            try {
                $studentAssigned = json_decode($_POST['user'], true);

                $student = array();                        
                foreach($data as $key => $value){
                    if($value['entity'] === 'student'){
                        if(!in_array($value['email'], $studentAssigned)){
                            $student[] = $data[$key];
                        }
                    }
                }

                http_response_code(200);
                echo json_encode($student);
            }
            catch(Exception $ex){
                http_response_code(500);
                echo json_encode(array("message" => $ex->getMessage()));
            }
            break;

        case 'getUserName':
            try {
                $user = json_decode($_POST['user'], true);
                $userName = array();
                if(count($user) > 0){
                    foreach($user as $value){
                        if(array_key_exists($value, $data)){
                            $userName[] = array(
                                "email" => $value,
                                "name" => $data[$value]['name']
                            );
                        } else {
                            throw new Exception($value . " is not a valid user.");
                        }
                    }
                } else {
                    throw new Exception("No user available");
                }
                http_response_code(200);
                echo json_encode($userName);
            }
            catch(Exception $ex) {
                http_response_code(500);
                echo json_encode(array("message" => $ex->getMessage()));
            }
            break;

        case 'authenticate':
            if(array_key_exists($_POST['username'], $data)){
                http_response_code(200);
                echo json_encode($data[$_POST['username']]);
            } else {
                http_response_code(500);
                echo json_encode(array("message" => "Username or password invalid."));
            }
            break;

        case 'verifyTutor':
            $tutor = json_decode($_POST['tutor'], true);
            if(count($tutor) > 0){
                $notTutor = array();
                foreach($tutor as $tutorEmail){
                    if(!array_key_exists($tutorEmail, $data)){
                        $notTutor[] = $tutorEmail;
                    }
                }

                if(count($notTutor) === 0){
                    http_response_code(200);
                    echo $_POST['tutor'];
                } else {
                    http_response_code(500);
                    echo json_encode(array("message" => implode(",", $notTutor) . " not valid."));
                }                
            } else {
                http_response_code(500);
                echo json_encode(array("message" => "Tutor emails must not empty."));
            }           
            break;

        case 'verifyStudent':
            $student = json_decode($_POST['student'], true);
            if(count($student) > 0){
                $notStudent = array();
                foreach($student as $studentEmail){
                    if(!array_key_exists($studentEmail, $data)){
                        $notStudent[] = $studentEmail;
                    }
                }                    

                if(count($notStudent) === 0){
                    http_response_code(200);
                    echo $_POST['student'];
                } else {
                    http_response_code(500);
                    echo json_encode(array("message" => implode(", ", $notStudent) . " not valid."));
                }
            } else {
                http_response_code(500);
                echo json_encode(array("message" => "Student emails must not empty."));
            }
            break;

        default:
            http_response_code(500);
            echo json_encode(array("message" => "End point not exist."));
            break;
    }
