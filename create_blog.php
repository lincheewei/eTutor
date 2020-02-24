<?php
require 'scrum_connection.php';
require('session.php');
require "utility.php";

$conn = getconnection();
$uid =  getUserEmail();
$uname = getUserName();
?>
<html xmlns="http://www.w3.org/1999/html">
<?php Utility::loadHeader("View meeting", array("bootstrap.min.css", "jquery.dataTables.min.css")); ?>
<body>
<?php Utility::loadNavBar(); ?>
<main class="container">
    <div class="row pt-3">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <form method="post" enctype="multipart/form-data" action=" <?php echo $_SERVER['PHP_SELF']?>" id="add_blog" name="add_blog">
                <div class="form-group">
                    <label for="BlogTitleInput" >Blog Title </label>
                    <input type="text" class="form-control" id="BlogTitleInput" name="BlogTitleInput" placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="BlogCategoryInput" >Blog Category </label>
                    <select class="form-control" id="BlogCategoryInput" name="BlogCategoryInput" required>
                        <option selected="" value="">Select Your Blog Type</option>
                        <option value="HTML">HTML</option>
                        <option value="PHP">PHP</option>
                        <option value="JavaScript">JavaScript</option>
                        <option value="Jquery">Jquery</option>
                        <option value="Bootstrap">Bootstrap</option>
                        <option value="My SQL">My SQL</option>
                    </select>

                </div>


                <div class="form-group">
                    <label for="BlogDescriptionInput">Blog Description</label>
                    <textarea class="form-control" id="BlogDescriptionInput" name="BlogDescriptionInput" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="BlogContentInput">Blog Content</label>
                    <textarea class="form-control" id="BlogContentInput" name="BlogContentInput" rows="6" required></textarea>

                </div>

                <div class="form-group">
                    <label for="ImagesUpload" >Blog Images</label>
                    <input type="file" class="form-control-file" id="ImagesUpload[]" name="ImagesUpload[]" multiple>
                    <small id="ImagesUploadHelp" class="form-text  " style="color: red"><?php
                        if(isset($_SESSION['ImagesUploadErr'])){
                            echo $_SESSION['ImagesUploadErr'];
                            unset($_SESSION['ImagesUploadErr']);
                        }
                        ?></small>
                </div>
                <div class="form-group float-right">
                    <a href="./MyBlog.php" class="btn btn-danger">Cancel</a>

                    <button type="submit" class="btn btn-success " name="add_blog" id="add_blog" >Submit</button>

                </div>

            </form>


        </div>
    </div>
</main>
<?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js", "popper.js", "jquery.dataTables.min.js")); ?>
<script>
    $(document).ready( function () {
        $('#MyBlog').DataTable({
        });
        $('#MyBlog').dataTable();
    } );

    $('#add_blog').on("submit", function(){
        console.log("hi");
        var totalfiles = document.getElementById('ImagesUpload[]').files.length;
        console.log(totalfiles);
       var form_data = new FormData();
        var action="add";
        var id = $('#blog_id').val();
        var blog_title=$('#BlogTitleInput').val();
        var blog_category=$('#BlogCategoryInput').val();
        var blog_description=$('#BlogDescriptionInput').val();
        var blog_content=$('#BlogContentInput').val();
        console.log(blog_content);
        form_data.append('action', action);
        form_data.append('id', id);
        form_data.append('blog_title', blog_title);
        form_data.append('blog_category', blog_category);
        form_data.append('blog_description', blog_description);
        form_data.append('blog_content', blog_content);


        for (var x = 0; x < totalfiles; x++) {
            form_data.append("ImagesUpload[]", document.getElementById('ImagesUpload[]').files[x]);
        }

        $.ajax({
            url: 'blog_server.php',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',

            beforeSend:function(){

                $('#insert').val("Inserting");
            },

            success: function(php_script_response){
                console.log("success");
                alert(php_script_response);
                window.location = "MyBlog.php";

            },

        });
    })
    ;

</script>
<?php Utility::loadFooter(); ?>



</body>

</html>
