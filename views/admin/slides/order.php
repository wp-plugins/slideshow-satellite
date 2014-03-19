<?php       if (!empty($_GET['single'])) {
                $single = $_GET['single'];
                $galleries = $this -> Gallery -> find_all(array('id'=>(int) stripslashes($single)), null, array('id', "ASC"));
            }
            else {
                $galleries = $this -> Gallery -> find_all();
                $single = '';
            }
            if (!empty($_GET['order'])) { $order = $_GET['order']; }
            else { $order = 'slide_order'; }
            if (!empty($_GET['dir'])) { $dir = $_GET['dir']; }
            else { $dir = 'ASC'; }
?>
﻿<div class="wrap"> 
        
	<h2><?php _e('Order Slides', SATL_PLUGIN_NAME); ?></h2>
	<div style="float:none;" class="subsubsub">
            <?php $manage_link = ($single) ? $this -> url .'&single='.$single : $this -> url; ?>
		<a href="<?php echo $manage_link; ?>"><?php _e('&larr; Back to Slides', SATL_PLUGIN_NAME); ?></a>
	</div>
	<?php if (!empty($slides)) :
            foreach ($galleries as $gallery ) {
            echo "<h3>".$gallery -> title . "(#".$gallery -> id.")</h3>";
            echo "Order <a href=?page=satellite-slides&method=order&single=".$gallery -> id."&order=title>Alphabetically</a> | ";
            echo "<a href=?page=satellite-slides&method=order&single=".$gallery -> id."&order=title&dir=DESC>Reverse-Alph</a> | ";
            echo "<a href=?page=satellite-slides&method=order&single=".$gallery -> id."&order=created>Created By</a> | ";
            echo "<a href=?page=satellite-slides&method=order&single=".$gallery -> id."&order=created&dir=DESC>Reverse-Created</a> | ";
            echo "<a href=?page=satellite-slides&method=order&single=".$gallery -> id."&order=slide_order>Slide Order</a><br />";

            echo "Drag any slide to save!"
            ?>
            <ul id="slidelist<?php echo $gallery -> id;?>" class="slide-order">
                <?php $slides = $this -> Slide -> find_all(array('section'=>(int) stripslashes($gallery -> id)), null, array($order, $dir)); ?>
                    <?php if (is_array($slides)) : ?>
                    <?php foreach ($slides as $slide) : ?>
                            <li class="lineitem" id="item_<?php echo $slide -> id; ?>">
                                    <img src="<?php echo $this -> Html -> image_url($this -> Html -> thumbname($slide -> image, "thumb")); ?>" alt="<?php echo $this -> Html -> sanitize($slide -> title); ?>" />
                                    <p><?php echo $slide -> title; ?></p>
                            </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
            </ul>
            <div id="slidemessage<?php echo $gallery -> id;?>" class="clearfix"></div>

            <script type="text/javascript">
            jQuery(document).ready(function() {
                    jQuery("ul#slidelist<?php echo $gallery -> id;?>").sortable({
                            start: function(request) {
                                    jQuery("#slidemessage<?php echo $gallery -> id;?>").slideUp();
                            },
                            stop: function(request) {
                                    jQuery("#slidemessage<?php echo $gallery -> id;?>").load(SatelliteAjax + "?cmd=slides_order", jQuery("ul#slidelist<?php echo $gallery -> id;?>").sortable('serialize')).slideDown("slow");
                            }
                    });
                    jQuery("ul#slidelist<?php echo $gallery -> id;?>").disableSelection();
            });
            </script>
            <?php } ?>
	<?php else : ?>
		<p style="color:red;"><?php _e('No slides found', SG2_PLUGIN_NAME); ?></p>
	<?php endif; ?>
</div>