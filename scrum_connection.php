<?php
    define("MYSQL_HOST",'localhost');
    define("MYSQL_USERNAME",'root');
    define("MYSQL_PASSWORD",'');
    define("MYSQL_DB",'etutor');

    function getConnection(){
        $conn =mysqli_connect(MYSQL_HOST,MYSQL_USERNAME,MYSQL_PASSWORD,MYSQL_DB);
        if(!$conn){
            echo "Connection Failed";
            return false;
        }
        return $conn;
    }
?>
