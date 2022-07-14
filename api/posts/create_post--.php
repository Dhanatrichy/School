<?php

//header("Content-Type: application/json");
//header("Acess-Control-Allow-Origin: *");
//header("Acess-Control-Allow-Methods: POST");
//header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

include_once('../database.php'); // include database connection file
if (isset($_GET["action"])) {
    if (($_GET["action"] == 'create_post')) {

        extract($_POST);
//$data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format
//
//$school_id = $data['school_id'];
//$author_id = $data['author_id'];
//$author_type = $data['author_type'];
//$title = $data['title'];
//$description = $data['description'];

        $fileName = $_FILES['file']['name'];
        $tempPath = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];

        if (empty($fileName)) {
            echo json_encode(['status' => 'true', 'msg' => 'Please Select Image', 'result' => 'Error']);
        } else {

            if($author_type=='school'){
                $upload_path = '../../school/uploads/posts/'; // set upload folder path 
            }else if($author_type=='teacher'){
                $upload_path = '../../teacher/uploads/posts/'; // set upload folder path 
            }
            
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // get image extension

            $file = time() . '.' . $fileExt;

            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf', 'doc', 'docx');

            // allow valid image file formats
            if (in_array($fileExt, $valid_extensions)) {
                //check file not exist our upload folder path
                if (!file_exists($upload_path . $fileName)) {
                    // check file size '5MB'
                    if ($fileSize < 5000000) {

                        $time=time();
                        $insert = "insert into tbl_post(school_id,author_id,author_type,title,allow_like,allow_comment,description,image,datetime,addedon,status)values('" . $school_id . "','" . $author_id . "','" . $author_type . "','" . $title . "','" . $allow_like . "','" . $allow_comment . "','" . $description . "','" . $file . "','" . date("Y-m-d H:i:s", $time) . "','" . $time . "','requested')";
                        $run_insert = mysqli_query($db, $insert);
                        if (mysqli_insert_id($db) > 0) {
                            move_uploaded_file($tempPath, $upload_path . $file); // move file from system temporary path to our upload folder path 
                            echo json_encode(['status' => 'true', 'msg' => 'Post Created Successfully', 'result' => 'Operation Complete']);
                        }
                    } else {
                        echo json_encode(['status' => 'true', 'msg' => 'Sorry, your file is too large, please upload 5 MB size', 'result' => 'Error']);
                    }
                } else {
                    echo json_encode(['status' => 'true', 'msg' => 'Sorry, file already exists check upload folder', 'result' => 'Error']);
                }
            } else {
                echo json_encode(['status' => 'true', 'msg' => 'Sorry, only JPG, JPEG, PNG, PDF, DOC, DOCX & GIF files are allowed', 'result' => 'Error']);
            }
        }
    }
}
