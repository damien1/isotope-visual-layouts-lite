<?php
/*
Plugin Name: Isotope Visual Layouts lite
Plugin URI: http://wordpress.damien.co/isotope?utm_source=WordPress&utm_medium=isotope&utm_campaign=Isotope-Layouts
Description: Add visual effects to your list of posts & custom post types using Isotope. Needs a responsive theme   
Version: 1.1
Author: Damien Saunders
Author URI: http://damien.co/?utm_source=WordPress&utm_medium=isotope&utm_campaign=Isotope-Layouts
License: This plugin GPLv3 - All changes to the HTML / CSS or Javascript do require a licence.
*/

/**
 * You shouldn't be here.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Globals
 */
define ("ISOTOPE_LITE_VERSION", "1.1");

$plugin = plugin_basename(__FILE__); 

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

require 'inc/plugin-update-checker.php';
$IsotopeUpdateChecker = new PluginUpdateChecker(
    'http://damien.co/lite-isotope.json',
    __FILE__,
    'isotope-visual-layouts-lite'
    );


/**
 * Enqueue isotope.js
 */
function my_scripts_method() {
	wp_enqueue_script('isotope', plugins_url('/js/jquery.isotope.js', __FILE__), array('jquery'));
}    
 
add_action('wp_enqueue_scripts', 'my_scripts_method');

/**
 * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
 */
add_action( 'wp_enqueue_scripts', 'dbc_isotope_add_my_stylesheet' );

/**
 * Enqueue plugin style-file
 */
function dbc_isotope_add_my_stylesheet() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'dbc_isotope-style', plugins_url('css/custom_isotope.css', __FILE__) );
    wp_enqueue_style( 'dbc_isotope-style' );
}

/**
 * Add Hook for Menu under Appearance
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
  $settings_link = '<a href="themes.php?page=isotope-visual-post-layouts/dbc-isotope-options.php">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'isotope_visual_post_types_settings_link' );


/**
 * Add shortcode function
 * usage example
 * [dbc_isotope posts=5] will show 5 posts
 * [dbc_isotope posts=-1] will show all posts
 * [dbc_isotope posts=-1 post_type=feedback] will show all posts from custom post type feedback
 * [dbc_isotope cats=5] will show 10 posts from category 5
 * @param posts default is 10
 * @param cats default is all
 */
add_shortcode('dbc_isotope', 'dbc_isotope_shortcode_handler');
 
function dbc_isotope_shortcode_handler($atts) {
	extract(shortcode_atts(array(
      'posts' => 10,
      'cats' => '',
      'order' => 'DESC',
      'post_type' => ''
      ), 
     $atts));
	 $ds_cats2 = $cats;
	 $ds_posttype = $post_type;
	 $ds_order = $order;
	 
	 /**
	  * isotope_vpl_option
	  * 
	  * (default value: isotope_vpl_get_global_options())
	  * 
	  * @var mixed
	  * @access public
	  */
	 $isotope_vpl_option = isotope_vpl_get_global_options();
	 $isotope_vpl_style = $isotope_vpl_option["dropdown1"];
	 $isotope_vpl_images = $isotope_vpl_option["dropdown2"];

	 ?>
	<!-- Isotope Visual Layouts Lite for WordPress by Damien http://wordpress.damien.co/isotope  -->
	<?php 
		$args = (array(
		'post_type' => $ds_posttype,
		'orderby' => 'date', 
		'order' => $ds_order, 
		'cat' => $ds_cats2, 
		'numberposts' => $posts
		));
		global $post, $blogid;
		
		$isotope_vpl_current_site ='';
		$isotope_vpl_current_site = get_current_blog_id();
		$isotope_vpl_current_site .='_isotope_query';
		
		
		// Get any existing copy of our transient data
		if ( false === ( $isotope_posts = get_transient( $isotope_vpl_current_site ) ) ) {
			// It wasn't there, so regenerate the data and save the transient
			$isotope_posts = get_posts($args);;
			set_transient( $isotope_vpl_current_site, $isotope_posts );
     }


		
	
        			
		/**
		 * depending on the option in the database to include featured images	
		 */			
		switch ($isotope_vpl_images) {
		case 'Image Only'; // try this with a photoblog or custom post type
		$isotope_vpl_return='<div id="isocontent">';			
		foreach( $isotope_posts as $post ) :	setup_postdata($post);
		$isotope_vpl_return .= '<div class="box box'.$isotope_vpl_style.'"><a href="'.get_permalink().'">'.get_the_post_thumbnail($id, 'thumbnail', array('class' => 'dsimage')).'</a></div>';
		endforeach;
		$isotope_vpl_return.='</div>';
		// return the output
		return $isotope_vpl_return;
		break;
		
		case 'Image with Text'; // the default option
		$isotope_vpl_return='<div id="isocontent">';			
		foreach( $isotope_posts as $post ) :	setup_postdata($post);
		$isotope_vpl_return .= '<div class="box box'.$isotope_vpl_style.'"><a href="'.get_permalink().'">'.get_the_post_thumbnail($id, 'thumbnail', array('class' => 'dsimage')).'<div class="ftext">'.get_the_title().'</div></a></div>';
		endforeach;
		$isotope_vpl_return.='</div>';
		// return the output
		return $isotope_vpl_return;
		break;
		
		case 'Text Only'; // No Image
		$isotope_vpl_return='<div id="isocontent">';			
		foreach( $isotope_posts as $post ) :	setup_postdata($post);
		$isotope_vpl_return .= '<div class="box box'.$isotope_vpl_style.'"><a href="'.get_permalink().'"><div class="ftext">'.get_the_title().'</a></div></div>';
		endforeach;
		$isotope_vpl_return.='</div>';
		// return the output
		return $isotope_vpl_return;
		break;
		
		}	
	}	
			
			
			
			
			

/**
 * isotope_vpl_set_style function.
 * Am I Isotope or Filtered?
 *
 * @access public
 * @return void
 */
add_action('wp_footer','isotope_vpl_set_style');

function isotope_vpl_set_style() {
$style = (get_option('damien_style'));
if	($style == "isotope"){
		include("inc/myfile.js");
		}
else {
	echo "boo-Isotope settings not saved";}
	}

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
		$new_options['dropdown1'] = "Yellow";
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
	$items = array("Red", "Green", "Blue", "Orange", "White", "Violet", "Yellow");
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