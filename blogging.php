<?php
require 'scrum_connection.php';
require('session.php');
require "utility.php";

$conn = getconnection();
$uid =  getUserEmail();
$uname = getUserName();

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 5;
$offset = ($pageno - 1) * $no_of_records_per_page;



?>

<!DOCTYPE html>
<html>
<?php Utility::loadHeader("Dashboard", array("bootstrap.min.css","fontawesome","custom.css")); ?>

<body>
<?php Utility::loadNavBar(); ?>
<main class="container">
    <div class="row pt-3">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <h3 class="text-center">Blog</h3>
            <hr
        </div>
<!--        <div class="col-md-12 col-xs-12 col-sm-12">-->
<!--            <div class="container my-4">-->
<!---->
                <!--Carousel Wrapper-->
<!--                <div id="multi-item-example" class=" carousel slide carousel-multi-item" data-ride="carousel">-->
<!---->
<!---->
<!---->
                    <!--Indicators-->
<!---->
                    <!--/.Indicators-->
<!---->
                    <!--Slides-->
<!--                    <div class="carousel-inner" role="listbox">-->
<!---->
                        <!--First slide-->
<!--                        <div class="carousel-item active">-->
<!---->
<!--                            <div class="row">-->
<!--                                <div class="col-md-4">-->
<!--                                    <div class="card mb-2">-->
<!--                                        <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(34).jpg"-->
<!--                                             alt="Card image cap">-->
<!--                                        <div class="card-body">-->
<!--                                            <h4 class="card-title">Card title</h4>-->
<!--                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the-->
<!--                                                card's content.</p>-->
<!--                                            <a class="btn btn-primary">Button</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <div class="col-md-4 clearfix d-none d-md-block">-->
<!--                                    <div class="card mb-2">-->
<!--                                        <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(18).jpg"-->
<!--                                             alt="Card image cap">-->
<!--                                        <div class="card-body">-->
<!--                                            <h4 class="card-title">Card title</h4>-->
<!--                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the-->
<!--                                                card's content.</p>-->
<!--                                            <a class="btn btn-primary">Button</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <div class="col-md-4 clearfix d-none d-md-block">-->
<!--                                    <div class="card mb-2">-->
<!--                                        <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(35).jpg"-->
<!--                                             alt="Card image cap">-->
<!--                                        <div class="card-body">-->
<!--                                            <h4 class="card-title">Card title</h4>-->
<!--                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the-->
<!--                                                card's content.</p>-->
<!--                                            <a class="btn btn-primary">Button</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
                        <!--/.First slide-->
<!---->
                        <!--Second slide-->
<!--                        <div class="carousel-item">-->
<!---->
<!--                            <div class="row">-->
<!--                                <div class="col-md-4">-->
<!--                                    <div class="card mb-2">-->
<!--                                        <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/City/4-col/img%20(60).jpg"-->
<!--                                             alt="Card image cap">-->
<!--                                        <div class="card-body">-->
<!--                                            <h4 class="card-title">Card title</h4>-->
<!--                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the-->
<!--                                                card's content.</p>-->
<!--                                            <a class="btn btn-primary">Button</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <div class="col-md-4 clearfix d-none d-md-block">-->
<!--                                    <div class="card mb-2">-->
<!--                                        <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/City/4-col/img%20(47).jpg"-->
<!--                                             alt="Card image cap">-->
<!--                                        <div class="card-body">-->
<!--                                            <h4 class="card-title">Card title</h4>-->
<!--                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the-->
<!--                                                card's content.</p>-->
<!--                                            <a class="btn btn-primary">Button</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <div class="col-md-4 clearfix d-none d-md-block">-->
<!--                                    <div class="card mb-2">-->
<!--                                        <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/City/4-col/img%20(48).jpg"-->
<!--                                             alt="Card image cap">-->
<!--                                        <div class="card-body">-->
<!--                                            <h4 class="card-title">Card title</h4>-->
<!--                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the-->
<!--                                                card's content.</p>-->
<!--                                            <a class="btn btn-primary">Button</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
                        <!--/.Second slide-->
<!---->
                        <!--Third slide-->
<!--                        <div class="carousel-item">-->
<!---->
<!--                            <div class="row">-->
<!--                                <div class="col-md-4">-->
<!--                                    <div class="card mb-2">-->
<!--                                        <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/4-col/img%20(53).jpg"-->
<!--                                             alt="Card image cap">-->
<!--                                        <div class="card-body">-->
<!--                                            <h4 class="card-title">Card title</h4>-->
<!--                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the-->
<!--                                                card's content.</p>-->
<!--                                            <a class="btn btn-primary">Button</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <div class="col-md-4 clearfix d-none d-md-block">-->
<!--                                    <div class="card mb-2">-->
<!--                                        <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/4-col/img%20(45).jpg"-->
<!--                                             alt="Card image cap">-->
<!--                                        <div class="card-body">-->
<!--                                            <h4 class="card-title">Card title</h4>-->
<!--                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the-->
<!--                                                card's content.</p>-->
<!--                                            <a class="btn btn-primary">Button</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <div class="col-md-4 clearfix d-none d-md-block">-->
<!--                                    <div class="card mb-2">-->
<!--                                        <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/4-col/img%20(51).jpg"-->
<!--                                             alt="Card image cap">-->
<!--                                        <div class="card-body">-->
<!--                                            <h4 class="card-title">Card title</h4>-->
<!--                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the-->
<!--                                                card's content.</p>-->
<!--                                            <a class="btn btn-primary">Button</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
                        <!--/.Third slide-->
<!---->
<!--                    </div>-->
                    <!--/.Slides-->
                    <!--Controls-->
<!---->
<!--                    <div class="controls-top">-->
<!--                        <a class="btn-floating waves-effect waves-light" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>-->
<!--                        <a class="btn-floating waves-effect waves-light" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>-->
<!--                    </div>-->
                    <!--/.Controls-->
<!---->
<!--                </div>-->
                <!--/.Carousel Wrapper-->
<!---->
<!---->
<!--            </div>-->
<!--        </div>-->

        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="row">

                <!-- Blog Entries Column -->
                <div class="col-md-8">

                    <h1 class="my-4">Recent Posts
                    </h1>


                    <!-- Blog Post -->
                    <?php
                    if(isset($_POST['blog_search'])){
                         $search_input="'".$_REQUEST['search_input']."'";
                         $total_pages_sql = "SELECT COUNT(*) FROM blog WHERE 
                        blog_title LIKE $search_input OR 
                        blog_category LIKE $search_input   OR 
                        blog_description LIKE $search_input OR 
                        blog_content LIKE $search_input  OR 
                        blog_author LIKE $search_input  
                        " ;

                        $result = mysqli_query($conn, $total_pages_sql) or die(mysqli_error($conn));


                        $total_rows = mysqli_fetch_array($result)[0];
                        $total_pages = ceil($total_rows / $no_of_records_per_page);

                        $select = "SELECT * FROM blog  WHERE 
                        blog_title LIKE $search_input OR 
                        blog_category LIKE $search_input OR 
                        blog_description LIKE $search_input OR 
                        blog_content LIKE $search_input OR 
                        blog_author LIKE $search_input LIMIT $offset,$no_of_records_per_page 
                        ORDER BY
                        blog_created 
                        DESC 
                        " ;

                        $result = mysqli_query($conn, $select)or die(mysqli_error($conn));

                        if (mysqli_num_rows($result) > 0) {
                            while (($row = mysqli_fetch_assoc($result))) {

                                if(!empty($row['blog_img']))
                                {
                                    $img_array = explode(",", $row["blog_img"]);
                                    $imageURL = 'uploads/' . $img_array[0];
                                    echo '<div class="card mb-4">';
                                    echo '<img class="card-img-top blog_img" src="'.$imageURL.'" alt="Card image cap">';
                                    echo '<div class="card-body">';
                                    echo '<h2 class="card-title">'.$row['blog_title'].'</h2>';
                                    echo '<p class="card-text">'.$row['blog_description'].'</p>';
                                    echo '<form method="post" id="read_more" name="read_more" action="readmore.php" >';
                                    echo '<button type="submit" class="btn btn-primary" name="read_more" id="read_more" value="'.$row['blog_id'].'">Read More &rarr;</button>';
                                    echo '</form>';                                    echo '</div>';
                                    echo '<div class="card-footer text-muted">';
                                    echo 'Posted on '.$row['blog_created'].' by '.$row['blog_author'];
                                    echo '</div>';
                                    echo '</div>';
                                }else{
                                    echo '<div class="card mb-4">';
                                    echo '<div class="card-body">';
                                    echo '<h2 class="card-title">'.$row['blog_title'].'</h2>';
                                    echo '<p class="card-text">'.$row['blog_description'].'</p>';
                                    echo '<form method="post" id="read_more" name="read_more" action="readmore.php" >';
                                    echo '<button type="submit" class="btn btn-primary" name="read_more" id="read_more" value="'.$row['blog_id'].'">Read More &rarr;</button>';
                                    echo '</form>';                                    echo '</div>';
                                    echo '<div class="card-footer text-muted">';
                                    echo 'Posted on '.$row['blog_created'].' by '.$row['blog_author'];
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                        }else{
                            echo '<p >Content not found!</p>';

                        }
                    }elseif(isset($_POST['category_input'])){
                        $category_input="'".$_REQUEST['category_input']."'";
                        $total_pages_sql = "SELECT COUNT(*) FROM blog WHERE                       
                        blog_category = $category_input 
                        " ;

                        $result = mysqli_query($conn, $total_pages_sql) or die(mysqli_error($conn));


                        $total_rows = mysqli_fetch_array($result)[0];
                        $total_pages = ceil($total_rows / $no_of_records_per_page);

                        $select = "SELECT * FROM blog  WHERE                      
                        blog_category = $category_input 
                        ORDER BY
                        blog_created 
                        DESC 
                         LIMIT $offset,$no_of_records_per_page 
                        " ;

                        $result = mysqli_query($conn, $select)or die(mysqli_error($conn));

                        if (mysqli_num_rows($result) > 0) {
                            while (($row = mysqli_fetch_assoc($result))) {

                                if(!empty($row['blog_img']))
                                {
                                    $img_array = explode(",", $row["blog_img"]);
                                    $imageURL = 'uploads/' . $img_array[0];
                                    echo '<div class="card mb-4">';
                                    echo '<img class="card-img-top blog_img" src="'.$imageURL.'" alt="Card image cap">';
                                    echo '<div class="card-body">';
                                    echo '<h2 class="card-title">'.$row['blog_title'].'</h2>';
                                    echo '<p class="card-text">'.$row['blog_description'].'</p>';
                                    echo '<form method="post" id="read_more" name="read_more" action="readmore.php" >';
                                    echo '<button type="submit" class="btn btn-primary" name="read_more" id="read_more" value="'.$row['blog_id'].'">Read More &rarr;</button>';
                                    echo '</form>';                                    echo '</div>';
                                    echo '<div class="card-footer text-muted">';
                                    echo 'Posted on '.$row['blog_created'].' by '.$row['blog_author'];
                                    echo '</div>';
                                    echo '</div>';
                                }else{
                                    echo '<div class="card mb-4">';
                                    echo '<div class="card-body">';
                                    echo '<h2 class="card-title">'.$row['blog_title'].'</h2>';
                                    echo '<p class="card-text">'.$row['blog_description'].'</p>';
                                    echo '<form method="post" id="read_more" name="read_more" action="readmore.php" >';
                                    echo '<button type="submit" class="btn btn-primary" name="read_more" id="read_more" value="'.$row['blog_id'].'">Read More &rarr;</button>';
                                    echo '</form>';                                    echo '</div>';
                                    echo '<div class="card-footer text-muted">';
                                    echo 'Posted on '.$row['blog_created'].' by '.$row['blog_author'];
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                        }else{
                            echo '<p >Content not found!</p>';

                        }

                    } else{
                        $total_pages_sql = "SELECT COUNT(*) FROM blog";
                        $result = mysqli_query($conn, $total_pages_sql);
                        $total_rows = mysqli_fetch_array($result)[0];
                        $total_pages = ceil($total_rows / $no_of_records_per_page);

                        $select = "SELECT * FROM blog 
                        ORDER BY
                        blog_created 
                        DESC 
                        LIMIT $offset,$no_of_records_per_page ";
                        $result = mysqli_query($conn, $select);
                        if (mysqli_num_rows($result) > 0) {
                            while (($row = mysqli_fetch_assoc($result))) {
                                if(!empty($row['blog_img']))
                                {
                                    $img_array = explode(",", $row["blog_img"]);
                                    $imageURL = 'uploads/' . $img_array[0];
                                    echo '<div class="card mb-4">';
                                    echo '<img class="card-img-top blog_img" src="'.$imageURL.'" alt="Card image cap">';
                                    echo '<div class="card-body">';
                                    echo '<h2 class="card-title">'.$row['blog_title'].'</h2>';
                                    echo '<p class="card-text">'.$row['blog_description'].'</p>';
                                    echo '<form method="post" id="read_more" name="read_more" action="readmore.php" >';
                                    echo '<button type="submit" class="btn btn-primary" name="read_more" id="read_more" value="'.$row['blog_id'].'">Read More &rarr;</button>';
                                    echo '</form>';
                                    echo '</div>';
                                    echo '<div class="card-footer text-muted">';
                                    echo 'Posted on '.$row['blog_created'].' by '.$row['blog_author'];
                                    echo '</div>';
                                    echo '</div>';
                                }else{
                                    echo '<div class="card mb-4">';
                                    echo '<div class="card-body">';
                                    echo '<h2 class="card-title">'.$row['blog_title'].'</h2>';
                                    echo '<p class="card-text">'.$row['blog_description'].'</p>';
                                    echo '<form method="post" id="read_more" name="read_more" action="readmore.php" >';
                                    echo '<button type="submit" class="btn btn-primary" name="read_more" id="read_more" value="'.$row['blog_id'].'">Read More &rarr;</button>';
                                    echo '</form>';                                    echo '</div>';
                                    echo '<div class="card-footer text-muted">';
                                    echo 'Posted on '.$row['blog_created'].' by '.$row['blog_author'];
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                        }
                    }


                    ?>

                    <!-- Pagination -->
                    <ul class="pagination justify-content-center mb-4">


                        <li class="page-item ">
                            <a class="page-link" href="?pageno=1">&laquo;</a>
                        </li>
                        <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>" >
                            <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">&larr;Newer </a>
                        </li>
                        <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                            <a class="page-link  " href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Older&rarr; </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="?pageno=<?php echo $total_pages; ?>">&raquo;</a>
                        </li>
                    </ul>

                </div>

                <!-- Sidebar Widgets Column -->
                <div class="col-md-4">

                    <!-- Search Widget -->
                    <form method="post" id="blog_search" name="blog_search" action="<?php echo $_SERVER['PHP_SELF']?>">
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
                    <form method="post" id="blog_filter" name="blog_filter" action="<?php echo $_SERVER['PHP_SELF']?>">
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
            <!-- /.row -->
        </div>
    </div>
</main>
<?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js")); ?>
<?php Utility::loadFooter(); ?>
</body>
</html>
