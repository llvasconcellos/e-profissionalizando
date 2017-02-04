<?php
/*
processImage.php
Copyright (C) 2004-2006 Peter Frueh (http://www.ajaxprogrammer.com/)
Additional code contributions and modifications by David Fuller, Olli Jarva, and Simon Jensen
Heavily modified by David Barrett 2010 for integration into ceditFinder

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
*/

// required params: imageName, origName

header("Content-Type: text/plain");

$imageName = str_replace(array("../", "./"), "", $_REQUEST['imageName']);
$origName = str_replace(array("../", "./"), "", $_REQUEST['origName']);

if ( empty($origName) ) {
	echo "{imageFound:false}";
	exit;
}

if ( $origName == $imageName ) {
	// This is first call, so we need to create copy of image for editing
	if ( !file_exists($origName) ) {
		echo '{imageFound:false}';
		exit;
	}
	if ( file_exists($imageName) ) @unlink($imagename);
	$editDirectory = getcwd() . "/edit/";
	$imageName = $editDirectory . basename( $origName );
	copy( $origName, $imageName );
}

if ( !file_exists($imageName) ) {
	echo '{imageFound:false}';
	exit;
}
	
$action = $_REQUEST["action"];
$fileInfo = pathinfo($imageName);
$extension = $fileInfo['extension'];

switch($action){
	case "undo":  // This is actually revert now, as only revert is supported
		if (file_exists($origName)) {
			unlink($imageName);
			copy( $origName, $imageName );
		}
		break;

	case "save":  // Copy working image back to original
		copy( $imageName, $origName );
		break;

	case "resize": // additional required params: w, h
		$out_w = $_REQUEST["w"];
		$out_h = $_REQUEST["h"];
		if (!is_numeric($out_w) || $out_w < 1 || $out_w > 2000 || !is_numeric($out_h) || $out_h < 1 || $out_h > 2000) { exit; }
		list($in_w, $in_h) = getimagesize($imageName);
		$in = create_image( $imageName );
		$out = imagecreatetruecolor($out_w, $out_h);
		imagecopyresampled($out, $in, 0, 0, 0, 0, $out_w, $out_h, $in_w, $in_h);
		output_image( $out, $imageName );
		imagedestroy($in);
		imagedestroy($out);
		break;

	case "rotate": // additional required params: degrees (90, 180 or 270)
		$degrees = $_REQUEST["degrees"];
		if (($degrees != 90 && $degrees != 180 && $degrees != 270)) { exit; }

		$in = create_image( $imageName );
		if ($degrees == 180){
			$out = imagerotate($in, $degrees, 180);
		}else{ // 90 or 270
			$x = imagesx($in);
			$y = imagesy ($in);
			$max = max($x, $y);

			$square = imagecreatetruecolor($max, $max);
			imagecopy($square, $in, 0, 0, 0, 0, $x, $y);
			$square = imageRotate($square, $degrees, 0);

			$out = imagecreatetruecolor($y, $x);
			if ($degrees == 90) {
				imagecopy($out, $square, 0, 0, 0, $max - $x, $y, $x);
			} elseif ($degrees == 270) {
				imagecopy($out, $square, 0, 0, $max - $y, 0, $y, $x);
			}
			imagedestroy($square);
		}
		output_image( $out, $imageName );
		imagedestroy($in);
		imagedestroy($out);
		break;

	case "crop": // additional required params: x, y, w, h
		$x = $_REQUEST["x"];
		$y = $_REQUEST["y"];
		$w = $_REQUEST["w"];
		$h = $_REQUEST["h"];
		if (!is_numeric($x) || !is_numeric($y) || !is_numeric($w) || !is_numeric($h)) { exit; }

		$in = create_image( $imageName );
		$out = imagecreatetruecolor($w, $h);
		imagecopyresampled($out, $in, 0, 0, $x, $y, $w, $h, $w, $h);
		output_image( $out, $imageName );
		imagedestroy($in);
		imagedestroy($out);
		break;

	case "grayscale":	// no additional params.

		$in = create_image( $imageName );
		imagefilter($in,IMG_FILTER_GRAYSCALE);
		output_image( $in, $imageName );
		imagedestroy($in);
		break;

	case "sepia":	// no additional params.

		$in = create_image( $imageName );
		imagefilter($in, IMG_FILTER_GRAYSCALE);
		imagefilter($in, IMG_FILTER_COLORIZE, 100, 50, 0);
		output_image( $in, $imageName );
		imagedestroy($in);
		break;

	case "pencil":	// no additional params.

		$in = create_image( $imageName );
		imagefilter($in, IMG_FILTER_EDGEDETECT);
		output_image( $in, $imageName );
		imagedestroy($in);
		break;

	case "emboss":	// no additional params.

		$in = create_image( $imageName );
		imagefilter($in, IMG_FILTER_EMBOSS);
		output_image( $in, $imageName );
		imagedestroy($in);
		break;

	case "blur":	// no additional params.

		$in = create_image( $imageName );
		imagefilter($in, IMG_FILTER_GAUSSIAN_BLUR);
		output_image( $in, $imageName );
		imagedestroy($in);
		break;

	case "smooth":	// no additional params.

		$in = create_image( $imageName );
		imagefilter($in, IMG_FILTER_SMOOTH, 5);
		output_image( $in, $imageName );
		imagedestroy($in);
		break;

	case "invert":	// no additional params.

		$in = create_image( $imageName );
		imagefilter($in, IMG_FILTER_NEGATE);
		output_image( $in, $imageName );
		imagedestroy($in);
		break;

	case "brighten":	// param amt = amount to brighten (up or down)
		$amt = $_REQUEST['amt'];

		$in = create_image( $imageName );
		imagefilter($in, IMG_FILTER_BRIGHTNESS, $amt);
		output_image( $in, $imageName );
		imagedestroy($in);
		break;

}

list($w, $h) = getimagesize($imageName);
echo '{imageFound:true,imageName:"'.str_replace('\\', '\\\\', $imageName).'",w:'.$w.',h:'.$h.'}';



function create_image( $imageName ) {
	global $extension;
	if ($extension == "jpg" || $extension == "jpeg") {
		$image = imagecreatefromjpeg($imageName);
	}
	if ($extension == "gif") {
		$image = imagecreatefromgif($imageName);
	}
	if ($extension == "png") {
		$image = imagecreatefrompng($imageName);
	}
	return $image;
}

function output_image( $image, $imageName ) {
	global $extension;
	if ($extension == "jpg" || $extension == "jpeg") imagejpeg( $image, $imageName, 100 );
	if ($extension == "gif") imagegif( $image,$imageName );
	if ($extension == "png") imagepng( $image,$imageName );
}
?>