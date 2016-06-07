<?php

/**************************************
WIDGET: cookbook_toggle
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_toggle' );
	function register_widget_cookbook_toggle () {
		register_widget('cookbook_toggle');	
	}

	class cookbook_toggle extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_toggle', 								
					'description' => __('Displays a toggle', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'cookbook_toggle' 														
				);

				parent::__construct('cookbook_toggle', __('Cookbook: Toggle', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
				'title' 		=> __('Toggle', "loc_cookbook_widgets_plugin"),
				'toggle'		=> array(
					0				=> array(
						'title'			=> "Toggle Trigger",
						'content'		=> "",
					),
				),
			);

			//merge default
			if (!empty($defaults_checkboxes)) $defaults = array_merge($defaults, $defaults_checkboxes);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			?>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('title')); ?>' name='<?php echo esc_attr($this->get_field_name('title')); ?>' value="<?php if(isset($title)) echo htmlspecialchars($title); ?>">
				</p>

				<br>

				<?php _e("toggle sections", "loc_cookbook_widgets_plugin"); ?>:
				
				<ul class="widget_sortable" data-split_index="3">
				<?php
					for ($i = 0; $i < count($toggle); $i++) {  
					?>

						<li>
							<input class="widefat li_option" type='text' name='<?php echo esc_attr($this->get_field_name('toggle')."[".$i."][title]"); ?>' value="<?php if(isset($toggle[$i]['title'])) echo htmlspecialchars($toggle[$i]['title']); ?>">
							<textarea class='widefat li_option' name='<?php echo esc_attr($this->get_field_name('toggle')."[".$i."][content]"); ?>' rows='5'><?php if (isset($toggle[$i]['content'])) echo esc_attr($toggle[$i]['content']); ?></textarea>
						</li>
					<?php
					}
				?>

				</ul>

				<div class="ul_control" data-min="1" data-max="1000">
					<input type="button" class="button ul_add" value="<?php _e("Add", "loc_cookbook_widgets_plugin"); ?>" />
					<input type="button" class="button ul_del" value="<?php _e("Delete", "loc_cookbook_widgets_plugin"); ?>" />
				</div>



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
				$title 				= __('Toggle', "loc_cookbook_widgets_plugin");
				$toggle				= array(
					0					=> array(
						'title'				=> "Toggle Trigger",
						'content'			=> "",
					),
				);
			}

            // WPML
            $title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );
			
			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php echo wp_kses_post($before_title . $title . $after_title); ?>

    			<ul class="toggle">

    				<?php
    					
    					for ($i = 0; $i < count($toggle); $i++) {  

				            // WPML
    						if (function_exists('icl_translate') && function_exists('icl_register_string')) {

					            // VERSION < 3.3
					            icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][title]", $toggle[$i]['title']);
					            icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][content]", $toggle[$i]['content']);

					            $toggle[$i]['title'] = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][title]", $toggle[$i]['title']);
					            $toggle[$i]['content'] = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][content]", $toggle[$i]['content']);
    						
    						} elseif (class_exists('SitePress')) {
					            
					            // VERSION > v3.3
					            do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][title]", $toggle[$i]['title']);
					            do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][content]", $toggle[$i]['content']);
					            
					            $toggle[$i]['title'] = apply_filters('wpml_translate_single_string', $toggle[$i]['title'], 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][title]");
					            $toggle[$i]['content'] = apply_filters('wpml_translate_single_string', $toggle[$i]['content'], 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][content]");
    						
    						}
    					
    					?>
		    			    <li>
		    			      <a href='#' class='toggle-btn<?php if ($i === 0) { echo " active"; } ?>'><?php echo esc_attr($toggle[$i]['title']); ?></a>
		    			      <div class='toggle-content<?php if ($i === 0) { echo " active"; } ?>'>
		    			      	<p><?php echo do_shortcode(wp_kses_post($toggle[$i]['content'])); ?></p>
		    			      </div>
		    			    </li>
    					<?php
    					}
    				
    				?>

    			  </ul>

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



