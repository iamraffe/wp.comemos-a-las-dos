<?php

/**************************************
WIDGET: cookbook_vc_posts_listed
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_vc_posts_listed' );
	function register_widget_cookbook_vc_posts_listed () {
		register_widget('cookbook_vc_posts_listed');	
	}

	class cookbook_vc_posts_listed extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_vc_posts_listed', 								
					'description' => __('Displays a list of posts. Custom element for use with Visual Composer. May also be used as a widget. Please notice that this widget was designed with a specific layout in mind and may not look good in all possible layouts.', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'cookbook_vc_posts_listed' 														
				);

				parent::__construct('cookbook_vc_posts_listed', __('Cookbook VC: Posts Listed', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
				'title' 					=> __('Latest posts', "loc_cookbook_widgets_plugin"),
				'show'						=> "latest_posts",
				'offset'					=> 1,
				'num_posts_show'			=> 4,
				'meta'						=> 'date',
				'hide_rating'				=> 'unchecked',
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
					<label for="<?php echo esc_attr($this->get_field_id('show')); ?> "><?php _e("Get posts from", "loc_cookbook_widgets_plugin"); ?>:	 </label><br>
					<select id="<?php echo esc_attr($this->get_field_id('show')); ?>" name="<?php echo esc_attr($this->get_field_name('show')); ?>"> 
						<option value="latest_posts" <?php if (isset($show)) {if ($show == "latest_posts") echo "selected='selected'";} ?>><?php _e("Latest posts", "loc_cookbook_widgets_plugin"); ?>	</option> 
						<option value="popular_views" <?php if (isset($show)) {if ($show == "popular_views") echo "selected='selected'";} ?>><?php _e("Popular posts by views", "loc_cookbook_widgets_plugin"); ?>	</option> 
						<option value="popular_comments" <?php if (isset($show)) {if ($show == "popular_comments") echo "selected='selected'";} ?>><?php _e("Popular posts by comments", "loc_cookbook_widgets_plugin"); ?>	</option> 


						<option value=""><hr></option> 

						<?php 
							$categories = get_categories(array(
								'orderby' => 'name',
								'order' => 'ASC'
							));
							foreach ($categories as $single_category) {
							?>
								<option value="postcat_<?php echo esc_attr($single_category->slug); ?>" <?php if (isset($show)) {if ($show == "postcat_" . $single_category->slug) echo "selected='selected'";} ?>><?php echo esc_attr($single_category->name); ?> category</option> 
							<?php	     						
							}
						 ?>

					</select> 
				</p>

			<!-- NUMBER -->	
				<p>
					<label for='<?php echo esc_attr($this->get_field_id('offset')); ?>'><?php _e("Begin at post number", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='1'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('offset')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('offset')); ?>' 
						value='<?php if (isset($offset)) echo esc_attr($offset); ?>'
					>
				</p>

			<!-- NUMBER -->	
				<p>
					<label for='<?php echo esc_attr($this->get_field_id('num_posts_show')); ?>'><?php _e("Number of posts to show", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='1'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('num_posts_show')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('num_posts_show')); ?>' 
						value='<?php if (isset($num_posts_show)) echo esc_attr($num_posts_show); ?>'
					>
				</p>

			<!-- SELECT -->	
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('meta')); ?> "><?php _e("Meta", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<select id="<?php echo esc_attr($this->get_field_id('meta')); ?>" name="<?php echo esc_attr($this->get_field_name('meta')); ?>"> 
		     			<option value="date" <?php if (isset($meta)) {if ($meta == "date") echo "selected='selected'";} ?>><?php _e("Publish date", "loc_cookbook_widgets_plugin"); ?>	</option> 
		     			<option value="categories" <?php if (isset($meta)) {if ($meta == "categories") echo "selected='selected'";} ?>><?php _e("Categories", "loc_cookbook_widgets_plugin"); ?>	</option> 
					</select> 
				</p>

			<!-- CHECKBOX -->	
				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'hide_rating' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'hide_rating' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_rating' )); ?>" value="checked" <?php checked($hide_rating == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'hide_rating' )); ?>"><?php _e("Hide rating", "loc_cookbook_widgets_plugin"); ?></label>
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
				'num_posts_show'			=> 4,
				'meta'						=> 'date',
				'hide_rating'				=> 'unchecked',
			), $instance);

			extract($args);								
			extract($instance);							

 			// EMPTY WIDGET ID FAILSAIFE (WHEN WIDGET IS USED AS VC ELEMENT)
			if (!isset($widget_id)) { $widget_id = "cookbook_vc_posts_listed-" . uniqid(); }

			//  get options
			$canon_options_post = get_option('canon_options_post');

			// basic args
			$query_args = array();
			$query_args = array_merge($query_args, array(
				'post_type'    		=> 'post',
				'numberposts' 		=> $num_posts_show,
				'post_status'     	=> 'publish',
				'offset' 			=> $offset-1,
				'suppress_filters' 	=> false,
				'tax_query' => array(
					array(
						'taxonomy' 		=> 'post_format',
						'field'    		=> 'slug',
						'terms'    		=> array('post-format-quote', 'post-format-gallery'),
						'operator'		=> 'NOT IN',
					)
				),
			));

			if ($show == "latest_posts") {
				$query_args = array_merge($query_args, array(
					'category'			=> '',
					'orderby'			=> 'post_date',
					'order'				=> 'DESC',
				));
			} elseif ($show == "popular_views") {
				$query_args = array_merge($query_args, array(
					'category'			=> '',
					'meta_key'			=> 'post_views',
					'orderby'   		=> 'meta_value_num', //or 'meta_value_num'
					'order'				=> 'DESC',
					'exclude'			=> mb_get_exclude_string('cmb_hide_from_popular'),
				));
			} elseif ($show == "popular_comments") {
				$query_args = array_merge($query_args, array(
					'category'			=> '',
					'orderby'			=> 'comment_count',
					'order'				=> 'DESC',
					'exclude'			=> mb_get_exclude_string('cmb_hide_from_popular'),
				));
			} elseif (strpos($show, "postcat_") !== false) {
				$show = str_replace("postcat_", "", $show);
				$query_args = array_merge($query_args, array(
					'category_name'		=> $show,
					'orderby'			=> 'post_date',
					'order'				=> 'DESC',
				));
			}

			// final query
			$results_query = get_posts($query_args);
			
            // WPML (ONLY IF WIDGET)
			if (isset($widget_id)) { $title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance ); }

			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php if (!empty($title)) { echo wp_kses_post($before_title . $title . $after_title); } ?>


				<!-- POSTS -->
				<ul class="thumb-list">

					<?php 

						// POSTS LOOP
						for ($i = 0; $i < count($results_query); $i++) {

							$this_post = $results_query[$i];

							$post_format = get_post_format();
							$has_feature = mb_has_feature($this_post->ID);
							$cmb_post_ratings_overall_score = get_post_meta($this_post->ID, 'cmb_post_ratings_overall_score', true);

							?>


							<li <?php post_class("", $this_post->ID); ?>>

								<?php 

									// FEATURED IMAGE
									if (has_post_thumbnail($this_post->ID) && get_post(get_post_thumbnail_id($this_post->ID)) ) { 

			                            $cmb_post_show_ratings = get_post_meta($this_post->ID, 'cmb_post_show_ratings', true);
			                            $cmb_post_ratings_overall_score = get_post_meta($this_post->ID, 'cmb_post_ratings_overall_score', true);

										$post_thumbnail_src_fit = wp_get_attachment_image_src(get_post_thumbnail_id($this_post->ID), 'small_square_thumb');
										$img_alt = get_post_meta(get_post_thumbnail_id($this_post->ID), '_wp_attachment_image_alt', true);
										$img_post = get_post(get_post_thumbnail_id($this_post->ID));

										echo '<div class="rate-container">';
	                                    if ( $hide_rating != "checked" && $cmb_post_show_ratings == "checked" && !empty($cmb_post_ratings_overall_score) ) { printf('<div class="rate-tab rate-small feat-block-1"><strong>%s</strong></div>', esc_attr($cmb_post_ratings_overall_score)); }
										printf('<a href="%s"><img src="%s" alt="%s" /></a>', get_the_permalink($this_post->ID), esc_url($post_thumbnail_src_fit[0]), esc_attr($img_alt));
										echo '</div>';

									}

									if ($meta == "date") {

										// META DATE
		                                $archive_year  = get_the_time('Y', $this_post->ID); 
		                                $archive_month = get_the_time('m', $this_post->ID); 
		                                $archive_day   = get_the_time('d', $this_post->ID);                             

		                                if ($canon_options_post['show_meta_date'] == "checked") { printf('<h6 class="meta feat-1"><a href="%s">%s</a></h6>', esc_url(get_day_link( $archive_year, $archive_month, $archive_day)), esc_attr(mb_localize_datetime(get_the_time(get_option('date_format'), $this_post->ID)))); } 

											
									} else {
											
										// CATEGORIES
										$cat_string = mb_get_cat_string($this_post->ID, " | ");
										printf('<div class="meta feat-1"><h6>%s</h6></div>', wp_kses_post($cat_string));

									}


									// TITLE
									printf('<a href="%s" class="title"><h3 class="title">%s</h3></a>', esc_url(get_the_permalink($this_post->ID)), esc_attr(get_the_title($this_post->ID)));
								?>

							</li>


							<?php

						}

					?>

				</ul>

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



