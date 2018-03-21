<style>
    		.form_title{
			margin-bottom: 0px;
		}
</style>
<div id="form_wrapper">
    <h2 class="form_title">Upload/Create Gallery</h2>
    <form id="myForm" name="myForm" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" enctype="multipart/form-data" >
 <?php wp_nonce_field('action','upload_form'); ?>
        <label for="Directory">Directory Name:</label>
        <input type="text" name="directory" id="directory" ><br>
        <input type="file" name="files[]" id="file" multiple="" ><br>
        <input type="hidden" name="action" value="upload_form">
         <input type="submit" value="Submit" />
    </form>
        <h2 class="form_title">Remove Images/Delete Gallery</h2>
    <form id="delete_gallery" name="delete_gallery" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" enctype="multipart/form-data" >
 <?php wp_nonce_field('action','delete_form'); ?>
                <label for="Directory">Directory Name:</label>
        <input type="text" name="directory" id="directory" ><br>
        <input type="hidden" name="action" value="delete_form">
        <label for="delete_directory">Delete Entire Gallery?:</label>
        <input type="checkbox" value="delete_directory" id="delete_directory" name="delete_directory" /><br>
         <input type="submit" value="Submit" />
    </form>

</div>