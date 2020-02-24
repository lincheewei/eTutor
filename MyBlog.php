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
            <h3 class="text-center">My Blog</h3>
            <hr />
            <div class="table-responsive">

                <div class="form-group float-lg-left">
                    <a href="create_blog.php" class="btn btn-success"><i class="fa fa-plus"></i> Create New Blog</a>
                </div>

                <table class="table table-bordered table-striped table-hover" id="MyBlog" name="MyBlog" >
                    <thead>
                    <tr>
                        <th scope="col">Blog ID</th>
                        <th scope="col">Blog Title</th>
                        <th scope="col">Blog Category</th>
                        <th scope="col">Blog Description</th>
                        <th scope="col">Blog Content </th>
                        <th scope="col">Blog Images </th>
                        <th scope="col">Blog Author</th>
                        <th scope="col">Blog Created</th>
                        <th scope="col">Blog Updated</th>

                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $select = "SELECT * FROM blog WHERE blog.blog_author  = '$uname'";
                    //            $select = "SELECT * FROM blog ";

                    $result = mysqli_query($conn, $select);

                    if(mysqli_num_rows($result)>0) {
                        while (($row = mysqli_fetch_assoc($result))) {
                            echo " <tr class=\"table-default\">
               <td>".$row['blog_id']."</td>
               <td>".$row['blog_title']."</td>
               <td>".$row['blog_category']."</td>
               <td>".$row['blog_description']."</td>
               <td>".$row['blog_content']."</td>
             
               <td>";
                            $img_array = explode(",",$row["blog_img"]);
                            foreach ($img_array as $img){
                                if(!empty($img)){
                                    $imageURL= 'uploads/'.$img;
                                    echo "<img class='img-fluid' style='padding-bottom:20px' src ='".$imageURL."'>";
                                }

                            }

                            echo "</td>
            
                  <td>".$row['blog_author']."</td>
                  <td>".$row['blog_created']."</td>
                  <td>".$row['blog_updated']."</td>

<td>
               <button type='button' class='btn btn-sm btn-info edit_blog' id='".$row['blog_id']."' name='edit' id='edit' value='edit' style='width: 100%'>Edit</button>
               <button type='button' class='btn btn-sm btn-danger delete_blog' id='".$row['blog_id']."' name='delete' id='delete' value='delete' style='width: 100%'>Delete</button></td>
</tr> ";
                        }
                    }
                    else{
                        echo  $select.mysqli_error($conn);
                    }


                    ?>
                    <tfoot>
                    <tr>
                        <th scope="col">Blog ID</th>
                        <th scope="col">Blog Title</th>
                        <th scope="col">Blog Category</th>
                        <th scope="col">Blog Description</th>
                        <th scope="col">Blog Content </th>
                        <th scope="col">Blog Images </th>
                        <th scope="col">Blog Author</th>
                        <th scope="col">Blog Created</th>
                        <th scope="col">Blog Updated</th>

                        <th scope="col">Action</th>
                    </tr>
                    </tfoot>
                    </tbody>
                </table>

            </div>


        </div>
    </div>

    <!-- add service modal -->
    <div id="add_Blog_Modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Blog</h4>

                    <button type="reset" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
       <form method="post" id="add_blog_form" onsubmit="return false;" >
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

           <input type="hidden" id="blog_id">




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

                    <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />

                </div>
                </form>

            </div>
        </div>
    </div>
</main>
<?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js", "popper.js", "jquery.dataTables.min.js")); ?>
<script>
    $(document).ready( function () {
        $('#MyBlog').DataTable({
        });
        $('#MyBlog').dataTable();


        $(document).on('click', '.edit_blog', function(){

            // $('#add_service_form')[0].reset();
            $("input[type=checkbox]").prop("checked",false);

            var array ;

            var id = $(this).attr("id");
            var action = "select";
            var form_data = new FormData();
            form_data.append('id', id);
            form_data.append('action', action);
            // $('#msg').attr('hidden',true);
            // $('#msg').attr('readonly',false);
            $.ajax({
                url: 'blog_server.php',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',

                success:function(data){
                    console.log(data.service_location);
                    $('#blog_id').val(data.blog_id);
                    $('#BlogTitleInput').val(data.blog_title);
                    $('#BlogCategoryInput').val(data.blog_category);
                    $('#BlogDescriptionInput').val(data.blog_description);
                    $('#BlogContentInput').val(data.blog_content);
                    $('#insert').val("Update");

                    $('#add_Blog_Modal').modal('show');

                },
                error: function(jqXHR, exception) {

                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    $('#post').html(msg);
                }
            });

        });


        $(document).on('click', '.delete_blog', function(){
            var action="delete";
            var id = $(this).attr("id");
            var el = this;
            var form_data = new FormData();
            form_data.append('id', id);
            form_data.append('action', action );
            if(confirm("Are you sure you want to delete this?"))
            {
                $.ajax({
                    url: 'blog_server.php',
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (php_script_response) {
                        alert(php_script_response);

                        $(el).parents('tr').css('background', '#de6f6c').find("tr");
                        $(el).parents('tr').fadeOut(800, function () {
                            $(this).remove();

                        });
                        window.location.reload();

                    }
                });
            }
            else
            {
                return false;
            }
        });



        $('#add_blog_form').on("submit", function(){
            var totalfiles = document.getElementById('ImagesUpload[]').files.length;

            console.log(totalfiles);
            var form_data = new FormData();
            var action="edit";
            var id = $('#blog_id').val();
            var blog_title=$('#BlogTitleInput').val();
            var blog_category=$('#BlogCategoryInput').val();
            var blog_description=$('#BlogDescriptionInput').val();
            var blog_content=$('#BlogContentInput').val();

            form_data.append('action', action);
            form_data.append('id', id);
            form_data.append('blog_title', blog_title);
            form_data.append('blog_category', blog_category);
            form_data.append('blog_description', blog_description);
            form_data.append('blog_content', blog_content);


            for (var x = 0; x < totalfiles; x++) {
                form_data.append("files[]", document.getElementById('ImagesUpload[]').files[x]);
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
                    alert(php_script_response);
                    window.location.reload();

                },

            });
        })
        ;

    } );
</script>


<?php Utility::loadFooter(); ?>
</body>
</html>
