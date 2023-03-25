<?php
//if csrf passes
if ($_COOKIE['ckCsrfToken'] == $_POST['ckCsrfToken']) {

    //define file sizes
    define('KB', 1024);
    define('MB', 1048576);
    define('GB', 1073741824);
    define('TB', 1099511627776);

    //set variables 
    $tmpName         = $_FILES['upload']['tmp_name'];
    $filename        = $_FILES['upload']['name'];
    $size            = $_FILES['upload']['size'];
    $filePath      = "files/" . date('d-m-Y-H-i-s').'-'.$filename;
    $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $type            = $_GET['type'];
    $funcNum        = isset($_GET['CKEditorFuncNum']) ? $_GET['CKEditorFuncNum']: null;

    if ($type == 'image') {
        $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png');
    } else {
        //file
        $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx');
    }

    //contrinue only if file is allowed
    if (in_array($fileExtension, $allowedfileExtensions)) {

        //contunie if file is less then the desired size
        if ($size < 20*MB) {

            if (move_uploaded_file($tmpName, $filePath)) {

                $filePath = str_replace('../', 'http://filemanager.localhost/elfinder/', $filePath);
                $data = ['uploaded' => 1, 'fileName' => $filename, 'url' => $filePath];

                if ($type == 'file') {

                    echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$filePath');</script>";
                    exit();
                }

            } else {

                $error = 'There has been an error, please contact support.';

                if ($type == 'file') {
                    $message = $error;

                    echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$filePath', '$message');</script>";
                    exit();
                }

                $data = array('uploaded' => 0, 'error' => array('message' => $error));

            }

        } else {

            $error = 'The file must be less than 20MB';

            if ($type == 'file') {
                $message = $error;

                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$filePath', '$message');</script>";
                exit();
            }

            $data = array('uploaded' => 0, 'error' => array('message' => $error));

        }

    } else {

        $error = 'The file type uploaded is not allowed.';

        if ($type == 'file') {
            $funcNum = $_GET['CKEditorFuncNum'];
            $message = $error;

            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$filePath', '$message');</script>";
            exit();
        }


        $data = array('uploaded' => 0, 'error' => array('message' => $error));

    }

    //return response
    echo json_encode($data);
}
