<?php
/**
 * @package Impact_Hub
 * @version 1.0
 */
/*
Plugin Name: Impact Hub Supercharger
Plugin URI: http://wordpress.org/plugins/impact-hub-super-charger/
Description: This plugin is mean to add special functionality to the Impact Hub Bergen site.
Author: Thunki SA
Version: 1.0
Author URI: http://nilsnh.no/
*/

add_action( 'init', 'create_resource_post_type' );

function create_resource_post_type() {
	register_post_type( 'resource',
		array(
			'labels' => array(
				'name' => __( 'Resources' ),
				'singular_name' => __( 'Resource' )
				),
			'public' => true,
			'has_archive' => true,
			'taxonomies' => array('category'),
			)
		);
}

// source: http://wordpress.stackexchange.com/a/118976
add_action( 'post_submitbox_misc_actions' , 'wpse118970_change_visibility_metabox_value' );
function wpse118970_change_visibility_metabox_value(){
	global $post;
	if ($post->post_type != 'resource') return;
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

// create shortcode to list all clothes which come in blue
add_shortcode( 'list-resources', 'rmcc_post_listing_shortcode1' );
function rmcc_post_listing_shortcode1( $atts ) {
	ob_start();
	$query = new WP_Query( array(
		'post_type' => 'resource',
		'color' => 'blue',
		'posts_per_page' => -1,
		'order' => 'ASC',
		'orderby' => 'title',
		) );
		if ( $query->have_posts() ) { ?>
		<ul class="resources-listing">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</li>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</ul>
		<?php $myvariable = ob_get_clean();
		return $myvariable;
	}
}

// Remove prefix 'protected' and 'private' prefixes from posts
function the_title_trim($title) {
	// Might aswell make use of this function to escape attributes
	$title = esc_attr($title);
	// What to find in the title
	$findthese = array(
		'#Protected:#', // # is just the delimeter
		'#Private:#'
		);
	// What to replace it with
	$replacewith = array(
		'', // What to replace protected with
		'' // What to replace private with
		);
	// Items replace by array key
	$title = preg_replace($findthese, $replacewith, $title);
	return $title;
}
add_filter('the_title', 'the_title_trim');

function section_feed_shortcode( $atts ) {
	extract( shortcode_atts( array( 'limit' => -1, 'type' => 'post'), $atts ) );

	if ( !is_user_logged_in() ) {
		return '<p>' . __('Du må være innlogget for å kunne lese medlemsressursene.)') . '</p>';
	}

	$paged = get_query_var('paged') ? get_query_var('paged') : 1;

	query_posts(  array (
		'posts_per_page' => $limit,
		'post_type' => $type,
		'order' => 'ASC',
		'orderby' =>'menu_order',
		'paged' => $paged ) );

	$list = ' ';

	while ( have_posts() ) { the_post();

		$list .= '<article class="listing-view clearfix">'
		. '<div class="listing-content">'
		. '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>'
		.'<p>' . get_the_excerpt() . '</p>'
		. '<a href="' . get_permalink() . '">' . 'View &raquo;' . '</a>'
		. '</div>'
		. '</article>';
	}

	return

	'<div class="listings clearfix">'
	. $list
	. '<br/>'
	.	'<div class="nav-pagination">'
	. '<div class="nav-previous">' . get_next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts' ) ) . '</div>'
	. '<div class="nav-next">' . get_previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>' ) ) . '</div>'
	. '</div>'
	. '</div>' .
	wp_reset_query();

}
add_shortcode( 'list-posts', 'section_feed_shortcode' );

?>
