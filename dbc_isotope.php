<?php
/*
Plugin Name: Isotope Visual Layouts lite
Plugin URI: http://wordpress.damien.co/isotope?utm_source=WordPress&utm_medium=isotope-lite&utm_campaign=Isotope-Layouts
Description: Add visual effects to your list of posts & custom post types using Isotope. Needs a responsive theme   
Version: 3.0a
Author: Damien Saunders
Author URI: http://damien.co/?utm_source=WordPress&utm_medium=isotope-lite&utm_campaign=Isotope-Layouts
License: This plugin GPLv3 - All changes to the HTML / CSS or Javascript do require a licence.
*/

/**
 * You shouldn't be here.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Globals
 */
define ("ISOTOPE_LITE_VERSION", "3.0a");

$plugin = plugin_basename(__FILE__); 
//$damien_filtrify = true;

/**
 * Included files
 * since v3.0
 */
require_once ('inc/shortcode-handler.php');


/**
 * isotope_vpl_get_global_options function.
 * 
 * @access public
 * @return void
 */
function isotope_vpl_get_global_options(){  
global $isotope_vpl_option;
  $isotope_vpl_option  = get_option('isotope_options');  
return $isotope_vpl_option;  
} 


/**
 * Plugin Updater thanks to Janis -
 * visit http://w-shadow.com/blog/2010/09/02/automatic-updates-for-any-plugin/
 */

require 'inc/plugin-update/plugin-update-checker.php';
$IsotopeUpdateChecker = new PluginUpdateChecker(
    'http://damien.co/lite-isotope.json',
    __FILE__,
    'isotope-visual-layouts-lite'
    );


/**
 * Enqueue isotope.js
 */
function vpl_scripts_method() {
	wp_enqueue_script('isotope', plugins_url('/js/jquery.isotope.min.js', __FILE__), array('jquery'), true, true);
	wp_enqueue_script('isotope_myfile', plugins_url('/js/jquery.damien.js', __FILE__), array('isotope'), true, true);
	
}    
 
add_action('wp_enqueue_scripts', 'vpl_scripts_method');

/**
 * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
 */
add_action( 'wp_enqueue_scripts', 'dbc_isotope_add_my_stylesheet' );

/**
 * Enqueue plugin style-file
 */
function dbc_isotope_add_my_stylesheet() {
  // metro ui css
	wp_register_style( 'dbc_isotope-style', plugins_url('css/modern.css', __FILE__) );
  //  wp_register_style( 'dbc_isotope-style', plugins_url('css/custom_isotope.css', __FILE__) );
    wp_enqueue_style( 'dbc_isotope-style' );
}

/**
 * Add Hook for Admin page under Appearance
 */
add_action('admin_menu', 'dbc_isotope');
function dbc_isotope() 
{
	if(function_exists('add_menu_page')) 
	{
		add_theme_page('Isotope', 'Isotope', 'manage_options', dirname(__FILE__).'/dbc-isotope-options.php');
	}
}


/*
 * Add settings link on Installed Plugin page
 */
function isotope_visual_post_types_settings_link($links) { 
  $settings_link = '<a href="themes.php?page=isotope-visual-layouts-lite/dbc-isotope-options.php">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'isotope_visual_post_types_settings_link' );





/**
 * Register Activation Hook called on Plugin Init.
 * Define default option settings
 * @access public
 * @return void
 */
register_activation_hook(__FILE__, 'isotope_vpl_set_default_options');


/**
 * Add the default settings to the database
 */
add_action('admin_init', 'isotope_vpl_set_default_options');

function isotope_vpl_set_default_options() {
	if (get_option('isotope_options') === false){
		$new_options['dropdown1'] = "grey";
		$new_options['dropdown2'] = "Image with Text";
		$new_options['version'] = ISOTOPE_LITE_VERSION;
		add_option('isotope_options', $new_options);
		add_option('damien_style', "isotope");
	}
	
}


/**
 *  Register the settings and such
 */
add_action('admin_init', 'isotope_vpl_plugin_admin_init');

function isotope_vpl_plugin_admin_init(){
register_setting( 'isotope_vpl_plugin_options', 'isotope_options');
add_settings_section('isotope_vpl_plugin_main', 'Plugin Settings', 'isotope_vpl_plugin_section_text', 'dbc_isotope');
add_settings_field('isotope_vpl_drop_down1', 'Colour', 'isotope_vpl_setting_dropdown_fn', 'dbc_isotope', 'isotope_vpl_plugin_main');
add_settings_field('isotope_vpl_drop_down2', 'Featured Image', 'isotope_vpl_setting_thumbnails_fn', 'dbc_isotope', 'isotope_vpl_plugin_main');
}

/**
 * Main Settings Section description
 */
function isotope_vpl_plugin_section_text() {
echo '<div class="inside"><p>This plugin is free for you to use. Because I paid for a licence, you don\'t need one to use this.</p>';
}

/**
 * CSS Style Dropdown
 */
function isotope_vpl_setting_dropdown_fn() {
	$options = get_option('isotope_options');
	$items = array("Red", "Green", "Blue", "orange", "white", "violet", "yellow", "grey");
	echo "<select id='vpl_drop_down1' name='isotope_options[dropdown1]'>";
	foreach($items as $item) {
		$selected = ($options['dropdown1']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

/**
 * @deprecated Text field reserved for registration key
 */
function isotope_vpl_plugin_setting_string() {
$options = get_option('isotope_options');
echo "<input id='isotope_vpl_plugin_text_string' name='isotope_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
}

/**
* Thumbnails
*/
	function isotope_vpl_setting_thumbnails_fn() {
	$options = get_option('isotope_options');
	$items = array("Image with Text", "Image Only", "Text Only");
	echo "<select id='isotope_vpl_drop_down2' name='isotope_options[dropdown2]'>";
	foreach($items as $item) {
		$selected = ($options['dropdown2']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}


/**
 * isotope_vpl_plugin_options_page function.
 * display the admin options page
 *
 * @access public
 * @return void
 */
function isotope_vpl_plugin_options_page() {
?>
<form action="options.php" method="post">
<?php settings_fields('isotope_vpl_plugin_options');
	do_settings_sections('dbc_isotope'); ?>
<input class="button-primary" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
</form>

<?php
}




/**
 * Uninstall function
 */	
function isotope_vpl_uninstall()
{	
	delete_option('isotope_options');
	delete_option('damien_style');
}
register_deactivation_hook(__FILE__, 'isotope_vpl_uninstall');
?>