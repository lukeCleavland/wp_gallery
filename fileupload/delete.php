<?php
function delete($settings)
{
    if (! wp_verify_nonce( $_POST['delete_form'], 'action' ))
    {
        print 'Sorry, your nonce did not verify.';
        exit;

    } else {

        if(isset($_POST['directory']) && $_POST['directory'] != 'null'){
            $uploads_dir = $_POST['directory'];
        }

        if(isset($_POST['delete_directory']) && $_POST['delete_directory'] != 'null'){
            $delete_directory = true;
        }

        $dir = wp_upload_dir()['basedir']."/".$uploads_dir;
        if(is_dir($dir)){
            $delete_dir = array_filter(scandir($dir), function($item) {
            return $dir."/".$item;
            });

            $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) {
                if(is_dir("$dir/$file")) {
                    $s_files = array_diff(scandir("$dir/$file"), array('.','..'));
                    foreach($s_files as $s_file){
                        unlink("$dir/$file/$s_file");
                    }
                    if($delete_directory){
                        rmdir("$dir/$file");
                    }

                }else{
                unlink("$dir/$file");
                }

            }
            if($delete_directory){
                rmdir($dir);
            }
        }else{
             echo "Directory does not exist."; echo " <a href='".$_SERVER['HTTP_REFERER']."'>&lt;&lt; back</a>"; exit;
        }
    }
}
?>