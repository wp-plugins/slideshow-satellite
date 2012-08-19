<?php

if (!empty($slides)) :
    $displayFirstSatellite = $this -> render('default', array('slides' => $slides, 'frompost' => false), false, 'orbit');
    ?>
    <div class='satl-gal-wrap'>
        <div class='satl-gal-titles'>
            <?php foreach ($galleries as $gallery) : 
                $info = $this -> Gallery -> find(array("id" => $gallery));
                ?>
            <div class='salt-gal-title'>
                <a href="javascript:void(0);" onclick="showSatellite(<?php echo($info->id);?>);">
                    <?php echo ($info->title);?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="galleries-satl-wrap">
            <?php echo $displayFirstSatellite; ?>
        </div>
        
    </div>
<?php    
endif;


