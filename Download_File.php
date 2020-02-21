<?php
    include "session.php";
    include "upload_config.php";

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        $fetch_doc_data_sql = "SELECT * FROM docdb WHERE Doc_ID = '" . $id . "'";
        $result_doc_data = mysqli_query($db, $fetch_doc_data_sql);
        $display_doc_data = mysqli_fetch_assoc($result_doc_data);
        $document_name = $display_doc_data["Doc_New_Name"];

        $filename = $document_name;

        if (file_exists($filename)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($filename));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            ob_clean();
            flush();
            readfile($filename);
            exit;
        }
    }
