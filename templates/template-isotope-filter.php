<?php
/*
Template Name: Isotope Filter
*/
?>

<?php get_header(); ?>
	<div id="primary">
	 <div id="content" class="page col-full">
		<ul id="options">
		  <li><a href="#" data-filter="*" class="current">show all</a></li>
		  <li><a href="#" data-filter=".web" class="current">web</a></li>
		  <li><a href="#" data-filter=".mobile" class="current">mobile</a></li>
		</ul>
	<div class="clearboth"></div> 
			<div id="isocontent">
		<?php 
	
		// $query = new WP_Query( array ( 'orderby' => 'rand', 'posts_per_page' => '15' ) );
		 $query = new WP_Query( 'posts_per_page=-1' );
		// $query = new WP_Query( 'nopaging=true' );
		// $query = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => -1)); 
			while ($query->have_posts()) : $query->the_post(); ?>
			<div class="box box<?php $category = get_the_category(); echo $category[0]->cat_ID;?> <?php $category = get_the_category(); echo $category[0]->cat_name;?>">
			<p><?php $category = get_the_category(); echo $category[0]->cat_name;?></p>
			<a href="<?php the_permalink() ?>"><?php the_title(); ?></a> 
			<p><?php echo $post->ID; ?></p>
			</div><!-- .box -->
			<?php endwhile; ?>
			</div><!-- #isocontent -->
			<div class="clearboth"></div>  
  
			</div><!-- #content -->
		</div><!-- #primary -->
		


   <script type="text/javascript">
    jQuery(document).ready(function(){
      var mycontainer = jQuery('#isocontent');
      mycontainer.isotope({
      itemSelector: '.box'
      });
    
    // filter items when filter link is clicked
	jQuery('#options a').click(function(){
	  var selector = jQuery(this).attr('data-filter');
	  mycontainer.isotope({ filter: selector });
	  return false;  
	  });
	  
	});
  </script>


<?php get_footer(); ?>