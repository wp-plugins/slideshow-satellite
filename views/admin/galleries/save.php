<?php
global $post, $post_ID;
$post_ID = 1;
wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);

$slides = $this -> Slide -> find_all(array('section'=>(int) stripslashes($single)), null, array('order', "ASC"));

$pluginName = "Slideshow Satellite";
$shortname = "satl";
$ptypes1 = get_post_types(array('public' => true),'names','and');
$ptypes = array_push($ptypes1, 'resume');

$options = array (

array(  "name" => "The Gallery Editor",
        "type" => "title"),

array(  "type" => "open"),

array(  "name"      => "Title",
        "id"        => "title",
        "type"      => "text",
        "std"       => "New Gallery"),

array(  "name"      => "Gallery Type",
        "desc"      => "What kind of slideshow is this?",
        "id"        => "type",
        "type"      => "select",
        "std"       => "custom",
        "options"   => array('custom slides')),

array(  "name"      => "Description",
        "desc"      => "This will be used in future slideshow versions to describe the slideshow before someone selects to view it.",
        "id"        => "description",
        "type"      => "textarea"),

/*array(  "name"      => "Cover Image?",
        "desc"      => "What do you want as the cover image?.",
        "id"        => "image",
        "type"      => "image"),*/
array(  "name"      => "Upload Images",
        "desc"      => "Select multiple images using the uploader, then drag the thumbs to order them right here before saving the gallery",
        "id"        => "slides",
        "type"      => "upload"),

array(  "name"      => "Caption Display",
        "desc"      => "Where would you like to display the caption?",
        "id"        => "capdisplay",
        "type"      => "select",
        "std"       => "Overlayed",
        "options"   => array('Overlayed', 'On Right', 'Disabled')),

array(  "type"      => "close")

);	
        
?>        
    <div class="wrap">
        <style type="text/css">
	.swfupload {
		position: absolute;
		z-index: 1;
	}
        </style>
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



        
	<?php 
/*    if ( $_REQUEST['page'] == basename(__FILE__) ) {
         if( 'save-option' == $_REQUEST['action'] ) {
               foreach ( $options as $value ) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] );
               }

                    $action = "saved";

        } else {
            
        }
   // }
	
    if ( $action == 'saved' ) echo '<div id="message" class="updated fade"><p><strong>New '.$pluginName.' Gallery created.</strong></p></div>';*/

?>
<div class="wrap">
<h2><?php echo $pluginName; ?> <?php _e('Gallery Creator', SATL_PLUGIN_NAME); ?></h2>
	<h2></h2>


<form action="<?php echo $this -> url; ?>&amp;method=save" name="post" id="post" method="post">
<input type="hidden" name="Gallery[id]" value="<?php echo $this -> Gallery -> data -> id; ?>" />
<?php 
foreach ($options as $value) {
	
	switch ( $value['type'] ) {

		case "open":
			?>
			<table width="100%" border="0"id="satl_table" style="">
			<?php break;
                    
		case "close":
			?>
			</table><br />
			<?php break;

		case "title":
			?>
			<table width="100%" border="0" style="background-color:#dceefc; padding:5px 10px;"><tr>
				<td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>
			</tr>
			<?php break;

		case 'text':
                        if ($this -> Gallery -> data -> title) {
                            $display = esc_attr($this -> Gallery -> data -> title);
                        } else { $display = $value['std']; }
			?>
			
			<tr class="glx-option">
				<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
				<td width="80%">
                                    <input style="width:400px;" name="Gallery[<?php echo $value['id']; ?>]" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo $display; ?>" />
                                    <?php echo (!empty($this -> Gallery -> errors['title']) && $value['id'] == 'title') ? '<div style="color:red;">' . $this -> Gallery -> errors['title'] . '</div>' : ''; ?>
                                </td>
			</tr>
			
			<tr>
				<td><small><?php echo $value['desc']; ?></small></td>
			</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
			
			<?php
		break;

		case 'textarea':
                        if ($this -> Gallery -> data -> description) {
                            $display = esc_attr($this -> Gallery -> data -> description);
                        } else { $display = $value['std']; }
                    
			?>
			
			<tr>
				<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
				<td width="80%"><textarea name="Gallery[<?php echo $value['id']; ?>]" style="width:400px; height:80px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php echo $display; ?></textarea></td>
			
			</tr>
			
			<tr>
				<td><small><?php echo $value['desc']; ?></small></td>
			</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
			
			<?php
		break;

		case 'select':
                        if ($this -> Gallery -> data -> capdisplay && $value['id'] == 'capdisplay' ) {
                            $display = esc_attr($this -> Gallery -> data -> capdisplay);
                        } else { $display = $value['std']; }
                    
			?>
			<tr>
                            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                            <td width="80%"><select style="width:140px;" name="Gallery[<?php echo $value['id']; ?>]" id="<?php echo $value['id']; ?>">
                            <?php foreach ($value['options'] as $option) { ?>
                                <option id="<?php echo(get_settings( $value['id'])); ?>"<?php 
                                if ( $display == $option) { echo ' selected="selected"'; 

                                } elseif (($option == $value['std']) && (get_settings( $value['id']) == FALSE)) { echo ' selected="selected"'; } ?>>
                                <?php echo $option; ?></option>
                             <?php } ?></select></td>
			</tr>
			
			<tr>
				<td><small><?php echo $value['desc']; ?></small></td>
			</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
			
			<?php
		break;

		case 'checkbox':
			?>
			<tr>
                            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                            <td width="80%"><? if(get_settings($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                                <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
                            </td>
			</tr>

			<tr>
                            <td><small><?php echo $value['desc']; ?></small></td>
			</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

			<?php         
		break;
                
                case 'upload':
                    ?>
                    <tr>
                        <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                    <td width="80%">
                        <?php
                        // adjust values here
                        $id = "images"; // this will be the name of form field. Image url(s) will be submitted in $_POST using this key. So if $id == “img1” then $_POST[“img1”] will have all the image urls

                        $svalue = ""; // this will be initial value of the above form field. Image urls.

                        $multiple = true; // allow multiple files upload

                        $width = null; // If you want to automatically resize all uploaded images then provide width here (in pixels)

                        $height = null; // If you want to automatically resize all uploaded images then provide height here (in pixels)
                        ?>

                        <label>Upload and Order Images</label>
                        <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id; ?>" value="<?php echo $svalue; ?>" />
                        <div class="plupload-upload-uic hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-upload-ui">
                            <input id="<?php echo $id; ?>plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" />
                            <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($id . 'pluploadan'); ?>"></span>
                            <?php if ($width && $height): ?>
                                    <span class="plupload-resize"></span><span class="plupload-width" id="plupload-width<?php echo $width; ?>"></span>
                                    <span class="plupload-height" id="plupload-height<?php echo $height; ?>"></span>
                            <?php endif; ?>
                            <div class="filelist"></div>
                        </div>
                        <div class="plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-thumbs">
                        </div>
                        <div class="clear"></div>
                        
                    </td>
                    </tr>
                    
                    <tr>
                        <td><small><?php echo $value['desc']; ?></small></td>
                    </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

                    <?php
                break;
                
                case 'default':
                    
                    break;
		
	}

}
?>
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