<?php
/*
Template Name: Isotope15
*/
?>

<?php wp_enqueue_script("jquery"); ?>

<?php get_header(); ?>

		<div id="primary">
		<div id="isocontent">
		
		
		<?php 
		$query = new WP_Query( array ( 'orderby' => 'rand', 'posts_per_page' => '15' ) );
		// $query = new WP_Query( 'posts_per_page=50' );
		// $query = new WP_Query( 'posts_per_page=-1' );
		// $query = new WP_Query( 'nopaging=true' );
				while ($query->have_posts()) : $query->the_post(); ?>
			<div class="box box<?php $category = get_the_category(); echo $category[0]->cat_ID; ?>">
			<p><?php $category = get_the_category(); echo $category[0]->cat_name;?></p>
			<a href="<?php the_permalink() ?>"><?php the_title(); ?></a> 
			<p><?php echo $post->ID; ?></p>
			

			</div><!-- .box -->
			
			<?php endwhile; ?>
			</div><!-- #isocontent -->
			
			
		</div><!-- #primary -->



  <script type="text/javascript">
    $(function(){

      var $container = $('#isocontent');

      $container.isotope({
        itemSelector: '.post-box'
      });

    });
  </script>


<?php get_footer(); ?>