<div id="form_wrapper">
    <form id="myForm" name="myForm" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" enctype="multipart/form-data" >
 <?php wp_nonce_field('action','upload_form'); ?>
        <label for="Directory">Directory Name:</label>
        <input type="text" name="directory" id="directory" ><br>
        <input type="file" name="files[]" id="file" multiple="" ><br>
        <input type="hidden" name="action" value="upload_form">
         <input type="submit" value="Submit" />
    </form>
</div>