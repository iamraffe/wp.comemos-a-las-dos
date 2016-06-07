<?php

/**************************************
WIDGET: cookbook_quote
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_quote' );
	function register_widget_cookbook_quote () {
		register_widget('cookbook_quote');	
	}

	class cookbook_quote extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_quote', 								
					'description' => __('Displays a quote', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'cookbook_quote' 														
				);

				parent::__construct('cookbook_quote', __('Cookbook: Quote', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
					// 'fb_faces' => 'checked'
				);	
			}

			//defaults
			$defaults = array( 
				'title' 		=> __('Quote', "loc_cookbook_widgets_plugin"),
				'quote'			=> "",
				'byline'		=> "",
			);

			//merge default
			if (!empty($defaults_checkboxes)) $defaults = array_merge($defaults, $defaults_checkboxes);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input class="widefat" type='text' id='<?php echo esc_attr($this->get_field_id('title')); ?>' name='<?php echo esc_attr($this->get_field_name('title')); ?>' value="<?php if(isset($title)) echo htmlspecialchars($title); ?>">
				</p>

				<p>
					<label for='<?php echo esc_attr($this->get_field_id('quote')); ?>'><?php _e("Quote", "loc_cookbook_widgets_plugin"); ?></label><br>
					<textarea class='widefat' name='<?php echo esc_attr($this->get_field_name('quote')); ?>' rows='5'><?php if (isset($quote)) echo esc_attr($quote); ?></textarea>
				</P>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('byline')); ?> "><?php _e("Byline", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input class="widefat" type='text' id='<?php echo esc_attr($this->get_field_id('byline')); ?>' name='<?php echo esc_attr($this->get_field_name('byline')); ?>' value="<?php if(isset($byline)) echo htmlspecialchars($byline); ?>">
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
				$title 				= __('Quote', "loc_cookbook_widgets_plugin");
				$quote 				= "";
				$bylline 			= "";
			}

            // WPML
			$title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );
			if (function_exists('icl_translate') && function_exists('icl_register_string')) {

				// VERSION < 3.3
				icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[quote]", $quote);
				icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[byline]", $byline);

				$quote = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[quote]", $quote);
				$byline = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[byline]", $byline);
			
			} elseif (class_exists('SitePress')) {

				// VERSION > v3.3
				do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[quote]", $quote);
				do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[byline]", $byline);
				
				$quote = apply_filters('wpml_translate_single_string', $quote, 'loc_cookbook_widgets_plugin', "$widget_id-widget[quote]");
				$byline = apply_filters('wpml_translate_single_string', $byline, 'loc_cookbook_widgets_plugin', "$widget_id-widget[byline]");
			
			}

			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php echo wp_kses_post($before_title . $title . $after_title); ?>

			<blockquote>
				<?php echo wp_kses_post($quote); ?>
				<?php if (!empty($byline)) { printf('<cite>- %s</cite>', esc_attr($byline)); } ?>
			
			</blockquote>

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



