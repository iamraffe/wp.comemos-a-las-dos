<?php

/**************************************
WIDGET: cookbook_vc_posts_carousel
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_vc_posts_carousel' );
	function register_widget_cookbook_vc_posts_carousel () {
		register_widget('cookbook_vc_posts_carousel');	
	}

	class cookbook_vc_posts_carousel extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_vc_posts_carousel', 								
					'description' => __('Displays a post carousel. Custom element for use with Visual Composer. May also be used as a widget. Please notice that this widget was designed with a specific layout in mind and may not look good in all possible layouts.', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'cookbook_vc_posts_carousel' 														
				);

				parent::__construct('cookbook_vc_posts_carousel', __('Cookbook VC: Posts Carousel', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
				'title' 				 	=> "",
				'show'						=> "latest_posts",
				'offset'					=> 1,
				'num_posts_load'			=> 10,
				'num_posts_show'			=> 4,
				'meta'						=> 'categories',
				'excerpt_length'			=> 360,

				'use_title_caption'			=> 'unchecked',
				'hide_featured_media'		=> 'unchecked',
				'hide_comments_count'		=> 'unchecked',
				'hide_rating'				=> 'unchecked',
				'hide_meta'					=> 'unchecked',
				'hide_title'				=> 'unchecked',
				'hide_excerpt'				=> 'unchecked',
				'hide_pagination'			=> 'unchecked',

				'slide_speed'				=> 200,
				'autoplay_speed'			=> 0,
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>

			<!-- TEXT -->	
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title (Optional)", "loc_cookbook_widgets_plugin"); ?>: </label><br>
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
					<label for='<?php echo esc_attr($this->get_field_id('num_posts_load')); ?>'><?php _e("Number of posts to load", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='1'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('num_posts_load')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('num_posts_load')); ?>' 
						value='<?php if (isset($num_posts_load)) echo esc_attr($num_posts_load); ?>'
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


			<!-- NUMBER -->	
				<p>
					<label for='<?php echo esc_attr($this->get_field_id('excerpt_length')); ?>'><?php _e("Excerpt length", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='1'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('excerpt_length')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('excerpt_length')); ?>' 
						value='<?php if (isset($excerpt_length)) echo esc_attr($excerpt_length); ?>'
					>
				</p>

			<!-- CHECKBOX -->	
				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'use_title_caption' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'use_title_caption' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'use_title_caption' )); ?>" value="checked" <?php checked($use_title_caption == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'use_title_caption' )); ?>"><?php _e("Use category and title as image caption", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

			<!-- CHECKBOX -->	
				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'hide_featured_media' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'hide_featured_media' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_featured_media' )); ?>" value="checked" <?php checked($hide_featured_media == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'hide_featured_media' )); ?>"><?php _e("Hide featured media", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

			<!-- CHECKBOX -->	
				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'hide_comments_count' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'hide_comments_count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_comments_count' )); ?>" value="checked" <?php checked($hide_comments_count == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'hide_comments_count' )); ?>"><?php _e("Hide comments count", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

			<!-- CHECKBOX -->	
				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'hide_rating' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'hide_rating' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_rating' )); ?>" value="checked" <?php checked($hide_rating == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'hide_rating' )); ?>"><?php _e("Hide rating", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

			<!-- CHECKBOX -->	
				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'hide_meta' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'hide_meta' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_meta' )); ?>" value="checked" <?php checked($hide_meta == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'hide_meta' )); ?>"><?php _e("Hide categories", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

			<!-- CHECKBOX -->	
				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'hide_title' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'hide_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_title' )); ?>" value="checked" <?php checked($hide_title == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'hide_title' )); ?>"><?php _e("Hide title", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

			<!-- CHECKBOX -->	
				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'hide_excerpt' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'hide_excerpt' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_excerpt' )); ?>" value="checked" <?php checked($hide_excerpt == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'hide_excerpt' )); ?>"><?php _e("Hide excerpt", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

			<!-- CHECKBOX -->	
				<p>
					<input type="hidden" name="<?php echo esc_attr($this->get_field_name( 'hide_pagination' )); ?>" value="unchecked" />
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'hide_pagination' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_pagination' )); ?>" value="checked" <?php checked($hide_pagination == "checked"); ?>/> 
					<label for="<?php echo esc_attr($this->get_field_id( 'hide_pagination' )); ?>"><?php _e("Hide carousel pagination", "loc_cookbook_widgets_plugin"); ?></label>
				</p>

				<hr>

			<!-- NUMBER -->	
				<p>
					<label for='<?php echo esc_attr($this->get_field_id('slide_speed')); ?>'><?php _e("Slide speed (ms)", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='1'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('slide_speed')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('slide_speed')); ?>' 
						value='<?php if (isset($slide_speed)) echo esc_attr($slide_speed); ?>'
					>
				</p>

			<!-- NUMBER -->	
				<p>
					<label for='<?php echo esc_attr($this->get_field_id('autoplay_speed')); ?>'><?php _e("Autoplay speed (ms) (0 is off)", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='0'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('autoplay_speed')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('autoplay_speed')); ?>' 
						value='<?php if (isset($autoplay_speed)) echo esc_attr($autoplay_speed); ?>'
					>
				</p>


			<?php
		}

		/**************************************
		4. DISPLAY
		***************************************/
		function widget($args, $instance) {

			// DEFAULTS
			$instance = array_merge(array(
				'title' 				 	=> "",
				'show'						=> "latest_posts",
				'offset'					=> 1,
				'num_posts_load'			=> 10,
				'num_posts_show'			=> 4,
				'meta'						=> 'categories',
				'excerpt_length'			=> 360,

				'use_title_caption'			=> 'unchecked',
				'hide_featured_media'		=> 'unchecked',
				'hide_comments_count'		=> 'unchecked',
				'hide_rating'				=> 'unchecked',
				'hide_meta'					=> 'unchecked',
				'hide_title'				=> 'unchecked',
				'hide_excerpt'				=> 'unchecked',
				'hide_pagination'			=> 'unchecked',

				'slide_speed'				=> 200,
				'autoplay_speed'			=> 0,
			), $instance);

			extract($args);								
			extract($instance);

			//  get options
			$canon_options_post = get_option('canon_options_post');

			// basic args
			$query_args = array();
			$query_args = array_merge($query_args, array(
				'post_type'    		=> 'post',
				'numberposts' 		=> $num_posts_load,
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

    			<!-- Start Carousel Block -->
    			<div class="owl-carousel-container">

	    			<!-- Carousel Nav -->
	    			<div class="customNavigation">
	    			    <a class="prev"><i class="fa fa-angle-left"></i></a>
	    			    <a class="next"><i class="fa fa-angle-right"></i></a>
	    			</div>
    			
    			
	    			<!-- The Carousel -->
	    			<div 
	    				class="owl-carousel canon-posts-carousel"
	    				data-display_num_posts = "<?php echo esc_attr($num_posts_show); ?>"
	    				data-slide_speed = "<?php echo esc_attr($slide_speed); ?>"
	    				data-autoplay_speed = "<?php echo esc_attr($autoplay_speed); ?>"
	    				data-stop_on_hover = "checked"
	    				data-hide_pagination = "<?php echo esc_attr($hide_pagination); ?>"
	    			>


					<?php

						// IF NO POSTS
						if (empty($results_query)) { printf('<div class="no-post">%s</div>', _e("Sorry, no posts matched your query!", "loc_cookbook_widgets_plugin")); }

						// POSTS LOOP
						for ($i = 0; $i < count($results_query); $i++) {

							$this_post = $results_query[$i];

							$post_format = get_post_format();
							$cmb_feature = get_post_meta($this_post->ID, 'cmb_feature', true);
							$cmb_media_link = get_post_meta($this_post->ID, 'cmb_media_link', true);
							$cmb_post_show_ratings = get_post_meta($this_post->ID, 'cmb_post_show_ratings', true);
							$cmb_post_ratings_overall_score = get_post_meta($this_post->ID, 'cmb_post_ratings_overall_score', true);
							$has_feature = mb_has_feature($this_post->ID);

							$cat_string = mb_get_cat_string($this_post->ID, " | ");


							?>
			
								<!-- SINGLE POST-->
								<div 
									<?php post_class('full', $this_post->ID); ?>
									data-post_ID="<?php echo esc_attr($this_post->ID); ?>" 
									data-nonce="<?php echo wp_create_nonce('like_post_' . $this_post->ID); ?>"
								>

									<!-- FEATURED MEDIA-->
									<?php if ($has_feature && $hide_featured_media != "checked") : ?>

										<div class="rate-container">

											<!-- META: COMMENTS -->
											<?php if ($hide_comments_count != "checked") { printf('<div class="comment-num"><a href="%s#comments">%s</a></div>', get_the_permalink($this_post->ID), esc_attr(get_comments_number($this_post->ID))); } ?>

											<div class="feat-title-container">

												<!-- RATING -->
												<?php if ( $cmb_post_show_ratings == "checked" && !empty($cmb_post_ratings_overall_score) && $hide_rating != "checked") { printf('<div class="rate-tab rate-big feat-block-1"><strong>%s</strong><i>%s</i></div>', esc_attr($cmb_post_ratings_overall_score), __('Score', 'loc_cookbook_widgets_plugin')); } ?>

												
												<?php if ( ($hide_meta != "checked" || $hide_title != "checked") && ($use_title_caption == "checked") ) : ?>

													<div class="feat-title">

														<!-- META -->
														<?php

															if ($hide_meta != "checked") {
																	
																if ($meta == "date") {

																	// META DATE
									                                $archive_year  = get_the_time('Y', $this_post->ID); 
									                                $archive_month = get_the_time('m', $this_post->ID); 
									                                $archive_day   = get_the_time('d', $this_post->ID);                             

									                                if ($canon_options_post['show_meta_date'] == "checked") { printf('<h6 class="meta feat-1"><a href="%s">%s</a></h6>', esc_url(get_day_link( $archive_year, $archive_month, $archive_day)), esc_attr(mb_localize_datetime(get_the_time(get_option('date_format'), $this_post->ID)))); } 

																		
																} else {
																		
																	// CATEGORIES
																	$cat_string = mb_get_cat_string($this_post->ID, " | ");
																	printf('<div class="meta feat-1"><h6>%s</h6></div>', $cat_string);

																}
															}

														 ?>

														<!-- TITLE -->
														<?php if ($hide_title != "checked") { printf('<a href="%s"><h2>%s</h2></a>', esc_url(get_the_permalink($this_post->ID)), esc_attr($this_post->post_title)); } ?>
													</div>

												<?php endif; ?>

											</div>

											<!-- FEATURED MEDIA -->
											<?php 

												if ( ($cmb_feature == "media") && (!empty($cmb_media_link)) ) {
													echo "<div class='featured_media'>";
													output_cmb_media_link($cmb_media_link);
													echo "</div>";
												} else {
													// $post_thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($this_post->ID),'full');
													$post_thumbnail_src_fit = wp_get_attachment_image_src(get_post_thumbnail_id($this_post->ID), 'full');
													$img_alt = get_post_meta(get_post_thumbnail_id($this_post->ID), '_wp_attachment_image_alt', true);
													$img_post = get_post(get_post_thumbnail_id($this_post->ID));

													if ( ($cmb_feature == "media_in_lightbox") && (!empty($cmb_media_link)) && get_post(get_post_thumbnail_id($this_post->ID)) ) {

														echo "<div class='featured_media'>";
														echo '<div class="mosaic-block circle">';
														printf('<a href="%s" class="mosaic-overlay fancybox-media fancybox.iframe play"></a>', esc_url($cmb_media_link));
														printf('<div class="mosaic-backdrop"><img src="%s" alt="%s" /></div>', esc_url($post_thumbnail_src_fit[0]), esc_attr($img_alt));
														echo "</div>";
														echo '</div>';
													
													} elseif (has_post_thumbnail($this_post->ID) && get_post(get_post_thumbnail_id($this_post->ID)) ) { 

														echo "<div class='featured-media'>";
														echo '<div class="mosaic-block circle">';
														printf('<a href="%s" class="mosaic-overlay link" title="%s"></a>', esc_url(get_permalink($this_post->ID)), esc_attr($img_post->post_title));
														printf('<div class="mosaic-backdrop"><img src="%s" alt="%s" /></div>', esc_url($post_thumbnail_src_fit[0]), esc_attr($img_alt));
														echo "</div>";
														echo '</div>';

													}
												}

											?>

										</div>

									<?php endif; ?>

												
									<?php if ( ($hide_meta != "checked" || $hide_title != "checked") && ($use_title_caption != "checked") ) : ?>

										<div class="post-title">

										<!-- META -->
											<?php

												if ($hide_meta != "checked") {
														
													if ($meta == "date") {

														// META DATE
						                                $archive_year  = get_the_time('Y', $this_post->ID); 
						                                $archive_month = get_the_time('m', $this_post->ID); 
						                                $archive_day   = get_the_time('d', $this_post->ID);                             

						                                if ($canon_options_post['show_meta_date'] == "checked") { printf('<h6 class="meta feat-1"><a href="%s">%s</a></h6>', esc_url(get_day_link( $archive_year, $archive_month, $archive_day)), esc_attr(mb_localize_datetime(get_the_time(get_option('date_format'), $this_post->ID)))); } 

															
													} else {
															
														// CATEGORIES
														$cat_string = mb_get_cat_string($this_post->ID, " | ");
														printf('<div class="meta feat-1"><h6>%s</h6></div>', $cat_string);

													}
												}

											 ?>

											<?php if ($hide_title != "checked") { printf('<a href="%s"><h2>%s</h2></a>', esc_url(get_the_permalink($this_post->ID)), esc_attr($this_post->post_title)); } ?>
										</div>

									<?php endif; ?>

									<!-- EXCERPT -->
									<?php if ($hide_excerpt != "checked") { printf('<div class="excerpt">%s</div>', mb_get_excerpt( $this_post->ID, $excerpt_length)); } ?>

								</div>

						

							<?php 
						}

					?>


	
	    			</div>
	    			<!-- end carousel -->
	    			  
				<!-- End Carousel container -->
    			</div>
			

			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



