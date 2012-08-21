<?php
global $satellite_init_ok;
if (!empty($slides)) :
    $displayFirstSatellite = $this -> render('default', array('slides' => $slides, 'frompost' => false), false, 'orbit');
    ?>
        <div id="splash-satl-wrap-<?php echo($satellite_init_ok);?>" class="splash-satl-wrap">
            <?php 
                echo "<a href='javascript:void(0);' onclick='showSoloSatellite(".intval($slides[0]->section).",".$satellite_init_ok.");'>";
                echo "<img class='absoluteCenter play' src='".SATL_PLUGIN_URL."/images/playbutton.png' alt='Play Slideshow'/>";
                echo "<img class='absoluteCenter splash' src='".$this->Html->image_url($slides[0]->image)."' alt='Play Slideshow'/>";
                echo "</a>";
                ?>
        </div>
<?php    
endif;
?>
