<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Parts Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* 
* Modified by David Barrett 09/11/2009
* Changed: Resize function (now supports transparency and proportional resize)
* Copyright: 2009 David Barrett
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

class simpleimage {
   
   var $image;
   var $image_type;
 
	function load($filename) {
		$image_info = getimagesize($filename);
		$this->image_type = $image_info[2];
		if( $this->image_type == IMAGETYPE_JPEG ) {
			$this->image = imagecreatefromjpeg($filename);
		} elseif( $this->image_type == IMAGETYPE_GIF ) {
			$this->image = imagecreatefromgif($filename);
		} elseif( $this->image_type == IMAGETYPE_PNG ) {
			$this->image = imagecreatefrompng($filename);
		} else $this->image = FALSE;
	}
	
	function isImage() {
		if ( $this->image === FALSE ) return FALSE;
		return true;
	}

	function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
		$success = false;
		if( $image_type == IMAGETYPE_JPEG ) {
			$success = imagejpeg($this->image,$filename,$compression);
		} elseif( $image_type == IMAGETYPE_GIF ) {
			$success = imagegif($this->image,$filename);         
		} elseif( $image_type == IMAGETYPE_PNG ) {
			$success = imagepng($this->image,$filename);
		}   
		if( $permissions != null) {
			chmod($filename,$permissions);
		}
		return $success;
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
		if ( $this->image === FALSE ) return false;
		return imagesx($this->image);
	}
	
	function getHeight() {
		if ( $this->image === FALSE ) return false;
		return imagesy($this->image);
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
   
	function resize( $width = 0, $height = 0, $proportional = false )
	{
		if ( $height <= 0 && $width <= 0 ) return false;
		
		if ( $this->image_type != IMAGETYPE_GIF && $this->image_type != IMAGETYPE_JPEG && $this->image_type != IMAGETYPE_PNG ) return false;
		
		$final_width = 0;
		$final_height = 0;
		$width_old = imagesx($this->image);
		$height_old = imagesy($this->image);
		
		if ( $proportional ) {
			if ($width == 0) $factor = $height/$height_old;
			elseif ($height == 0) $factor = $width/$width_old;
			else $factor = min ( $width / $width_old, $height / $height_old);   			
			$final_width = round ($width_old * $factor);
			$final_height = round ($height_old * $factor);			
		} else {
			$final_width = ( $width <= 0 ) ? $width_old : $width;
			$final_height = ( $height <= 0 ) ? $height_old : $height;
		}
		
		$image_resized = imagecreatetruecolor( $final_width, $final_height );
		
		if ( ( $this->image_type == IMAGETYPE_GIF) || ( $this->image_type == IMAGETYPE_PNG) ) {
			$transparent_index = imagecolortransparent( $this->image );
			if ($transparent_index >= 0) {
				$transparent_colour = imagecolorsforindex($this->image, $transparent_index);
				$transparent_index = imagecolorallocate($image_resized, $transparent_colour['red'], $transparent_colour['green'], $transparent_colour['blue']);
				imagefill($image_resized, 0, 0, $transparent_index);
				imagecolortransparent($image_resized, $transparent_index);
			} 
			elseif ( $this->image_type == IMAGETYPE_PNG) {
				imagealphablending($image_resized, false);
				$color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
				imagefill($image_resized, 0, 0, $color);
				imagesavealpha($image_resized, true);
			}
		}
		
		imagecopyresampled($image_resized, $this->image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
		
		$this->image = $image_resized;
		return true;
	}   
   
}
?>

