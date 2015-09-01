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

add_action( 'admin_bar_init', '\impcthub\add_style_sheet_to_hide_menu_elements_for_hubmembers' );

// Hide menu elements if activated

function add_style_sheet_to_hide_menu_elements_for_hubmembers () {
  if (is_current_user_hub_member()) {
    wp_enqueue_style(
      'impact-hub-supercharger-plugin',
      plugins_url('../styles/style.css', __FILE__));
  }
}

add_filter('admin_body_class', '\impcthub\add_hub_member_class');

function add_hub_member_class($classes) {
  if (is_current_user_hub_member()) {
    $classes .= " hubmember-user-logged-in";
  }
  return $classes;
}

function is_current_user_hub_member() {
  $current_user = wp_get_current_user();
  $roles = $current_user->roles;
  return in_array("hubmember", $roles);
}

?>