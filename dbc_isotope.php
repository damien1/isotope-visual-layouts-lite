<?php
/*
Plugin Name: Isotope Visual Post Layouts
Plugin URI: http://wordpress.damien.co/isotope?utm_source=WordPress&utm_medium=isotope&utm_campaign=WordPress-Plugin
Description: Add visual effects to your list of posts & custom post types using Isotope. Needs a responsive theme   
Version: 0.2
Author: Damien Saunders
Author URI: http://damien.co/?utm_source=WordPress&utm_medium=isotope&utm_campaign=WordPress-Plugin
License: This plugin GPLv3 - changes to the HTML / CSS do require a licence.
*/

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


/**
 * Add shortcode function
 * usage example
 * [dbc_isotope posts=5] will show 5 posts
 * [dbc_isotope posts=-1] will show all posts
 * [dbc_isotope posts=-1 post_type=feedback] will show all posts from custom post type feedback
 * @param posts default is 10
 * @param cat default is all
 */
add_shortcode('dbc_isotope', 'dbc_isotope_shortcode_handler');
 
function dbc_isotope_shortcode_handler($atts) {
	extract(shortcode_atts(array(
      'posts' => 10,
      'cats' => '',
      'post_type' => ''
      ), 
      $atts));
	 $ds_cats2 = $cats;
	 $ds_posttype = $post_type;
	 include("inc/myfile.php"); 
	?>
	<div class="clearboth"></div>
	<!-- Isotope for WordPress by Damien http://wordpress.damien.co/isotope  -->
	<div id="isocontent" class="isotope">
	<?php 
			
		$query = new WP_Query(array(
		'post_type' => $ds_posttype,
		'orderby' => 'date', 
		'order' => 'ASC' , 
		'cat' => $ds_cats2, 
		'posts_per_page' => $posts
		));
		$return = '';			
		while ($query->have_posts()) : $query->the_post(); 
			$category = get_the_category(); 
				$return .= '<div class="box box' . $category[0]->cat_ID . '"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div>';
		endwhile;
		// return the output
		return $return;?>
	</div> <!-- #isocontent -->
	<?php 
	
			}

?>