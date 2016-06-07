<?php

/**************************************
WIDGET: cookbook_search
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_search' );
	function register_widget_cookbook_search () {
		register_widget('cookbook_search');	
	}

	class cookbook_search extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_search', 								
					'description' => __("Display search", "loc_cookbook_widgets_plugin")		 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'cookbook_search' 														
				);

				parent::__construct('cookbook_search', __("Cookbook: Search", "loc_cookbook_widgets_plugin")	 , $widget_ops, $control_ops );	
		}

		/**************************************
		2. UPDATE
		***************************************/
		function update($new_instance, $old_instance) {
			return $new_instance;	 
		}

		/**************************************
		3. FORM
		***************************************/
		function form($instance) {

			//default for checkboxes
			if (empty($instance)) {
				$defaults_checkboxes = array(
				);	
			}

			//defaults
			$defaults = array( 
				'title' 					=> __("Search", "loc_cookbook_widgets_plugin")	,
				'widget_placeholder_text' 	=> __("Search...", "loc_cookbook_widgets_plugin")	,
			);

			//merge default
			if (!empty($defaults_checkboxes)) $defaults = array_merge($defaults, $defaults_checkboxes);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title <i>(optional)</i>", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('title')); ?>' name='<?php echo esc_attr($this->get_field_name('title')); ?>' value="<?php if(isset($title)) echo htmlspecialchars($title); ?>">
				</p>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('widget_placeholder_text')); ?> "><?php _e("Placeholder text", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('widget_placeholder_text')); ?>' name='<?php echo esc_attr($this->get_field_name('widget_placeholder_text')); ?>' value="<?php if(isset($widget_placeholder_text)) echo htmlspecialchars($widget_placeholder_text); ?>">
				</p>

			<?php
		}

		/**************************************
		4. DISPLAY
		***************************************/
		function widget($args, $instance) {
			extract($args);								
			extract($instance);		

			// DEFAULTS
			if (empty($instance)) {
				$title 						= __("Search", "loc_cookbook_widgets_plugin");
				$widget_placeholder_text 	= __("Search...", "loc_cookbook_widgets_plugin");
			}

            // WPML
			$title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );
			if (function_exists('icl_translate') && function_exists('icl_register_string')) {

				// VERSION < 3.3
				icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[widget_placeholder_text]", $widget_placeholder_text);

				$widget_placeholder_text = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[widget_placeholder_text]", $widget_placeholder_text);
			
			} elseif (class_exists('SitePress')) {

				// VERSION > v3.3
				do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[widget_placeholder_text]", $widget_placeholder_text);
				
				$widget_placeholder_text = apply_filters('wpml_translate_single_string', $widget_placeholder_text, 'loc_cookbook_widgets_plugin', "$widget_id-widget[widget_placeholder_text]");
			
			}
            
			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php if (!empty($title)) { echo wp_kses_post($before_title . $title . $after_title); } ?>

	    		<form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url( '/' )); ?>">
	    			<input type="text" id="s" class="full" name="s" placeholder="<?php echo esc_attr($widget_placeholder_text); ?>" />
                	<?php if (isset($_GET['lang'])) { printf("<input type='hidden' name='lang' value='%s' />", esc_attr($_GET['lang'])); } ?>
	    		</form>

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



