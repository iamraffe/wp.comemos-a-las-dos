<?php

/**************************************
CANON SHORTCODE

[canon_royalslider foo="foo-value"]

***************************************/

	add_shortcode('canon_royalslider', 'sc_canon_royalslider');

	function sc_canon_royalslider ($atts) {

		extract( shortcode_atts( array(
			'el_class'		=> '',
		), $atts ) );

		$output = (class_exists('NewRoyalSliderMain')) ? get_new_royalslider($atts['id']) : __("<i>New RoyalSlider plugin missing!</i>", 'loc_cookbook_core_plugin');

		return $output;	 

	}

/**************************************
VISUAL COMPOSER MAP
***************************************/


	add_action('widgets_init', 'canon_royalslider_map' );

	function canon_royalslider_map () {

		if (class_exists('NewRoyalSliderMain')) {

			vc_map(array(
			   "name" 				=> __("Cookbook: New RoyalSlider", "loc_cookbook_core_plugin"),
			   "description"		=>  __("Displays a RoyalSlider", "loc_cookbook_core_plugin"),
			   "base" 				=> "canon_royalslider",
			   "class"				=> "",
			   "icon" 				=> "canon_shortcode_icon",
			   "category" 			=> __('Theme Elements', "loc_cookbook_core_plugin"),
			   "params" 			=> array(
				  array(
					 "type" 			=> "canon_royalslider_select",
					 "class" 			=> "",
					 "heading" 			=> __("RoyalSlider", "loc_cookbook_core_plugin"),
					 "param_name" 		=> "id",
					 "description" 		=> __("Select the slider to display", "loc_cookbook_core_plugin")
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

	


