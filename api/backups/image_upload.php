<?php 

//header("Content-Type: application/json");
//header("Acess-Control-Allow-Origin: *");
//header("Acess-Control-Allow-Methods: POST");
//header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

include_once('database.php'); // include database connection file

$data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format

$fileName = $_FILES['file']['name'];
$tempPath = $_FILES['file']['tmp_name'];
$fileSize = $_FILES['file']['size'];

if (empty($fileName)) {
    $errorMSG[] .= "please select image";
    
} else {
    
    $upload_path = '../../../school/uploads/posts/'; // set upload folder path 

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // get image extension
    
    $file=time().'.'.$fileExt;

    // valid image extensions
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf', 'doc', 'docx');

    // allow valid image file formats
    if (in_array($fileExt, $valid_extensions)) {
        //check file not exist our upload folder path
        if (!file_exists($upload_path . $fileName)) {
            // check file size '5MB'
            if ($fileSize < 5000000) {
                move_uploaded_file($tempPath, $upload_path . $file); // move file from system temporary path to our upload folder path 
            } else {
                $errorMSG[] .= "Sorry, your file is too large, please upload 5 MB size";
            }
        } else {
            $errorMSG[] .= "Sorry, file already exists check upload folder";
        }
    } else {
        $errorMSG[] .= "Sorry, only JPG, JPEG, PNG, PDF, DOC, DOCX & GIF files are allowed";
    }
}

// if no error caused, continue ....
if (count($errorMSG)>0) {
    echo json_encode(['status' => 'true', 'msg' => $errorMSG, 'result' => 'Error']);
}else{
    echo json_encode(['status' => 'true', 'msg' => "Image Uploaded Successfully", 'result' => 'Error']);
   
}
 
?>