<?php
    require 'scrum_connection.php';
    require('session.php');
    require "utility.php";
    $conn = getconnection();
    $uid =  getUserEmail();
    $uname = getUserName();

    if (isset($_POST['submit'])){
        $title = $_POST['title'];
        $date = $_POST['date'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $filename = "";

        $sql = "INSERT INTO meeting (meeting_name,meeting_date,meeting_start,meeting_end,user_email) VALUES ('$title','$date','$start','$end','$uid')";
        mysqli_query($conn, $sql);
        echo "File uploaded successfully.";
        echo "<script>window.location.href='viewmeeting.php'</script>";

    }
?>
<html xmlns="http://www.w3.org/1999/html">
    <?php Utility::loadHeader("Add Meeting", array("bootstrap.min.css")); ?>
    <body>
        <?php Utility::loadNavBar(); ?>
        <main class="container">
            <div class="row pt-3">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <h3 class="text-center">Add Meeting</h3>
                    <hr />
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Meeting Title" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="date" class="form-control" id="date" name="date" placeholder="Date" min="" required>
                        </div>
                        <div class="form-group">
                            <label for="start">Start:</label>
                            <input type="time" class="form-control" id="start" name="start" placeholder="Start time" required>
                        </div>
                        <div class="form-group">
                            <label for="end">End:</label>
                            <input type="time" class="form-control" id="end" name="end" placeholder="End time" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary float-right"/>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js", "popper.js", "jquery.dataTables.min.js")); ?>
        <script type="text/javascript">
            let date = new Date().toISOString().substr(0, 10);
            document.querySelector("#date").value = date;
            document.querySelector("#date").min = date;
        </script>
        <?php Utility::loadFooter(); ?>
    </body>
</html>    
