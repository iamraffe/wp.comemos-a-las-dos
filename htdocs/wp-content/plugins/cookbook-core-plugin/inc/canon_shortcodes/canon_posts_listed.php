<?php

/**************************************
CANON SHORTCODE

[canon_post_listed foo="foo-value"]

***************************************/

	add_shortcode('canon_post_listed', 'sc_canon_post_listed');

	function sc_canon_post_listed ($atts) {

		extract( shortcode_atts( array(
			'el_class'		=> '',
		), $atts ) );

		$output = '<div class="canon_shortcode wpb_content_element '.$el_class.'">';
		$type = 'cookbook_vc_posts_listed';
		
		// usually a widget inherits the args from the sidebar they preside in but in this case there is no sidebar so we define our args. Notice that we only define the ones we need to change from default.
		$args = array(
			'before_title' 	=> '<h2 class="widget-title">',
			'after_title' 	=> '</h2>',
		);

		ob_start();
		@the_widget( $type, $atts, $args );	// @ to prevent error notice if widget does not exist
		$output .= ob_get_clean();

		$output .= "</div>";

		return $output;	 

	}

/**************************************
VISUAL COMPOSER MAP
***************************************/


	add_action('widgets_init', 'canon_post_listed_map' );

	function canon_post_listed_map () {

		if (class_exists('cookbook_vc_posts_listed')) {

			vc_map(array(
			   "name" 				=> __("Cookbook: Posts Listed", "loc_cookbook_core_plugin"),
			   "description"		=>  __("Displays a list of posts", "loc_cookbook_core_plugin"),
			   "base" 				=> "canon_post_listed",
			   "class"				=> "",
			   "icon" 				=> "canon_shortcode_icon",
			   "category" 			=> __('Theme Elements', "loc_cookbook_core_plugin"),
			   // 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
			   // 'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
			   "params" 			=> array(
				  array(
					'type'				=> 'textfield',
					'heading' 			=> __( 'Wiget Title', 'loc_cookbook_core_plugin' ),
					'param_name' 		=> 'title',
					// 'value'				=> __( 'Latest Posts', 'loc_cookbook_core_plugin' ),
					'description' 		=> __( 'The widget title (can be empty for no widget title)', 'loc_cookbook_core_plugin' )
				  ),
				  array(
					 "type" 			=> "canon_show_select",
					 "class" 			=> "",
					 "heading" 			=> __("Get posts from", "loc_cookbook_core_plugin"),
					 "param_name" 		=> "show",
					 "value" 			=> "latest_posts",
					 "description" 		=> __("Select what group of posts to pull from.", "loc_cookbook_core_plugin"),
					 "exclude"			=> array("random_posts"),
				  ),
				  array(
					 "type" 			=> "canon_number",
					 "class" 			=> "",
					 "heading" 			=> __("Begin at post number", "loc_cookbook_core_plugin"),
					 "param_name" 		=> "offset",
					 "min"				=> 1,
					 "value" 			=> 1,
					 "description" 		=> __("Select what post to show from the selected group.", "loc_cookbook_core_plugin")
				  ),
				  array(
					 "type" 			=> "canon_number",
					 "class" 			=> "",
					 "heading" 			=> __("Number of posts to show", "loc_cookbook_core_plugin"),
					 "param_name" 		=> "num_posts_show",
					 "min"				=> 1,
					 "value" 			=> 4,
					 "description" 		=> __("How many posts to show in the carousel.", "loc_cookbook_core_plugin")
				  ),
				  array(
					'type'				=> 'dropdown',
					'heading' 			=> __( 'Meta', 'loc_cookbook_core_plugin' ),
					'param_name' 		=> 'meta',
					'value'				=> array(
						__( 'Publish date', 'loc_cookbook_core_plugin' )	=> 'date',
						__ ( 'Categories', 'loc_cookbook_core_plugin' )	=> 'categories',
					),
					'description' 		=> __( 'Separator style.', 'loc_cookbook_core_plugin' )
				  ),
				  array(
					  'type' => 'checkbox',
					  'param_name' => 'hide_rating',
					  'value' => array( __( 'Hide rating', 'loc_cookbook_core_plugin' ) => 'checked' ),
				  ),
			   )
			));

		}
	}

	


