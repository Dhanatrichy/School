<?php

//header("Content-Type: application/json");
//header("Acess-Control-Allow-Origin: *");
//header("Acess-Control-Allow-Methods: POST");
//header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

include_once('../database.php'); // include database connection file
if (isset($_REQUEST["action"])) {
    if (($_REQUEST["action"] == 'update_post')) {

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

        //$post_id = $_POST['post_id'];

        if ($post_id =='' && empty($post_id)) {
            echo json_encode(['status' => 'true', 'msg' => 'Post Id Missing', 'result' => 'Error']);
        }else{

            if (empty($fileName)) {
                if (!empty($title) && !empty($description)) {
                    $update = "UPDATE tbl_post SET school_id = '" . $school_id . "',author_id = '" . $author_id . "',author_type = '" . $author_type . "',title = '" . $title . "',allow_like = '" . $allow_like . "',allow_comment = '" . $allow_comment . "',description = '" . $description . "',updatedon = '" . date("Y-m-d H:i:s", $updatedon) . "',status = '" . $status . "' WHERE id = '" . $post_id . "' ";
                    $run_update = mysqli_query($db, $update);
                    if (mysqli_affected_rows($run_update) >0) {

                        if (!empty($_POST['class_assign_id'])) {
                            $classIds = $_POST['class_assign_id'];
                            $inserClass = multipal_insert_data('tbl_assign_class_post', $post_id, $classIds, 'post_id', 'class_id', $post_id);
                        }
                        if (!empty($_POST['section_assign_id'])) {
                            $sectionIds = $_POST['section_assign_id'];
                            $insertSection = multipal_insert_data('tbl_assign_section_post', $post_id, $sectionIds, 'post_id', 'section_id', $post_id);
                        }
                        if (!empty($_POST['audience_type'])) {
                            $audienceIds = $_POST['audience_type'];
                            $insertAud = multipal_insert_data('tbl_assign_audience_post', $post_id, $audienceIds, 'post_id', 'audience_id', $post_id);
                        }

                        echo json_encode(['status' => 'true', 'msg' => 'Post Updated Successfully', 'result' => 'Operation Complete']);
                    }
                }else{
                    echo json_encode(['status' => 'true', 'msg' => 'Please Fill Mandetory Fields', 'result' => 'Error']);
                }
                //echo json_encode(['status' => 'true', 'msg' => 'Please Select Image', 'result' => 'Error']);
            } else {

                if ($author_type == 'school') {
                    $upload_path = '../../school/uploads/posts/'; // set upload folder path 
                } else if ($author_type == 'teacher') {
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

                            $time = time();
                            $update = "UPDATE tbl_post SET school_id = '" . $school_id . "',author_id = '" . $author_id . "',author_type = '" . $author_type . "',title = '" . $title . "',allow_like = '" . $allow_like . "',allow_comment = '" . $allow_comment . "',description = '" . $description . "',image = '" . $file . "',updatedon = '" . date("Y-m-d H:i:s", $updatedon) . "',status = '" . $status . "' WHERE id = '" . $post_id . "' ";
                            $run_update = mysqli_query($db, $update);
                            if (mysqli_affected_rows($run_update) >0) {

                                if (!empty($_POST['class_assign_id'])) {
                                    $classIds = $_POST['class_assign_id'];
                                    $inserClass = multipal_insert_data('tbl_assign_class_post', $post_id, $classIds, 'post_id', 'class_id', $post_id);
                                }
                                if (!empty($_POST['section_assign_id'])) {
                                    $sectionIds = $_POST['section_assign_id'];
                                    $insertSection = multipal_insert_data('tbl_assign_section_post', $post_id, $sectionIds, 'post_id', 'section_id', $post_id);
                                }
                                if (!empty($_POST['audience_type'])) {
                                    $audienceIds = $_POST['audience_type'];
                                    $insertAud = multipal_insert_data('tbl_assign_audience_post', $post_id, $audienceIds, 'post_id', 'audience_id', $post_id);
                                }
                                
                                move_uploaded_file($tempPath, $upload_path . $file); // move file from system temporary path to our upload folder path 
                                echo json_encode(['status' => 'true', 'msg' => 'Post Updated Successfully', 'result' => 'Operation Complete']);
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
}

?>