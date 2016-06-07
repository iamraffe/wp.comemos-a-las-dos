<?php

/**************************************
WIDGET: cookbook_social_links
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_social_links' );
	function register_widget_cookbook_social_links () {
		register_widget('cookbook_social_links');	
	}

	class cookbook_social_links extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_social_links', 								
					'description' => __('Display your social links as icons', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 550, 
					'height' => 350, 
					'id_base' => 'cookbook_social_links' 														
				);

				parent::__construct('cookbook_social_links', __('Cookbook: Social Links', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
					'open_in_new' 	=> 'checked',
				);	
			}

			//defaults
			$defaults = array( 
				'title' 		=> __('Social Links', "loc_cookbook_widgets_plugin"),
				'display_style'	=> 'circle',
				'social_links'	=> array(
					0 				=> array('fa-facebook', 'https://www.facebook.com/themecanon'),
					1 				=> array('fa-twitter', 'https://twitter.com/ThemeCanon'),
					2 				=> array('fa-rss', get_bloginfo('rss2_url')),
				),
			);

			//merge default
			if (!empty($defaults_checkboxes)) $defaults = array_merge($defaults, $defaults_checkboxes);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			//get font awesome array
			$font_awesome_array = mb_get_font_awesome_icon_names_in_array();

			$social_links = array_values($social_links);	
			?>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title <i>(Optional)</i> :", "loc_cookbook_widgets_plugin"); ?> </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('title')); ?>' name='<?php echo esc_attr($this->get_field_name('title')); ?>' value="<?php if(isset($title)) echo htmlspecialchars($title); ?>">
				</p>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('display_style')); ?> "><?php _e("Display style", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<select id="<?php echo esc_attr($this->get_field_id('display_style')); ?>" name="<?php echo esc_attr($this->get_field_name('display_style')); ?>"> 
		     			<option value="standard" <?php if (isset($display_style)) {if ($display_style == "standard") echo "selected='selected'";} ?>><?php _e("Standard", "loc_cookbook_widgets_plugin"); ?>	</option> 
		     			<option value="circle" <?php if (isset($display_style)) {if ($display_style == "circle") echo "selected='selected'";} ?>><?php _e("Circle background", "loc_cookbook_widgets_plugin"); ?>	</option> 
	 					<option value="rounded" <?php if (isset($display_style)) {if ($display_style == "rounded") echo "selected='selected'";} ?>><?php _e("Rounded box background", "loc_cookbook_widgets_plugin"); ?>	</option> 
					</select> 
				</p>

				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'open_in_new' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'open_in_new' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'open_in_new' )); ?>" value="checked" <?php checked($open_in_new == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'open_in_new' )); ?>"><?php _e("Open social links in new window", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

				<br>

				<?php _e("Social links:", "loc_cookbook_widgets_plugin"); ?>
				<ul class="widget_sortable widget-social-links-sortable" data-split_index="3">
				<?php
					for ($i = 0; $i < count($social_links); $i++) {  
					?>

						<li>
							<select class="li_option fa_select" name='<?php echo esc_attr($this->get_field_name('social_links')."[".$i."][0]"); ?>'> 
								<?php 

									for ($n = 0; $n < count($font_awesome_array); $n++) {  
									?>
				     					<option value="<?php echo esc_attr($font_awesome_array[$n]); ?>" <?php if (isset($social_links[$i][0])) {if ($social_links[$i][0] == $font_awesome_array[$n]) echo "selected='selected'";} ?>><?php echo esc_attr($font_awesome_array[$n]); ?></option> 
									<?php
									}

								?>
							</select> 

							<i class="fa <?php if (isset($social_links[$i][0])) { echo esc_attr($social_links[$i][0]); } else { echo "fa-flag"; } ?>"></i>

							<?php _e("URL:", "loc_cookbook_widgets_plugin"); ?>
							<input class="li_option" type='text' name='<?php echo esc_attr($this->get_field_name('social_links')."[".$i."][1]"); ?>' value="<?php if(isset($social_links[$i][1])) echo htmlspecialchars($social_links[$i][1]); ?>">
							<button class="ul_del_this button float-right"><?php _e("delete", "loc_cookbook_widgets_plugin"); ?></button>

						</li>
					<?php
					}
				?>

				</ul>

				<div class="ul_control" data-min="1" data-max="1000">
					<input type="button" class="button ul_add" value="<?php _e("Add", "loc_cookbook_widgets_plugin"); ?>" />
				</div>

				<br>

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
				$title 			= __('Social Links', "loc_cookbook_widgets_plugin");
				$display_style 	= 'circle';
				$open_in_new	= 'checked';
				$social_links	= array(
					0 				=> array('fa-facebook', 'https://www.facebook.com/themecanon'),
					1 				=> array('fa-twitter', 'https://twitter.com/ThemeCanon'),
					2 				=> array('fa-rss', get_bloginfo('rss2_url')),
				);
			}

			// FAILSAFE
			$social_links = array_values($social_links);	

            // WPML
			$title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );

			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php if (!empty($title)) { echo wp_kses_post($before_title . $title . $after_title); } ?>

			<div class="social-links-container">

				<ul class="social-links <?php echo esc_attr($display_style); ?>">

					<?php 

						for ($i = 0; $i < count($social_links); $i++) {  
						?>
							<li><a href="<?php echo esc_url($social_links[$i][1]); ?>" <?php if ($open_in_new == 'checked') { echo "target='_blank'"; } ?>><em class="fa <?php echo esc_attr($social_links[$i][0]); ?>"></em></a></li>
						<?php
						}
					?>

				</ul>

			</div>

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



