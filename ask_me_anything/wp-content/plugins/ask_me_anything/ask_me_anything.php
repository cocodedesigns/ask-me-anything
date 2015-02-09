<?php
/**
 * Plugin Name: Ask Me Anything
 * Plugin URI: https://github.com/mattkaye/ask-me-anything
 * Description: Allows site users to directly ask a questions to the site owner. Highly configurable form fields and colors. Questions can be answered either privately though email or in a Q&A style directly on the site.
 * Version: 1.0
 * Author: Matt Kaye
 * Author URI: http://netcandy.co
 * License: Do what you want :)
 */

//Include files
include_once(plugin_dir_path(__FILE__) . 'includes/widgets.php');
include_once(plugin_dir_path(__FILE__) . 'includes/nav.php');
include_once(plugin_dir_path(__FILE__) . 'includes/actions.php');
include_once(plugin_dir_path(__FILE__) . 'includes/filters.php');
include_once(plugin_dir_path(__FILE__) . 'includes/functions.php');
include_once(plugin_dir_path(__FILE__) . 'includes/shortcodes.php');
include_once(plugin_dir_path(__FILE__) . 'includes/custom_post_types.php');
include_once(plugin_dir_path(__FILE__) . 'ajax/functions.php');
include_once(plugin_dir_path(__FILE__) . 'classes/Ama_WPAlchemy_MetaBox.class.php');
include_once(plugin_dir_path(__FILE__) . 'classes/Filecache.class.php');
include_once(plugin_dir_path(__FILE__) . 'classes/AmaStyle.class.php');
include_once(plugin_dir_path(__FILE__) . 'classes/AmaForm.class.php');
include_once(plugin_dir_path(__FILE__) . 'metaboxes/form_specs.php');

if (class_exists('Mustache_Engine') === false) {
	include_once(plugin_dir_path(__FILE__) . 'classes/Mustache/Autoloader.php');
	Mustache_Autoloader::register();
}
?>