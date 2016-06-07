<?php

/**************************************
WIDGET: cookbook_tabs
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_tabs' );
	function register_widget_cookbook_tabs () {
		register_widget('cookbook_tabs');	
	}

	class cookbook_tabs extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_tabs', 								
					'description' => __('Displays tabs with popular posts, comments and tags.', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'cookbook_tabs' 														
				);

				parent::__construct('cookbook_tabs', __('Cookbook: Tabs', "loc_cookbook_widgets_plugin"), $widget_ops, $control_ops );	
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
				'title' 		=> __('Trending', "loc_cookbook_widgets_plugin"),
				'default_tab' 	=> 'popular',
				'popular_by' 	=> 'views',
				'num_popular' 	=> 5,
				'num_comments' 	=> 3,
				'num_tags' 		=> 20,
				'tags_smallest' => 14,
				'tags_largest' 	=> 40,
			
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>

			<!-- TEXT -->	
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title (Optional)", "loc_cookbook_widgets_plugin"); ?>: </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('title')); ?>' name='<?php echo esc_attr($this->get_field_name('title')); ?>' value="<?php if(isset($title)) echo htmlspecialchars($title); ?>">
				</p>

			<!-- SELECT -->	
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('default_tab')); ?> "><?php _e("Default tab", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<select id="<?php echo esc_attr($this->get_field_id('default_tab')); ?>" name="<?php echo esc_attr($this->get_field_name('default_tab')); ?>"> 
		     			<option value="popular" <?php if (isset($default_tab)) {if ($default_tab == "popular") echo "selected='selected'";} ?>><?php _e("Popular", "loc_cookbook_widgets_plugin"); ?>	</option> 
		     			<option value="comments" <?php if (isset($default_tab)) {if ($default_tab == "comments") echo "selected='selected'";} ?>><?php _e("Comments", "loc_cookbook_widgets_plugin"); ?>	</option> 
		     			<option value="tags" <?php if (isset($default_tab)) {if ($default_tab == "tags") echo "selected='selected'";} ?>><?php _e("Tags", "loc_cookbook_widgets_plugin"); ?>	</option> 
					</select> 
				</p>

			<!-- SELECT -->	
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('popular_by')); ?> "><?php _e("Show popular by", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<select id="<?php echo esc_attr($this->get_field_id('popular_by')); ?>" name="<?php echo esc_attr($this->get_field_name('popular_by')); ?>"> 
		     			<option value="views" <?php if (isset($popular_by)) {if ($popular_by == "views") echo "selected='selected'";} ?>><?php _e("Number of views", "loc_cookbook_widgets_plugin"); ?>	</option> 
		     			<option value="comments" <?php if (isset($popular_by)) {if ($popular_by == "comments") echo "selected='selected'";} ?>><?php _e("Number of comments", "loc_cookbook_widgets_plugin"); ?>	</option> 
					</select> 
				</p>

			<!-- NUMBER -->	
				<p>
					<label for='<?php echo esc_attr($this->get_field_id('num_popular')); ?>'><?php _e("Number of popular posts to show", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='0'
						max='1000'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('num_popular')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('num_popular')); ?>' 
						value='<?php if (isset($num_popular)) echo esc_attr($num_popular); ?>'
					>
				</p>

			<!-- NUMBER -->	
				<p>
					<label for='<?php echo esc_attr($this->get_field_id('num_comments')); ?>'><?php _e("Number of comments to show", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='0'
						max='1000'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('num_comments')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('num_comments')); ?>' 
						value='<?php if (isset($num_comments)) echo esc_attr($num_comments); ?>'
					>
				</p>

			<!-- NUMBER -->	
				<p>
					<label for='<?php echo esc_attr($this->get_field_id('num_tags')); ?>'><?php _e("Number of tags to show", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='0'
						max='1000'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('num_tags')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('num_tags')); ?>' 
						value='<?php if (isset($num_tags)) echo esc_attr($num_tags); ?>'
					>
				</p>

			<!-- NUMBER -->	
				<p>
					<label for='<?php echo esc_attr($this->get_field_id('tags_smallest')); ?>'><?php _e("Tag cloud smallest font size (pixels)", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='0'
						max='1000'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('tags_smallest')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('tags_smallest')); ?>' 
						value='<?php if (isset($tags_smallest)) echo esc_attr($tags_smallest); ?>'
					>
				</p>

			<!-- NUMBER -->	
				<p>
					<label for='<?php echo esc_attr($this->get_field_id('tags_largest')); ?>'><?php _e("Tag cloud largest font size (pixels)", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 80px;'
						type='number' 
						min='0'
						max='1000'
						step='1'
						id='<?php echo esc_attr($this->get_field_id('tags_largest')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('tags_largest')); ?>' 
						value='<?php if (isset($tags_largest)) echo esc_attr($tags_largest); ?>'
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
				'title' 		=> __('Trending', "loc_cookbook_widgets_plugin"),
				'default_tab' 	=> 'popular',
				'popular_by' 	=> 'views',
				'num_popular' 	=> 5,
				'num_comments' 	=> 3,
				'num_tags' 		=> 20,
				'tags_smallest' => 14,
				'tags_largest' 	=> 40,
			), $instance);

			// EXTRACTION
			extract($args);
			extract($instance);	

			//build exclude string
			$exclude_string = "";
			$results_exclude_posts = get_posts(array(
				'numberposts'		=> -1,
        		'meta_key'          => 'cmb_hide_from_popular',
				'meta_value'		=> 'checked',
				'orderby'			=> 'post_date',
				'order'				=> 'DESC',
				'post_type'			=> 'any',
			));
			if (count($results_exclude_posts) > 0) {
				$exclude_string = "";
				for ($i = 0; $i < count($results_exclude_posts); $i++) {  
					$exclude_string .= $results_exclude_posts[$i]->ID . ",";
				}	
				$exclude_string = substr($exclude_string, 0, strlen($exclude_string)-1);
			} 

			//basic args
			$query_args = array();
			$query_args = array_merge($query_args, array(
				'post_type'    		=> 'post',
				'numberposts' 		=> $num_popular*10,
				'post_status'     	=> 'publish',
				'offset' 			=> 0,
				'suppress_filters' 	=> false
			));

			if ($popular_by == "views") {
				$query_args = array_merge($query_args, array(
					'category'			=> '',
					'meta_key'			=> 'post_views',
            		'orderby'   		=> 'meta_value_num', //or 'meta_value_num'
					'order'				=> 'DESC',
					'exclude'			=> $exclude_string,
				));
			} else {
				$query_args = array_merge($query_args, array(
					'category'			=> '',
					'orderby'			=> 'comment_count',
					'order'				=> 'DESC',
					'exclude'			=> $exclude_string,
				));
			} 

			//final query
			$results_popular = get_posts($query_args);

			//if less posts in query set num_popular to num query posts
			if (count($results_popular) < $num_popular) $num_popular = count($results_popular);

            // WPML
			$title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );

            // VARS
            $uniqid = uniqid();

			?>

			<?php echo wp_kses_post($before_widget); ?>

			<?php if (!empty($title)) { echo wp_kses_post($before_title . $title . $after_title); } ?>


				<div id="<?php echo esc_attr($uniqid); ?>" class="canon-cleanTabs-container tab-container">

					<ul class="tab-nav">

						<li data-tab="<?php echo esc_attr($uniqid); ?>-tab-popular" <?php if ($default_tab == 'popular') { echo 'class="active"'; } ?>><?php _e("Popular", "loc_cookbook_widgets_plugin"); ?></li>
						<li data-tab="<?php echo esc_attr($uniqid); ?>-tab-comments" <?php if ($default_tab == 'comments') { echo 'class="active"'; } ?>><?php _e("Comments", "loc_cookbook_widgets_plugin"); ?></li>
						<li data-tab="<?php echo esc_attr($uniqid); ?>-tab-tags" <?php if ($default_tab == 'tags') { echo 'class="active"'; } ?>><?php _e("Tags", "loc_cookbook_widgets_plugin"); ?></li>

					</ul>
		
					<div class="tab-contents">

					<!-- POPULAR POSTS -->
						<h3 class="v_nav <?php if ($default_tab == 'popular') { echo "v_active"; } ?>" data-tab="<?php echo esc_attr($uniqid); ?>-tab-popular"><?php _e("Popular", "loc_cookbook_widgets_plugin"); ?></h3>
						<div id="<?php echo esc_attr($uniqid); ?>-tab-popular" class="tab_content tabs-lists">


							<ul class="thumb-list">

							<?php
								
								$post_counter = 0;
								for ($i = 0; $i < count($results_popular); $i++) {  

									if ($post_counter < $num_popular) {

										$this_post = $results_popular[$i];

										$post_format = get_post_format();
										$has_feature = mb_has_feature($this_post->ID);
										$cmb_post_ratings_overall_score = get_post_meta($this_post->ID, 'cmb_post_ratings_overall_score', true);

										?>


										<li id="post-<?php echo esc_attr($this_post->ID); ?>" <?php post_class('', $this_post->ID); ?>>

											<?php 

												// FEATURED IMAGE
												if (has_post_thumbnail($this_post->ID) && get_post(get_post_thumbnail_id($this_post->ID)) ) { 

						                            $cmb_post_show_ratings = get_post_meta($this_post->ID, 'cmb_post_show_ratings', true);
						                            $cmb_post_ratings_overall_score = get_post_meta($this_post->ID, 'cmb_post_ratings_overall_score', true);

													$post_thumbnail_src_fit = wp_get_attachment_image_src(get_post_thumbnail_id($this_post->ID), 'small_square_thumb');
													$img_alt = get_post_meta(get_post_thumbnail_id($this_post->ID), '_wp_attachment_image_alt', true);
													$img_post = get_post(get_post_thumbnail_id($this_post->ID));

													echo '<div class="rate-container">';
	                                    			if ( $cmb_post_show_ratings == "checked" && !empty($cmb_post_ratings_overall_score) ) { printf('<div class="rate-tab rate-small feat-block-1"><strong>%s</strong></div>', esc_attr($cmb_post_ratings_overall_score)); }
													printf('<a href="%s"><img src="%s" alt="%s" /></a>', get_the_permalink($this_post->ID), esc_url($post_thumbnail_src_fit[0]), esc_attr($img_alt));
													echo '</div>';

												}
													
												// CATEGORIES
												$cat_string = mb_get_cat_string($this_post->ID, " | ");
												printf('<div class="meta feat-1"><h6>%s</h6></div>', $cat_string);

												// TITLE
												printf('<a href="%s" class="title"><h3 class="title">%s</h3></a>', get_the_permalink($this_post->ID), esc_attr(get_the_title($this_post->ID)));
											?>

										</li>


										<?php

										$post_counter++;
									}

								}	
							
							?>

							</ul>

						</div>
		
					<!-- COMMENTS -->
						<h3 class="v_nav <?php if ($default_tab == 'comments') { echo "v_active"; } ?>" data-tab="<?php echo esc_attr($uniqid); ?>-tab-comments"><?php _e("Comments", "loc_cookbook_widgets_plugin"); ?></h3>
						<div id="<?php echo esc_attr($uniqid); ?>-tab-comments" class="tab_content tabs-comments">

							<ul class="wiget-comment-list">

								<?php
									
									$results_comments = get_comments(array(
										'number'			=> $num_comments,
										'orderby'			=> 'comment_date',
										'order'				=> 'DESC',
										'status'			=> 'approve'
									));

									for ($i = 0; $i < count($results_comments); $i++) {

										$this_comment = $results_comments[$i];
										$assoc_post = get_post($this_comment->comment_post_ID);
									?>
										
										<li>
											<a href="<?php echo get_permalink($assoc_post->ID); ?>#comments"><?php echo mb_make_excerpt($this_comment->comment_content, 70, true); ?>
											<h6 class="meta"><?php echo esc_attr($this_comment->comment_author); ?></h6>
											</a>
										</li>
								

									<?php
									}

								?>

							</ul>

						</div>
						
					<!-- TAGS -->
						<h3 class="v_nav <?php if ($default_tab == 'tags') { echo "v_active"; } ?>" data-tab="<?php echo esc_attr($uniqid); ?>-tab-tags"><?php _e("Tags", "loc_cookbook_widgets_plugin"); ?></h3>
						<div id="<?php echo esc_attr($uniqid); ?>-tab-tags" class="tab_content tabs-tags">

							<?php
								
								wp_tag_cloud(array(
									'smallest'                  => $tags_smallest,     
									'largest'                   => $tags_largest,    
									'unit'                      => 'px',     
									'number'                    => $num_tags,      
									'format'                    => 'flat',    
									'orderby'                   => 'name',     
									'order'                     => 'ASC',    
									'exclude'                   => null,     
									'include'                   => null,     
									'link'                      => 'view',     
									'taxonomy'                  => 'post_tag',     
									'echo'                      => true
								));
							
							?>

						</div>
					</div>
				</div>


			<?php echo wp_kses_post($after_widget); ?>


			<?php
		}

	} //END CLASS



