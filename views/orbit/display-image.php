<?php global $satellite_init_ok; ?>
<?php
$images = $this->get_option('Images');
$imagesbox = $images['imagesbox'];
$title = ($frompost) ? $slider->post_title : $slider->title;
$attachment_link = ($frompost) ? get_attachment_link($slider->ID) : '';
$pagelink = $images['pagelink'];
$full_image_href = wp_get_attachment_image_src($slider->ID, 'full', false);
$imagelink = ($frompost) ? $full_image_href[0] : $this->Html->image_url($slider->image);
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
  <a href="<?php echo $slider->link; ?>" title="<?php echo $slider->title; ?>" target="<?php echo ($pagelink == "S") ? "_self" : "_blank" ?>">
<?PHP elseif ($frompost && $this->get_option('wpattach') == 'Y') : ?>
  <a class="<?php echo $class; ?>" href="<?php echo $attachment_link; ?>" rel="<?php echo $rel; ?>" title="<?php echo $title; ?>">
<?PHP elseif ($imagesbox != "N" && ! $this->get_option('nolinker')) : ?>
  <a class="sorbit-link <?php echo $class; ?>" href="<?php echo $imagelink; ?>" rel="<?php echo $rel; ?>" title="<?php echo $title; ?>">
<?PHP endif; ?>
<img <?php echo ($this->get_option('abscenter') == "Y") ? "class='absoluteCenter'" : "" ?> 
  src="<?php echo $imagelink; ?>" 
  alt="<?php echo $title; ?>" />
<?PHP if (($imagesbox != "N" && ! $this->get_option('nolinker')) || $slider->uselink == "Y")  { ?></a><?PHP } ?>
