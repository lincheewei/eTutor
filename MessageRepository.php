<?php
    require_once "DatabaseConfig.php";

    class MessageRepository {
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

        public function recallMessage($messageId, $senderEmail) {
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "UPDATE messages SET IsRecalled = 1 WHERE Id = ? AND IsRecalled = 0 AND SenderEmail = ?")){
                $id = 1;
                mysqli_stmt_bind_param($stmt, "ds", $messageId, $senderEmail);
                mysqli_stmt_execute($stmt);
                if(mysqli_stmt_affected_rows($stmt) === 1){
                    return true;
                } else {
                    if(mysqli_stmt_errno($stmt) === 0){
                        throw new Exception("No message has been recalled.");
                    } else {
                        throw new Exception(mysqli_stmt_error($stmt));
                    }
                }
                mysqli_stmt_close($stmt);
            }
        }

        public function sendMessage($senderEmail, $recipientEmail, $message = null){           
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "INSERT INTO messages (SenderEmail, RecipientEmail, Message, DateSend) VALUES (?,?,?,?)")){
                $date = date("Y-m-d H-i-s");
                mysqli_stmt_bind_param($stmt, "ssss", $senderEmail, $recipientEmail, $message, $date);
                mysqli_stmt_execute($stmt);
                if(mysqli_stmt_affected_rows($stmt) === 1){
                    return true;
                } else {
                    if(mysqli_stmt_errno($stmt) === 0){
                        throw new Exception("No message has been sent.");
                    } else {
                        throw new Exception(mysqli_stmt_error($stmt));
                    }
                }
                mysqli_stmt_close($stmt);
            }
        }

        public function getMessage($senderEmail, $recipientEmail){
            $result = array();
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT Id, SenderEmail, RecipientEmail, Message, DateSend FROM messages WHERE SenderEmail IN (?, ?) AND RecipientEmail IN (?, ?) AND IsRecalled = 0 ORDER BY DateSend ASC")){
                mysqli_stmt_bind_param($stmt, "ssss", $senderEmail, $recipientEmail, $senderEmail, $recipientEmail);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $id, $senderEmail, $recipientEmail, $message, $dateSend);
                while(mysqli_stmt_fetch($stmt)){
                    $result[] = array(
                        "id" => $id, 
                        "senderEmail" => $senderEmail,
                        "recipientEmail" => $recipientEmail,
                        "message" => $message,
                        "dateSend" => $dateSend
                    );
                }
                mysqli_stmt_close($stmt);

                return array(
                    "data" => $result,
                    "rowCount" => count($result)
                );                
            }
        }

        public function getMessageSentLast28($email = array()){
            $result = array();
            $today = new DateTime("now");
            $today = $today->format("Y-m-d");
            $lastDay = new DateTime("now");
            $lastDay->sub(new DateInterval('P28D'));
            $lastDay = $lastDay->format("Y-m-d");
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT COUNT(Id) AS TotalMessage FROM messages WHERE (SenderEmail = ? OR RecipientEmail = ?) AND DATE(DateSend) <= ? AND DATE(DateSend) > ?")){
                mysqli_stmt_bind_param($stmt, "ssss", $value, $value, $today, $lastDay);
                mysqli_stmt_bind_result($stmt, $totalMessage);
                foreach($email as $value){
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) === 1){
                        mysqli_stmt_fetch($stmt);
                        $result[$value] = $totalMessage;
                    }
                }
                mysqli_stmt_close($stmt);
                return $result;
            }
        }

        public function getMessageSentLast7($email = array()){
            $result = array();
            $today = new DateTime("now");
            $today = $today->format("Y-m-d");
            $lastDay = new DateTime("now");
            $lastDay->sub(new DateInterval('P7D'));
            $lastDay = $lastDay->format("Y-m-d");
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT COUNT(Id) AS TotalMessage FROM messages WHERE (SenderEmail = ? OR RecipientEmail = ?) AND DATE(DateSend) <= ? AND DATE(DateSend) > ?")){
                mysqli_stmt_bind_param($stmt, "ssss", $value, $value, $today, $lastDay);
                mysqli_stmt_bind_result($stmt, $totalMessage);
                foreach($email as $value){
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) === 1){
                        mysqli_stmt_fetch($stmt);
                        $result[$value] = $totalMessage;
                    }
                }
                mysqli_stmt_close($stmt);
                return $result;
            }
        }

        public function getMessageSentByEmail($email){
            $result = array();
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT RecipientEmail, DATE(DateSend), COUNT(Id) AS TotalMessage FROM messages WHERE SenderEmail = ? GROUP BY RecipientEmail, DATE(DateSend) ORDER BY DateSend ASC")){
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) > 0){
                    mysqli_stmt_bind_result($stmt, $recipientEmail, $dateSend, $totalMessage);
                    while(mysqli_stmt_fetch($stmt)){
                        if(array_key_exists($recipientEmail, $result)) {
                            $result[$recipientEmail][$dateSend] = $totalMessage; 
                        } else {
                            $result[$recipientEmail] = array(
                                $dateSend => $totalMessage
                            );
                        }
                    }                    
                }
                mysqli_stmt_close($stmt);
                return $result;
            }
        }
    }



