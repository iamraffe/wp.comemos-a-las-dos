<?php

/**************************************
WIDGET: cookbook_accordion
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_accordion' );
	function register_widget_cookbook_accordion () {
		register_widget('cookbook_accordion');	
	}

	class cookbook_accordion extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_accordion', 								
					'description' => __('Displays an accordion', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'cookbook_accordion' 														
				);

				parent::__construct('cookbook_accordion', __('Cookbook: Accordion', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
				'title' 	=> __('Accordion', "loc_cookbook_widgets_plugin"),
				'accordion'		=> array(
					0				=> array(
						'title'			=> "Accordion Trigger",
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
				<?php _e("Accordion sections", "loc_cookbook_widgets_plugin"); ?>:
				<ul class="widget_sortable" data-split_index="3">
				<?php
					for ($i = 0; $i < count($accordion); $i++) {  
					?>

						<li>
							<input class="widefat li_option" type='text' name='<?php echo esc_attr($this->get_field_name('accordion')."[".$i."][title]"); ?>' value="<?php if(isset($accordion[$i]['title'])) echo htmlspecialchars($accordion[$i]['title']); ?>">
							<textarea class='widefat li_option' name='<?php echo esc_attr($this->get_field_name('accordion')."[".$i."][content]"); ?>' rows='5'><?php if (isset($accordion[$i]['content'])) echo esc_attr($accordion[$i]['content']); ?></textarea>
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
				$title 		= __('Accordion', "loc_cookbook_widgets_plugin");
				$accordion			= array(
					0					=> array(
						'title'				=> "Accordion Trigger",
						'content'			=> "",
					),
				);
			}

            // WPML
            $title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );

			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php echo wp_kses_post($before_title . $title . $after_title); ?>

    			<ul class="accordion">

    				<?php
    					
    					for ($i = 0; $i < count($accordion); $i++) {  

				            // WPML
    						if (function_exists('icl_translate') && function_exists('icl_register_string')) {

					            // VERSION < 3.3
					            icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][title]", $accordion[$i]['title']);
					            icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][content]", $accordion[$i]['content']);

					            $accordion[$i]['title'] = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][title]", $accordion[$i]['title']);
					            $accordion[$i]['content'] = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[$i][content]", $accordion[$i]['content']);
    						
    						} elseif (class_exists('SitePress')) {
					            
					            // VERSION > v3.3
					            do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][title]", $accordion[$i]['title']);
					            do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][content]", $accordion[$i]['content']);
					            
					            $accordion[$i]['title'] = apply_filters('wpml_translate_single_string', $accordion[$i]['title'], 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][title]");
					            $accordion[$i]['content'] = apply_filters('wpml_translate_single_string', $accordion[$i]['content'], 'loc_cookbook_widgets_plugin', "$widget_id-widget[$i][content]");
    						
    						}

    					?>
		    			    <li>
		    			      <a href='#' class='accordion-btn<?php if ($i === 0) { echo " active"; } ?>'><?php echo esc_attr($accordion[$i]['title']); ?></a>
		    			      <div class='accordion-content<?php if ($i === 0) { echo " active"; } ?>'>
		    			      	<p><?php echo do_shortcode(wp_kses_post($accordion[$i]['content'])); ?></p>
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



