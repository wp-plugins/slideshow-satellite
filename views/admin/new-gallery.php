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
        "desc"      => "What is the path to your logo?",
        "id"        => $shortname."_logo",
        "type"      => "text",
        "std"       => "New Gallery"),

array(  "name"      => "Type",
        "desc"      => "What kind of slideshow is this?",
        "id"        => $shortname."_planetheight",
        "type"      => "select",
        "std"       => "1000",
        "options"   => array('custom','wordpress')),

array(  "name"      => "Description",
        "desc"      => "How much space between your planets?.",
        "id"        => $shortname."_space",
        "type"      => "textarea"),

array(  "name"      => "Disable Captions?",
        "desc"      => "Check this box if you would like to DISABLE text from popping up.",
        "id"        => $shortname."_caption_disable",
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
//                    if ($_REQUEST[ $value['class']]) {
				//	$update_option( $value['class'], $_REQUEST[ $value['class'] ] );
				//}
			}

			$action = "saved";

        } else if( 'reset-option' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            //header("Location: admin.php?page=gx_options.php&reset=true");
			$action = "reset";
		}
		else {echo("<script><alert>No request has worked.!</alert></script>");}
   // }
	
    if ( $action == 'saved' ) echo '<div id="message" class="updated fade"><p><strong>'.$plugin_name.' settings saved.</strong></p></div>';
    if ( $action == 'reset' ) echo '<div id="message" class="updated fade"><p><strong>'.$plugin_name.' settings reset well.</strong></p></div>';

?>
<div class="wrap">
<h2><?php echo $plugin_name; ?> <?php _e('Gallery Creator', SATL_PLUGIN_NAME); ?></h2>
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
				<td width="80%"><textarea name="Gallery[<?php echo $value['id']; ?>]" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea></td>
			
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
                            <td width="80%"><select style="width:140px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
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