<?php

include_once ('path/to/wp-blog-header.php');

class life {

function defaultStreams() {
	// To add another service to the system, simply
	// add it to this array().
	return array( 
		'life_blog' => '',
		'life_flickr' => '',
		'life_twitter' => '',
		'life_facebook' => '',
		'life_lastfm' => '',
		'life_foursquare' => '',
		);
}

function checkStreams() {
	if( get_option( 'life_installed' ) ) {
	} else {
		self::install();
	}
}

function install() {
	add_option( 'life_installed', '1', "" );
	add_option( 'life_version', '1.0', "");
	foreach ( self::defaultStreams() as $key => $value ) {
		add_option( $key, $value, "" );
	}
	echo 'Installed, ready to go.';
}

function upgrade() {
	foreach ( self::defaultStreams() as $key => $value ) {
		if( !get_option( $key ) ) {
		add_option( $key, $value, "" );
		echo 'Added ' . $key;
		}
	}
}

function loadStreams() {
	foreach( self::defaultStreams() as $key => $value ) {
	// find the values for each of our streams (RSS Feeds)
		if( get_option( $value ) ) {
			$value = get_option(  $value );
		} else {
			echo '<p>' . $key . ': ' . $value . ' not found in the database.</p>';
		}
	}
}
}

life::checkStreams();

?>