<?php
    require_once "DatabaseConfig.php";
    require_once "UserRepositoryInterface.php";
    require_once "UserRepository.php";
    require_once "EmailService.php";

    class AssignRepository {
        private $databaseConnection = null;        
        private $userRepo = null;

        public function __construct(){
            $this->databaseConnection = new mysqli(DatabaseConfig::HOST, DatabaseConfig::USER, DatabaseConfig::PASSWORD, DatabaseConfig::DATABASE);
            if($this->databaseConnection->connect_error){
                throw new Exception($this->databaseConnection->connect_error);
            }

            $this->userRepo = new UserRepository();            
            $this->sendGrid = new \SendGrid('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');
        }

        public function assign($student = array(), $tutor = array(), $staffId, $reallocate = false) {
            try {
                if(count($student) > 0){
                    $student = $this->userRepo->verifyStudent($student);
                } else {
                    throw new Exception("Student emails cannot be empty.");
                }             

                if(count($tutor) > 0){
                    $tutor = $this->userRepo->verifyTutor($tutor);
                } else {
                    throw new Exception("Tutor emails can be empty.");
                }                

                $stmt = mysqli_stmt_init($this->databaseConnection);
                if(mysqli_stmt_prepare($stmt, "INSERT INTO assign (StudentEmail, TutorEmail, DateAssigned, StaffId) VALUES (?,?,?,?)")){
                    mysqli_stmt_bind_param($stmt, "sssd", $studentEmail, $tutorEmail, $date, $staffId);
                    $result = array();
                    $studentList = array(); $tutorList = array();
                    $date = date("Y-m-d H-i-s");
                    foreach($student as $studentEmail){
                        foreach($tutor as $tutorEmail){                            
                            mysqli_stmt_execute($stmt);
                            if(mysqli_stmt_affected_rows($stmt) === 1) {
                                if(!in_array($studentEmail, $studentList)){
                                    $studentList[] = $studentEmail;
                                }
                                if(!in_array($tutorEmail, $tutorList)){
                                    $tutorList[] = $tutorEmail;
                                }

                                $result[] = array(
                                    "status" => 200,
                                    "message" => $studentEmail . " has been allocated tutor " . $tutorEmail . " successfully."
                                );
                            } else {
                                switch(mysqli_stmt_errno($stmt)){
                                    case 1062:
                                        $result[] = array(
                                            "status" => 500,
                                            "message" => $studentEmail . " has already been allocated tutor " . $tutorEmail . "."
                                        );
                                        break;

                                    default:
                                        $result[] = array(
                                            "status" => 500,
                                            "message" => $studentEmail . " failed to be allocated tutor " . $tutorEmail . ". " . mysqli_stmt_error($stmt)
                                        );
                                        break;
                                }
                            }
                        }
                    }

                    if(count($result) > 0){
                        if($reallocate === true){
                            $emailService = new EmailService("System Notification");
                            $studentStatus = $emailService->notifyStudents($studentList, "You have been reallocated personal tutor(s).");
                            $emailService = new EmailService("System Notification");
                            $tutorStatus = $emailService->notifyTutors($studentList, "You have been reallocated student(s).");
                        } else {
                            $emailService = new EmailService("System Notification");
                            $studentStatus = $emailService->notifyStudents($studentList, "You have been allocated personal tutor(s).");
                            $emailService = new EmailService("System Notification");
                            $tutorStatus = $emailService->notifyTutors($studentList, "You have been allocated student(s).");
                        }
                        if($studentStatus === false){
                            $result[] = array(
                                "status" => 500,
                                "message" => "Failed to send notification emails to students."
                            );
                        }

                        if($tutorStatus === false) {
                            $result[] = array(
                                "status" => 500,
                                "message" => "Failed to send notification emails to tutors."
                            );
                        }

                        return $result;
                    } else{
                        throw new Exception("Result no available.");
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            catch(Exception $ex){
                throw new Exception($ex->getMessage());
            }           
        }        

        public function reallocate($student = array(), $tutor = array(), $staffId){
            try {
                if(count($student) > 0){
                    $student = $this->userRepo->verifyStudent($student);
                } else {
                    throw new Exception("Student emails cannot be empty.");
                }             

                if(count($tutor) > 0){
                    $tutor = $this->userRepo->verifyTutor($tutor);
                } else {
                    throw new Exception("Tutor emails can be empty.");
                }                

                $stmt = mysqli_stmt_init($this->databaseConnection);
                if(mysqli_stmt_prepare($stmt, "DELETE FROM assign WHERE StudentEmail = ?")){
                    $result = array();
                    mysqli_stmt_bind_param($stmt, "s", $studentEmail);
                    foreach($student as $studentEmail){
                        mysqli_stmt_execute($stmt);
                        if(mysqli_stmt_affected_rows($stmt) > 0) {
                            $result = array_merge($result, $this->assign(array($studentEmail), $tutor, $staffId, true));
                        } else {
                            $result[] = array(
                                "status" => 500,
                                "message" => "Failed to reallocate student " . $studentEmail . ". " . mysqli_stmt_error($stmt)
                            );
                        }
                    }

                    if(count($result) > 0){
                        return $result;
                    } else{
                        throw new Exception("Result not available.");
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            catch(Exception $ex){
                throw new Exception($ex->getMessage());
            }           
        }

        public function getStudent($tutorEmail) {
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT StudentEmail FROM assign WHERE TutorEmail = ?")){
                mysqli_stmt_bind_param($stmt, "s", $tutorEmail);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result = array();
                if(mysqli_stmt_num_rows($stmt) > 1) {                
                    mysqli_stmt_bind_result($stmt, $studentEmail);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = $studentEmail;
                    }
                } else {
                    mysqli_stmt_close($stmt);
                    return $result;
                }
            }
            mysqli_stmt_close($stmt);
            return $this->userRepo->getName($result);
        }       

        public function getTutor($studentEmail) {
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT TutorEmail FROM assign WHERE StudentEmail = ?")){
                mysqli_stmt_bind_param($stmt, "s", $studentEmail);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result = array();
                if(mysqli_stmt_num_rows($stmt) > 1) {                
                    mysqli_stmt_bind_result($stmt, $tutorEmail);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = $tutorEmail;
                    }
                } else {
                    mysqli_stmt_close($stmt);
                    return $result;
                }
            }
            mysqli_stmt_close($stmt);

            return $this->userRepo->getName($result);
        }       

        public function getAllTutorEmail(){
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT DISTINCT TutorEmail FROM assign")){
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result = array();
                if(mysqli_stmt_num_rows($stmt) > 1) {                
                    mysqli_stmt_bind_result($stmt, $tutorEmail);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = $tutorEmail;
                    }
                }
            }
            mysqli_stmt_close($stmt);

            return $result;
        }
        
        public function getAllStudentEmail(){
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT DISTINCT StudentEmail FROM assign")){
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result = array();
                if(mysqli_stmt_num_rows($stmt) > 1) {                
                    mysqli_stmt_bind_result($stmt, $studentEmail);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = $studentEmail;
                    }
                }
            }
            mysqli_stmt_close($stmt);

            return $result;
        }
    }



