<?php
/**
 * Template Name: Isotope Woo
 *
 * The archives page template displays a conprehensive archive of the current
 * content of your website on a single page. 
 *
 * @package WooFramework
 * @subpackage Template
 */
 
 get_header();
?>       
    <!-- #content Starts -->
	<?php woo_content_before(); ?>
    <div id="content" class="page col-full">

    	<div id="main-sidebar-container">    

            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <div id="main">
                        
				<?php woo_loop_before(); ?>
                <!-- Post Starts -->
                <?php woo_post_before(); ?>
                <div <?php post_class(); ?>>
                    
                    <?php woo_post_inside_before(); ?>
    
                    <h2 class="title"><?php the_title(); ?></h2>
                    
                    <div class="entry">
                    
                        <h3><?php _e( 'The Last 30 Posts', 'woothemes' ); ?></h3>                                             
                        <div  id="isocontent">											  
                            <?php $saved = $wp_query; query_posts( 'showposts=30' ); ?>		  
                            <?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>
                                <?php $wp_query->is_home = false; ?>	  
                                <div class="box box<?php $category = get_the_category(); echo $category[0]->cat_ID; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> - <?php the_time( get_option( 'date_format' ) ); ?> - <?php echo $post->comment_count; ?> <?php _e( 'comments', 'woothemes' ); ?></div>
                            <?php } } $wp_query = $saved; ?>					  
                        </div>											  
                                                                          
                        
    
                    </div><!-- /.entry -->
                                
                    <?php woo_post_inside_after(); ?>
    
                </div><!-- /.post -->                 
                <?php woo_post_after(); ?>
                    
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
    
           <!-- <?php get_sidebar(); ?> -->
    
		</div><!-- /#main-sidebar-container -->         

	<!--	<?php get_sidebar( 'alt' ); ?> -->

    </div><!-- /#content -->
    	<script type="text/javascript">
    jQuery(document).ready(function() {
      var $container = jQuery('#isocontent');
      $container.isotope({
      itemSelector: '.box'
      });
    });
  </script>
	<?php woo_content_after(); ?>
<?php get_footer(); ?>