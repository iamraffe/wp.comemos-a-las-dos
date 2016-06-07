<?php

/**************************************
WIDGET: cookbook_vc_separator
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_vc_separator' );
	function register_widget_cookbook_vc_separator () {
		register_widget('cookbook_vc_separator');	
	}

	class cookbook_vc_separator extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_vc_separator', 								
					'description' => __('Displays a separator. Custom element for use with Visual Composer. May also be used as a widget. Please notice that this widget was designed with a specific layout in mind and may not look good in all possible layouts.', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'cookbook_vc_separator' 														
				);

				parent::__construct('cookbook_vc_separator', __('Cookbook VC: Separator', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
				'title' 					=> "Latest News",
				'style'						=> 'bar_style',
				'link_text'					=> 'See All',
				'link'						=> '#',
			);


			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			?>

			<!-- TEXT -->	
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('title')); ?>' name='<?php echo esc_attr($this->get_field_name('title')); ?>' value="<?php if(isset($title)) echo htmlspecialchars($title); ?>">
				</p>

			<!-- DYNAMIC SELECT -->

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('style')); ?> "><?php _e("Style", "loc_cookbook_widgets_plugin"); ?>:	 </label><br>
					<select id="<?php echo esc_attr($this->get_field_id('style')); ?>" name="<?php echo esc_attr($this->get_field_name('style')); ?>"> 
						<option value="line_style" <?php if (isset($style)) {if ($style == "line_style") echo "selected='selected'";} ?>><?php _e("Line", "loc_cookbook_widgets_plugin"); ?>	</option> 
						<option value="bar_style" <?php if (isset($style)) {if ($style == "bar_style") echo "selected='selected'";} ?>><?php _e("Bar", "loc_cookbook_widgets_plugin"); ?>	</option> 
					</select> 
				</p>

			<!-- TEXT -->	
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('link_text')); ?> "><?php _e("Link text (optional)", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('link_text')); ?>' name='<?php echo esc_attr($this->get_field_name('link_text')); ?>' value="<?php if(isset($link_text)) echo htmlspecialchars($link_text); ?>">
				</p>

			<!-- TEXT -->	
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('link')); ?> "><?php _e("Link (URL)", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('link')); ?>' name='<?php echo esc_attr($this->get_field_name('link')); ?>' value="<?php if(isset($link)) echo htmlspecialchars($link); ?>">
				</p>


			<?php
		}

		/**************************************
		4. DISPLAY
		***************************************/
		function widget($args, $instance) {

			// DEFAULTS
			$instance = array_merge(array(
				'title' 					=> "Latest News",
				'style'						=> 'bar_style',
				'link_text'					=> '',
				'link'						=> '',
			), $instance);

			extract($args);								
			extract($instance);

			// WPML (ONLY IF WIDGET)
			if (isset($widget_id)) {

				$title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );
				if (function_exists('icl_translate') && function_exists('icl_register_string')) {

					// VERSION < 3.3
					icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[link_text]", $link_text);

					$link_text = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[link_text]", $link_text);

				} elseif (class_exists('SitePress')) {

					// VERSION > v3.3
					do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[link_text]", $link_text);
					
					$link_text = apply_filters('wpml_translate_single_string', $link_text, 'loc_cookbook_widgets_plugin', "$widget_id-widget[link_text]");
				
				}

			}

			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php
				
				if ($style == "line_style") {

					// LINE
					echo '<div class="text-seperator-line">';
					echo "<h5>$title</h5>";
					echo '<div></div>';
					if (!empty($link_text)) { printf('<a class="btn" href="%s">%s</a>', esc_url($link), esc_attr($link_text)); }
					echo '</div>';
						
				} else {

					// BAR
					echo '<div class="text-seperator-bar">';
					echo "<h5>$title</h5>";
					if (!empty($link_text)) { printf('<a class="btn" href="%s">%s</a>', esc_url($link), esc_attr($link_text)); }
					echo '</div>';
				}
			
			?>
    			

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



