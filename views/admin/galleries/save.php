﻿<?php
global $post, $post_ID;
$post_ID = 1;
wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);

$slides = $this -> Slide -> find_all(array('section'=>(int) stripslashes($single)), null, array('slide_order', "ASC"));

$pluginName = "Slideshow Satellite";
$shortname = "satl";
$ptypes1 = get_post_types(array('public' => true),'names','and');
$ptypes = array_push($ptypes1, 'resume');
$options = $this -> Config -> displayOption('gallery', $this -> Gallery);
        
?>        
    <div class="wrap">
    <script type="text/javascript">
    // Convert divs to queue widgets when the DOM is ready
    jQuery(function($) {
	$("#uploader").plupload({
		// General settings
		runtimes : 'gears,flash,silverlight,browserplus,html5',
		url : 'upload.php',
		max_file_size : '10mb',
		chunk_size : '1mb',
		unique_names : true,

		// Resize images on clientside if we can
		resize : {width : 320, height : 240, quality : 90},

		// Specify what files to browse for
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		],

		// Flash settings
		flash_swf_url : '../plupload/js/plupload.flash.swf'

		// Silverlight settings
		//silverlight_xap_url : '/plupload/js/plupload.silverlight.xap'
            });

            // Client side form validation
            $('form').submit(function(e) {
            var uploader = $('#uploader').plupload('getUploader');

            // Files in queue upload them first
            if (uploader.files.length > 0) {
                // When all files are uploaded submit form
                uploader.bind('StateChanged', function() {
                    if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                        $('form')[0].submit();
                    }
                });

                uploader.start();
            } else
                alert('You must at least upload one file.');

            return false;
        });
    });
    </script>

    <?php 
    $version = $this->Version->checkLatestVersion();
    if( !$version['latest'] && SATL_PRO ){ ?>
            <div class="plugin-update-tr">
                    <div class="update-message">
                            <?php echo $version['message']; ?>
                    </div>
            </div>
    <?php } ?>

    <img src="<?php echo(SATL_PLUGIN_URL.'/images/Satellite-Logo-sm.png');?>" style="height:100px" />
    <div class="wrap">
    <h2><?php echo $pluginName; ?> <?php _e('Gallery Creator', SATL_PLUGIN_NAME); ?></h2>
            <h2></h2>


    <form action="<?php echo $this -> url; ?>&amp;method=save" name="post" id="post" method="post">
    <input type="hidden" name="Gallery[id]" value="<?php echo $this -> Gallery -> data -> id; ?>" />
    
    <?php $this -> Form -> display($options, 'Gallery'); ?>
    
    <p class="submit">
    <input name="saver" type="submit" value="Save" />
    <input type="hidden" name="action" value="save-option" />
    </p>
    </form>

    <form method="post">
    <p class="submit">
    <input name="reseter" type="submit" value="Reset" />
    <input type="hidden" name="action" value="reset-option" />
    </p>
    </form>
      
        
</div>