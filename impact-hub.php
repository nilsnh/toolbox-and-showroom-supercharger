<?php namespace impcthub;
/**
 * @package Impact_Hub
 * @version 1.0
 */
/*
Plugin Name: Impact Hub Supercharger
Plugin URI: http://wordpress.org/plugins/impact-hub-super-charger/
Description: This plugin adds custom posts 'Resources' and 'Member' and shortcode for displaying them.
Author: Thunki SA
Version: 1.0
Author URI: http://nilsnh.no/
*/

add_action( 'init', '\impcthub\create_resource_post_type' );
function create_resource_post_type() {
	register_post_type( 'impcthub-resource',
		array(
			'labels' => array(
				'name' => __( 'Resources' ),
				'singular_name' => __( 'Resource' )
				),
			'public' => true,
			'has_archive' => true,
			'taxonomies' => array('category')
			)
		);
}

add_action( 'init', '\impcthub\create_member_profile_post_type' );
function create_member_profile_post_type() {
	register_post_type( 'impcthub-member',
		array(
			'labels' => array(
				'name' => __( 'Member profiles' ),
				'singular_name' => __( 'Member profile' )
				),
			'public' => true,
			'has_archive' => true,
			'taxonomies' => array('category')
			)
		);
}

// Code for automatically making a post type private
// source: http://wordpress.stackexchange.com/a/118976
add_action( 'post_submitbox_misc_actions' , '\impcthub\change_visibility_metabox_value' );
function change_visibility_metabox_value(){
	global $post;
	if ($post->post_type != 'impcthub-resource') return;
	$post->post_password = '';
	$visibility = 'private';
	$visibility_trans = __('Private');
	?>
	<script type="text/javascript">
		(function($){
			try {
				$('#post-visibility-display').text('<?php echo $visibility_trans; ?>');
				$('#hidden-post-visibility').val('<?php echo $visibility; ?>');
				$('#visibility-radio-<?php echo $visibility; ?>').attr('checked', true);
			} catch(err){}
		}) (jQuery);
	</script>
	<?php
}

// Remove prefix 'protected' and 'private' prefixes from posts
add_filter('the_title', '\impcthub\the_title_trim');
function the_title_trim($title) {
	$title = esc_attr($title);
	$findthese = array(
		'#Protected:#', // # is just the delimeter
		'#Private:#',
		'#Privat:#',
		);
	$replacewith = array(
		'', // What to replace protected with
		'', // What to replace private with
		''
		);
	$title = preg_replace($findthese, $replacewith, $title);
	return $title;
}

add_shortcode( 'list-posts', '\impcthub\section_feed_shortcode' );
function section_feed_shortcode( $atts ) {
	extract( shortcode_atts( array( 'limit' => -1, 'type' => 'post'), $atts ) );

	if ($type == 'impcthub-resource' && !is_user_logged_in() ) {
		return '';
	}

	$paged = get_query_var('paged') ? get_query_var('paged') : 1;

	query_posts(  array (
		'posts_per_page' => $limit,
		'post_type' => $type,
		'order' => 'ASC',
		'orderby' =>'menu_order',
		'paged' => $paged ) );

	$list = ' ';

	while ( have_posts() ) {
		the_post();
		$list .= '<article class="listing-view post-type-'. $type .' clearfix">'
		. '<div class="listing-content">'
		. '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>'
		. '<div class="entry-content">' . apply_filters( 'the_content', get_the_content() ) . '</div>'
		. '</div>'
		. '</article>';
	}

	return

	'<div class="listings clearfix post-type-'. $type .'">'
	. $list
	. '<br/>'
	.	'<div class="nav-pagination">'
	. '<div class="nav-previous">' . get_next_posts_link( __( '<span class="meta-nav">&larr;</span> Eldre ressurser' ) ) . '</div>'
	. '<div class="nav-next">' . get_previous_posts_link( __( 'Nyere ressurser <span class="meta-nav">&rarr;</span>' ) ) . '</div>'
	. '</div>'
	. '</div>' .
	wp_reset_query();

}

?>
