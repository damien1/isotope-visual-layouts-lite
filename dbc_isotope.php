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

//hooks to add custom stylesheet
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
function dbc_isotope() 
{
	if(function_exists('add_menu_page')) 
	{
		add_theme_page('Isotope', 'Isotope', 'manage_options', dirname(__FILE__).'/dbc-isotope-options.php');
	}
}


// Add shortcode function
add_shortcode('dbc_isotope', 'dbc_isotope_shortcode_handler');
 
function dbc_isotope_shortcode_handler($atts) {
	global $add_my_script;
 
	$add_my_script = true; ?>
	<!-- #isotope for WordPress by Damien  -->
	<div id="isocontent">
	<?php 
		$query = new WP_Query( 'posts_per_page=-1' );
			while ($query->have_posts()) : $query->the_post(); ?>
			<div class="box box<?php $category = get_the_category(); echo $category[0]->cat_ID; ?>">
			<p><?php $category = get_the_category(); echo $category[0]->cat_name;?></p>
			<a href="<?php the_permalink() ?>"><?php the_title(); ?></a> 
			<p><?php echo $post->ID; ?></p>
			</div><!-- .box -->
			<?php endwhile; ?>
			</div><!-- #isocontent -->
			
	<script type="text/javascript">
	jQuery(document).ready(function() {
    var mycontainer = jQuery('#isocontent');
      mycontainer.isotope({
      itemSelector: '.box'
      });
    });
   </script>
<?php   		
}


//RSS feed
function dbc_isotope_rss_display()
{
$dbc_feed = 'http://damien.co/feed';

echo '<div class="rss-widget">';

wp_widget_rss_output( array(
	'url' => $dbc_feed,
	'title' => 'RSS Feed',
	'items' => 3,
	'show summary' => 1,
	'show_author' => 0,
	'show date' => 0,
	));
echo '</div>';
}

?>