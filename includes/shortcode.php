<?php namespace impcthub;

add_shortcode( 'list-posts', '\impcthub\section_feed_shortcode' );

function section_feed_shortcode( $atts ) {
  extract( shortcode_atts( array( 'limit' => -1, 'type' => 'post'), $atts ) );

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
    . add_post_thumbnail()
    . '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>'
    . '<div class="entry-content">' . apply_filters( 'the_content', get_the_content() ) . '</div>'
    . '</div>'
    . '</article>';
  }

  return

  '<div class="listings clearfix post-type-'. $type .'">'
  . $list
  . '<br/>'
  . '<div class="nav-pagination">'
  . '<div class="nav-previous">' . get_next_posts_link( __( '<span class="meta-nav">&larr;</span> Previous' ) ) . '</div>'
  . '<div class="nav-next">' . get_previous_posts_link( __( 'Next <span class="meta-nav">&rarr;</span>' ) ) . '</div>'
  . '</div>'
  . '</div>' .
  wp_reset_query();

}

function add_post_thumbnail() {
  $thumbnail = get_the_post_thumbnail();
  if ($thumbnail) {
    return '<div class="post-thumbnail">' . get_the_post_thumbnail() . '</div>';
  }
}

?>