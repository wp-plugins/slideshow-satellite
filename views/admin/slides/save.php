<?php
global $post, $post_ID;
$post_ID = 1;
wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);

//$slides = $this -> Slide -> find_all(array('section'=>(int) stripslashes($single)), null, array('order', "ASC"));

$shortname = "satl";
$ptypes1 = get_post_types(array('public' => true),'names','and');
$ptypes = array_push($ptypes1, 'resume');

$options = array (
array(  "name"      => "Link To",
        "desc"      => "link/URL to go to when a user clicks the slide eg. http://www.domain.com/mypage/",
        "id"        => "link",
        "type"      => "text",
        "std"       => "http://"),
    
array(  "name"      => "More Image",
        "desc"      => "From here you can select an image if you have a Gallery with the title 'More'",
        "id"        => "capdisplay",
        "type"      => "select",
        "std"       => "Select an Image",
        "options"   => $this -> Slide -> getAllMoreImages())

);	

echo "Get all More Images: ".$this -> Slide -> getAllMoreImages();
        
?>  <div class="wrap">
	<h2><?php _e('Save a Slide', SATL_PLUGIN_NAME); ?></h2>
	
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post" enctype="multipart/form-data">
		<input type="hidden" name="Slide[id]" value="<?php echo $this -> Slide -> data -> id; ?>" />
		<input type="hidden" name="Slide[order]" value="<?php echo $this -> Slide -> data -> order; ?>" />
		<table class="form-table">
                    <tbody>
                        <tr>
                                <th><label for="Slide.title"><?php _e('Title', SATL_PLUGIN_NAME); ?></label></th>
                                <td>
                                        <input class="widefat" type="text" name="Slide[title]" value="<?php echo esc_attr($this -> Slide -> data -> title); ?>" id="Slide.title" />
                                        <span class="howto"><?php _e('title/name of your slide as it will be displayed to your users.', SATL_PLUGIN_NAME); ?></span>
                                        <?php echo (!empty($this -> Slide -> errors['title'])) ? '<div style="color:red;">' . $this -> Slide -> errors['title'] . '</div>' : ''; ?>
                                </td>
                        </tr>
                        <tr>
                                <th><label for="Slide.description"><?php _e('Description', SATL_PLUGIN_NAME); ?></label></th>
                                <td>
                                        <textarea class="widefat" name="Slide[description]"><?php echo esc_attr($this -> Slide -> data -> description); ?></textarea>
                                        <span class="howto"><?php _e('description of your slide as it will be displayed to your users below the title.', SATL_PLUGIN_NAME); ?></span>
                                        <?php echo (!empty($this -> Slide -> errors['description'])) ? '<div style="color:red;">' . $this -> Slide -> errors['description'] . '</div>' : ''; ?>
                                </td>
                        </tr>
                        <tr>
                            <th><label for="Slide.section"><?php _e('Gallery', SATL_PLUGIN_NAME); ?></label></th>
                            <td>
                                <select name="Slide[section]">
                                    <?php $gals = $this -> Gallery -> find_all(null, array('id','title'), array('order', "ASC") ); ?>

                                        <?php if (!empty($gals)) : ?>
                                            <?php foreach ( $gals as $gallery ) {?>
                                                <option <?php echo ((int) $this -> Slide -> data -> section == $gallery -> id) ? 'selected="selected"' : ''; ?> value="<?php echo($gallery -> id) ?>">Gallery <?php echo($gallery -> id. ": ".$gallery -> title)?></option>
                                            <?php } ?>
                                        <?php else : ?>
                                                <option <?php echo ((int) $this -> Slide -> data -> section == '1') ? 'selected="selected"' : ''; ?> value="1">Gallery 1</option>
                                        <?php endif; ?>

                                </select>              				
                                <span class="howto"><?php _e('The gallery this slide belongs to', SATL_PLUGIN_NAME); ?></span>
                                    <?php echo (!empty($this -> Slide -> errors['section'])) ? '<div style="color:red;">' . $this -> Slide -> errors['section'] . '</div>' : ''; ?>
                            </td>
                        </tr>				
                <tr>
                	<th><label for="Slide.text.location"><?php _e('Text Location', SATL_PLUGIN_NAME); ?></label></th>
                    <td>
                        <label><input <?php echo ($this -> Slide -> data -> textlocation == "N") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[textlocation]" value="N" id="Slide.text.location0" /> <?php _e('None', SATL_PLUGIN_NAME); ?></label>
                    	<label><input <?php echo (empty($this -> Slide -> data -> textlocation) || $this -> Slide -> data -> textlocation == "D") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[textlocation]" value="D" id="Slide.text.locationD" /> <?php _e('Default', SATL_PLUGIN_NAME); ?></label>
                        <label><input <?php echo ($this -> Slide -> data -> textlocation == "BR") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[textlocation]" value="BR" id="Slide.text.locationBR" /> <?php _e('Bottom Right', SATL_PLUGIN_NAME); ?></label>
                        <label><input <?php echo ($this -> Slide -> data -> textlocation == "TR") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[textlocation]" value="TR" id="Slide.text.locationTR" /> <?php _e('Top Right', SATL_PLUGIN_NAME); ?></label>
                        <?php echo (!empty($this -> Slide -> errors['textlocation'])) ? '<div style="color:red;">' . $this -> Slide -> errors['textlocation'] . '</div>' : ''; ?>
                        <span class="howto"><?php _e('Default is the bottom caption bar', SATL_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
                <tr>
                	<th><label for="Slide.type.file"><?php _e('Image Type', SATL_PLUGIN_NAME); ?></label></th>
                    <td>
                    	<label><input onclick="jQuery('#typediv_file').show(); jQuery('#typediv_url').hide();" <?php echo (empty($this -> Slide -> data -> type) || $this -> Slide -> data -> type == "file") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[type]" value="file" id="Slide.type.file" /> <?php _e('Upload File (recommended)', SATL_PLUGIN_NAME); ?></label>
                        <label><input onclick="jQuery('#typediv_url').show(); jQuery('#typediv_file').hide();" <?php echo ($this -> Slide -> data -> type == "url") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[type]" value="url" id="Slide.type.url" /> <?php _e('Specify URL', SATL_PLUGIN_NAME); ?></label>
                        <?php echo (!empty($this -> Slide -> errors['type'])) ? '<div style="color:red;">' . $this -> Slide -> errors['type'] . '</div>' : ''; ?>
                        <span class="howto"><?php _e('do you want to upload an image or specify a local/remote image URL?', SATL_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
				
            </tbody>
        </table>
        
        <div id="typediv_file" style="display:<?php echo (empty($this -> Slide -> data -> type) || $this -> Slide -> data -> type == "file") ? 'block' : 'none'; ?>;">
        	<table class="form-table">
            	<tbody>
                	<tr>
                    	<th><label for="Slide.image_file"><?php _e('Choose Image', SATL_PLUGIN_NAME); ?></label></th>
                        <td>
                        	<input type="file" name="image_file" value="" id="Slide.image_file" />
                            <span class="howto"><?php _e('choose your image file from your computer. JPG, PNG, GIF, SWF are supported.', SATL_PLUGIN_NAME); ?></span>
                            <?php echo (!empty($this -> Slide -> errors['image_file'])) ? '<div style="color:red;">' . $this -> Slide -> errors['image_file'] . '</div>' : ''; ?>
                            <?php
                            /*if (!empty($this -> Slide -> data -> type) && $this -> Slide -> data -> type == "file") {
                                    if (!empty($this -> Slide -> data -> image)) {
                                            $name = $this -> Html -> strip_ext($this -> Slide -> data -> image, 'filename');
                                            $ext = $this -> Html -> strip_ext($this -> Slide -> data -> image, 'ext');*/
                                            ?>

                                <input type="hidden" name="Slide[image_oldfile]" value="<?php echo esc_attr(stripslashes($this -> Slide -> data -> image)); ?>" />

                                <?php 
                                if (!empty($this -> Slide -> data -> image)) {
                                    $image = $this -> Slide -> data -> image;
                                    
                                    ?>                                    
                                    <p><small><?php _e('Current thumbnail. Leave the field above blank to keep this image.', SATL_PLUGIN_NAME); ?></small></p>
                                   	<a href="<?php echo $this -> Html -> image_url($image); ?>" class="thickbox">
                                                <!--img src="<?php echo SATL_UPLOAD_URL; ?>/<?php echo $name; ?>-thumb.<?php echo $ext; ?>" alt="" /-->
                                                <img src="<?php echo $this -> Html -> image_url($this -> Html -> thumbname($image, "thumb")); ?>" />
                                                        <br />
                                                        <?php	echo ("Filename: " . $this -> Slide -> data -> image); ?>
                                                <br />
                                        </a>
                                    <?php	
                                 }
                            //}
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div id="typediv_url" style="display:<?php echo ($this -> Slide -> data -> type == "url") ? 'block' : 'none'; ?>;">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><label for="Slide.image_url"><?php _e('Image URL', SATL_PLUGIN_NAME); ?></label></th>
                        <td>
                            <input class="widefat" type="text" name="Slide[image_url]" value="<?php echo esc_attr($this -> Slide -> data -> image_url); ?>" id="Slide.image_url" />
                            <span class="howto"><?php _e('Local or remote image location eg. http://domain.com/path/to/image.jpg', SATL_PLUGIN_NAME); ?></span>
                            <?php echo (!empty($this -> Slide -> errors['image_url'])) ? '<div style="color:red;">' . $this -> Slide -> errors['image_url'] . '</div>' : ''; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>    
                
        <table class="form-table">
        <tbody>
                    <tr>
                        <th><label for="Slide_userlink_N"><?php _e('Use Link', SATL_PLUGIN_NAME); ?></label></th>
                        <td>
                                <label><input onclick="jQuery('#Slide_uselink_div').show();" <?php echo ($this -> Slide -> data -> uselink == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[uselink]" value="Y" id="Slide_uselink_Y" /> <?php _e('Yes', SATL_PLUGIN_NAME); ?></label>
                                <label><input onclick="jQuery('#Slide_uselink_div').hide();" <?php echo (empty($this -> Slide -> data -> uselink) || $this -> Slide -> data -> uselink == "N") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[uselink]" value="N" id="Slide_uselink_N" /> <?php _e('No', SATL_PLUGIN_NAME); ?></label>
            <span class="howto"><?php _e('set this to Yes to link this slide to a link/URL of your choice.', SATL_PLUGIN_NAME); ?></span>
                        </td>
                    </tr>
                </tbody>
        </table>
		
        <div id="Slide_uselink_div" style="display:<?php echo ($this -> Slide -> data -> uselink == "Y") ? 'block' : 'none'; ?>;">
            <table class="form-table">
                    <tbody>
                <?php foreach ($options as $value) {

                        switch ( $value['type'] ) {
                            case 'select':
                                if ( $this -> Slide -> data -> more  && $value['id'] == 'more' ) :
                                    $display = esc_attr($this -> Slide -> data -> more);
                                    $error = 'more';
                                    if ( ! in-array($value['std'],$value['options']) ) :
                                            $value['options'] = array_unshift(&$value['options'],$value['std']);
                                    endif;
                                else: 
                                    $display = $value['std'];
                                endif;

                                ?>
                                <tr>
                                    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                    <td width="80%"><select style="width:140px;" name="Gallery[<?php echo $value['id']; ?>]" id="<?php echo $value['id']; ?>">
                                    <?php if ( ! in_array($value['std'],$value['options']) ) { ?>
                                            <option id="" ><?php echo($value['std']); ?></option> 
                                            <?php } ?>
                                    <?php foreach ($value['options'] as $option) { ?>
                                        <option id="<?php echo(get_settings( $value['id'])); ?>"<?php 
                                        if ( $display == $option) { echo ' selected="selected"'; 

                                        } elseif (($option == $value['std']) && (get_settings( $value['id']) == FALSE)) { echo ' selected="selected"'; } ?>>
                                        <?php echo $option; ?></option>
                                     <?php } ?></select></td>
                                </tr>

                                <tr>
                                        <td><small><?php echo $value['desc']; ?></small></td>
                                </tr>
                            <?php
                            
                            break;
                            
                            case 'text':
                                    if ( $this -> Slide -> data -> title  && $value['id'] == 'title' ) :
                                        $display = esc_attr($this -> Slide -> data -> title);
                                        $error = 'title';
                                    elseif ( $this -> Slide -> data -> link  && $value['id'] == 'link' ) :
                                        $display = esc_attr($this -> Slide -> data -> link);
                                        $error = 'more';
                                    else :
                                        $display = $value['std']; 
                                    endif;
                                    ?>

                                    <tr">
                                            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                            <td width="80%">
                                                <input style="width:400px;" name="Slide[<?php echo $value['id']; ?>]" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo $display; ?>" />
                                                <?php echo (!empty($this -> Gallery -> errors['title'])) ? '<div style="color:red;">' . $this -> Slide -> errors[$error] . '</div>' : ''; ?>
                                            </td>
                                    </tr>

                                    <tr>
                                            <td><small><?php echo $value['desc']; ?></small></td>
                                    </tr>

                                    <?php
                            break;
                            case 'default' :

                         break;

                        }
                }?>
                    </tbody>
            </table>
        </div>
		
		<p class="submit">
			<input class="button-primary" type="submit" name="submit" value="<?php _e('Save Slide', SATL_PLUGIN_NAME); ?>" />
		</p>
	</form>
</div>