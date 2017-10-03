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
include_once('settings.php');
include_once('gallery.php');
include_once('fileupload/upload.php');
if( is_admin() ){
   $settings = new BasicGallery_Settings();

}

function process_upload_form() {
$settings = new BasicGallery_Settings();
$directory = $_POST['directory'];
 upload($settings);
	make_gallery($directory);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
add_action( 'admin_post_nopriv_upload_form', 'process_upload_form' );
add_action( 'admin_post_upload_form', 'process_upload_form' );

add_shortcode( 'gallery', 'build_gallery' );
function build_gallery($atts){
	$basicGallery = new BasicGallery();
	wp_enqueue_script( 'lightboxjs', plugin_dir_url( __FILE__ ) . 'bower_components/lightbox2/dist/js/lightbox.js', array(), NULL, true );
	wp_enqueue_style( 'lightbox-stylesheet', plugin_dir_url( __FILE__ ) . 'bower_components/lightbox2/dist/css/lightbox.css', array(), NULL, 'screen' );
       //get_scripts();
       $a = shortcode_atts( array(
       'dir' => NULL
       ), $atts );
 return $basicGallery->show_gallery($atts);

}

function make_gallery($directory){
			$subdir= $directory;
			$dir = wp_upload_dir();
			$gal_dir = $dir['basedir'].'/'.$subdir;
			$img_dir = $dir['baseurl'].'/'.$subdir;
			$imgs = NULL;
			if(is_dir($gal_dir)){
				if(!is_dir($gal_dir."/thumb")){
					mkdir($gal_dir."/thumb");
				}

				$gal_array = array_diff(scandir($gal_dir), array(".", ".."));

				foreach($gal_array as $img){

					if(!is_dir($gal_dir.'/'.$img) && file_exists($gal_dir.'/'.$img)){
					make_thumb($gal_dir,$gal_dir.'/thumb/', $img);
					}
				}
			}
		}

function make_thumb($srcdir, $dest, $file) {
				if(!(file_exists($dest.$file))){
					$thumbSize = 100;
			$name = $srcdir.'/'.$file;
			$myImage = imagecreatefromjpeg($name);
			list($width, $height) = getimagesize($name);
				$limiting_dim = 0;
				if( $height > $width ){
					/* Portrait */
								$limiting_dim = $width;
				}else{
					/* Landscape */
							$limiting_dim = $height;
				}
			$new = imagecreatetruecolor( $thumbSize , $thumbSize );
				$b = imagecopyresampled( $new , $myImage , 0 , 0 , ($width-$limiting_dim )/2 , ( $height-$limiting_dim )/2 , $thumbSize , $thumbSize , $limiting_dim , $limiting_dim );
			imagejpeg( $new, $dest.$file);
				}


		}

?>