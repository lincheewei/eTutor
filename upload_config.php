<?php   
    $db = mysqli_connect('localhost', 'root', '', 'etutor') or die ('Could not connect to the database' . mysqli_connect_error());
    //add new comment
    if(isset($_POST['AddCommentBTN'])){
        $Comment = mysqli_real_escape_string($db,$_POST['InputComment']);
        $Comment_Doc_ID = mysqli_real_escape_string($db,$_POST['InputDocID']);
        $Comment_User_Email = $_SESSION['Email'];

        mysqli_query($db, "INSERT INTO commentdb (D_ID,Comment_Content,Comment_User_Email) VALUES ('$Comment_Doc_ID','$Comment','$Comment_User_Email')");
        echo "<script type='text/javascript'>alert('Comment Added!');</script>";


    }

    //upload test 2
    if (isset($_POST['UploadBTN'])) {
        $Document_Title = mysqli_real_escape_string($db, $_POST['InputDocumentTitle']);

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
