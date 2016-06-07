<?php

/****************************************************
INDEX

CANON SHORTCODES
CUSTOM ATTRIBUTE: CANON_SHOW_SELECT
CUSTOM ATTRIBUTE: CANON_NUMBER
CUSTOM ATTRIBUTE: CANON_SINGLE_POST_SELECT
CUSTOM ATTRIBUTE: CANON_ROYALSLIDER_SELECT

****************************************************/



/****************************************************
CANON SHORTCODES
****************************************************/

	include 'canon_single_post.php';
	include 'canon_posts_carousel.php';
	include 'canon_posts_listed.php';
	include 'canon_separator.php';
	include 'canon_royalslider.php';

/****************************************************
CUSTOM ATTRIBUTE: CANON_SHOW_SELECT
****************************************************/

	add_shortcode_param('canon_show_select', 'canon_show_select_callback');

	function canon_show_select_callback ($settings, $value) {

		$dependency = vc_generate_dependencies_attributes($settings);
		$output = "";
		$param_name = $settings['param_name'];
		$exclude_array = $settings['exclude'];
		$class = "wpb_vc_param_value wpb-textinput " . $settings['param_name'] . " " . $settings['type'] . "_field";

		// before
		$output .= "<div class='canon_show_select'><select name='$param_name' class='$class' $dependency>";

		// static options
		if (!in_array("lastest_posts", $exclude_array)) { $output .= "<option value='latest_posts' "; if ($value == "latest_posts") { $output .= "selected='selected'"; } $output .= ">" . __("Latest posts", "loc_cookbook_core_plugin") . "</option>"; }
		if (!in_array("random_posts", $exclude_array)) { $output .= "<option value='random_posts' "; if ($value == "random_posts") { $output .= "selected='selected'"; } $output .= ">" . __("Random posts", "loc_cookbook_core_plugin") . "</option>"; }
		if (!in_array("popular_views", $exclude_array)) { $output .= "<option value='popular_views' "; if ($value == "popular_views") { $output .= "selected='selected'"; } $output .= ">" . __("Popular by views", "loc_cookbook_core_plugin") . "</option>"; }
		if (!in_array("popular_comments", $exclude_array)) { $output .= "<option value='popular_comments' "; if ($value == "popular_comments") { $output .= "selected='selected'"; } $output .= ">" . __("Popular by comments", "loc_cookbook_core_plugin") . "</option>"; }

		if (!in_array("categories", $exclude_array)) {
			$output .= "<option value=''><hr></option>";
			
			// categories
			$categories = get_categories(array(
				'orderby' => 'name',
				'order' => 'ASC'
			));

			foreach ($categories as $single_category) {
				$output .= "<option value='postcat_$single_category->slug' "; if ($value == "postcat_" . $single_category->slug) { $output .= "selected='selected'"; } $output .= ">" . $single_category->name . " category</option>";
			}
		}

		// after
		$output .= "</select></div>";
	   

		return $output;

	}

/****************************************************
CUSTOM ATTRIBUTE: CANON_NUMBER
****************************************************/

	add_shortcode_param('canon_number', 'canon_number_callback');

	function canon_number_callback ($settings, $value) {

		$dependency = vc_generate_dependencies_attributes($settings);
		$output = "";
		$param_name = $settings['param_name'];
		$min = (isset($settings['min'])) ? $settings['min'] : 0;
		$max = (isset($settings['max'])) ? $settings['max'] : 1000000;
		$step = (isset($settings['step'])) ? $settings['step'] : 1;

		$class = "wpb_vc_param_value wpb-textinput " . $settings['param_name'] . " " . $settings['type'] . "_field";

		// before
		$output .= "<div class='canon_number'>";

		$output .= "<input type='number' name='$param_name' min='$min' max='$max' step='$step' value='$value' class='$class' $dependency>";

		// after
		$output .= "</div>";
	   

		return $output;

	}

/****************************************************
CUSTOM ATTRIBUTE: CANON_SINGLE_POST_SELECT
****************************************************/

	add_shortcode_param('canon_single_post_select', 'canon_single_post_select_callback');

	function canon_single_post_select_callback ($settings, $value) {

		$dependency = vc_generate_dependencies_attributes($settings);
		$output = "";
		$param_name = $settings['param_name'];
		$class = "wpb_vc_param_value wpb-textinput " . $settings['param_name'] . " " . $settings['type'] . "_field";

		// before
		$output .= "<div class='canon_single_post_select'><select name='$param_name' class='$class' $dependency>";

		// posts
		$query_args = array();
		$query_args = array_merge($query_args, array(
			'post_type'    		=> 'post',
			'numberposts' 		=> -1,
			'post_status'     	=> 'publish',
			'offset' 			=> 0,
			'suppress_filters' 	=> false,
			'orderby'			=> 'title',
			'order'				=> 'ASC',
		));

		//final query
		$results_query = get_posts($query_args);



		foreach ($results_query as $this_post) {
			$output .= "<option value='$this_post->ID' "; if ($value == $this_post->ID) { $output .= "selected='selected'"; } $output .= ">" . $this_post->post_title . "</option>";
		}

		// after
		$output .= "</select></div>";
	   

		return $output;

	}

/****************************************************
CUSTOM ATTRIBUTE: CANON_ROYALSLIDER_SELECT
****************************************************/

	add_shortcode_param('canon_royalslider_select', 'canon_royalslider_select_callback');

	function canon_royalslider_select_callback ($settings, $value) {

		$dependency = vc_generate_dependencies_attributes($settings);
		$output = "";
		$param_name = $settings['param_name'];
		$class = "wpb_vc_param_value wpb-textinput " . $settings['param_name'] . " " . $settings['type'] . "_field";

		// before
		$output .= "<div class='canon_royalslider_select'><select name='$param_name' class='$class' $dependency>";

        global $wpdb;
        $table = NewRoyalSliderMain::get_sliders_table_name();
        $data = $wpdb->get_results("SELECT * FROM $table", ARRAY_A );


		foreach ($data as $slider) {
			$slider_id = $slider['id'];
			$slider_name = $slider['name'];
			$output .= "<option value='$slider_id' "; if ($value == $slider_id) { $output .= "selected='selected'"; } $output .= ">" . $slider_name . "</option>";
		}

		// after
		$output .= "</select></div>";
	   

		return $output;

	}

