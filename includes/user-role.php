<?php namespace impcthub;

register_activation_hook( plugin_dir_path( __FILE__ ) . '/../index.php',
  '\impcthub\add_role_on_plugin_activation' );

function add_role_on_plugin_activation() {

  remove_role( 'hubmember' );

  add_role( 'hubmember', 'Hub member',
    array(
      'read' => true,
      'read_private_posts' => true,
      'edit_posts' => true,
      'edit_private_posts' => true,
      'edit_published_posts' => true,
      'publish_posts' => true,
      'delete_posts' => true,
      'upload_files' => true
      ) );
}

register_deactivation_hook( plugin_dir_path( __FILE__ ) . '/../index.php',
  '\impcthub\remove_role_on_plugin_deactivation' );

function remove_role_on_plugin_deactivation() {
  remove_role( 'hubmember' );
}

// Hide menu elements if activated
function hide_menu_elements_for_hubmembers () {
  $current_user = get_currentuserinfo();
  if ( !($current_user instanceof WP_User) )
     return;
  $roles = $current_user->roles;

  echo $roles;

}

?>