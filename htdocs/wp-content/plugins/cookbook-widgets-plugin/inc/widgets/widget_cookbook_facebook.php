<?php

/**************************************
WIDGET: widget_cookbook_facebook
***************************************/

	add_action('widgets_init', 'register_widget_widget_cookbook_facebook' );
	function register_widget_widget_cookbook_facebook () {
		register_widget('widget_cookbook_facebook');	
	}

	class widget_cookbook_facebook extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'widget_cookbook_facebook', 								
					'description' => __('Display Facebook box', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 350, 
					'height' => 350, 
					'id_base' => 'widget_cookbook_facebook' 														
				);

				parent::__construct('widget_cookbook_facebook', __('Cookbook: Facebook', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
					'fb_cover' 				=> 'checked',
					'fb_faces' 				=> 'unchecked',
					'fb_posts' 				=> 'unchecked',
					'fb_small_header' 		=> 'unchecked',
				);	
			}

			//defaults
			$defaults = array( 
				'title' 		=> __('Like us on facebook', "loc_cookbook_widgets_plugin"),
				'fb_page' 		=> "https://www.facebook.com/themecanon",
				'fb_width'		=> '600',
				'fb_height'		=> '360',
			);

			//merge default
			if (!empty($defaults_checkboxes)) $defaults = array_merge($defaults, $defaults_checkboxes);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input class='widefat' type='text' id='<?php echo esc_attr($this->get_field_id('title')); ?>' name='<?php echo esc_attr($this->get_field_name('title')); ?>' value="<?php if(isset($title)) echo htmlspecialchars($title); ?>">
				</p>

				<p>
					<label for='<?php echo esc_attr($this->get_field_id('fb_page')); ?>'><?php _e("Facebook Page", "loc_cookbook_widgets_plugin"); ?>: </label>
					<input class='widefat' type='text' id='<?php echo esc_attr($this->get_field_id('fb_page')); ?>' name='<?php echo esc_attr($this->get_field_name('fb_page')); ?>' value='<?php if (!empty($fb_page)) echo esc_attr($fb_page); ?>'>
				</p>

				<p>
					<label for='<?php echo esc_attr($this->get_field_id('fb_width')); ?>'><?php _e("Max-width (pixels)", "loc_cookbook_widgets_plugin"); ?>: </label>
					<input class='widefat' type='text' id='<?php echo esc_attr($this->get_field_id('fb_width')); ?>' name='<?php echo esc_attr($this->get_field_name('fb_width')); ?>' value='<?php if (!empty($fb_width)) echo esc_attr($fb_width); ?>'>
				</p>

				<p>
					<label for='<?php echo esc_attr($this->get_field_id('fb_height')); ?>'><?php _e("Height (pixels)", "loc_cookbook_widgets_plugin"); ?>: </label>
					<input class='widefat' type='text' id='<?php echo esc_attr($this->get_field_id('fb_height')); ?>' name='<?php echo esc_attr($this->get_field_name('fb_height')); ?>' value='<?php if (!empty($fb_height)) echo esc_attr($fb_height); ?>'>
				</p>

				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'fb_cover' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'fb_cover' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'fb_cover' )); ?>" value="checked" <?php checked($fb_cover == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'fb_cover' )); ?>"><?php _e("Show cover", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'fb_faces' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'fb_faces' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'fb_faces' )); ?>" value="checked" <?php checked($fb_faces == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'fb_faces' )); ?>"><?php _e("Show faces", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'fb_posts' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'fb_posts' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'fb_posts' )); ?>" value="checked" <?php checked($fb_posts == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'fb_posts' )); ?>"><?php _e("Show posts", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'fb_small_header' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'fb_small_header' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'fb_small_header' )); ?>" value="checked" <?php checked($fb_small_header == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'fb_small_header' )); ?>"><?php _e("Small header", "loc_cookbook_widgets_plugin"); ?></label>
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
				$title 					= __('Like us on facebook', "loc_cookbook_widgets_plugin");
				$fb_page 				= "https://www.facebook.com/themecanon";
				$fb_width				= '600';
				$fb_height				= '360';
				$fb_cover				= 'checked';
				$fb_faces 				= 'unchecked';
				$fb_posts 				= 'unchecked';
				$fb_small_header 		= 'unchecked';
			}

            // WPML
            $title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );

			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php echo wp_kses_post($before_title . $title . $after_title); ?>

				<div class="fb-page" 
					data-href					= "<?php echo esc_url($fb_page); ?>" 
					data-width 					= "<?php echo esc_attr($fb_width); ?>" 
					data-height					= "<?php echo esc_attr($fb_height); ?>" 
					data-hide-cover				= "<?php if ($fb_cover == "checked") { echo "false"; } else { echo "true"; } ?>" 
					data-show-facepile			= "<?php if ($fb_faces == "checked") { echo "true"; } else { echo "false"; } ?>" 
					data-show-posts				= "<?php if ($fb_posts == "checked") { echo "true"; } else { echo "false"; } ?>"
					data-hide-cta				= "false"
					data-small-header			= "<?php if ($fb_small_header == "checked") { echo "true"; } else { echo "false"; } ?>" 
					data-adapt-container-width	= "true" 
				>
					<div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="https://www.facebook.com/facebook"><?php _e('Facebook page plugin loading...', 'loc_cookbook_widgets_plugin'); ?></a></blockquote></div>
				</div>

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS
