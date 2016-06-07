<?php

/**************************************
WIDGET: cookbook_statistics
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_statistics' );
	function register_widget_cookbook_statistics () {
		register_widget('cookbook_statistics');	
	}

	class cookbook_statistics extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_statistics', 								
					'description' => __('Display statistics', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 550, 
					'height' => 350, 
					'id_base' => 'cookbook_statistics' 														
				);

				parent::__construct('cookbook_statistics', __('Cookbook: Statistics', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
				'title' 		=> __('Statistics', "loc_cookbook_widgets_plugin"),
				'statistic'		=> array(
					0 				=> array(
						'icon'			=> 'fa-flag',
						'stat_text'		=> 'Fundraising',
						'stat_num'		=> '10%',
					),
				),
				'text'			=> "",
			);

			//merge default
			if (!empty($defaults_checkboxes)) $defaults = array_merge($defaults, $defaults_checkboxes);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			//get font awesome array
			$font_awesome_array = mb_get_font_awesome_icon_names_in_array();

			$statistic = array_values($statistic);	

			?>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('title')); ?>' name='<?php echo esc_attr($this->get_field_name('title')); ?>' value="<?php if(isset($title)) echo htmlspecialchars($title); ?>">
				</p>

				<br>
				Statistics:
				<ul class="widget_sortable" data-split_index="3">
				<?php
					for ($i = 0; $i < count($statistic); $i++) {  
					?>

						<li>
							<select class="li_option fa_select" name='<?php echo esc_attr($this->get_field_name('statistic')."[".$i."][icon]"); ?>'> 
								<?php 

									for ($n = 0; $n < count($font_awesome_array); $n++) {  
									?>
				     					<option value="<?php echo esc_attr($font_awesome_array[$n]); ?>" <?php if (isset($statistic[$i]['icon'])) {if ($statistic[$i]['icon'] == $font_awesome_array[$n]) echo "selected='selected'";} ?>><?php echo esc_attr($font_awesome_array[$n]); ?></option> 
									<?php
									}

								?>
							</select> 

							<i class="fa <?php if (isset($statistic[$i]['icon'])) { echo esc_attr($statistic[$i]['icon']); } else { echo "fa-flag"; } ?>"></i>

							Text: <input class="li_option" type='text' name='<?php echo esc_attr($this->get_field_name('statistic')."[".$i."][stat_text]"); ?>' value="<?php if(isset($statistic[$i]["stat_text"])) echo htmlspecialchars($statistic[$i]["stat_text"]); ?>">
							Number: <input class="li_option nums" type='text' name='<?php echo esc_attr($this->get_field_name('statistic')."[".$i."][stat_num]"); ?>' value="<?php if(isset($statistic[$i]["stat_num"])) echo htmlspecialchars($statistic[$i]["stat_num"]); ?>">

						</li>
					<?php
					}
				?>

				</ul>

				<div class="ul_control" data-min="1" data-max="1000">
					<input type="button" class="button ul_add" value="<?php _e("Add", "loc_cookbook_widgets_plugin"); ?>" />
					<input type="button" class="button ul_del" value="<?php _e("Delete", "loc_cookbook_widgets_plugin"); ?>" />
				</div>

				<br>

				<p>
					<label for='<?php echo esc_attr($this->get_field_id('text')); ?>'><?php _e("Statistics text", "loc_cookbook_widgets_plugin"); ?></label><br>
					<textarea class='widefat' id='<?php echo esc_attr($this->get_field_id('text')); ?>' name='<?php echo esc_attr($this->get_field_name('text')); ?>' rows='6'><?php if (isset($text)) echo esc_attr($text); ?></textarea>
				</P>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('read_more_link')); ?> "><?php _e("Read More Link (Optional)", "loc_cookbook_widgets_plugin"); ?>:</label><br> 
					<input class='widefat' type='text' id='<?php echo esc_attr($this->get_field_id('read_more_link')); ?>' name='<?php echo esc_attr($this->get_field_name('read_more_link')); ?>' value="<?php if(isset($read_more_link)) echo htmlspecialchars($read_more_link); ?>">
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
				$title 				= __('Statistics', "loc_cookbook_widgets_plugin");
				$statistic			= array(
					0 					=> array(
						'icon'				=> 'fa-flag',
						'stat_text'			=> 'Fundraising',
						'stat_num'			=> '10%',
					),
				);
				$text				= "";
			}

			$statistic = array_values($statistic);						

            // WPML
			$title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );
			if (function_exists('icl_translate') && function_exists('icl_register_string')) {

				// VERSION < 3.3
				icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[text]", $text);

				$text = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[text]", $text);

			} elseif (class_exists('SitePress')) {

				// VERSION > v3.3
				do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[text]", $text);
				
				$text = apply_filters('wpml_translate_single_string', $text, 'loc_cookbook_widgets_plugin', "$widget_id-widget[text]");
			
			}

			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php echo wp_kses_post($before_title . $title . $after_title); ?>

			<ul class="statistics">
				<?php 

					for ($i = 0; $i < count($statistic); $i++) {  
						
			            // WPML
						if (function_exists('icl_translate') && function_exists('icl_register_string')) {

				            // VERSION < 3.3
				            icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][stat_text]", $statistic[$i]['stat_text']);
				            icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][stat_num]", $statistic[$i]['stat_num']);

				            $statistic[$i]['stat_text'] = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][stat_text]", $statistic[$i]['stat_text']);
				            $statistic[$i]['stat_num'] = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][stat_num]", $statistic[$i]['stat_num']);
						
						} elseif (class_exists('SitePress')) {
				            
				            // VERSION > v3.3
				            do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][stat_text]", $statistic[$i]['stat_text']);
				            do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][stat_num]", $statistic[$i]['stat_num']);
				            
				            $statistic[$i]['stat_text'] = apply_filters('wpml_translate_single_string', $statistic[$i]['stat_text'], 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][stat_text]");
				            $statistic[$i]['stat_num'] = apply_filters('wpml_translate_single_string', $statistic[$i]['stat_num'], 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][stat_num]");
						
						}

						printf('<li><em class="fa %s"></em> %s - <span>%s</span></li>', 
							esc_attr($statistic[$i]['icon']),
							esc_attr($statistic[$i]['stat_text']),
							esc_attr($statistic[$i]['stat_num'])
						);
					}

				?>
			</ul>

			<?php 

				if (!empty($text) || !empty($read_more_link)) {
					echo "<div class='statistics_text'>";
					if (!empty($text)) { echo do_shortcode(wp_kses_post($text)); }
					if (!empty($read_more_link)) { printf('&#8230;<a class="read_more" href="%s">%s</a>', esc_url($read_more_link), __("Read More", "loc_cookbook_widgets_plugin")); }
					echo "</div>";
				}

			?>	

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



