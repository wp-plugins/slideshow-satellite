<?php global $satellite_init_ok, $post; ?>
<?php
$images = $this->get_option('Images');
$imagesbox = $images['imagesbox'];
$ID = ($frompost) ? $slider->ID : $slider->id;
$title = ($frompost) ? $slider->post_title : $slider->title;
$attachment_link = ($frompost) ? get_attachment_link($ID) : '';
$pagelink = $images['pagelink'];

$full_image_href = wp_get_attachment_image_src($ID, 'full', false);

$image_path = ($frompost) ? $full_image_href[0] : $this->Html->image_path($slider->image);
$imagelink = ($frompost) ? $full_image_href[0] : $this->Html->image_url($slider->image);
$this->log_me($image_path);
if ($images['position'] == "S" || $images['position'] == "C") {
  $crop = ($images['position'] == "C") ? true : false;
  if (!$frompost && $data = getimagesize($image_path)) {
    list($width,$height) = $data;
    $size = $this->Image->getImageStretch($GLOBALS['post']->ID,$width,$height,$crop);
  } elseif ($frompost) {
    $size = $this->Image->getImageStretch($GLOBALS['post']->ID,$full_image_href[1],$full_image_href[2],$crop);
  } else {
    $size = null;
  }
  if ($images['position'] == "C") 
    $position = $size;
  else
    $position = "absoluteCenter stretchCenter " .$size;
} else {
  $position = "absoluteCenter noStretch";
}
$rel = "";
$class= "";
if ($imagesbox == "T") {
  $class="thickbox";
} elseif ($imagesbox == "L") {
  $rel = ($frompost) ? "lightbox[".$slider->post_parent."]" : "lightbox[".$slider->section."]";
  $class = "lightbox";
}
?>

<?php if (!$frompost && $slider->uselink == "Y" && !empty($slider->link)) : ?>
  <a class="sorbit-link" href="<?php echo $slider->link; ?>" title="<?php echo $slider->title; ?>" target="<?php echo ($pagelink == "S") ? "_self" : "_blank" ?>">
<?PHP elseif ($frompost && $this->get_option('wpattach') == 'Y') : ?>
  <a class="sorbit-link <?php echo $class; ?>" href="<?php echo $attachment_link; ?>" rel="<?php echo $rel; ?>" title="<?php echo $title; ?>">
<?PHP elseif ($imagesbox != "N" && ! $this->get_option('nolinker')) : ?>
  <a class="sorbit-link <?php echo $class; ?>" href="<?php echo $imagelink; ?>" rel="<?php echo $rel; ?>" title="<?php echo $title; ?>">
<?PHP endif; ?>
<img class="<?php echo($position);?>"
  src="<?php echo $imagelink; ?>" 
  alt="<?php echo $title; ?>" />
<?PHP if (($imagesbox != "N" && ! $this->get_option('nolinker')) || $slider->uselink == "Y")  { ?></a><?PHP } ?>
