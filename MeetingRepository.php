<?php
    require_once "DatabaseConfig.php";

    class MeetingRepository {
        private $databaseConnection = null;

        public function __construct(){
            $this->databaseConnection = new mysqli(DatabaseConfig::HOST, DatabaseConfig::USER, DatabaseConfig::PASSWORD, DatabaseConfig::DATABASE);
            if($this->databaseConnection->connect_error){
                throw new Exception($this->databaseConnection->connect_error);
            }
        }

        public function __destruct(){
            mysqli_close($this->databaseConnection);
        }

        public function getMeetingByEmail($email) {
            $meeting = array();
            $meeting['tutor2@gmail.com'] = array(
                "2020-02-15" => 11,
                "2020-02-12" => 2 
            );

            return $meeting;
        }
    }



