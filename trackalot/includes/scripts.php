<?php

function ta_add_scripts() {
	// Add Main CSS
	wp_enqueue_style('ta-main-style', plugins_url(). '/trackalot/css/style.css');
	// Add Main JS
	wp_enqueue_script('ta-main-script', plugins_url(). '/trackalot/js/main.js');
}

add_action('wp_enqueue_scripts', 'ta_add_scripts');