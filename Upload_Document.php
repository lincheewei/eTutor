<?php
    include "session.php";
    require "utility.php";
    include "upload_config.php";
?>

<!DOCTYPE html>
<html lang="en">
    <?php Utility::loadHeader("Upload Document", array("bootstrap.min.css")); ?>

    <body>
        <?php Utility::loadNavBar(); ?>
        <main class="container">
            <div class="row pt-3">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <form action="Upload_Document.php" method="post" autocomplete="off" enctype="multipart/form-data">
                        <h3 class="text-center">Upload Document</h3>
                        <hr />
                        <div class="form-group">
                            <label for="DocumentTitle">Document Title</label>
                            <input type="text" class="form-control" id="InputDocumentTitle" name="InputDocumentTitle">
                        </div>
                        <div class="form-group">                            
                            <label for="fileToUpload">Choose file</label>
                            <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required />
                            <small id="emailHelp" class="form-text text-muted">Accept .docx or .pdf only.</small>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="UploadBTN">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js", "popper.js")); ?>
        <?php Utility::loadFooter(); ?>
    </body>
</html>
