<?php
function upload($settings){
if (! wp_verify_nonce( $_POST['upload_form'], 'action' ))
 {
   print 'Sorry, your nonce did not verify.';
   exit;

} else {

if(isset($_POST['inputname'])){
    $inputname = $_POST['inputname'];
}

if(isset($_POST['directory']) && $_POST['directory'] != 'null'){
    $uploads_dir = $_POST['directory'];
}

    function increment_filename($filename){
        $filename = explode(".", $filename);
        $parts = explode(")(", $filename[0]);
        $last = array_pop($parts);
        $last = explode(")",$last);
        if(isset($last[1])){
            $last = ++$last[0];
            array_push($parts, $last);
            $parts = implode(")(", $parts);
            $parts = $parts.")";
            $newname = $parts.".".$filename[1];
        }else{
            $newname = $last[0]."(1).".$filename[1];
        }

        return $newname;
    }



$dir_path = wp_upload_dir()['basedir'];
$maxfilesize = 1000000;

for($i=0; $i < count($_FILES["files"]["name"]); $i++){
$tmp_name = $_FILES["files"]["tmp_name"][$i];
$name = basename($_FILES["files"]["name"][$i]);

$filesize = $_FILES["files"]["size"][$i];
$errorcode = $_FILES["files"]["error"][$i];
$imageFileType = pathinfo($name,PATHINFO_EXTENSION);
$allowed_file_types = ['jpg','png', 'gif'];
$error = NULL;
if($errorcode != 0){
    $error = "There was a problem uploading the file";
}else{
    if(!is_dir($dir_path.'/'.$uploads_dir)){

         mkdir($dir_path.'/'.$uploads_dir);
    }
    if(!in_array($imageFileType, $allowed_file_types)){
    $error = "<strong style='text-transform:uppercase'>".$imageFileType."</strong> is not an allowed file type (jpg, png, gif).";
    }

    if($filesize > $maxfilesize){
    $error = "This file size (".$filesize.") exceeded max file size (".$maxfilesize.").";
    }
}


while(is_file($dir_path.'/'.$uploads_dir.'/'.$name)){

$name = increment_filename($name);
}

   move_uploaded_file($tmp_name,$dir_path.'/'.$uploads_dir.'/'.$name);
  if($error != NULL){
      print_r( $error);
  }else{

    header('Location: ' . $_SERVER['HTTP_REFERER']);

 }
}
}
}
?>