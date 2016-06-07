<?php

/**************************************
WIDGET: cookbook_animated_number
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_animated_number' );
	function register_widget_cookbook_animated_number () {
		register_widget('cookbook_animated_number');	
	}

	class cookbook_animated_number extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_animated_number', 								
					'description' => __('Display an animated number', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'cookbook_animated_number' 														
				);

				parent::__construct('cookbook_animated_number', __('Cookbook: Animated Number', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
				'number' 				=> "100",
				'postfix' 				=> "",
				'text' 					=> 'Nullam quis risus eget urna mollis ornare vel eu leo. Etiam porta sem malesuada magna.',
				'animation_speed' 		=> 3000,
				'use_seperator' 		=> 'checked',
				'show_text' 			=> 'checked',
			);

			//merge default
			if (!empty($defaults_checkboxes)) $defaults = array_merge($defaults, $defaults_checkboxes);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('number')); ?> "><?php _e("Number", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('number')); ?>' name='<?php echo esc_attr($this->get_field_name('number')); ?>' value="<?php if(isset($number)) echo htmlspecialchars($number); ?>">
				</p>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('prefix')); ?> "><?php _e("Prefix", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('prefix')); ?>' name='<?php echo esc_attr($this->get_field_name('prefix')); ?>' value="<?php if(isset($prefix)) echo htmlspecialchars($prefix); ?>">
				</p>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('postfix')); ?> "><?php _e("Postfix", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('postfix')); ?>' name='<?php echo esc_attr($this->get_field_name('postfix')); ?>' value="<?php if(isset($postfix)) echo htmlspecialchars($postfix); ?>">
				</p>

				<p>
					<label for='<?php echo esc_attr($this->get_field_id('text')); ?>'><?php _e("Text", "loc_cookbook_widgets_plugin"); ?></label><br>
					<textarea class='widefat' id='<?php echo esc_attr($this->get_field_id('text')); ?>' name='<?php echo esc_attr($this->get_field_name('text')); ?>' rows='5'><?php if (isset($text)) echo esc_attr($text); ?></textarea>
				</P>

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

				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'use_seperator' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'use_seperator' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'use_seperator' )); ?>" value="checked" <?php checked($use_seperator == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'use_seperator' )); ?>"><?php _e("Comma seperator", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'show_text' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'show_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_text' )); ?>" value="checked" <?php checked($show_text == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'show_text' )); ?>"><?php _e("Show text", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

			<?php
		}

		/**************************************
		4. DISPLAY
		***************************************/
		function widget($args, $instance) {
			extract($args);								
			extract($instance);							

            // WPML
			if (function_exists('icl_translate') && function_exists('icl_register_string')) {

	            // VERSION < 3.3
	            icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[number]", $number);
	            icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[prefix]", $prefix);
	            icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[postfix]", $postfix);
	            icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[text]", $text);

	            $number = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[number]", $number);
	            $prefix = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[prefix]", $prefix);
	            $postfix = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[postfix]", $postfix);
	            $text = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[text]", $text);
			
			} elseif (class_exists('SitePress')) {

	            // VERSION > v3.3
	            do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[number]", $number);
	            do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[prefix]", $prefix);
	            do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[postfix]", $postfix);
	            do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[content]", $text);
	            
	            $number = apply_filters('wpml_translate_single_string', $number, 'loc_cookbook_widgets_plugin', "$widget_id-widget[number]");
	            $prefix = apply_filters('wpml_translate_single_string', $prefix, 'loc_cookbook_widgets_plugin', "$widget_id-widget[prefix]");
	            $postfix = apply_filters('wpml_translate_single_string', $postfix, 'loc_cookbook_widgets_plugin', "$widget_id-widget[postfix]");
	            $text = apply_filters('wpml_translate_single_string', $text, 'loc_cookbook_widgets_plugin', "$widget_id-widget[text]");
			
			}


			?>

			<?php echo wp_kses_post($before_widget); ?>

			<div class="canon_animated_number" data-number="<?php echo esc_attr($number); ?>" data-seperator="<?php echo esc_attr($use_seperator); ?>" data-animation_speed="<?php echo esc_attr($animation_speed); ?>">

				<h1 class="super"><?php if (!empty($prefix)) { echo esc_attr($prefix); } ?> <span class="canon_animated_number_wrapper">0</span> <?php if (!empty($postfix)) { echo esc_attr($postfix); } ?></h1>

				<?php if ($show_text == 'checked') { printf('<p>%s</p>', esc_attr($text)); } ?>

			</div>

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



