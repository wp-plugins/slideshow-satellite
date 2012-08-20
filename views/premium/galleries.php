<?php

if (!empty($slides)) :
    $displayFirstSatellite = $this -> render('default', array('slides' => $slides, 'frompost' => false), false, 'orbit');
    $displaySplash = true;
    ?>
    <div class='satl-gal-wrap'>
        <div class='satl-gal-titles'>
            <?php 
            $i=0;
            foreach ($galleries as $gallery) : 
                $info = $this -> Gallery -> find(array("id" => $gallery));
                $current = ($_POST['slideshow'] == $info->id) ? 'current' : '';
                if ($i == 0)
                    $firstID = $info->id;
                ?>
                <div class='salt-gal-title gal<?php echo($info->id);?>'>
                    <a href="javascript:void(0);" onclick="showSatellite(<?php echo($info->id);?>);">
                        <?php echo ($info->title);?>
                    </a>
                </div>
                <?php 
                $i++;
            endforeach; ?>
        </div>
        <div class="galleries-satl-wrap">
            <?php 
            if ($displaySplash) : 
                echo "<a href='javascript:void(0);' onclick='showSatellite(".$firstID.");'>";
                echo "<img class='absoluteCenter play' src='".SATL_PLUGIN_URL."/images/playbutton.png' alt='Play Slideshow'/>";
                echo "<img class='absoluteCenter splash' src='".$this->Html->image_url($slides[0]->image)."' alt='Play Slideshow'/>";
                echo "</a>";
            else :
                echo $displayFirstSatellite; 
            endif;?>
        </div>
        
    </div>
    <div style="clear:both;"></div>
<?php    
endif;


