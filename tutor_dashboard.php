<?php
    require_once "session.php";
    require_once "utility.php";
    require_once "AssignRepository.php";

    checkEntity(array("tutor", "admin"));

    try {
        $email = getUserEmail();

        if(getUserEntity() === 'admin'){
            if(!empty($_GET['tutor'])){
                if (filter_var(filter_var($_GET['tutor'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
                    $email = $_GET['tutor'];
                } else {
                    throw new Exception("Invalid email.");
                }                        
            } else {
                throw new Exception("Invalid email.");
            }
        }

        $assignRepo = new AssignRepository();
        $student = $assignRepo->getStudent($email);       
    }
    catch(Exception $ex){
        $errorMessage = $ex->getMessage();
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
                    <h3 class="text-center">Personal Dashboard</h3>
                    <hr /> 
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <table id="tutee_table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tutee Email</th>
                                <th>Tutee Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($errorMessage)){
                                    echo "<div class='alert alert-danger'>" . $errorMessage . "</div>";
                                } else {
                                    if(count($student) > 0){
                                        foreach($student as $value){
                                            echo "<tr>";
                                            echo "<td>" . $value['email'] . "</td>";
                                            echo "<td>" . $value['name'] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<div class='alert alert-info'>You currently do not have any tutees.</div>";
                                    }
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Tutee Email</td>
                                <td>Tutee Name</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js", "jquery.dataTables.min.js")); ?>
        <script type="text/javascript">
            $(document).ready(
                function() {
                    $("#tutee_table").DataTable({
                                
                    });
                }
            );
        </script>
        <?php Utility::loadFooter(); ?>
    </body>
</html>
