<?php
/**
* @package trackalot
*/
/*
Plugin Name: Trackalot
Plugin URI:http:webs4u.net
Description: Creates a widget that can output user IP address, location, geo coordinates and/or registered phone number.
Version: 1
Author: Benedict Marien
Author URI: http://webs4u.net
License: GPLv2 or later
Text Domain: trackalot
?>
*/

/*
Copyright (C) 2017  Benedict Marien

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if(!defined('ABSPATH')) {
	die;
}

// Load Scripts
require_once(plugin_dir_path(__FILE__). '/includes/scripts.php');

// Load Class
require_once(plugin_dir_path(__FILE__). '/includes/trackalot-class.php');

// Register Widget
function register_trackalot() {
	register_widget('trackalot_widget');
}

// Hooks
add_action('widgets_init', 'register_trackalot');



