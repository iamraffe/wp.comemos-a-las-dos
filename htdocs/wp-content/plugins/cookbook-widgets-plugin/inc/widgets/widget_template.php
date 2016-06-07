<?php

/**************************************
WIDGET: CANON_SIDEBAR_TEMPLATE
***************************************/

	add_action('widgets_init', 'register_widget_CANON_SIDEBAR_TEMPLATE' );
	function register_widget_CANON_SIDEBAR_TEMPLATE () {
		register_widget('CANON_SIDEBAR_TEMPLATE');	
	}

	class CANON_SIDEBAR_TEMPLATE extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'CANON_SIDEBAR_TEMPLATE', 								
					'description' => __('YOUR STANDARD TEMPLATE BANNER', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'CANON_SIDEBAR_TEMPLATE' 														
				);

				parent::__construct('CANON_SIDEBAR_TEMPLATE', __('TEMPLATE_DISPLAY_TITLE', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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

			//defaults
			$defaults = array( 
				'title' 	=> __('Like us on facebook', "loc_cookbook_widgets_plugin"),
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>

			<!-- TEXT -->	
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('title')); ?>' name='<?php echo esc_attr($this->get_field_name('title')); ?>' value="<?php if(isset($title)) echo htmlspecialchars($title); ?>">
				</p>

			<!-- NUMBER -->	
				<p>
					<label for='<?php echo esc_attr($this->get_field_id('animation_speed')); ?>'><?php _e("Animation Speed", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='0'
						max='100000'
						step='100'
						id='<?php echo esc_attr($this->get_field_id('animation_speed')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('animation_speed')); ?>' 
						value='<?php if (isset($animation_speed)) echo esc_attr($animation_speed); ?>'
					>
				</p>

			<!-- CHECKBOX -->	
				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'use_seperator' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'use_seperator' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'use_seperator' )); ?>" value="checked" <?php checked($use_seperator == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'use_seperator' )); ?>"><?php _e("Comma seperator", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

			<!-- SELECT -->	
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('display_style')); ?> "><?php _e("Display style", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<select id="<?php echo esc_attr($this->get_field_id('display_style')); ?>" name="<?php echo esc_attr($this->get_field_name('display_style')); ?>"> 
		     			<option value="images_to_posts" <?php if (isset($display_style)) {if ($display_style == "images_to_posts") echo "selected='selected'";} ?>><?php _e("Images linking to posts", "loc_cookbook_widgets_plugin"); ?>	</option> 
		     			<option value="images_to_lightbox" <?php if (isset($display_style)) {if ($display_style == "images_to_lightbox") echo "selected='selected'";} ?>><?php _e("Images linking to lightbox", "loc_cookbook_widgets_plugin"); ?>	</option> 
	 					<option value="text" <?php if (isset($display_style)) {if ($display_style == "text") echo "selected='selected'";} ?>><?php _e("Text", "loc_cookbook_widgets_plugin"); ?>	</option> 
					</select> 
				</p>

			<?php
		}

		/**************************************
		4. DISPLAY
		***************************************/
		function widget($args, $instance) {

			// DEFAULTS
			$instance = array_merge(array(
				'title' 					=> "",
				'show'						=> "latest_posts",
				'offset'					=> 1,
				'excerpt_length'			=> 360,

				'use_title_caption'			=> 'unchecked',
				'hide_featured_media'		=> 'unchecked',
				'hide_comments_count'		=> 'unchecked',
				'hide_rating'				=> 'unchecked',
				'hide_categories'			=> 'unchecked',
				'hide_title'				=> 'unchecked',
				'hide_excerpt'				=> 'unchecked',
			), $instance);
			
			extract($args);								
			extract($instance);							

 			// EMPTY WIDGET ID FAILSAIFE (WHEN WIDGET IS USED AS VC ELEMENT)
			if (!isset($widget_id)) { $widget_id = "CANON_SIDEBAR_TEMPLATE-" . uniqid(); }

           // WPML
			$title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );

			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php echo wp_kses_post($before_title . $title . $after_title); ?>

			<?php var_dump($instance); ?>

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



