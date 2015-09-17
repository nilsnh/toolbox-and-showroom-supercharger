<?php namespace impcthub;

register_activation_hook( plugin_dir_path( __FILE__ ) . '/../index.php',
  '\impcthub\add_role_on_plugin_activation' );

function add_role_on_plugin_activation() {

  $role = get_role_name();

  remove_role( $role );

  add_role( $role , 'Hub member',
    array(
      'read' => true,
      'read_private_posts' => true,
      'edit_posts' => true,
      'edit_private_posts' => true,
      'edit_published_posts' => true,
      'delete_posts' => true,
      'upload_files' => true
      ) );
}

register_deactivation_hook( plugin_dir_path( __FILE__ ) . '/../index.php',
  '\impcthub\remove_role_on_plugin_deactivation' );

function remove_role_on_plugin_deactivation() {
  remove_role( get_role_name() );
}

function get_role_name() {
  return "hubmember";
}

/* Add logged in user role to admin body as class so that we
can style by it later.
*/
add_filter('admin_body_class', '\impcthub\add_user_role_to_classes');

function add_user_role_to_classes($classes) {
  foreach (get_current_user_roles() as $role)
    $classes .= 'current-user-role-' . $role;
  return $classes;
}

function get_current_user_roles() {
  $current_user = wp_get_current_user();
  return $current_user->roles;
}

?>