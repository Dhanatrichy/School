<?php

include_once('../../database.php'); // include database connection file
if (isset($_GET["action"])) {
    if (($_GET["action"] == 'add_assignment')) {

        extract($_POST);
        
        if ($title == "") {
            $errorMsg .= "Please Enter The Title.<br />";
        }

        if ($class_id == "") {
            $errorMsg .= "Please Select Class.<br />";
        }

        if ($section_id == "") {
            $errorMsg .= "Please Select Section.<br />";
        }

        if ($subject_id == "") {
            $errorMsg .= "Please Select Subject.<br />";
        }
        
        if ($errorMsg == '') {

            $fileName = $_FILES['file']['name'];
            $tempPath = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];

            if (empty($fileName)) {
                echo json_encode(['status' => 'true', 'msg' => 'Please Select Image', 'result' => 'Error']);
            } else {

                $upload_path = '../../../teacher/uploads/assignments/'; // set upload folder path 

                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // get image extension

                $file = time() . '.' . $fileExt;

                // valid image extensions
                $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xlsx');

                // allow valid image file formats
                if (in_array($fileExt, $valid_extensions)) {
                    //check file not exist our upload folder path
                    if (!file_exists($upload_path . $fileName)) {
                        // check file size '5MB'
                        if ($fileSize < 5000000) {

                            $time=time();
                            $insert = "insert into tbl_student_assignment(school_id,teacher_id,title,class_id,section_id,subject_id,attachment,datetime,addedon)values('" . $school_id . "','" . $teacher_id . "','" . $title . "','" . $class_id . "','" . $section_id . "','" . $subject_id . "','" . $file . "','" . date("Y-m-d H:i:s", $time) . "','" . $time . "')";
                            $run_insert = mysqli_query($db, $insert);
                            if (mysqli_insert_id($db) > 0) {
                                move_uploaded_file($tempPath, $upload_path . $file); // move file from system temporary path to our upload folder path 
                                echo json_encode(['status' => 'true', 'msg' => 'Added Successfully', 'result' => 'Operation Complete']);
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
        }else{
            echo json_encode(['status' => 'true', 'msg' => $errorMsg, 'result' => 'Error']);
        }
    }
}
?>