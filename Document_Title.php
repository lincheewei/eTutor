<?php
    include "session.php";
    require "utility.php";
    include "upload_config.php";
?>

<!DOCTYPE html>
<html lang="en">
    <?php Utility::loadHeader("Document Title", array("bootstrap.min.css", "jquery.dataTables.min.css")); ?>

    <body>
        <?php Utility::loadNavBar(); ?>
        <main class="container">
            <div class="row pt-3">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <h3 class="text-center">Document Title</h3>
                    <hr />
                    <form method="post" action="Document_Title.php">
                        <div class="table-responsive">
                            <table id="docdb" class="table table-striped table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th align="center">User's Email</th>
                                        <th align="center">Document Name</th>
                                        <th align="center">Download</th>
                                        <th align="center">Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = "SELECT * FROM docdb";
                                        $result = mysqli_query($db, $query);

                                        while ($displayDocData = mysqli_fetch_array($result)) {
                                            echo '
                                            <tr>
                                                <td align="center">' . $displayDocData["User_Email"] . '</td>
                                                <td align="center">' . $displayDocData["Doc_Title"] . '</td>
                                                <td align="center"><a href="Download_File.php?id='.$displayDocData["Doc_ID"].'" class="btn btn-info">Download</a></td>
                                                <td align="center"><a href="Document_Forum.php?id='.$displayDocData["Doc_ID"].'" class="btn btn-info">Comment</a></td>
                                            </tr>
                                            ';
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td align="center">User's Email</td>
                                        <td align="center">Document Name</td>
                                        <td align="center">Download</td>
                                        <td align="center">Comment</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js", "popper.js", "jquery.dataTables.min.js")); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#docdb').DataTable();
            })
        </script>
        <?php Utility::loadFooter(); ?>
    </body>
</html>

