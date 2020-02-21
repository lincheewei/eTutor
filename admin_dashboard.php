<?php
    require "session.php";
    require "utility.php";   
    require "UserRepositoryInterface.php";
    require "UserRepository.php";
    require "AssignRepository.php";
    require "MessageRepository.php";

    if(!empty($_POST['submit'])){
        if($_POST['submit'] === 'Search'){
            switch($_POST['entity']){
                case 'tutee':
                    header("Location: student_dashboard.php?student=" . $_POST['email']);
                    break;

                case 'tutor':
                    header("Location: tutor_dashboard.php?tutor=" . $_POST['email']);
                    break;

                default:
                    break;
            }                    
        }
    }

    try {
        $assignRepo = new AssignRepository();
        $students = $assignRepo->getAllStudentEmail();
        $tutors = $assignRepo->getAllTutorEmail();
       
        $messageRepo = new MessageRepository();
        $message7 = $messageRepo->getMessageSentLast7($students);
        $message28 = $messageRepo->getMessageSentLast28($students);
        $messageTotal7 = $messageRepo->getMessageSentLast7($tutors);
        echo "<pre>";
        print_r($message7);
        print_r($message28);
        print_r($students);
        print_r($tutors);
        echo "</pre>";

        $assignRepo = new AssignRepository();
        $userRepo = new UserRepository();
        $studentNoTutor = $userRepo->getStudentWithoutTutor($students);
    }
    catch(Exception $ex) {
        echo $ex->getMessage();
    }    
?>

<!DOCTYPE html>
<html>
    <?php Utility::loadHeader("Dashboard", array("bootstrap.min.css", "jquery.dataTables.min.css")); ?>

    <body>
        <?php Utility::loadNavBar(); ?>
        <main class="container">
            <div class="row pt-3">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <h3 class="text-center">Admin Dashboard</h3>
                    <hr /> 
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            Dashboard Access
                        </div>
                        <div class="card-body">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="row">
                                <div class="form-group col-md-8 col-sm-12 col-xs-12">
                                    <input type="email" id="email" name="email" class="form-control" placeholder="User email" required />
                                </div>
                                <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                    <select id="entity" name="entity" class="form-control">
                                        <option value="tutee">Tutee</option>
                                        <option value="tutor">Tutor</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                    <input type="submit" name="submit" value="Search" class="btn btn-primary btn-block" />
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-xs-12 col-sm-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            Statistics Report
                        </div>
                        <div class="card-body">
                            <div clas="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5>Number of messages in last 7 days for tutors</h5>
                                    <?php
                                        if(!empty($messageTotal7)){
                                            if(count($messageTotal7) > 0){
                                                echo "<ul>";
                                                foreach($messageTotal7 as $key => $value) {
                                                    echo "<li>" . $key . " has " . $value . " message(s) in total.</li>";
                                                }
                                            }
                                        }
                                    ?>    
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5>Average number of messages for tutors</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 col-sm-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            Exception Report
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5>Student without personal tutors</h5>
                                    <?php
                                        if(!empty($studentNoTutor)){
                                            if(count($studentNoTutor) > 0){
                                                echo "<ul>";
                                                foreach($studentNoTutor as $value) {
                                                    echo "<li>" . $value['email'] . "</li>";
                                                }
                                            }
                                        }
                                    ?>    
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5>Student do not interact with tutors for 7 days</h5>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5>Student do not interact with tutors for 28 days</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js")); ?>
        <?php Utility::loadFooter(); ?>
    </body>
</html>
