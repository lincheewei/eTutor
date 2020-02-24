<?php
    include "session.php";
    require "utility.php";
    include "upload_config.php";

    if (!filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        header("Location: Document_Title.php");
    } 
?>

<!DOCTYPE html>
<html lang="en">
    <?php Utility::loadHeader("Document Forum", array("bootstrap.min.css")); ?>    
    <body>
        <?php Utility::loadNavBar(); ?>       
        <main class="container">
            <div class="row pt-3">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <?php
                        if (!empty($_GET['id'])) {
                            $id = (int)$_GET['id'];

                            $fetch_doc_data_sql = "SELECT * FROM docdb WHERE Doc_ID = '" . $id . "'";
                            $result_doc_data = mysqli_query($db, $fetch_doc_data_sql);
                            $display_doc_data = mysqli_fetch_assoc($result_doc_data);

                            echo "<h3> Document Title - " . $display_doc_data['Doc_Title'] . "</h3>";
                            echo "<hr />";
                        }
                    ?>
                    <?php
                        if(!empty($errorMessages)){
                            if(count($errorMessages) >0){
                                echo "<div class='alert alert-danger'>";                           
                                foreach($errorMessages as $value){
                                    echo "<li>" . $value . "</li>";
                                }
                                echo "</div>";
                            }
                        }
                    ?>
                    <?php
                        $select_comment = "SELECT * FROM commentdb WHERE D_ID = '" . $id . "'";
                        $result_comment_content = mysqli_query($db, $select_comment);

                        while ($display_comment_content = mysqli_fetch_assoc($result_comment_content)) {
                            echo '<div class="card mb-1" style="width: 100%;">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">Commented by '.$display_comment_content['Comment_User_Email'].' :';
                            echo '</h5>';
                            echo "<p class='card-text'>" . $display_comment_content['Comment_Content'] . "</p>";
                            if($display_comment_content['Comment_User_Email'] === getUserEmail()){
                                echo '<a class="deleteComment btn btn-danger" href="Document_Forum.php?id=' . $_GET['id'] . '&delete='.$display_comment_content["Comment_ID"].'">Delete Comment</a>';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    ?>
                    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                        <?php
                            if (isset($_GET['id'])) {
                                $id = (int)$_GET['id'];
                                $fetch_doc_data_sql = "SELECT * FROM docdb WHERE Doc_ID = '" . $id . "'";
                                $result_doc_data = mysqli_query($db, $fetch_doc_data_sql);
                                $display_doc_data = mysqli_fetch_assoc($result_doc_data);
                            }
                            echo "<input type='hidden' name='InputDocID' value='" . $display_doc_data['Doc_ID'] . "'>";
                        ?>
                        <br />
                        <h5>Any comments ? Type it here</h5>
                        <div class="form-group">
                            <textarea class="form-control" id="InputComment" name="InputComment" required style="height: 100px; resize:none"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary float-right" name="AddCommentBTN">Add Comment</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js", "popper.js")); ?>
        <script type="text/javascript">
            $(document).ready(
                function() {
                    $(".deleteComment").click(
                        function() {
                            if(confirm("Confirm delete this comment? The proccess is irreversible.")){
                                return true;
                            } else {
                                return false;
                            }                        
                        }
                    );
                }
            );
        </script>
        <?php Utility::loadFooter(); ?>
    </body>
</html>

