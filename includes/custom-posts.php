<?php namespace impcthub;

add_action( 'init', '\impcthub\create_resource_post_type' );
function create_resource_post_type() {
  register_post_type( 'impcthub-resource',
    array(
      'labels' => array(
        'name' => __( 'Entrepreneur resources' ),
        'singular_name' => __( 'Resource' )
        ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => __('toolbox')),
      'taxonomies' => array('category'),
      'supports' => array(
        'title',
        'editor',
        'author',
        'comments',
        'revisions',
        'excerpt'
        )
      )
    );
}

add_action( 'init', '\impcthub\create_member_profile_post_type' );
function create_member_profile_post_type() {
  register_post_type( 'impcthub-member',
    array(
      'labels' => array(
        'name' => __( 'Member showcases' ),
        'singular_name' => __( 'Member showcase' )
        ),
      'public' => true,
      'has_archive' => true,
      'taxonomies' => array('category'),
      'rewrite' => array('slug' => __('hubmembers')),
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'revisions',
        'excerpt'
        )
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

?>