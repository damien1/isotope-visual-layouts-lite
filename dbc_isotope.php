<?php
/*
Plugin Name: DBC Isotope
Plugin URI: http://wordpress.damien.co/isotope?utm_source=WordPress&utm_medium=isotope&utm_campaign=WordPress-Plugin
Description: A plugin to add Isotope & Masonry to your website. 
Version: 0.1
Author: Damien Saunders
Author URI: http://damien.co/?utm_source=WordPress&utm_medium=isotope&utm_campaign=WordPress-Plugin
License: Caution needs commercial licence
*/

//hooks to add isotope jquery and custom stylesheet
add_action('init', 'register_my_script');
add_action('wp_footer', 'print_my_script');
add_action( 'wp_print_styles', 'add_my_stylesheet' );
 
function register_my_script() {
	wp_register_script('isotope', plugins_url('/js/jquery.isotope.min.js', __FILE__), array('jquery'), '1.0', true);
}

function add_my_stylesheet() {
        $myStyleUrl = plugins_url('style.css', __FILE__); 
        $myStyleFile = WP_PLUGIN_DIR . __FILE__ . '/css/style.css';
        if ( file_exists($myStyleFile) ) {
            wp_register_style('myStyleSheets', $myStyleUrl);
            wp_enqueue_style( 'myStyleSheets');
        }
    }

 
function print_my_script() {
	wp_print_scripts('isotope');
}

// Add Hook for Menu under Appearance
add_action('admin_menu', 'dbc_isotope');
function dbc_excludesitewide() 
{
	if(function_exists('add_menu_page')) 
	{
		add_theme_page('Isotope', 'Isotope', 'manage_options', dirname(__FILE__).'/dbc-isotope-options.php');
	}
}



?>