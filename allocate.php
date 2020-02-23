<?php
    require "session.php";
    require "utility.php";
    require "AssignRepository.php";

    checkEntity(array("admin"));

    if(!empty($_POST['submit'])){
        switch($_POST['submit']) {
            case 'Assign':
                try {
                    $assignRepo = new AssignRepository();
                    $result = $assignRepo->assign($_POST['student'], $_POST['tutor'], getUserId());                
                }
                catch(Exception $ex){
                    $errorMessage = $ex->getMessage();
                }
                break;

            case 'Reallocate':
                try {
                    $assignRepo = new AssignRepository();
                    $result = $assignRepo->reallocate($_POST['student'], $_POST['tutor'], getUserId());                
                }
                catch(Exception $ex){
                    $errorMessage = $ex->getMessage();
                }
                break;

            default:
                break;
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php Utility::loadHeader("Allocation", array("bootstrap.min.css")); ?>

    <body>
        <style>
        .duplicate {
            border: 1px solid red;
            color: red;
        }
        </style>
        <?php Utility::loadNavBar(); ?>
        <main class="container">
            <div class="row pt-4">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h4 class="text-center">Allocation</h4>
                    <hr />
                </div>
                <div class="col-md-9 col-xs-12 col-sm-12">
                    <?php
                        if(!empty($errorMessage)){
                            echo "<div class='alert alert-danger'>" . $errorMessage . "</div>";
                        }

                        if(!empty($result)){
                            if(count($result) > 0) {
                                foreach($result as $value){
                                    if($value['status'] === 200){
                                        echo "<div class='alert alert-success'>" . $value['message'] . "</div>";
                                    } else {                                       
                                        echo "<div class='alert alert-info'>" . $value['message'] . "</div>";
                                    }
                                }
                            }
                        }
                    ?>
                    <form id="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="row">
                        <input type="hidden" id="submit" name="submit" value="Assign" />
                        <div class="col-md-6 col-xs-12 col-sm-12">
                            <div class="card">
                                <div class="card-header text-center bg-info text-white">
                                    Student
                                </div>
                                <div class="card-body" id="studentContainer">
                                    <?php
                                        if(!empty($errorMessage)){
                                            foreach($_POST['student'] as $key => $value){
                                                if($key === 0){
                                                    echo '<input type="email" id="student" name="student[]" class="form-control" placeholder="Student email" value="' . $value .'" multiple />';
                                                } else {
                                                    echo '<input type="email" id="student" name="student[]" class="form-control mt-2" placeholder="Student email" value="' . $value .'" multiple />';
                                                }
                                            }
                                        } else {
                                            echo '<input type="email" id="student" name="student[]" class="form-control" placeholder="Student email" multiple required />';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-xs-12 col-sm-12">
                            <div class="card">
                                <div class="card-header text-center bg-info text-white">
                                    Tutor
                                </div>
                                <div class="card-body" id="tutorContainer">
                                    <input type="email" id="tutor" name="tutor[]" class="form-control" placeholder="Tutor email" multiple required />
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
                <div class="col-md-3 col-xs-12 col-sm-12">
                    <div class="card sticky-top">
                        <div class="card-body">
                            <button type="button" id="addStudent" class="btn btn-primary btn-block">Add Student</button>
                            <button type="button" id="addTutor" class="btn btn-primary btn-block">Add Tutor</button>
                            <button type="submit" id="allocate" form="form" class="btn btn-success btn-block">Allocate</button>
                            <button type="button" id="reallocate" class="btn btn-secondary btn-block">Reallocate</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js")); ?>
        <audio id="msgTone" src="assets/media/msgtone.mp3" preload="auto"></audio>
        <script type="text/javascript">
            $(document).ready(
                function(){
                    $("#reallocate").click(
                        function(){
                            console.log("Reallocate");
                            $("#submit").val("Reallocate");
                            $("#allocate").trigger('click'); 
                        }
                    );

                    $("form").submit(function() {
                        console.log("Submit form");
                        var arr = [];
                        $("input").each(function(){
                            if($(this).hasClass('duplicate')){
                                $(this).removeClass('duplicate');
                            }
                            if($(this).val().length === 0){                                
                                return true;
                            } else {
                                var value = $(this).val();
                                if (arr.indexOf(value) == -1) {
                                    arr.push(value);
                                } else {
                                    $(this).addClass("duplicate");
                                }
                            }
                        });

                        var inputs = $(".duplicate");

                        if(inputs.length > 0){
                            alert("Duplicate value detected. Please change or empty the value.");
                            return false;
                        } else {
                            $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
                            return true; 
                        }
                    });

                    $('#addStudent').click(
                        function() {
                            $('<input>').attr({
                                type: 'email',
                                id: 'student',
                                name: 'student[]',
                                placeholder: 'Student email',
                                class: 'form-control mt-2'
                            }).prop("multiple", true).appendTo('#studentContainer');
                        }
                    );
                    $('#addTutor').click(
                        function() {
                            $('<input>').attr({
                                type: 'email',
                                id: 'tutor',
                                name: 'tutor[]',
                                placeholder: 'Tutor email',
                                class: 'form-control mt-2'
                            }).prop("multiple", true).appendTo('#tutorContainer');
                        }
                    );
                }
            );
        </script>                                    
        <?php Utility::loadFooter(); ?>
    </body>
</html>
