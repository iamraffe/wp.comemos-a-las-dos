<?php

/*
Plugin Name: Cookbook Core Plugin
Plugin URI: http://www.themecanon.com
Description: Core functionality plugin for Cookbook theme by Theme Canon.
Version: 1.1
Author: ThemeCanon
Auhtor URI: http://www.themecanon.com
*/



/**************************************
INDEX

PHP INCLUDES
WP ENQUEUE
PLUGIN LOCALIZATION INIT
ADD CUSTOM FIELDS TO USER PROFILE

***************************************/



/**************************************
PHP INCLUDES
***************************************/

	// custom post types and custom meta boxes
	include 'inc/functions/functions_cmb_pages.php';
	include 'inc/functions/functions_cmb_posts.php';

	// Visual Composer shortcodes
	add_action('plugins_loaded', 'include_canon_shortcodes' );
	function include_canon_shortcodes() { if (function_exists('vc_map')) { include 'inc/canon_shortcodes/canon_shortcodes.php'; } }




/**************************************
WP ENQUEUE
***************************************/

	//front end includes
	add_action('wp_enqueue_scripts','cookbook_core_plugin_load_to_front');
	function cookbook_core_plugin_load_to_front() {
	}

	//back end includes
	add_action('admin_enqueue_scripts', 'cookbook_core_plugin_load_to_back');  //this was changed to admin_enqueue_scripts from action hook admin_footer. Let's see if it makes a difference
	function cookbook_core_plugin_load_to_back() {

		//scripts (js)
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui', false, array(), false, false);
		wp_enqueue_script('jquery-ui-sortable', false, array(), false, true);
		wp_enqueue_script('thickbox', false, array(), false, true);					
		wp_enqueue_script('media-upload', false, array(), false, true);
		// wp_enqueue_script('canon_colorpicker', get_template_directory_uri() . '/js/colorpicker.js', array(), false, true);
		wp_enqueue_script('cookbook_core_plugin_admin_scripts', plugins_url('', __FILE__ ) . '/js/admin-scripts.js', array(), false, true);

		//style (css)	
		wp_enqueue_style('cookbook_core_plugin_admin_style', plugins_url('', __FILE__ ) . '/css/admin-style.css');

	}


/**************************************
PLUGIN LOCALIZATION INIT
***************************************/

	add_action('after_setup_theme', 'cookbook_core_plugin_localization_setup');
	function cookbook_core_plugin_localization_setup() {
	    load_plugin_textdomain('loc_cookbook_core_plugin', false,  dirname( plugin_basename( __FILE__ ) ) . '/lang/');
	}


/**************************************
ADD CUSTOM FIELDS TO USER PROFILE
***************************************/

	add_filter('user_contactmethods', 'cookbook_add_social_links_to_user_profile');

	function cookbook_add_social_links_to_user_profile ($profile_fields) {

		// Add new fields
		$profile_fields['twitter'] 		= 'Twitter URL';
		$profile_fields['facebook'] 	= 'Facebook URL';
		$profile_fields['googleplus'] 	= 'Google+ URL';
		$profile_fields['linkedin'] 	= 'LinkedIn URL';

		// Remove old fields
		// unset($profile_fields['aim']);

		return $profile_fields;
	}
