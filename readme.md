# Meta modern cleaner wordpress plugin

* Requires WP at least: 4.5
* Tested up to: 5.8.1
* Requires PHP: 5.6
* License: GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html

Simple plugin to clean meta data in Wordpress posts (and CPTs)

![Meta modern cleaner UI](/screenshot-1.png)

The plugin is intended primarily for developers and experienced users who understand what they are doing.
The plugin works in the Wordpress admin panel and allows you to select and perform bulk remove of meta fields in standard Wordpress posts as well as in custom post types through a simple and intuitive interface.

**Before any manipulations with the plugin, make sure to backup your database!**

## Installation

1. `git clone git@github.com:qzya/meta-modern-cleaner.git` in the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

## FAQ

### Is it safe?

NO! This plugin is in early beta and can permanently remove some records from your database. Do not use the plugin on prod and make sure to back up the database before any manipulations with the plugin. 
Use it at your own risk.

### How do I know if it's safe to delete this given meta field?

If you're not sure, you better not delete it. If you think a field was added by a plugin that is not used anymore or even deleted, try clicking the `search on github` link next to the field name. In most cases, a github code search will show, which plugin is using that field name.

![Meta modern cleaner guthub search](/screenshot-2.png)
