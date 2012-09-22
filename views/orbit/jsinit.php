<?php
    global $satellite_init_ok;
    $style = $this->get_option('styles');
    if ($this->get_option('autoslide') == "Y") {
        $autospeed = $this->get_option('autospeed');
        $autospeed2 = $this->get_option('autospeed2');
    } else {
        $autospeed = '0';
        $autospeed2 = '0';
    }
    if (!$this->get_option('nav_opacity')) {$this->update_option('nav_opacity',.1);}
    $thumbwidth = (int) $style['thumbheight'] + $style['thumbspacing'] + $style['thumbspacing'];
    $transition = $this->Config->getTransitionType();
    if ($fullthumb)
    { $bullets = true; }
    elseif ($this->get_option('thumbnails_temp') == "Y")
    { $bullets = true; }
    else 
    { $bullets = false; }
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#featured<?php echo $satellite_init_ok; ?>').orbit({
                animation: '<?PHP echo ($transition) ? $transition : $this->get_option('transition'); ?>',                  // fade, horizontal-slide, vertical-slide, horizontal-push
                animationSpeed: <?php echo($this->get_option('duration')); ?>,                // how fast animations are
                timer: <?PHP echo ($this->get_option("autoslide_temp") == "Y" ) ? 'true' : 'false'; ?>, 	 // true or false to have the timer
                advanceSpeed: <?PHP echo ($autospeed2); ?>, 		 // if timer is enabled, time between transitions 
                pauseOnHover: <?php echo ($gallery->data->pausehover) ? 'true' : 'false'; ?>, 		 // if you hover pauses the slider
                startClockOnMouseOut: <?php echo ($gallery->data->pausehover) ? 'true' : 'false'; ?>, 	 // if clock should start on MouseOut
                startClockOnMouseOutAfter: 1000, 	 // how long after MouseOut should the timer start again
                directionalNav: true, 		 // manual advancing directional navs
                captions: <?php echo($this->get_option('information_temp') == 'Y') ? 'true' : 'false'; ?>,	 // do you want captions?
                captionAnimation: <?php echo ($gallery->data->capanimation) ? '\'' . $this->Gallery->data->capanimation . '\'' : '\'slideOpen\''; ?>, // fade, slideOpen, none
                captionHover: <?php echo ($gallery->data->caphover) ? 'true' : 'false'; ?>, // true means only show caption on mousehover
                captionAnimationSpeed: 800, 	 // if so how quickly should they animate in
                bullets: <?php echo($bullets) ? 'true' : 'false'; ?>,	// true or false to activate the bullet navigation
                bulletThumbs: true,		 // thumbnails for the bullets
                bulletThumbLocation: '',	 // location from this file where thumbs will be
                afterSlideChange: function(){},    // empty function 
                centerBullets: <?php echo $this->get_option('bullcenter'); ?>,
                navOpacity: <?php echo $this->get_option('nav_opacity'); ?>,
                thumbWidth: <?php echo $thumbwidth; ?>
            });				
        });
    </script> 
