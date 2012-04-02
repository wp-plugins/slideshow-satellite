
<?php 
if (!empty($slides)) : 
?>
<script type="text/javascript">
	var jsSlideshow = new Array();
<?php /**************  CREATING ARRAY OF IMAGES **************/
$slidenums = 0;
	if ($frompost) : 
		foreach ($slides as $single) :    
			$full_image_href2 = wp_get_attachment_image_src($single -> ID, 'full', false);
			$slideshow[] = $full_image_href2;?>
			jsSlideshow.push("<?php echo($full_image_href2[0]); ?>");
			<?php	$slidenums += 1;endforeach;
	else:
		foreach ($slides as $single):?>
			jsSlideshow.push("<?php echo SATL_UPLOAD_URL ?>/<?php echo $single -> image; ?>");
		<?php $slidenums += 1; endforeach;
	endif;

	/***** END ARRAY OF IMAGES ****/
		?>
	</script>
	<?php
	$style = $this -> get_option('styles');
	$lightbox = $this -> get_option('lightbox');
	if ($this -> get_option('autoslide') == "Y")
		$autospeed = $this -> get_option('autospeed');
	if ($this -> get_option('autoslide2') == "Y")
		$autospeed2 = $this -> get_option('autospeed2');
	
	if ($style['height_temp']) :	$height = $style['height_temp'];	else : $height = $style['height'];endif;
	foreach ($this -> get_option('width_temp') as $skey => $sval) {
		if ($skey == $GLOBALS['post']->ID)
			$width = $sval;
	}	
?>
	<style>
		#loading {
			position:relative;top:<?php echo(($height/2)-10);?>px;left:<?php echo(($width/2)-10);?>px;z-index:1104;
		}

	</style>
    
	<div id="slideshow-wrap">
    	<div id="gs-fullsize">
        <div id="iprev" class="inav" title="Previous Image"></div>
        <div id="inext" class="inav" title="Next Image"></div>
		<!--<img id="loading" alt="" src="<?php echo(GS_PLUGIN_URL)?>/images/spinner.gif"/>-->
        
        
		<?php if ($frompost) : ?>

			<ul id="slidecustom" class="galslider">
                <?php foreach ($slideshow as $slider) : ?>       
                    <li>
                    	<?PHP if ($lightbox == "Y") : ?>
                        	<a rel="lightbox" href="<?php echo $slider[0]; ?>">
						<?PHP endif; ?>
                    		<img src="<?php echo $slider[0]; ?>" alt="" />
                        <?PHP if ($lightbox == "Y") : ?></a><?PHP endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <script type="text/javascript">
			//jsSlideshow[0];
			jQuery.preLoadImages(
				[jsSlideshow[0],jsSlideshow[1],jsSlideshow[2]],function(){			
					jQuery('#loading').css("display", "none");
					jQuery('#slidecustom').ulslide({
						effect: {
							type: 'slide', // slide or fade
							axis: 'x',     // x, y
							distance: 40   // Distance between frames
						},
						duration: <?php echo($this -> get_option('duration')); ?>,
						autoslide: <?PHP if ($autospeed2): echo($autospeed2); else: echo('false'); endif?>,
						width: <?php echo($width); ?>,
						height: 440,
						mousewheel: false,
						nextButton: '#inext',
						prevButton: '#iprev'					/*
                         width: <?php echo($width); ?>,
                         affect: 'slide',
                         duration: <?php echo($this -> get_option('duration')); ?>,
                         height: 440,
                         bnext: '#inext',
                         bprev: '#iprev',
                         axis: '<?php echo($this -> get_option('axis')); ?>',
                         direction: '<?php echo($this -> get_option('direction')); ?>',
                         preload : 'true',
						 autoslide: <?PHP if ($autospeed): echo($autospeed); else: echo('false'); endif?>*/
                      });
				}
			);
            </script>      
            <?php else : ?>
            <ul id="slidecustom" class="galslider">
                <?php foreach ($slides as $slider) : ?>       
                    <li>
                  		<?php if ($slider -> uselink == "Y" && !empty($slider -> link)) : ?>
							<a href="<?php echo $slider -> link; ?>" title="<?php echo $slider -> title; ?>">
                            	
						<?php elseif ($lightbox == "Y") : ?>
                        	<a rel="lightbox" href="<?php echo $full_image_href2[0]; ?>">
						<?PHP endif; ?>
                    	<img src="<?php echo $this -> Html -> image_url($slider -> image); ?>" alt="<?php echo $slider -> description;  ?>" />
                        <?PHP if ($lightbox == "Y" || $slider -> uselink == "Y") : ?></a><?PHP endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <script type="text/javascript">
			//jsSlideshow[0];
			jQuery.preLoadImages(
				[jsSlideshow[0],jsSlideshow[1],jsSlideshow[2]],function(){			
					jQuery('#loading').css("display", "none");
					jQuery('#slidecustom').css("display", "block");
					jQuery('#slidecustom').ulslide({
						effect: {
							type: 'slide', // slide or fade
							axis: 'x',     // x, y
							distance: 40   // Distance between frames
						},
						duration: <?php echo($this -> get_option('duration')); ?>,
						autoslide: <?PHP echo ($autospeed2) ? $autospeed2 : 'false';?>,
						width: <?php echo($width); ?>,
						height: <?php echo($height); ?>,
						mousewheel: false,
						nextButton: '#inext',
						prevButton: '#iprev'					
						/*
                         width: <?php echo($width); ?>,
                         affect: 'slide',
                         duration: <?php echo($this -> get_option('duration')); ?>,
                         height: 440,
                         bnext: '#inext',
                         bprev: '#iprev',
                         axis: '<?php echo($this -> get_option('axis')); ?>',
                         direction: '<?php echo($this -> get_option('direction')); ?>',
                         preload : 'true',
						 autoslide: <?PHP if ($autospeed): echo($autospeed); else: echo('false'); endif?>*/
                      });
				}
			);
			/*jQuery('#slidecustom').ready(function() {
				jQuery('.galslider').css("display", "none");
				jQuery('#loading').css("display", "none");
			});*/
			
            </script>
        <?php endif; ?>
        </div>
        <script type="text/javascript">
     		jQuery(document).ready(function() {
				jQuery(window).keyup(function (event) {
					if (event.keyCode == 37) {
						jQuery('#iprev').click();
					}
					if (event.keyCode == 39) {
						jQuery('#inext').click();
					}
				});
			});
		</script>
    </div>
<!--<img style="height:75px;" src="<?php echo $this -> Html -> image_url($this -> Html -> thumbname(basename($slide -> image_url))); ?>" alt="<?php echo $this -> Html -> sanitize($slide -> title); ?>" />-->
<?php endif; ?>