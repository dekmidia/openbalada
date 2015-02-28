=== Betta Boxes CMS ===
Contributors: shauno
Donate link: http://shauno.co.za/donate/
Tags: custom, fields, custom fields, meta, boxes, meta boxes, gui, ui, ux
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 1.1.5

Create custom fields linked to posts, pages, or any custom post type with a point-and-click user interface.

== Description ==

Welcome to the Betta Boxes CMS plugin. This plugin turns your WordPress Blog into a powerful CMS, without the need to get down and dirty in the source code.
Betta Boxes gives you a clean, simple administration user interface to create custom fields, and link them to Posts, Pages, and any Custom Post Types you have!

Betta Boxes uses the default WordPress functionality of 'post meta'. This means the plugin works with WordPress, rather than fighting against it.

You can create the following types of custom fields, and link them to any post types:

= Field Types =

* Short Text
* Long Text
* HTML Text
* Drop Down
* Check Boxes
* Radio Buttons
* Color Picker
* Date Picker
* Time Picker

== Installation ==

This section describes how to install the plugin and get it working.

1. Unzip the plugin to your `wp-content/plugins/` directory.
1. Activate the plugin through the WordPress 'Plugins' menu in the administration area.
1. This will create a new menu item under 'settings' in the WordPress administration area, labeled *Betta Boxes*.
	
== Frequently Asked Questions ==

See the /docs/ folder for a run through on how to use the plugin. Better FAQ coming soon.
You can also post of the forum, using the tag 'betta-boxes-cms'. I hang around there from time to time, so I should see it pretty soon.

== Screenshots ==

1. Screenshot Admin Menu
2. Screenshot Meta Boxes Listing
3. Screenshot Add / Edit Meta Boxes. Managing Custom Fields
4. Screenshot Custom Field Types
5. Screenshot Deleting Custom Field
6. Screenshot Deleting Meta Box

== Changelog ==

= 1.1.5 =
* Changed the way the admin URL is defined, improving compatibility with installs moved into sub directories.

= 1.1.4 =
* Changed some database character encodings, for better UTF-8 compatibility (thanks to jamesblackvn for reporting the issue).

= 1.1.3 =
* Fixed issue where in rare situations an `Illegal string offset` was being thrown (thanks to gothbarbie for reporting and testing solution).

= 1.1.2 =
* Fixed time values saving as integers (eg: 02:00:00 would save and display as 2:0:0)

= 1.1.1 =
* Added label for wp_editor() field on add/edit screen.

= 1.1 =
* Added support for WordPress' new wp_editor() API in the HTML Text (WYSIWYG) custom field type.

= 1.0.2 =
* Fixed bug with jQuery 1.7 deprecating a method the plugin was using.

= 1.0.1 =
* Fixed "cannot unset string offsets" error.

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.1.5 =
Minor bug fix for installs moved into sub directories.

= 1.1.4 =
Minor bug fix that adds better support for UTF-8 encodings.

= 1.1.3 =
Minor bug fix stopping rare `Illegal string offset` warning when saving post types.

= 1.0.2 =
Fixed bug with jQuery 1.7 deprecating a method the plugin was using.

= 1.0 =
Initial release.