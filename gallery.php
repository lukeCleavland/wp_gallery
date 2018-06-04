<?php
class BasicGallery
{
	public function ff_style() {
			$plugindir = basename(__DIR__);
		wp_enqueue_style( 'gal_styles', plugins_url().'/'.$plugindir.'/galleryStyle.css', false, null, false );
	}
	


	public function show_gallery($a){ ?>
	
	<?php
		if( !is_admin() ){
		add_action( 'wp_enqueue_scripts', array($this->ff_style() ));
	}
		$subdir= $a['dir'];
		$dir = wp_upload_dir();
		$gal_dir = $dir['basedir'].'/'.$subdir;
		$img_dir = $dir['baseurl'].'/'.$subdir;
		$imgs = NULL;

		if(is_dir($gal_dir)){
		$gal_array = array_diff(scandir($gal_dir), array(".", ".."));
	//Get the height and width of the image

		foreach($gal_array as $img){

			if(!is_dir($gal_dir.'/'.$img) && file_exists($gal_dir.'/'.$img)){

			$imgs .= '<div class="gal_thumb"><a target="_blank" href="'.$img_dir."/".$img.'" data-lightbox="'.$subdir.'"><img src="'.$img_dir."/thumb/".$img.'" /></a></div>';
				}
		}
		return "<div class='gallery_wrapper'>".$imgs."</div>";
					}else{
			echo "The directory you specified <strong>'".$subdir."'</strong> doesn't exist.";
					}

	}




}
