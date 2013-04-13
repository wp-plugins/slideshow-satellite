<div class="wrap" ng-app="scroll" ng-controller="Main">
	 <?php $version = $this->Version->checkLatestVersion();
        if (!$version['latest'] && $version['message'] && SATL_PRO) 
          { ?>
                <div class="plugin-update-tr">
                    <div class="update-message">
                            <?php echo $version['message']; ?>
                    </div>
                </div>
	<?php }
        $images = $this->get_option('Images'); 
		        if (!empty($_GET['single'])) {
            $single = $_GET['single'];
            $slides = $this -> Slide -> find_all(array('section'=>(int) stripslashes($single)), null, array('slide_order', "ASC"));
        } else { $single = false; }
        
        ?>

    <h2><?php _e('Manage Slides', SATL_PLUGIN_NAME); ?> <?php echo $this -> Html -> link(__('Add New'), 
                    $this -> url . '&amp;method=save&single='.$single, 
                    array('class' => "button add-new-h2")); ?></h2>
	<?php if (!empty($slides)) : ?>	
		<form id="posts-filter" action="<?php echo $this -> url; ?>" method="post">
			<ul class="subsubsub">
				<li><?php echo $paginate -> allcount; ?> <?php _e('slides', SATL_PLUGIN_NAME); ?></li>
			</ul>
		</form>
                <div class="alignright">
                    <form action="<?php echo $this -> url; ?>&amp;method=single" method="POST">
                        <select name="section">
                            <option value="All">All</option>
                            <?php $single = ($_GET['single']) ? $_GET['single'] : null;?>
                            <?php $gals = $this -> Gallery -> find_all(null, array('id','title'), array('gal_order', "ASC") );
							//print_r($gals);
							 ?>

                                <?php if (!empty($gals)) : ?>
                                    <?php foreach ( $gals as $gallery ) {?>
                                        <option <?php echo ((int) $single == $gallery -> id) ? 'selected="selected"' : ''; ?> value="<?php echo($gallery -> id) ?>">Gallery <?php echo($gallery -> id. ": ".$gallery -> title)?></option>
                                    <?php } ?>
                                <?php else : ?>
                                        <option <?php echo ((int) $this -> Slide -> data -> section == '1') ? 'selected="selected"' : ''; ?> value="1">Gallery 1</option>
                                <?php endif; ?>
                        </select>
                        <input type="submit" name="View" value="View"/>
                    </form>
                </div>
                <span class="alignright" style="padding-top:5px">View Only : </span>

	<?php endif; ?>
        
	
	<?php if (!empty($slides)) :  ?>
		<form onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected slides?', SATL_PLUGIN_NAME); ?>')) { return false; }" action="<?php echo $this -> url; ?>&amp;method=mass&amp;single=<?php echo($single);?>" method="post">
			<div class="tablenav">
				<div class="alignleft actions">
					<a href="<?php echo $this -> url; ?>&amp;method=order&single=<?php echo $_GET['single']; ?>" title="<?php _e('Order all your slides', SATL_PLUGIN_NAME); ?>" class="button clearfix alignright" style="margin-left:7px;"><?php _e('Order Slides', SATL_PLUGIN_NAME); ?></a>
				
					<select name="action" class="action alignleft">
						<option value="">- <?php _e('Bulk Actions', SATL_PLUGIN_NAME); ?> -</option>
						<option value="delete"><?php _e('Delete', SATL_PLUGIN_NAME); ?></option>
            <?php if ($images[resize]):?>
              <option value="resize"><?php _e('Resize to ', SATL_PLUGIN_NAME); echo($images['resize'].'px'); ?></option>
            <?php endif;?>
						<?php if ($this->canPremiumDoThis('watermark')) :?>
              <option value="watermark"><?php _e('Watermark', SATL_PLUGIN_NAME); ?></option>
            <?php endif; ?>
					</select>
					<input type="submit" class="button alignleft" value="<?php _e('Apply', SATL_PLUGIN_NAME); ?>" name="execute" />
				</div>
				<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
			</div>
		
			<div class="widefat">
        <ul>
          <li class="slide-holder row-fluid">
            <div class="fl-l loader-check check-column"><input type="checkbox" name="checkboxall" id="checkboxall" value="checkboxall" /></div>
            <div class="fl-l loader-image">Image</div>
            <div class="fl-l loader-title">Title</div>
            <div class="fl-r loader-date">Modified</div>
            <div class="fl-r loader-uselink">Use Link</div>
            <div class="fl-r loader-order">Order</div>
            <div class="fl-r loader-section">Gallery</div>
          </li>
        </ul>  
				<div class="thbody">
          <div id="fixed" when-scrolled="loadMore()">
            <ul>
              <li class="slide-holder row-fluid" ng-repeat="i in items" ng-mouseover="onhover($event)" ng-mouseout="onhover($event)">
                                <div class="fl-l loader-check check-column"><input type="checkbox" name="Slide[checklist][]" value="{{i.id}}" id="checklist{{i.id}}" /></div>
                <div class="fl-l loader-image"><a href="{{i.image}}"><img src="{{i.thumb}}"/></a></div>
                <div class="fl-l loader-title">
                  <a class="row-title" href="<?php echo $this -> url; ?>&amp;method=save&amp;id={{i.id}}&amp;single=<?php echo($single);?>" title="">{{i.title}}</a>
                  <div ng-show="hover">
                    <span class="edit"><?php echo $this -> Html -> link(__('Edit', SATL_PLUGIN_NAME), "?page=satellite-slides&amp;method=save&amp;single=".$single."&amp;id={{i.id}}"); ?> |</span>
                    <span class="delete"><?php echo $this -> Html -> link(__('Delete', SATL_PLUGIN_NAME), "?page=satellite-slides&amp;method=delete&amp;single=".$single."&amp;id={{i.id}}" . $slide ->id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you want to permanently remove this slide?', SATL_PLUGIN_NAME) . "')) { return false; }")); ?></span>
                  </div>

                  <div class="loader-title" style="display:none" showonhoverparent>
                     <span ng-click="deleteEntry(entry)"><a class="btn btn-danger" href="#">Delete</a></span>
                  </div>
                </div>
                <div class="fl-r loader-date">{{i.date}}</div>
                <div class="fl-r loader-uselink">{{i.uselink}}</div>
                <div class="fl-r loader-order">{{i.slide_order}}</div>
                <div class="fl-r loader-section">{{i.section}}</div>
              </li>
            </ul>  
          </div>
				<div>
        <ul>
          <li class="slide-holder row-fluid">
            <div class="fl-l loader-check check-column">&nbsp;</div>
            <div class="fl-l loader-image">Image</div>
            <div class="fl-l loader-title">Title</div>
            <div class="fl-r loader-date">Modified</div>
            <div class="fl-r loader-uselink">Use Link</div>
            <div class="fl-r loader-order">Order</div>
            <div class="fl-r loader-section">Gallery</div>
          </li>
        </ul>  
						<th class="check-column"><input type="checkbox" name="checkboxall" id="checkboxall" value="checkboxall" /></th>
						<th><?php _e('Image', SATL_PLUGIN_NAME); ?></th>
						<th><?php _e('Title', SATL_PLUGIN_NAME); ?></th>
                        <th><?php _e('Link', SATL_PLUGIN_NAME); ?></th>
						<th><?php _e('Date', SATL_PLUGIN_NAME); ?></th>
                        <th><?php _e('Gallery', SATL_PLUGIN_NAME); ?></th>
						<th><?php _e('Order', SATL_PLUGIN_NAME); ?></th>
				</div>

          <?php                                     
          foreach ($slides as $slide) : 
            continue;
			//print_r($slides);
            ?>
                                    
						<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
							<th class="check-column"><input type="checkbox" name="Slide[checklist][]" value="<?php echo $slide -> id; ?>" id="checklist<?php echo $slide -> id; ?>" /></th>
							<td style="width:75px;">
								<?php $image = $slide -> image; ?>
								<a href="<?php echo $this -> Html -> image_url($image); ?>" title="<?php echo $slide -> title; ?>" class="thickbox"><img style="width:50px;" src="<?php echo $this->Html->image_url($this->Html->thumbname($slide->image)); ?>" alt="<?php echo $this -> Html -> sanitize($slide -> title); ?>" /></a>
							</td>
							<td>
                  <a class="row-title" href="<?php echo $this -> url; ?>&amp;method=save&amp;id=<?php echo $slide -> id; ?>&amp;single=<?php echo($single);?>" title=""><?php echo $slide -> title; ?></a>
                  <div class="row-actions">
                  <span class="edit"><?php echo $this -> Html -> link(__('Edit', SATL_PLUGIN_NAME), "?page=satellite-slides&amp;method=save&amp;single=".$single."&amp;id=" . $slide -> id); ?> |</span>
                  <span class="delete"><?php echo $this -> Html -> link(__('Delete', SATL_PLUGIN_NAME), "?page=satellite-slides&amp;method=delete&amp;single=".$single."&amp;id=" . $slide -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you want to permanently remove this slide?', SATL_PLUGIN_NAME) . "')) { return false; }")); ?></span>
                  </div>
              </td>
              <td>
                  <?php if (!empty($slide -> uselink) && $slide -> uselink == "Y") : ?>
                          <span style="color:green;"><?php _e('Yes', SATL_PLUGIN_NAME); ?></span>
                  <?php else : ?>
                          <span style="color:red;"><?php _e('No', SATL_PLUGIN_NAME); ?></span>
                  <?php endif; ?>
              </td>
              <td><abbr title="<?php echo $slide -> modified; ?>"><?php echo date("Y-m-d", strtotime($slide -> modified)); ?></abbr></td>
              <td><?php echo ((int) $slide -> section); ?></td>
              <td><?php echo ((int) $slide -> slide_order + 1); ?></td>
            </tr>
                                                    
					<?php 
           endforeach; ?>
				</div>
			</table>
			
				<?php $this -> render('lazyload', array('slides' => $slides), true, 'admin'); ?>

		</form>
	<?php else : ?>
		<p style="color:red;"><?php _e('No slides found', SATL_PLUGIN_NAME); ?></p>
	<?php endif; ?>
</div>