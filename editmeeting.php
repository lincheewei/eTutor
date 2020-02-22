<!DOCTYPE HTML>
<?php
    require 'scrum_connection.php';
    require('session.php');
    require "utility.php";

    $conn = getconnection();
    $uid =  getUserId();
    $uname = getUserName();
?>
<html xmlns="http://www.w3.org/1999/html">
    <?php Utility::loadHeader("Edit meeting", array("bootstrap.min.css", "jquery.dataTables.min.css")); ?>

    <body>
        <?php Utility::loadNavBar(); ?>
        <main class="container">
            <div class="row pt-3">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <h3 class="text-center">Edit Meeting</h3>
                    <hr />
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <?php
                            $meetingids = $_SESSION['editmeetingid'];
                            $sql = "SELECT * FROM meeting WHERE meeting_id = '$meetingids'";
                            $result = mysqli_query($conn,$sql);
                            while ($row = mysqli_fetch_array($result)) {
                                $editmeetingname = $row['meeting_name'];
                                $editmeetingdate = $row['meeting_date'];
                                $editmeetingstart = $row['meeting_start'];
                                $editmeetingend = $row['meeting_end'];
                                $editmeetingrecord = $row['meeting_record'];
                            }
                        ?>

                        <?php
                            if (isset($_POST['submit'])){
                                $title = $_POST['title'];
                                $date = $_POST['date'];
                                $start = $_POST['start'];
                                $end = $_POST['end'];


                                //uploads https://artisansweb.net/how-to-implement-chunk-upload-in-php/
                                set_time_limit(0);

                                if ( !file_exists('records') ) {
                                    mkdir('records', 0777);
                                }

                                if($_FILES['file']['size'] == 0) {
                                    echo "no image";
                                    $sql = "UPDATE meeting SET meeting_name='$title',meeting_date='$date',meeting_start='$start',meeting_end='$end' WHERE meeting_id = '$meetingids'";
                                    mysqli_query($conn, $sql);
                                    echo "<script>window.location.href='viewmeeting.php'</script>";
                                } else {
                                    echo "gt image";
                                    $filename = $_FILES["file"]["name"];
                                    $filetype = $_FILES["file"]["type"];
                                    //$filesize = $_FILES["file"]["size"];

                                    // check file type
                                    $allowed = array("mp4" => "video/mp4", "flv" => "video/flv", "mov" => "video/mov", "avi" => "video/avi", "wmv" => "video/wmv", "mkv" => "video/mkv");
                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                    if (!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format. (MP4,FLV,MOV,AVI,WMV,mkv)  ");

                                     // Check is file exist
                                    if (file_exists("records/" . $filename)) {
                                        echo $filename . " is already exists please rename your records.";
                                    } else {
                                        $tmpfile = $_FILES['file']['tmp_name'];
                                        $orig_file_size = filesize($tmpfile);
                                        $target_file = 'records/' . microtime() . $_FILES['file']['name'];

                                        $chunk_size = 256; // chunk in bytes
                                        $upload_start = 0;

                                        $handle = fopen($tmpfile, "rb");
                                        $fp = fopen($target_file, 'w');

                                        while ($upload_start < $orig_file_size) {

                                        $contents = fread($handle, $chunk_size);
                                        fwrite($fp, $contents);

                                        $upload_start += strlen($contents);
                                        fseek($handle, $upload_start);
                                    }

                                    fclose($handle);
                                    fclose($fp);
                                    unlink($_FILES['file']['tmp_name']);

                                    $sql = "UPDATE meeting SET meeting_name='$title',meeting_date='$date',meeting_start='$start',meeting_end='$end',meeting_record='$target_file' WHERE meeting_id = '$meetingids'";
                                    mysqli_query($conn, $sql);
                                    echo "File uploaded successfully.";
                                    echo "<script>window.location.href='viewmeeting.php'</script>";
                                    }
                                }
                            }
                        ?>


                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Meeting Title" value="<?php echo $editmeetingname; ?>" required>
                        </div>

                        <?php
                            $sql = "SELECT * FROM meeting WHERE meeting_id = '$meetingids'";
                            $result = mysqli_query($conn,$sql);
                            while ($row = mysqli_fetch_array($result)) {
                                $editmeetingname = $row['meeting_name'];
                                $editmeetingdate = $row['meeting_date'];
                                $editmeetingstart = $row['meeting_start'];
                                $editmeetingend = $row['meeting_end'];
                                $editmeetingrecord = $row['meeting_record'];
                            }
                            $todate =  date("Y-m-d");
                            if ($todate > $editmeetingdate){
                                echo "    <div class=\"form-group\">
                                <label for=\"date\">Date:</label>
                                <input type=\"date\" class=\"form-control\" id=\"date\" name=\"date\" placeholder=\"Date\" value='$editmeetingdate' readonly required></div>";
                                echo "    <div class=\"form-group\">
                                <label for=\"start\">Start:</label>
                                <input type=\"time\" class=\"form-control\" id=\"start\" name=\"start\" placeholder=\"Start time\" value='$editmeetingstart' readonly required></div>";
                                echo "    <div class=\"form-group\">
                                <label for=\"end\">End:</label>
                                <input type=\"time\" class=\"form-control\" id=\"end\" name=\"end\" placeholder=\"End time\" value='$editmeetingend' readonly required></div>";
                            } else {
                                echo "    <div class=\"form-group\">
                                <label for=\"date\">Date:</label>
                                <input type=\"date\" class=\"form-control\" id=\"date\" name=\"date\" placeholder=\"Date\" value='$editmeetingdate' required></div>";
                                echo "    <div class=\"form-group\">
                                <label for=\"start\">Start:</label>
                                <input type=\"time\" class=\"form-control\" id=\"start\" name=\"start\" placeholder=\"Start time\" value='$editmeetingstart' required></div>";
                                echo "    <div class=\"form-group\">
                                <label for=\"end\">End:</label>
                                <input type=\"time\" class=\"form-control\" id=\"end\" name=\"end\" placeholder=\"End time\" value='$editmeetingend' required></div>";
                            }
                        ?>

                        <div class="form-group">
                            <label for="file">Records:</label>
                            <input type="file" id="file" name="file" class="form-control" />
                        </div>

                        <div class="form-group">
                            <?php
                                $sql = "SELECT * FROM meeting WHERE meeting_id = '$meetingids'";
                                $result = mysqli_query($conn,$sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $editmeetingdate = $row['meeting_date'];
                                }
                                $todate =  date("Y-m-d");
                                if ($todate > $editmeetingdate){
                                }else{
                                    echo "<input type=\"submit\" name=\"delete\" value=\"Delete\" class=\"btn btn-danger float-right\"/>";
                                    echo "</div>";
                                }
                            ?>
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary float-right mr-1"/>
                            <?php
                                if(isset($_POST['delete'])){
                                    $sql = "DELETE FROM meeting WHERE meeting_id = '$meetingids'";
                                    $result = mysqli_query($conn,$sql);
                                    echo "<script>window.location.href='viewmeeting.php'</script>";
                                }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js", "popper.js", "jquery.dataTables.min.js")); ?>
        <script type="text/javascript">
            let date = new Date().toISOString().substr(0, 10);
            document.querySelector("#date").min = date;
        </script>
        <?php Utility::loadFooter(); ?>
    </body>
</html>
