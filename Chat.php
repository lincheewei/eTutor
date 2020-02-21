<?php

    use Ratchet\MessageComponentInterface;
    use Ratchet\ConnectionInterface;

    class Chat implements MessageComponentInterface {
        # used to store connection
        protected $clients;

        # an array to link connection with user email
        protected $users;

        # an array to link connection resourceId with user email
        protected $sessions;

        public function __construct() {
            $this->clients = new \SplObjectStorage;
            $this->users = array();
            $this->sessions = array();
            echo "Chat server is running.\n";
        }

        public function onOpen(ConnectionInterface $conn) {
            $this->clients->attach($conn);
        }

        public function onMessage(ConnectionInterface $conn, $msg) {
            $data = json_decode($msg);            
            switch($data->flag){
            case "token":
                echo "Token received from user " . $data->username . ".\n";
                $this->sessions[$conn->resourceId] = $data->username;
                $this->users[$data->username] = $conn;
                break;

            case "message":
                if(array_key_exists($data->recipient, $this->users)) {
                    echo "Message send from " . $this->sessions[$conn->resourceId] . " to " . $data->recipient . ".\n";
                    $this->users[$data->recipient]->send(
                        json_encode(
                            array(
                                "sender" => $this->sessions[$conn->resourceId],
                                "message" => $data->message
                            )
                        )
                    );
                }
                break;
            } 
        }

        public function onClose(ConnectionInterface $conn) {
            echo "Closeing connection from user " . $this->sessions[$conn->resourceId] . ".\n";
            $this->clients->detach($conn);
            unset($this->users[$this->sessions[$conn->resourceId]]);
            unset($this->sessions[$conn->resourceId]);
            echo "Current user count: " . count($this->clients) . ".\n";
        }

        public function onError(ConnectionInterface $conn, \Exception $ex) {
            echo "Error : " . $ex->GetMessage() . "\n";
            $conn->close();
        }
    }
