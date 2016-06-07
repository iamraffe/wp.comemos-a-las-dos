<?php

/**************************************
WIDGET: cookbook_quicklinks
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_quicklinks' );
	function register_widget_cookbook_quicklinks () {
		register_widget('cookbook_quicklinks');	
	}

	class cookbook_quicklinks extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_quicklinks', 								
					'description' => __('Display a list of links', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 200, 
					'id_base' => 'cookbook_quicklinks' 														
				);

				parent::__construct('cookbook_quicklinks', __('Cookbook: Quicklinks', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
				'title' 	=> __('Quicklinks', "loc_cookbook_widgets_plugin"),
				'content' 	=> '<ul class="list-1">
	<li><a href="#">About</a></li>
	<li><a href="#">Sitemap Page</a></li>
	<li><a href="#">Make a Donation</a></li>
	<li><a href="#">Read Our Blog</a></li>
	<li><a href="#">Contact Us</a></li>
</ul>',
			);

			//merge default
			if (!empty($defaults_checkboxes)) $defaults = array_merge($defaults, $defaults_checkboxes);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title:", "loc_cookbook_widgets_plugin"); ?> </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('title')); ?>' name='<?php echo esc_attr($this->get_field_name('title')); ?>' value="<?php if(isset($title)) echo htmlspecialchars($title); ?>">
				</p>

				<p>
					<label for='<?php echo esc_attr($this->get_field_id('content')); ?>'><?php _e("List of contact links", "loc_cookbook_widgets_plugin"); ?></label><br>
					<textarea class='widefat' id='<?php echo esc_attr($this->get_field_id('content')); ?>' name='<?php echo esc_attr($this->get_field_name('content')); ?>' rows='15'><?php if (isset($content)) echo esc_attr($content); ?></textarea>
				</P>

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
				$title 			= __('Quicklinks', "loc_cookbook_widgets_plugin");
				$content 		= '<ul class="list-1">
	<li><a href="#">About</a></li>
	<li><a href="#">Sitemap Page</a></li>
	<li><a href="#">Make a Donation</a></li>
	<li><a href="#">Read Our Blog</a></li>
	<li><a href="#">Contact Us</a></li>
</ul>';
			}

            // WPML
			$title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );
			if (function_exists('icl_translate') && function_exists('icl_register_string')) {

				// VERSION < 3.3
				icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[content]", $content);

				$content = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[content]", $content);
			
			} elseif (class_exists('SitePress')) {

				// VERSION > v3.3
				do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[content]", $content);
				
				$content = apply_filters('wpml_translate_single_string', $content, 'loc_cookbook_widgets_plugin', "$widget_id-widget[content]");
			
			}

			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php if (!empty($title)) { echo wp_kses_post($before_title . $title . $after_title); } ?>

			<?php echo wp_kses_post($content); ?>

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



