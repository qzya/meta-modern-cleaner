=== Meta modern cleaner ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: https://example.com/
Tags: meta fields, database, cleaner, development, admin
Requires at least: 4.5
Tested up to: 5.8.1
Requires PHP: 5.6
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Simple plugin for clean meta data in posts (and CPTs)

== Description ==

The plugin is aimed primarily at developers and experienced users who understand what they are doing.
The plugin works in the Wordpress admin panel and allows you to select and bulk remove meta fields in standard Wordpress posts as well as in custom post types through a simple and intuitive interface.
**Before any manipulations with the plugin, be sure to backup your database!**

== Installation ==

1. Upload `meta-modern-cleaner` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Is it safe? =

NO! This plugin is in early beta and can permanently remove some records from your database. Do not use the plugin on prod and make sure to back up the database before any manipulations with the plugin. 
Use at your own risk.

= I don't know if it's safe to delete this meta field? =

If you're not sure, it's best not to delete it. If you think a field has added by plugin you don't use anymore, try clicking on the "search on github" link next to the field name. A github code search will in most cases reveal which plugin is using that field name.

== Screenshots ==

== Changelog ==

= 0.1.0 =
* first version
