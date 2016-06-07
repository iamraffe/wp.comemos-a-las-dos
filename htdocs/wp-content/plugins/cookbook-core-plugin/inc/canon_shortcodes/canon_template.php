<?php

/**************************************
CANON SHORTCODE

CHANGE:
CANON_TEMPLATE
WIDGET_HANDLE		(e.g. cookbook_main_posts_tiled)
VC_NAME
VC_DESCRIPTION

[CANON_TEMPLATE foo="foo-value"]

***************************************/

	add_shortcode('CANON_TEMPLATE', 'sc_CANON_TEMPLATE');

	function sc_CANON_TEMPLATE ($atts) {

		extract( shortcode_atts( array(
			'el_class'		=> '',
		), $atts ) );

		$output = '<div class="canon_shortcode wpb_content_element '.$el_class.'">';
		$type = 'WIDGET_HANDLE';
		
		// usually a widget inherits the args from the sidebar they preside in but in this case there is no sidebar so we define our args. Notice that we only define the ones we need to change from default.
		$args = array(
			'before_title' 	=> '<h1 class="widget-title">',
			'after_title' 	=> '</h1>',
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


	add_action('widgets_init', 'CANON_TEMPLATE_map' );

	function CANON_TEMPLATE_map () {

		if (class_exists('WIDGET_HANDLE')) {

			vc_map(array(
			   "name" 				=> __("VC_NAME", "loc_cookbook_core_plugin"),
			   "description"		=>  __("VC_DESCRIPTION", "loc_cookbook_core_plugin"),
			   "base" 				=> "CANON_TEMPLATE",
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
					 "heading" 			=> __("Show", "loc_cookbook_core_plugin"),
					 "param_name" 		=> "show",
					 "value" 			=> "latest_posts",
					 "description" 		=> __("Select what posts to show.", "loc_cookbook_core_plugin")
				  ),
				  array(
					 "type" 			=> "canon_number",
					 "class" 			=> "",
					 "heading" 			=> __("Number of posts", "loc_cookbook_core_plugin"),
					 "param_name" 		=> "num_posts",
					 "min"				=> 1,
					 "value" 			=> 4,
					 "description" 		=> __("Number of posts to display", "loc_cookbook_core_plugin")
				  ),
				  array(
					 "type" 			=> "canon_number",
					 "class" 			=> "",
					 "heading" 			=> __("Excerpt length", "loc_cookbook_core_plugin"),
					 "param_name" 		=> "excerpt_length",
					 "min"				=> 1,
					 "value" 			=> 250,
					 "description" 		=> __("Length of excerpt.", "loc_cookbook_core_plugin")
				  ),
				  array(
					  'type' => 'checkbox',
					  'param_name' => 'hide_featured_media',
					  'value' => array( __( 'Hide featured media', 'loc_cookbook_core_plugin' ) => 'checked' ),
				  ),
				  array(
					  'type' => 'checkbox',
					  'param_name' => 'hide_meta',
					  'value' => array( __( 'Hide meta info box', 'loc_cookbook_core_plugin' ) => 'checked' ),
				  ),
			      array(
			        'type' => 'textfield',
			        'heading' => __( 'Extra class name', 'loc_cookbook_core_plugin' ),
			        'param_name' => 'el_class',
			        'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'loc_cookbook_core_plugin' )
			      ),
				  array(
					'type'				=> 'dropdown',
					'heading' 			=> __( 'Style', 'loc_cookbook_core_plugin' ),
					'param_name' 		=> 'style',
					'value'				=> array(
						__( 'Line', 'loc_cookbook_core_plugin' )	=> 'line_style',
						__ ( 'Bar', 'loc_cookbook_core_plugin' )	=> 'bar_style',
					),
					'description' 		=> __( 'Separator style.', 'loc_cookbook_core_plugin' )
				  ),
			   )
			));

		}
	}

	


