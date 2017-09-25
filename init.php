<?php
/**
 * Plugin Name: Bare Bones Gallery
 * Plugin URI: https://github.com/lukeCleavland/wp_gmaps.git
 * Description: Just a gallery no BS
 * Version: 1.0.0
 * Author: Luke Cleavland
 * Author URI: lcleavland.com
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: widget-importer-exporter
 * Domain Path: /languages

 */

add_shortcode( 'show_gallery', 'make_gallery' );
function make_gallery($atts){
	wp_enqueue_script( 'lightboxjs', plugin_dir_url( __FILE__ ) . 'bower_components/lightbox2/dist/js/lightbox.js', array(), NULL, true );
wp_enqueue_style( 'lightbox-stylesheet', plugin_dir_url( __FILE__ ) . 'bower_components/lightbox2/dist/css/lightbox.css', array(), NULL, 'screen' );
       get_scripts();
       $a = shortcode_atts( array(
       'dir' => NULL
       ), $atts );

?>
<style>
    #gallery_wrapper{
        text-align: center;
    }
	.gal_thumb{
		display: inline-block;
		margin: 4px;

	}

	.gal_thumb img{
				max-height: 187px;
	}
</style>
<?php

    $subdir= $a['dir'];
	$dir = wp_upload_dir();


       $gal_dir = $dir['basedir'].'/'.$subdir;

	$img_dir = $dir['baseurl'].'/'.$subdir;
	$imgs = NULL;
        if(is_dir($gal_dir)){
		if(!is_dir($gal_dir."/thumb")){
		mkdir($gal_dir."/thumb");
		}

	$gal_array = array_diff(scandir($gal_dir), array(".", ".."));



//Get the height and width of the image

	foreach($gal_array as $img){
		if(!is_dir($gal_dir.'/'.$img) && file_exists($gal_dir.'/'.$img)){
					make_thumb($img_dir,$gal_dir.'/thumb/', $img);

		$imgs .= '<div class="gal_thumb"><a target="_blank" href="'.$img_dir."/".$img.'" data-lightbox="'.$subdir.'"><img src="'.$img_dir."/thumb/".$img.'" /></a></div>';
			}
	}
	return "<div id='gallery_wrapper'>".$imgs."</div>";
    }else{
        echo "The directory you specified <strong>'".$subdir."'</strong> doesn't exist.";
    }

}

function make_thumb($srcdir, $dest, $file) {
	$name = $srcdir.'/'.$file;
	$myImage = imagecreatefromjpeg($name);
	list($width, $height) = getimagesize($name);
	$scale = 0.25;
	//Create the zoom_out and cropped image
	$myImageThumb = imagecreatetruecolor($width*$scale,$height*$scale);

	// Fill the two images
	$b=imagecopyresampled($myImageThumb,$myImage,0,0,0,0,$width*$scale,$height*$scale,$width,$height);

	//$fileName="thumb";
	imagejpeg( $myImageThumb, $dest.$file);
}


?>