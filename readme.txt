=== Toolbox and Showroom Supercharger ===
Contributors: nilsnh
Tags: impacthub
Requires at least: 3.1
Tested up to: 4.3
Stable tag: 1.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin adds custom posts "Entrepreneur toolbox" and "Member showroom" and a shortcode for displaying them.

== Description ==

This plugin was tailored for the Impact Hub Bergen site. And it might be useful for other sites that are looking to implement similar functionality.

Please note: This plugin is by no means officially supported by the Impact Hub company.

What the plugin does:

1. Adds the custom posts "Entrepreneur toolbox" and "Member showroom".
1. Make Entrepreneur toolbox be published as private by default.
1. Trim away the word "Private:" from private posts.
1. Enable custom shortcode for listing out custom posts. It includes pagination and support for displaying featured image.
1. Adds a custom hubmember role.
1. Add logged-in user role to the body class declaration. So that one might add styles to customize the admin view based on the logged in user's role.

Shortcode example usage:

* `[list-posts limit=3 type="impcthub-resource"]` Lists out Entrepreneur resource posts with max three posts on each page with "previous" and "next" links for pagination.
* `[list-posts limit=-1 type="impcthub-member"]` Lists out all Member showcase posts without pagination.

== Installation ==

This section describes how to install the plugin and get it working.

1. Find this plugin through the plugin browser accessible through plugins -> add new. And then select install plugin.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Aaand you should be good to go. :)

== Frequently Asked Questions ==

= How to ask a question? =

For questions, comments and concerns you might tweet me at @thunki or find me at https://twitter.com/thunki.

== Screenshots ==

None yet.

== Changelog ==

= 1.6 =
* Remove old custom role on plugin activation.

= 1.5 =
* Bugfix for the bugfix: Replace old role with a fresh one.

= 1.4 =
* Bugfix: Show Hubmember users in the author list when changing post author.

= 1.3 =
* Enabled author setting for the custom post type Member showcase.

= 1.2 =
* Revert previous change: "Turned off url rewrite for both custom post types."

= 1.1 =
* Enabled featured image for resource.
* Turned off url rewrite for both custom post types.

= 1.0 =
* Initial release.

== Upgrade Notice ==

None yet.
