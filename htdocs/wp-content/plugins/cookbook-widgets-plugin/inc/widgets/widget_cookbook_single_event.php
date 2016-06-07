<?php

/**************************************
WIDGET: cookbook_single_event
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_single_event' );
	function register_widget_cookbook_single_event () {
		register_widget('cookbook_single_event');	
	}

	class cookbook_single_event extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_single_event', 								
					'description' => __('Display a single event', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'cookbook_single_event' 														
				);

				parent::__construct('cookbook_single_event', __('Cookbook: Single Event', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
				'title' 			=> __('Event', "loc_cookbook_widgets_plugin"),
				'excerpt_length' 	=> 650,
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

				<?php 

					// DETECT PLUGIN
					if (!class_exists('Tribe__Events__Main')) {
						echo '<p>';
						_e("<i><strong>WARNING:</strong> This block requires <strong>The Events Calendar</strong> plugin. The required plugin could not be found. Please go to plugins and install/activate the required plugin!</i>", "loc_cookbook_widgets_plugin");
						echo '</p>';
					} else  {
					?>

					<!-- DYNAMIC SELECT -->
						<?php 

							$events = tribe_get_events(array(
								'eventDisplay'		=> 'all',
								'orderby'			=> 'post_date',
								'order'				=> 'DESC',
								'posts_per_page'	=> -1,
							));

						 ?>
						<p>
							<label><?php _e("Select event", "loc_cookbook_widgets_plugin"); ?>: </label><br>
							<select name="<?php echo esc_attr($this->get_field_name('event_ID')); ?>"> 

							<?php 

								if (count($events) === 0) {
									echo "<option value=''>No events found</option>";
										
								} else {
									for ($i = 0; $i < count($events); $i++) { 
									?>
					     				<option value="<?php echo esc_attr($events[$i]->ID); ?>" <?php if (isset($event_ID)) {if ($event_ID == $events[$i]->ID) echo "selected='selected'";} ?>><?php printf('%s (%s)', esc_attr(strip_tags($events[$i]->post_title)), esc_attr(tribe_get_start_date($events[$i]->ID))); ?></option> 
									<?php
									}
										
								}
							?>
							</select> 
						<p>

						
					<?php
					}
				?>

				<p>
					<label for='<?php echo esc_attr($this->get_field_id('excerpt_length')); ?>'><?php _e("Automatic Excerpt Size", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='0'
						max='10000'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('excerpt_length')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('excerpt_length')); ?>' 
						value='<?php if (isset($excerpt_length)) echo esc_attr($excerpt_length); ?>'
					>
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
				$title 				= __('Event', "loc_cookbook_widgets_plugin");
				$excerpt_length 	= 650;

				// get events
				$events = tribe_get_events(array(
					'eventDisplay'		=> 'all',
					'orderby'			=> 'post_date',
					'order'				=> 'DESC',
					'numberposts'		=> 1,
				));

				$event_ID			= $events[0]->ID;
			}

			$cost = tribe_get_formatted_cost($event_ID);	

            // WPML
			$title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );
            if (function_exists('icl_object_id')) { $event_ID = icl_object_id($event_ID); }
			if (function_exists('icl_translate') && function_exists('icl_register_string')) {

				// VERSION < 3.3
				icl_register_string ('loc_cookbook_widgets_plugin', "$widget_id-widget[cost]", $cost);

				$cost = icl_translate('loc_cookbook_widgets_plugin', "$widget_id-widget[cost]", $cost);
			
			} elseif (class_exists('SitePress')) {

				// VERSION > v3.3
				do_action('wpml_register_single_string', 'loc_cookbook_widgets_plugin', "$widget_id-widget[cost]", $cost);
				
				$cost = apply_filters('wpml_translate_single_string', $cost, 'loc_cookbook_widgets_plugin', "$widget_id-widget[cost]");
			
			}

			if (!isset($event_ID) || empty($event_ID)) { return; }

			$event = get_post($event_ID);

			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php if (!empty($title)) { echo wp_kses_post($before_title . $title . $after_title); } ?>

            	<!-- Start Post --> 
            	<div class="clearfix tribe-events-tcblock">

					<!-- Event Cost -->
					<div class="tribe-events-event-cost">
						<span><?php echo esc_attr($cost); ?></span>
					</div>

					<!-- Event Title -->
					<h2 class="tribe-events-list-event-title summary">
						<?php printf('<a class="url" href="%s" title="%s" rel="bookmark">%s</a>', esc_url(tribe_get_event_link($event_ID)), esc_attr(strip_tags(get_the_title($event_ID))), wp_kses_post(get_the_title($event_ID))); ?>
					</h2>
					
					<!-- Event Image -->
					<div class="tribe-events-event-image">
						<?php 

							if ( has_post_thumbnail($event_ID) && get_post(get_post_thumbnail_id($event_ID)) ) {
                                $post_thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($event_ID),'full');
								printf('<a href="%s" title="%s"><img src="%s" title="%s"/></a>', esc_url(tribe_get_event_link($event_ID)), esc_attr(strip_tags(get_the_title($event_ID))), esc_url($post_thumbnail_src[0]), esc_attr(strip_tags(get_the_title($event_ID))) ); 
							}

						?>

					</div>
					
													
					<!-- Event Meta -->
					<div class="tribe-events-event-meta  vcard location">

						<!-- Schedule & Recurrence Details -->
						<div class="updated published time-details">
							<?php printf('<span class="date-start dtstart">%s</span>', esc_attr(tribe_get_start_date($event_ID))); ?>
						</div>

						<!-- Venue Display Info -->
						<div class="tribe-events-venue-details">

							<span class="author fn org"><?php echo tribe_get_venue($event_ID); ?></span>, 

							<address class="tribe-events-address">
								<span class="adr">
									<span class="street-address"><?php echo tribe_get_address($event_ID); ?></span>
									<span class="delimiter">,</span>  
									<span class="locality"><?php echo tribe_get_city($event_ID); ?></span>
									<span class="delimiter">,</span>  
									<span class="postal-code"><?php echo tribe_get_zip($event_ID); ?></span> 
									<span class="country-name"><?php echo tribe_get_country($event_ID); ?></span>
								</span>
							</address>

							<?php printf('<a class="tribe-events-gmap" href="%s" title="Click to view a Google Map" target="_blank">- Google Map</a>', esc_url(tribe_get_map_link($event_ID))); ?>

						</div> <!-- .tribe-events-venue-details -->

					</div><!-- .tribe-events-event-meta -->

					
					
					<!-- Event Content -->
					<div class="tribe-events-list-event-description tribe-events-content description entry-summary">

						
						<?php 
							$event_excerpt = (!empty($event->post_excerpt)) ? do_shortcode($event->post_excerpt) : mb_make_excerpt($event->post_content, $excerpt_length, true);

							// excerpt
							echo "<p>";
							echo wp_kses_post($event_excerpt);
							echo "</p>";

							// read more
							printf('<a href="%s" class="tribe-events-read-more" rel="bookmark">%s &raquo;</a>', esc_url(tribe_get_event_link($event_ID)), esc_attr(__('Find out more', "loc_cookbook_widgets_plugin")) );

						?>


						
					</div><!-- .tribe-events-list-event-description -->
                 
                </div>

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



