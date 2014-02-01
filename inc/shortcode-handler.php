<?php
/**
 * Created by IntelliJ IDEA.
 * User: damien saunders
 * Date: 01/01/2014
 * Updated: 01/02/2014
 */




/**
 * Add shortcode function
 * usage example
 * [dbc_isotope posts=5] will show 5 posts
 * [dbc_isotope posts=-1] will show all posts
 * [dbc_isotope posts=-1 post_type=feedback] will show all posts from custom post type feedback
 * [dbc_isotope cats=5] will show 10 posts from category 5
 * posts default is 10
 * cats default is all
 * @param posts
 * @param cats
 */

//lets define some variables that we are going to use
$ds_cats2 = '';
    $cats= '';
$ds_posttype = '';
$post_type='';
$ds_order = '';
    $order='';;
$ds_filtrify = '';
    $filtrify='';
$feat_title='';
$feat_image='';



add_shortcode('dbc_isotope', 'dbc_isotope_shortcode_handler');

function dbc_isotope_shortcode_handler($atts) {
    extract(shortcode_atts(array(
            'posts' => 10,
            'cats' => '',
            'order' => 'DESC',
            'post_type' => '',
            'filtrify' => 'off',
        ),
        $atts));
    $ds_cats2 = $cats;
    $ds_posttype = $post_type;
    $ds_order = $order;
    $ds_filtrify = $filtrify;

    /**
     * isotope_vpl_option
     *
     * (default value: isotope_vpl_get_global_options())
     *
     * @var mixed
     * @access public
     */
    global $damien_filtrify_placeholder;
    $isotope_vpl_option = isotope_vpl_get_global_options();
    $isotope_vpl_style = strtolower($isotope_vpl_option["dropdown1"]);
    $isotope_vpl_images = $isotope_vpl_option["dropdown2"];
    $isotope_vpl_return ='<!-- Isotope for WordPress by Damien http://wordpress.damien.co/isotope  -->'.$damien_filtrify_placeholder;
    ?>

    <?php
    $args = (array(
        'post_type' => $ds_posttype,
        'orderby' => 'date',
        'order' => $ds_order,
        'cat' => $ds_cats2,
        'posts_per_page' => $posts
    ));
    global $id, $post, $blogid;

   /**
     * adding Transient API and caching WP_query for 1 minute
     */
    $isotope_vpl_current_site ='';
    $isotope_vpl_current_site = get_current_blog_id();
    $isotope_vpl_current_site .='_isotope_query';
    if ( false === ( $isotope_posts = get_transient( $isotope_vpl_current_site ) ) ) {
        // It wasn't there, so regenerate the data and save the transient
        $isotope_posts = get_posts($args);;
        set_transient( $isotope_vpl_current_site, $isotope_posts, 60 );
    }

    $isotope_posts = new wp_query($args);

    if
    ($isotope_posts->have_posts())
        $isotope_vpl_return ='<!-- Isotope for WordPress by Damien http://wordpress.damien.co/isotope  -->'.$damien_filtrify_placeholder;
    $isotope_vpl_return .= '<ul class="isocontent metro page">';
    while
    ($isotope_posts->have_posts()) : $isotope_posts->the_post();
        //@TODO clean-up variable names to make them safe
        $meta = get_post_meta( $id, '_size', true );
        if
        ($meta != '')
        {
            $thumbv = 'tile.double-vertical';
        }
        else($thumbv ='tile.double');
        //	$cus_colour = $thumbv.' tile border-color-blue';

        $cus_colour = $thumbv.' tile bg-'.$isotope_vpl_style.' bd-'.$isotope_vpl_style.' ';
        $cat_class = implode(', ', wp_get_post_categories( get_the_ID(), array('fields' => 'names') ) );
        $tag_classes = implode(', ', wp_get_post_tags( get_the_ID(), array('fields' => 'names') ) );

        $data_attrib ='';
        $feat_excerpt = '';
        $data_attrib = 'data-pubDate="'.get_the_date('Y-m-d H:i:s').'"';
        $feat_filtrify ='';
        if
        ($ds_filtrify =='on')
        {
            $feat_filtrify ='data-tag="'.$tag_classes. '" data-category="'.$cat_class.'"';


        }

        //$meta ='thumbnail';
        switch ($isotope_vpl_images)
        {
            case 'Image Only'; // try this with a photoblog or custom post type
                $feat_excerpt ='';
                $feat_title ='';
                $feat_image = get_the_post_thumbnail($id, $thumbv);
                break;

            case 'Image with Text'; // the default option
                $feat_title = '<div class="padding5 fg-color-white">'.get_the_title().'</div>';
                $feat_image = get_the_post_thumbnail($id, $thumbv);
                $feat_excerpt;
                break;

            case 'Text Only'; // No Image
                $feat_title = '<div class="ftext">'.get_the_title().'</div>';
                $feat_image = '';
                $feat_excerpt;
                break;

        }



        //@TODO clean-up variable names to make them safe
        $isotope_vpl_return .='<li class="tile-content '. implode(' ', get_post_class($cus_colour, $post->ID)).'"';
        $isotope_vpl_return .= $feat_filtrify;
        $isotope_vpl_return .= $data_attrib;
        $isotope_vpl_return .='>';
        $isotope_vpl_return .= $feat_title;
        $isotope_vpl_return .='<a href="'.get_permalink().'">';
        $isotope_vpl_return .= '</a>';
        $isotope_vpl_return .= '<div class="tile.image">'.$feat_image.'</div>';
        $isotope_vpl_return .= $feat_excerpt;
        $isotope_vpl_return .= '</li>';

    endwhile;
    $isotope_vpl_return .='</ul>';
    wp_reset_query();
    return $isotope_vpl_return;

    $wp_query = null;
    $wp_query = $temp;


    //var_dump($isotope_posts);






}



