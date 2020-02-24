<?php
require 'scrum_connection.php';
require('session.php');
require "utility.php";

$conn = getconnection();
$uid =  getUserEmail();
$uname = getUserName();




?>

<!DOCTYPE html>
<html>
<?php Utility::loadHeader("Dashboard", array("bootstrap.min.css","fontawesome","custom.css")); ?>

<body>
<?php Utility::loadNavBar(); ?>
<main class="container">
    <div class="row pt-3">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <h3 class="text-center">Blog Post</h3>
            <hr
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="row">

                <!-- Post Content Column -->
                <div class="col-lg-8">
<?php

if (isset($_POST['read_more'])) {
$blog_id = $_REQUEST['read_more'];

$select = "SELECT * FROM blog where blog_id = $blog_id ";
$result = mysqli_query($conn, $select);
if (mysqli_num_rows($result) > 0) {
    while (($row = mysqli_fetch_assoc($result))) {
        if(!empty($row['blog_img']))
        {
            $img_array = explode(",",$row["blog_img"]);

            echo '<h1 class="mt-4">'.$row['blog_title'].'</h1>';
            echo '<p class="lead">';
            echo 'by ';
            echo '<a href="#">'.$row['blog_author'].'</a>';
            echo '</p>';
            echo '<hr>';
            echo '<p>Posted on '.$row['blog_created'].'</p>';
            echo '<hr>';
            echo '<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">';
            echo '<ol class="carousel-indicators">';
            $data_slide= 0;
            foreach ($img_array as $img){
                if(!empty($img)){
                    $imageURL= 'uploads/'.$img;
                    if($data_slide==0){
                        echo '<li data-target="#carouselExampleIndicators" data-slide-to="'.$data_slide.'" class="active"></li>';

                    }else{
                        echo '<li data-target="#carouselExampleIndicators" data-slide-to="'.$data_slide.'" ></li>';
                    }
                    $data_slide++;
                }

            }


            echo '</ol>';

            echo '<div class="carousel-inner">';

            $i = 0;
            foreach ($img_array as $img){
                if(!empty($img)){
                    $imageURL= 'uploads/'.$img;
                    if($i==0){
                        echo "active";
                        echo '<div class="carousel-item active ">';
                        echo '<img class="d-block w-100 post_img" src="'.$imageURL.'" alt="Second slide">';
                        echo '</div>';
                    }else{
                        echo "not active";

                        echo '<div class="carousel-item ">';
                        echo '<img class="d-block w-100 post_img" src="'.$imageURL.'" alt="Second slide">';
                        echo '</div>';
                    }
                  $i++;
                }

            }
            echo '</div>';
            echo '<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">';
            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Previous</span>';
            echo '</a>';
            echo '<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">';
            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Next</span>';
            echo '</a>';
            echo '</div>';            echo '<hr>';
            echo '<p class="lead">'.$row['blog_description'].'</p>';
            echo '<p>'.$row['blog_content'].'</p>';
            echo '<hr>';
        }else{

            echo '<h1 class="mt-4">'.$row['blog_title'].'</h1>';
            echo '<p class="lead">';
            echo 'by ';
            echo '<a href="#">'.$row['blog_author'].'</a>';
            echo '</p>';
            echo '<hr>';
            echo '<p>Posted on '.$row['blog_created'].'</p>';
            echo '<hr>';
            echo '<p class="lead">'.$row['blog_description'].'</p>';
            echo '<p>'.$row['blog_content'].'</p>';
            echo '<hr>';


        }



    }
}

}else{

}
        ?>

                </div>
                <!-- Sidebar Widgets Column -->
                <div class="col-md-4">

                    <!-- Search Widget -->
                    <form method="post" id="blog_search" name="blog_search" action="blogging.php">
                        <div class="card my-4">
                            <h5 class="card-header">Search</h5>
                            <div class="card-body">
                                <div class="input-group">
                                    <input type="text" id="search_input" name="search_input" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                            <button class="btn btn-secondary" id="blog_search" name="blog_search" type="submit">Go!</button>
                </span>
                                </div>
                            </div>
                        </div>
                    </form>


                    <!-- Categories Widget -->
                    <form method="post" id="blog_filter" name="blog_filter" action="blogging.php">
                        <div class="card my-4">
                            <h5 class="card-header">Categories</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <button class="category" name="category_input" type="submit" value="HTML">HTML</button>
                                            </li>
                                            <li>
                                                <button class="category" name="category_input" type="submit" value="PHP">PHP</button>
                                            </li>
                                            <li>
                                                <button class="category" name="category_input" type="submit" value="JavaScript">JavaScript</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <button class="category" name="category_input" type="submit" value="JQuery">JQuery</button>
                                            </li>
                                            <li>
                                                <button class="category" name="category_input" type="submit" value="Bootstrap">Bootstrap</button>
                                            </li>
                                            <li>
                                                <button class="category" name="category_input" type="submit" value="My SQL">My SQL</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                    <!-- Side Widget -->
                    <div class="card my-4">
                        <h5 class="card-header">Shortcuts</h5>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col text-center ">
                                    <div class="btn-group btn-group-justified">
                                        <div class=" btn-group-vertical">
                                            <a href="MyBlog.php" class="btn btn-success"><i class="fa fa-list"></i> My Blogs</a>
                                            <a href="create_blog.php" class="btn btn-success"><i class="fa fa-plus"></i> Create New Blog</a>
                                        </div>
                                    </div>

                                </div>

                            </div>
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
