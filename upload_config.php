<?php   
    $db = mysqli_connect('localhost', 'root', '', 'etutor') or die ('Could not connect to the database' . mysqli_connect_error());
    $errorMessages = array();
    //add new comment
    if(isset($_POST['AddCommentBTN'])){
        if (preg_match("/[^a-zA-Z0-9 ]/", $_POST['InputComment']) || empty(trim($_POST['InputComment']))){
            $errorMessages[] = "Invalid comment.";
        } else {
            $Comment = trim(mysqli_real_escape_string($db,$_POST['InputComment']));
        }                

        if (preg_match("/[^0-9]/", $_POST['InputDocID']) || empty(trim($_POST['InputDocID']))){
            $errorMessages[] = "Invalid document ID.";
        } else {
            $Comment_Doc_ID = trim(mysqli_real_escape_string($db,$_POST['InputDocID']));
        }                

        $Comment_User_Email = $_SESSION['Email'];

        if(count($errorMessages) === 0){
            mysqli_query($db, "INSERT INTO commentdb (D_ID,Comment_Content,Comment_User_Email) VALUES ('$Comment_Doc_ID','$Comment','$Comment_User_Email')");
            echo "<script type='text/javascript'>alert('Comment Added!');</script>";
        }
    }

    //upload test 2
    if (isset($_POST['UploadBTN'])) {
        if (preg_match("/[^a-zA-Z0-9 ]/", $_POST['InputDocumentTitle']) || empty(trim($_POST['InputDocumentTitle']))){
            $errorMessages[] = "Invalid document title.";
        } else {
            $Document_Title = trim(mysqli_real_escape_string($db, $_POST['InputDocumentTitle']));
        }                

        if(count($errorMessages) === 0){
            $name = $_FILES['fileToUpload']['name'];
            $cname = str_replace(" ", "_", $name);
            $tmp_name = $_FILES['fileToUpload']['tmp_name'];
            $target_path = "Uploaded_Documents/";
            $target_path = $target_path . basename($cname);

            $allowed_docs_extension = array(
                "docx",
                "pdf",
                "zip"
            );

            function findexts ($filename)
            {
                $filename = strtolower($filename) ;
                $exts = preg_split("[/\\.]", $filename) ;
                $n = count($exts)-1;
                $exts = $exts[$n];
                return $exts;
            }
            //This applies the function to our file
            $ext = findexts ($_FILES['fileToUpload']['name']) ;

            $ran = rand();
            $ran2 = $ran.".";
            $target_path = $target_path.$ran2.$ext;

            // Get doc file extension
            $file_extension = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);

            if (!in_array($file_extension, $allowed_docs_extension)) {
                echo "<script type='text/javascript'>alert('Only accept .docx and .pdf!');</script>";
            } else {
                $uploaded_file = $_FILES['fileToUpload']['tmp_name'];
                $uploaded_file = file_get_contents($uploaded_file);
                $uploaded_file = base64_encode($uploaded_file);

                $User_Email = $_SESSION['Email'];

                move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_path);

                mysqli_query($db, "INSERT INTO docdb (Doc_Title, Doc_Name,Doc_New_Name,User_Email) VALUES ('$Document_Title','$cname','$target_path','$User_Email')");
                echo "<script type='text/javascript'>alert('Successfully Upload!');</script>";
            }
        }
    }

    //delete comment
    if (isset($_GET["delete"])&& !isset($_POST['AddCommentBTN'])) {
        $id = $_GET["delete"];
        $commentEmail = getUserEmail();
        $sql_delete_comment = "DELETE FROM commentdb WHERE Comment_ID ='$id' AND Comment_User_Email = '$commentEmail'";
        $result_delete_comment = mysqli_query($db, $sql_delete_comment);

        echo "<script type='text/javascript'>alert('Successfully Delete')</script>";
    }
