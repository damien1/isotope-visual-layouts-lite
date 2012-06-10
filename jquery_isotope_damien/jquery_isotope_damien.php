<?php
/*
Plugin Name: Damien's Isotope Script Plugin
Description: All of the important stuff for Isotope is added.
Version: 0.2
License: GPL
Author: Damien Saunders
Author URI: http://wordpress.damiensaunders.com
*/


add_action('init', 'register_my_script');
add_action('wp_footer', 'print_my_script');
add_action( 'wp_print_styles', 'add_my_stylesheet' );
 
function register_my_script() {
	wp_register_script('isotope', plugins_url('/js/jquery.isotope.min.js', __FILE__), array('jquery'), '1.0', true);
}

function add_my_stylesheet() {
        $myStyleUrl = plugins_url('style.css', __FILE__); 
        $myStyleFile = WP_PLUGIN_DIR . '/jquery_isotope_damien/style.css';
        if ( file_exists($myStyleFile) ) {
            wp_register_style('myStyleSheets', $myStyleUrl);
            wp_enqueue_style( 'myStyleSheets');
        }
    }

 
function print_my_script() {
	wp_print_scripts('isotope');
}

?>