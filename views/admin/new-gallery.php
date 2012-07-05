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

array(  "name" => "Create a New Gallery",
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

array(  "name"      => "Disable Captions?",
        "desc"      => "Check this box if you would like to DISABLE text from popping up.",
        "id"        => "caption_disable",
        "type"      => "checkbox",
        "std"       => "false"),

array(  "type"      => "close")

);	
        
?>        
    <div class="wrap">

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
//    if ( $_REQUEST['page'] == basename(__FILE__) ) {
         if( 'save-option' == $_REQUEST['action'] ) {
               foreach ( $options as $value ) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] );
               }

                    $action = "saved";

        } else {echo("<script><alert>No request has worked.!</alert></script>");}
   // }
	
    if ( $action == 'saved' ) echo '<div id="message" class="updated fade"><p><strong>'.$pluginName.' gallery created.</strong></p></div>';

?>
<div class="wrap">
<h2><?php echo $pluginName; ?> <?php _e('Gallery Creator', SATL_PLUGIN_NAME); ?></h2>
	<h2></h2>


<form action="<?php echo $this -> url; ?>" name="post" id="post" method="post">

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
			?>
			
			<tr class="glx-option">
				<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
				<td width="80%"><input style="width:400px;" name="Gallery[<?php echo $value['id']; ?>]" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></td>
			</tr>
			
			<tr>
				<td><small><?php echo $value['desc']; ?></small></td>
			</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
			
			<?php
		break;

		case 'textarea':
			?>
			
			<tr>
				<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
				<td width="80%"><textarea name="Gallery[<?php echo $value['id']; ?>]" style="width:400px; height:80px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea></td>
			
			</tr>
			
			<tr>
				<td><small><?php echo $value['desc']; ?></small></td>
			</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
			
			<?php
		break;

		case 'select':
			?>
			<tr>
                            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                            <td width="80%"><select style="width:140px;" name="Gallery[<?php echo $value['id']; ?>]" id="<?php echo $value['id']; ?>">
                            <?php foreach ($value['options'] as $option) { ?>
                                <option id="<?php echo(get_settings( $value['id'])); ?>"<?php 
                                if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; 

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