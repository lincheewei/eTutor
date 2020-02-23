<?php
    require __DIR__ . "/vendor/autoload.php";

    use SendGrid\Mail\Personalization;
    use SendGrid\Mail\To;

    class EmailService {
        private $sendgridInstance = null;
        private $emailInstance = null;
        private const ADMIN_EMAIL = "systemAdmin@etutor.com";
        private const ADMIN_NAME = "eTutor System";

        public function __construct($subject = "") {
            $this->sendgridInstance = new \SendGrid('');
            $this->emailInstance = new \SendGrid\Mail\Mail();
            $this->emailInstance->setFrom(self::ADMIN_EMAIL, self::ADMIN_NAME);
            $this->emailInstance->setSubject($subject);
        }

        public function notifyStudents($student = array(), $msg){
            foreach($student as $value){
                $personalization = new Personalization();
                $personalization->addTo(new To($value));
                $this->emailInstance->addPersonalization($personalization);
            }
            
            $message = $msg . " Please check your eTutor dashboard for the latest update.";

            $this->emailInstance->addContent("text/plain", $message);

            try {
                $response = $this->sendgridInstance->send($this->emailInstance);
                if($response->statusCode() === 202){
                    return true;
                } else {
                    return false;
                }
            }
            catch(Exception $ex) {
                throw new Exception($ex->getMessage());
            }
        }

        public function notifyTutors($tutor = array(), $msg){
            foreach($tutor as $value){
                $personalization = new Personalization();
                $personalization->addTo(new To($value));
                $this->emailInstance->addPersonalization($personalization);
            }
            
            $message = $msg . " Please check your eTutor dashboard for the latest update.";

            $this->emailInstance->addContent("text/plain", $message);

            try {
                $response = $this->sendgridInstance->send($this->emailInstance);
                if($response->statusCode() === 202){
                    return true;
                } else {
                    return false;
                }                
            }
            catch(Exception $ex) {
                throw new Exception($ex->getMessage());
            }
        }
    }
