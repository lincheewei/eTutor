<?php
    date_default_timezone_set('Asia/Kuala_Lumpur');

    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }    

    //if(empty($_SESSION['Id'])){
    //    $_SESSION['Id'] = 1;
    //} 

    //if(empty($_SESSION['Name'])){
    //    $_SESSION['Name'] = "user1";
    //} 

    //if(empty($_SESSION['Email'])){
    //    $_SESSION['Email'] = "student1@gmail.com";
    //} 

    //# possible value of entity
    //# student, tutor, admin
    //if(empty($_SESSION['Entity'])){
    //    $_SESSION['Entity'] = "admin";
    //}
    
    function checkEntity($entity = array()) {
        if(!empty($_SESSION['Entity'])){
            if(!in_array($_SESSION['Entity'], $entity)){
                echo "Hi";
                switch($_SESSION['Entity']) {
                    case 'student':
                        header("Location: student_dashboard.php");
                        break;

                    case 'admin':
                        header("Location: admin_dashboard.php");
                        break;

                    case 'tutor':
                        header("Location: tutor_dashboard.php");
                        break;

                    default: 
                        header("Location: index.php");
                        break;
                }
            } 
        } else {
            if($_SERVER['PHP_SELF'] !== "/etutor/index.php"){
                header("Location: index.php");
            }
        }
    }

    function getUserId(){
        return $_SESSION['Id'];
    }

    function getUserName(){
        return $_SESSION['Name'];
    }

    function getUserEmail(){
        return $_SESSION['Email'];
    }

    function getUserEntity(){
        return $_SESSION['Entity'];
    }

