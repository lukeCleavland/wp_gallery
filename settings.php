<?php
 class BasicGallery_Settings
{


			function gal_settings() {
						if (!current_user_can('manage_options')) {
										wp_die('You do not have sufficient permissions to access this page.');
						}
					// Here is where you could start displaying the HTML needed for the settings
					// page, or you could include a file that handles the HTML output for you.
   }

    public function __construct()
    {

        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
    }



	private function read_dir(){

			$dirpath = '../wp-content/uploads';
			$dir= array_diff(scandir($dirpath), array(".", ".."));
			$list = NULL;
			$galleries = array();

			foreach($dir as $d){
				// $files = NULL;
					$class = 'file';
					if(is_dir("$dirpath/$d")){
							$fdir= array_diff(scandir($dirpath.'/'.$d), array(".", ".."));
							foreach ($fdir as $f){
														if($f == 'thumb'){
																			$galleries[] = $d;
														}
												}
										}
							}
					foreach($galleries as $gallery){
								$files= array_diff(scandir($dirpath.'/'.$gallery), array(".", ".."));
								$filelist = NULL;
										foreach($files as $file){
																	$gal_dir = NULL;
																	if($file != 'thumb'){
																	$filelist .= '<li class="file">'.$file.'</li>';
																			}
																	$gal_dir .= "<a style='cursor:pointer'>".$gallery."</a>"."<ul style='padding-left:25px'><li class='file' >".$filelist."</li></ul>";
										}
															$list .= '<li class="directory">'.$gal_dir.'</li>';
							}


			return '<ul>'.$list.'</ul>';
		}



    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Basic Gallery Settings', //page_title
            'Basic Gallery Settings', //menu_title
            'manage_options', //capability
            'basicgal-settings', //menu_slug
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'basic_gallery_option_name' );
        ?>
        <div class="wrap">
          <h1>Basic Gallery</h1>
          <?php include('fileupload/form.php'); ?>
          <hr>
          <h2 class="form_title">Uploads Directory</h2>
          <?php echo $this->read_dir();?>
        </div>
        <script>
         directory = document.getElementsByClassName("directory");
         for(i=0;i<directory.length;i++){
               directory[i].addEventListener("click", function(){

                if(this.getElementsByTagName('ul')[0].style.display != "none"){
                 this.getElementsByTagName('ul')[0].style.display = "none";
                }else{
                 this.getElementsByTagName('ul')[0].style.display = "block";
                }

         });
         }

        </script>
        <?php
    }
}
