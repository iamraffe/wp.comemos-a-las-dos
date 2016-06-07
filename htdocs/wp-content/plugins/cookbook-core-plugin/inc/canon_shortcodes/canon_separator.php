<?php

/**************************************
CANON SHORTCODE

[canon_separator foo="foo-value"]

***************************************/

	add_shortcode('canon_separator', 'sc_canon_separator');

	function sc_canon_separator ($atts) {

		extract( shortcode_atts( array(
			'el_class'		=> '',
		), $atts ) );

		$output = '<div class="canon_shortcode wpb_content_element '.$el_class.'">';
		$type = 'cookbook_vc_separator';
		
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


	add_action('widgets_init', 'canon_separator_map' );

	function canon_separator_map () {

		if (class_exists('cookbook_vc_separator')) {

			vc_map(array(
			   "name" 				=> __("Cookbook: Separator", "loc_cookbook_core_plugin"),
			   "description"		=>  __("Displays a text separator", "loc_cookbook_core_plugin"),
			   "base" 				=> "canon_separator",
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
					'value'				=> __( 'Latest Posts', 'loc_cookbook_core_plugin' ),
					'description' 		=> __( 'The separator title.', 'loc_cookbook_core_plugin' )
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
				  array(
					'type'				=> 'textfield',
					'heading' 			=> __( 'Link text', 'loc_cookbook_core_plugin' ),
					'param_name' 		=> 'link_text',
					// 'value'				=> __( 'Latest Posts', 'loc_cookbook_core_plugin' ),
					'description' 		=> __( 'Link text (leave blank for no link.)', 'loc_cookbook_core_plugin' )
				  ),
				  array(
					'type'				=> 'textfield',
					'heading' 			=> __( 'Link', 'loc_cookbook_core_plugin' ),
					'param_name' 		=> 'link',
					// 'value'				=> __( 'Latest Posts', 'loc_cookbook_core_plugin' ),
					'description' 		=> __( 'The URL.', 'loc_cookbook_core_plugin' )
				  ),
			      array(
			        'type' => 'textfield',
			        'heading' => __( 'Extra class name', 'loc_cookbook_core_plugin' ),
			        'param_name' => 'el_class',
			        'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'loc_cookbook_core_plugin' )
			      ),
			   )
			));

		}
	}

	


