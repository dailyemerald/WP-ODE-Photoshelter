<?php
/*
Plugin Name: ODE - Photoshelter gallery
Plugin URI: http://thegarage.dailyemerald.com
Description: Make a gallery (list) from Photoshelter
Version: 0.1
Author: Ivar Vong/Oregon Daily Emerald
Author URI: http://twitter.com/ivarvong
License: MIT
*/

function odephotoshelter($atts, $content=null) {
	$imageSuffix = "/s/980/700";
	$urlPart1 = "http://dailyemerald.photoshelter.com/gallery/"; 	 	
	$urlPart2 = "?feed=json&ppg=200&imgT=casc&cred=iptc";

	extract(shortcode_atts(array(  
	        "id" => ""
	), $atts));
	
	$json = json_decode( file_get_contents($urlPart1 . $id . $urlPart2) );
	
	$ret = "<style type='text/css'>\n";
	$ret = $ret . ".ps-caption { line-height: 18px; font-size: 14px; padding: 10px; background:#EEE; border: 1px solid #CCC; }\n";
	$ret = $ret . ".ps-image { margin-bottom: 40px; width: 980px; }\n";
	$ret = $ret . ".ps-image img {display: block; margin: 0 auto; }\n";
	$ret = $ret . "</style>\n\n";
	
	$images = $json->images;
	foreach ($images as $key => $image) {
		$ret = $ret . "<div class='ps-image'>";
		$ret = $ret . "<img src=\"" . $image->src . $imageSuffix ."\"></img>";
		$ret = $ret . "<p class='ps-caption'>" . $image->caption . "</p>";
		$ret = $ret . "</div>";
	}

	return $ret;
}
add_shortcode("odephotoshelter", "odephotoshelter");