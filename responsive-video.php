<?php
/**
 * @package Responsive Video for WordPress
 * @version 1.0
 */
/*
Plugin Name: Responsive Video for WordPress
Plugin URI: http://www.nosecreekweb.ca/
Description: Responsive Video Embeds
Author: @nosecreek
Version: 1.0
Author URI: http://www.nosecreekweb.ca/
*/

add_filter( 'oembed_dataparse', 'responsive_embed', 10, 3 );
function responsive_embed( $return, $data, $url )
{
    if($data->type == 'video') {
		preg_match('/width="(\d+)(px)?" height="(\d+)(px)?"/', $return, $matches);
		
		$width = intval($matches[1]);
		$height = intval($matches[3]);
		
		$ratio = $height/$width*100;
		
		$return = preg_replace( array('/ height="[0-9]+"/', '/ width="[^"]*"/'), array('', ''), $return );
		$return = preg_replace( array('/ height="[0-9]+"/', '/ width="[^"]*"/'), array('', ''), $return );
		
		return "<div style='max-width:" . $width . "px;'><div class='video-wrapper' style='padding-bottom:" . $ratio . "%;'>" . $return . "</div></div>";
	}
	return $return;
}


/* Include the CSS file in the page <head> */
function responsive_video_css() {
	wp_register_style( 'responsive-video', plugins_url('responsive-video.css', __FILE__) );
	wp_enqueue_style( 'responsive-video' );
}
add_action( 'wp_enqueue_scripts', 'responsive_video_css' );

?>
