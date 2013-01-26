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
    
    function applyWatermark($image, $ext) {
        if (!SATL_PRO) { return; }
        // TODO - Return if current gallery is "WaterMark" or "More"
        $gallery = $this -> data -> section;
        error_log("Applying watermark to new image in gallery: ". $gallery);
        $watermark = $this->get_option('Watermark');
        $Html = new SatelliteHtmlHelper;
        $imageurl = SATL_UPLOAD_URL . DS. $image;
        $imagedir = SATL_UPLOAD_DIR . DS. $image;
        $waterImg = $Html -> image_id($watermark['image']);
        if ($watermark['enabled']) {
            $stamp = $this->load($waterImg, true);
            $this->load($imageurl);
            $marge_right = 10;
            $marge_bottom = 10;
            $sx = imagesx($stamp);
            $sy = imagesy($stamp);
            // Copy the stamp image onto our photo using the margin offsets and the photo 
            // width to calculate positioning of the stamp. 
            imagecopy($this->image, $stamp, $this->getWidth() - $sx - $marge_right, $this->getHeight() - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

            // Output and free memory
            error_log("imaging");
            //imagepng($upload);
            $this->save($imagedir);
            error_log("imag destroying");
            imagedestroy($this->image);
        }
    }
    
    function deleteImages($record) {
      error_log("deleting all sizes of image files: ".$record->image);
      $imagepath = SATL_UPLOAD_DIR . DS;
      $name = SatelliteHtmlHelper::strip_ext($record->image, 'filename');
      $ext = SatelliteHtmlHelper::strip_ext($record->image, 'ext');

      $imagefull = $imagepath . $record->image;
      $thumbfull = $imagepath . $name . '-thumb.' . strtolower($ext);
      $smallfull = $imagepath . $name . '-small.' . strtolower($ext);
      $todelete = array($imagefull,$thumbfull,$smallfull);

      foreach ($todelete as $delete) {
        try {
          if (!unlink($delete)) {
              throw new Exception("Can not delete this file: ".$delete);
          }
        } catch (Exception $e) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
      }
    }


}