<?php

include_once ("blog/wp-config.php");

class life {

function defaultStreams() {
	// To add another service to the system, simply
	// add it to this array().
	return array( 
		'life_blog' => '',
		'life_flickr' => '',
		'life_lastfm' => '',
		'life_twitter' => '',
		'life_facebook' => '',
		'life_foursquare' => '',
		'life_instagram' => '',
		'life_youtube' => '',
		);
}

function checkStreams() {
	if( get_option( 'life_installed' ) ) {
	} else {
		self::install();
	}
}

}

life::checkStreams();

?>