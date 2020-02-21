<?php
    require_once "session.php";
    require_once "utility.php";
    require_once "MessageRepository.php";
    require_once "MeetingRepository.php";
    require_once "UserRepositoryInterface.php";
    require_once "UserRepository.php";

    try {
        $email = getUserEmail();

        if(getUserEntity() === 'admin'){
            if(!empty($_GET['student'])){
                $email = $_GET['student'];
            }
        }

        $messageRepo = new MessageRepository();
        $message = $messageRepo->getMessageSentByEmail($email);

        $meetingRepo = new MeetingRepository();
        $meeting = $meetingRepo->getMeetingByEmail($email);
    }
    catch(Exception $ex){
        $errorMessages = $ex->getMessage();
    }
?>

<!DOCTYPE html>
<html>
    <?php Utility::loadHeader("Dashboard", array("bootstrap.min.css")); ?>

    <body>
        <?php Utility::loadNavBar(); ?>
        <main class="container">
            <div class="row pt-3">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <h3 class="text-center">Personal Dashboard</h3>
                    <hr /> 
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <?php
                        if(!empty($errorMessage)){
                            echo "<div class='alert alert-danger'>" . $errorMessage . "</div>";
                        }

                        if(count($message) === 0 && count($meeting) === 0){
                            echo "<div class='alert alert-info'>You currently do not have any interaction with your personal tutor(s) allocated.</div>";
                        } else if(count($message) >= count($meeting)) {
                            foreach($message as $key => $value){
                                echo "<h4 style='border-bottom: solid black 1px'>" . $key . "</h4>";                                
                                echo "<p>Message</p>";
                                echo "<ul>";
                                foreach($value as $_key => $_value){
                                    echo "<li>You send <strong>" . $_value . " message(s)</strong> to " . $key . " at <strong>" . $_key . "</strong></li>";
                                }                            
                                echo "</ul>";

                                if(array_key_exists($key, $meeting)){
                                    echo "<p>Meeting</p>";
                                    echo "<ul>";
                                    foreach($meeting[$key] as $_key => $_value) {
                                        echo "<li>You have arranged <strong>" . $_value . " meeting(s)</strong> with " . $key . " in <strong>" . $_key . "</strong></li>";
                                    }
                                    echo "</ul>";
                                }
                            }
                        } else {
                            foreach($meeting as $key => $value){
                                echo "<h4 style='border-bottom: solid black 1px'>" . $key . "</h4>";                                
                                echo "<p>Meeting</p>";
                                echo "<ul>";
                                foreach($value as $_key => $_value){
                                    echo "<li>You have arranged <strong>" . $_value . " meeting(s)</strong> with " . $key . " in <strong>" . $_key . "</strong></li>";
                                }                            
                                echo "</ul>";

                                if(array_key_exists($key, $message)){
                                    echo "<p>Message</p>";
                                    echo "<ul>";
                                    foreach($message[$key] as $_key => $_value) {
                                        echo "<li>You send <strong>" . $_value . " message(s)</strong> to " . $key . " at <strong>" . $_key . "</strong></li>";
                                    }
                                    echo "</ul>";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js")); ?>
        <?php Utility::loadFooter(); ?>
    </body>
</html>
