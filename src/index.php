<?php namespace impcthub;
/*
Plugin Name: Impact Hub Supercharger
Plugin URI: http://wordpress.org/plugins/impact-hub-super-charger/
Description: This plugin adds custom posts "Entrepreneur toolbox" and "Member showroom" and a shortcode for displaying them.
Author: Thunki SA
Version: 1.6
Author URI: http://thunki.no/
*/

require_once( plugin_dir_path( __FILE__ ) .	'/includes/user-role.php' );
require_once( plugin_dir_path( __FILE__ ) .	'/includes/custom-posts.php' );
require_once( plugin_dir_path( __FILE__ ) .	'/includes/shortcode.php' );
require_once( plugin_dir_path( __FILE__ ) .	'/includes/other.php' );

register_activation_hook( __FILE__ ,
  '\impcthub\add_role_on_plugin_activation' );

register_deactivation_hook( __FILE__ ,
  '\impcthub\remove_role_on_plugin_deactivation' );

?>
