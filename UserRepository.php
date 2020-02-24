<?php

    use App\Repositories\Users\UserRepositoryInterface;    

    class UserRepository implements UserRepositoryInterface{
        public function getStudentWithoutTutor($student = array()){
            try {
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, "http://localhost/eTutor/dummyApi.php" );
                curl_setopt($curl, CURLOPT_POST, 1 ); 
                curl_setopt($curl, CURLOPT_POSTFIELDS, array("user" =>json_encode($student), "function" => "getStudentWihtoutTutor")); 
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
                $postResult = curl_exec($curl); 

                if (curl_errno($curl)) { 
                    throw new Exception(curl_error($curl));
                } 

                if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200){
                    return json_decode($postResult, true);
                } else {
                    throw new Exception(json_decode($postResult, true)['message']);
                }
            }
            catch(Exception $ex) {
                throw new Exception($ex->getMessage()); 
            }
            finally {
                curl_close($curl);
            }                        
        }

        public function getName($user = array()){
            try {
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, "http://localhost/eTutor/dummyApi.php" );
                curl_setopt($curl, CURLOPT_POST, 1 ); 
                curl_setopt($curl, CURLOPT_POSTFIELDS, array("user" =>json_encode($user), "function" => "getUserName")); 
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
                $postResult = curl_exec($curl); 

                if (curl_errno($curl)) { 
                    throw new Exception(curl_error($curl));
                } 

                if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200){
                    return json_decode($postResult, true);
                } else {
                    throw new Exception(json_decode($postResult, true)['message']);
                }
            }
            catch(Exception $ex) {
                throw new Exception($ex->getMessage()); 
            }
            finally {
                curl_close($curl);
            }                        
        }

        public function verifyStudent($student){
            try {
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, "http://localhost/eTutor/dummyApi.php" );
                curl_setopt($curl, CURLOPT_POST, 1 ); 
                curl_setopt($curl, CURLOPT_POSTFIELDS, array("student" =>json_encode($student), "function" => "verifyStudent")); 
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
                $postResult = curl_exec($curl); 

                if (curl_errno($curl)) { 
                    throw new Exception(curl_error($curl));
                } 

                if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200){
                    return json_decode($postResult, true);
                } else {
                    throw new Exception(json_decode($postResult, true)['message']);
                }
            }
            catch(Exception $ex) {
                throw new Exception($ex->getMessage()); 
            }
            finally {
                curl_close($curl);
            }                        
        }

        public function verifyTutor($tutor){
            try {
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, "http://localhost/eTutor/dummyApi.php" );
                curl_setopt($curl, CURLOPT_POST, 1 ); 
                curl_setopt($curl, CURLOPT_POSTFIELDS, array("tutor" =>json_encode($tutor), "function" => "verifyTutor")); 
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
                $postResult = curl_exec($curl); 

                if (curl_errno($curl)) { 
                    throw new Exception(curl_error($curl));
                } 

                if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200){
                    return json_decode($postResult, true);
                } else {
                    throw new Exception(json_decode($postResult, true)['message']);
                }
            }
            catch(Exception $ex) {
                throw new Exception($ex->getMessage()); 
            }
            finally {
                curl_close($curl);
            }                        
        }
        
        public function authenticate($username, $password){
            try {
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, "http://localhost/eTutor/dummyApi.php" );
                curl_setopt($curl, CURLOPT_POST, 1 ); 
                curl_setopt($curl, CURLOPT_POSTFIELDS, array("username" => $username, "password" => $password, "function" => "authenticate")); 
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
                $postResult = curl_exec($curl); 

                if (curl_errno($curl)) { 
                    throw new Exception(curl_error($curl));
                } 

                if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200){
                    return json_decode($postResult, true);
                } else {
                    throw new Exception(json_decode($postResult, true)['message']);
                }
            }
            catch(Exception $ex) {
                throw new Exception($ex->getMessage()); 
            }
            finally {
                curl_close($curl);
            }                        
        }
    }
