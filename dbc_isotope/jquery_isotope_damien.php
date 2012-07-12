<?php
/*
Plugin Name: DBC Isotope
Plugin URI: http://wordpress.damien.co/isotope?utm_source=WordPress&utm_medium=isotope&utm_campaign=WordPress-Plugin
Description: A plugin to add Isotope & Masonry to your website. Caution needs commercial licence
Version: 2.0
Author: damiensaunders
Author URI: http://damien.co/?utm_source=WordPress&utm_medium=isotope&utm_campaign=WordPress-Plugin
License: GPLv2 or later
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