<?php
/*
 * ORIGINALLY FROM:
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details:
* http://www.gnu.org/licenses/gpl.html
*
*/
class SatelliteImageHelper extends SatellitePlugin {
 
    var $image;
    var $image_type;

    function __construct() {
    }

    function load($filename, $return = false) {

      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
      if($return){
        return $this->image;
      }
    }
    
    function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {

         imagepng($this->image,$filename);
      }
      if( $permissions != null) {

         chmod($filename,$permissions);
      }
    }
    
    function output($image_type=IMAGETYPE_JPEG) {

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {

         imagepng($this->image);
      }
    }
    function getWidth() {

      return imagesx($this->image);
    }
    function getHeight() {

      return imagesy($this->image);
    }
    function resizeToBox($size = null) {
      if (!$size) { return; }
      if ($this->getHeight() > $this->getWidth()) {
        $this->resizeToHeight($size);
      } else {
        $this->resizeToWidth($size);
      }
    }
    function resizeToHeight($height) {

      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
    }

    function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
    }

    function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
    }

    function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
    }      
    
    public function getImageStretch($i_w,$i_h,$w) {
      $styles = $this->get_option('styles');
      $s_w = ($wt = intval($this->get_option('width_temp'))) ? $wt : $styles['width'];
      $s_h = ($ht = intval($this->get_option('height_temp'))) ? $ht : $styles['height'];
      $i_r = intval($i_w)/intval($i_h);
      $s_r = $s_w/$s_h;
      if ($i_r <= $s_r)
        return "tall";
      else
        return "wide";
    }
    /*
     * @image is 
     */
    function applyWatermark($image, $galId) {
        if (!SATL_PRO) { return; }
        $Gallery = new SatelliteGallery;
        error_log( "gallery id is ". $galId);
        if ($Gallery -> isSpecialGallery($galId)) {
          return;
        }
        $watermark = $this->get_option('Watermark');
        if (!$watermark['enabled']) {
          error_log("Watermarking is not enabled");
          return;
        }
        SatellitePremiumHelper::doWatermark($image, $watermark);
    }
    
    function deleteImages($record, $deleteall) {
      $imagepath = SATL_UPLOAD_DIR . '/';
      $name = SatelliteHtmlHelper::strip_ext($record->image, 'filename');
      $ext = SatelliteHtmlHelper::strip_ext($record->image, 'ext');

      $imagefull = $imagepath . $record->image;
      $thumbfull = $imagepath . $name . '-thumb.' . strtolower($ext);
      $smallfull = $imagepath . $name . '-small.' . strtolower($ext);
      $urlfull = ($record -> image_url) ? $record -> image_url : null;
      error_log('url to delete:'.$urlfull);
      
      $url = preg_replace('/^.*wp-content/', null, $urlfull);
      $urlfull = SATL_UPLOAD_DIR.'/../..'.$url;
      if ($deleteall) {
        error_log("deleting all sizes of image files: ".$record->image);
        $todelete = array($urlfull,$imagefull,$thumbfull,$smallfull);
      } else {
        error_log("deleting large size of image files: ".$record->image);
        $todelete = array($imagefull);
      }

      foreach ($todelete as $delete) {
        try {
          if (!unlink($delete)) {
              throw new Exception("Can not delete this file: ".$delete);
          }
        } catch (Exception $e) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
          error_log('Caught exception'. $e->getMessage()); 
        }
      }
    }


}