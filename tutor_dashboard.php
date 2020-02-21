<?php
    require_once "session.php";
    require_once "utility.php";
    require_once "AssignRepository.php";

    try {
        $email = getUserEmail();

        if(getUserEntity() === 'admin'){
            if(!empty($_GET['tutor'])){
                $email = $_GET['tutor'];
            }
        }

        $assignRepo = new AssignRepository();
        $student = $assignRepo->getStudent($email);       
    }
    catch(Exception $ex){
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
                                if(count($student) > 0){
                                    foreach($student as $value){
                                        echo "<tr>";
                                        echo "<td>" . $value['email'] . "</td>";
                                        echo "<td>" . $value['name'] . "</td>";
                                        echo "</tr>";
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
