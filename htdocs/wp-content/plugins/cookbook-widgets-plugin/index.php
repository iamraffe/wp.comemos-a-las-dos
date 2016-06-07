<?php

/*
Plugin Name: Cookbook Widgets Plugin
Plugin URI: http://www.themecanon.com
Description: Custom widgets for Cookbook theme by Theme Canon.
Version: 1.3
Author: ThemeCanon
Auhtor URI: http://www.themecanon.com
*/


/**************************************
NOTES

Plugins in this widget:
- Cookbook: More Posts.
- Cookbook: Twitter.
- Cookbook: Search.

- Cookbook: More Posts.
This widget taps into the post meta: "post_views" to determine most popular posts by view. (NB: data not supplied by plugin).
This widget uses a custom field (post): "cmb_hide_from_popular". (NB: data not supplied by plugin).

***************************************/

/**************************************
INDEX

PLUGIN LOCALIZATION INIT
PHP INCLUDES
WP ENQUEUE
IMAGE SIZES
FACEBOOK LIKE BOX MECHANICS

***************************************/

/**************************************
PLUGIN LOCALIZATION INIT
***************************************/

	add_action('after_setup_theme', 'cookbook_widgets_plugin_localization_setup');
	function cookbook_widgets_plugin_localization_setup() {
	    load_plugin_textdomain('loc_cookbook_widgets_plugin', false,  dirname( plugin_basename( __FILE__ ) ) . '/lang/');
	}


/**************************************
PHP INCLUDES
***************************************/

	// include widgets
	include 'inc/widgets/widget_cookbook_more_posts.php';
	include 'inc/widgets/widget_cookbook_twitter.php';
	include 'inc/widgets/widget_cookbook_search.php';
	include 'inc/widgets/widget_cookbook_quicklinks.php';
	include 'inc/widgets/widget_cookbook_statistics.php';
	include 'inc/widgets/widget_cookbook_fact.php';
	include 'inc/widgets/widget_cookbook_quote.php';
	include 'inc/widgets/widget_cookbook_accordion.php';
	include 'inc/widgets/widget_cookbook_tabs.php';
	include 'inc/widgets/widget_cookbook_toggle.php';
	include 'inc/widgets/widget_cookbook_facebook.php';
	include 'inc/widgets/widget_cookbook_animated_number.php';
	include 'inc/widgets/widget_cookbook_social_links.php';

	// visual composer widgets
	include 'inc/widgets/widget_cookbook_vc_single_post.php';
	include 'inc/widgets/widget_cookbook_vc_posts_listed.php';
	include 'inc/widgets/widget_cookbook_vc_posts_carousel.php';
	include 'inc/widgets/widget_cookbook_vc_separator.php';

	// conditional widgets. Notice the after_setup_theme action - this to prevent the class_exists check before all plugins have been loaded. If not in place the class_exists would just be executed when this plugin loads which could be before another plugin.
	add_action('after_setup_theme', 'load_conditional_widgets');
	function load_conditional_widgets() {
		if (class_exists('Tribe__Events__Main')) { include 'inc/widgets/widget_cookbook_single_event.php'; }
	}


/**************************************
WP ENQUEUE
***************************************/

	//front end includes
	add_action('wp_enqueue_scripts','cookbook_widgets_plugin_load_to_front');
	function cookbook_widgets_plugin_load_to_front() {

		//front end scripts (js)
		wp_enqueue_script('cookbook_widgets_plugin_scripts', plugins_url('', __FILE__ ) . '/js/scripts.js', array(), false, true);
		wp_enqueue_script('cookbook_widgets_plugin_animatenumbers', plugins_url('', __FILE__ ) . '/js/jquery.animateNumbers.js', array(), false, true);

		//style (css)	
		wp_enqueue_style('cookbook_widgets_plugin_style', plugins_url('', __FILE__ ) . '/css/style.css');

	}

	//back end includes
	add_action('admin_enqueue_scripts', 'cookbook_widgets_plugin_load_to_back');  //this was changed to admin_enqueue_scripts from action hook admin_footer. Let's see if it makes a difference
	function cookbook_widgets_plugin_load_to_back() {

		//back end scripts (js)
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui', false, array(), false, false);
		wp_enqueue_script('jquery-ui-sortable', false, array(), false, true);
		wp_enqueue_script('cookbook_widgets_plugin_admin_scripts', plugins_url('', __FILE__ ) . '/js/admin-scripts.js', array(), false, true);
		wp_enqueue_script('cookbook_widgets_plugin_colorpicker', plugins_url('', __FILE__ ) . '/js/colorpicker.js', array(), false, true);


		//style (css)	
		wp_enqueue_style('cookbook_widgets_plugin_admin_style', plugins_url('', __FILE__ ) . '/css/admin-style.css');
		wp_enqueue_style('cookbook_widgets_plugin_colorpicker_style', plugins_url('', __FILE__ ) . '/css/colorpicker.css');

	}

/**************************************
IMAGE SIZES
***************************************/

	add_image_size( 'widget_more_posts_thumb', 750, 500, true);


/**************************************
FACEBOOK LIKE BOX MECHANICS
***************************************/

	add_action('wp_footer', 'add_facebook_js');  
	function add_facebook_js () {
	?>
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>	
	<?php
	}