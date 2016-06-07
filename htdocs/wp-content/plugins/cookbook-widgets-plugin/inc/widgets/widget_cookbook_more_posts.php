<?php

/**************************************
WIDGET: cookbook_more_posts
***************************************/

	add_action('widgets_init', 'register_widget_cookbook_more_posts' );
	function register_widget_cookbook_more_posts () {
		register_widget('cookbook_more_posts');	
	}

	class cookbook_more_posts extends WP_Widget {

		/**************************************
		1. INIT
		***************************************/
		function __construct () {

				$widget_ops = array(
					'classname' => 'cookbook_more_posts', 								
					'description' => __('Display more posts', "loc_cookbook_widgets_plugin")	 				
				);
				$control_ops = array(
					'width' => 300, 
					'height' => 350, 
					'id_base' => 'cookbook_more_posts' 														
				);

				parent::__construct('cookbook_more_posts',__('Cookbook: More Posts', "loc_cookbook_widgets_plugin")	, $widget_ops, $control_ops );	
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
				'title' 			=> __('More posts', "loc_cookbook_widgets_plugin")	,
				'posts_from' 		=> 'latest_posts', 
				'display_style'		=> 'images_to_posts', 
				'num_posts' 		=> 4,
				'num_columns' 		=> 2,
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title')); ?> "><?php _e("Title", "loc_cookbook_widgets_plugin"); ?>:	 </label><br>
					<input type='text' id='<?php echo esc_attr($this->get_field_id('title')); ?>' name='<?php echo esc_attr($this->get_field_name('title')); ?>' value="<?php if(isset($title)) echo htmlspecialchars($title); ?>">
				</p>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('posts_from')); ?> "><?php _e("What to show", "loc_cookbook_widgets_plugin"); ?>:	 </label><br>
					<select id="<?php echo esc_attr($this->get_field_id('posts_from')); ?>" name="<?php echo esc_attr($this->get_field_name('posts_from')); ?>"> 
		     			<option value="latest_posts" <?php if (isset($posts_from)) {if ($posts_from == "latest_posts") echo "selected='selected'";} ?>><?php _e("Latest posts", "loc_cookbook_widgets_plugin"); ?>	</option> 
	 					<option value="random_posts" <?php if (isset($posts_from)) {if ($posts_from == "random_posts") echo "selected='selected'";} ?>><?php _e("Random posts", "loc_cookbook_widgets_plugin"); ?>	</option> 
		     			
		     			<option value=""><hr></option> 

		     			<option value="popular_views" <?php if (isset($posts_from)) {if ($posts_from == "popular_views") echo "selected='selected'";} ?>><?php _e("Popular posts by views", "loc_cookbook_widgets_plugin"); ?>	</option> 
	 					<option value="popular_comments" <?php if (isset($posts_from)) {if ($posts_from == "popular_comments") echo "selected='selected'";} ?>><?php _e("Popular posts by comments", "loc_cookbook_widgets_plugin"); ?>	</option> 


		     			<option value=""><hr></option> 

		     			<?php 
		     				$categories = get_categories(array(
		     					'orderby' => 'name',
		     					'order' => 'ASC'
		     				));
		     				foreach ($categories as $single_category) {
		     				?>
		     					<option value="postcat_<?php echo esc_attr($single_category->slug); ?>" <?php if (isset($posts_from)) {if ($posts_from == "postcat_" . $single_category->slug) echo "selected='selected'";} ?>><?php echo esc_attr($single_category->name); ?> category</option> 
		     				<?php	     						
		     				}
		     			 ?>

					</select> 
				</p>

				<p>
					<label for="<?php echo esc_attr($this->get_field_id('display_style')); ?> "><?php _e("Display style", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<select id="<?php echo esc_attr($this->get_field_id('display_style')); ?>" name="<?php echo esc_attr($this->get_field_name('display_style')); ?>"> 
		     			<option value="images_to_posts" <?php if (isset($display_style)) {if ($display_style == "images_to_posts") echo "selected='selected'";} ?>><?php _e("Images linking to posts", "loc_cookbook_widgets_plugin"); ?>	</option> 
		     			<option value="images_to_lightbox" <?php if (isset($display_style)) {if ($display_style == "images_to_lightbox") echo "selected='selected'";} ?>><?php _e("Images linking to lightbox", "loc_cookbook_widgets_plugin"); ?>	</option> 
	 					<option value="text" <?php if (isset($display_style)) {if ($display_style == "text") echo "selected='selected'";} ?>><?php _e("Text", "loc_cookbook_widgets_plugin"); ?>	</option> 
					</select> 
				</p>

				<p>
					<label for='<?php echo esc_attr($this->get_field_id('num_posts')); ?>'><?php _e("Number of posts", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 40px;'
						type='number' 
						min='1'
						max='100'
						id='<?php echo esc_attr($this->get_field_id('num_posts')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('num_posts')); ?>' 
						value='<?php if (isset($num_posts)) echo esc_attr($num_posts); ?>'
					>
				</p>

				<p>
					<label for='<?php echo esc_attr($this->get_field_id('num_columns')); ?>'><?php _e("Number of image columns", "loc_cookbook_widgets_plugin"); ?>	: </label><br>
					<input 
						style='width: 40px;'
						type='number' 
						min='1'
						max='5'
						id='<?php echo esc_attr($this->get_field_id('num_columns')); ?>' 
						name='<?php echo esc_attr($this->get_field_name('num_columns')); ?>' 
						value='<?php if (isset($num_columns)) echo esc_attr($num_columns); ?>'
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
				$title 				= __('More posts', "loc_cookbook_widgets_plugin");
				$posts_from			= 'latest_posts'; 
				$display_style 		= 'images_to_posts'; 
				$num_posts 			= 4;
				$num_columns 		= 2;
			}

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
				'numberposts' 		=> $num_posts*10,
				'post_status'     	=> 'publish',
				'offset' 			=> 0,
				'suppress_filters' 	=> false
			));

			if ($posts_from == "latest_posts") {
				$query_args = array_merge($query_args, array(
					'category'			=> '',
					'orderby'			=> 'post_date',
					'order'				=> 'DESC',
				));
			} elseif ($posts_from == "random_posts") {
				$query_args = array_merge($query_args, array(
					'category'			=> '',
					'orderby'			=> 'rand',
				));
			} elseif ($posts_from == "popular_views") {
				$query_args = array_merge($query_args, array(
					'category'			=> '',
					'meta_key'			=> 'post_views',
            		'orderby'   		=> 'meta_value_num', //or 'meta_value_num'
					'order'				=> 'DESC',
					'exclude'			=> $exclude_string,
				));
			} elseif ($posts_from == "popular_comments") {
				$query_args = array_merge($query_args, array(
					'category'			=> '',
					'orderby'			=> 'comment_count',
					'order'				=> 'DESC',
					'exclude'			=> $exclude_string,
				));
			} elseif (strpos($posts_from, "postcat_") !== false) {
				$posts_from = str_replace("postcat_", "", $posts_from);
				$query_args = array_merge($query_args, array(
					'category_name'		=> $posts_from,
					'orderby'			=> 'post_date',
					'order'				=> 'DESC',
				));
			}

			//final query
			$results_query = get_posts($query_args);

			//if less posts in query set num_posts to num query posts
			if (count($results_query) < $num_posts) $num_posts = count($results_query);

            // WPML
			$title = apply_filters('widget_title', empty($instance['title']) ? $title : $instance['title'], $instance );


			?>

			<?php echo wp_kses_post($before_widget); ?>
			<?php echo wp_kses_post($before_title . $title . $after_title); ?> 

			<div class="clearfix">

				<?php 

					if ($display_style == "images_to_posts" || $display_style == "images_to_lightbox") {



	                	$post_counter = 0;
						for ($i = 0; $i < count($results_query); $i++) { 
							if ($post_counter < $num_posts) {

								$this_post = $results_query[$i];


		                       	//the get_post check seems necessary if you have imported posts that have thumbnail id but not actual thumbnail
		                       	if (has_post_thumbnail($this_post->ID) && get_post(get_post_thumbnail_id($this_post->ID)) ) {
									//set classes
									$base_class = "mosaic-block circle";
									$size_class = " " . mb_get_size_class_from_num($num_columns, "fourth");
									$last_class = (($post_counter+1)%$num_columns) ? "" : " last";

			                        $cat_class = "";
			                        $item_categories = get_the_terms($this_post->ID, 'category');
			                        if ($item_categories) foreach ($item_categories as $value) $cat_class .= " cat-item-" . $value->term_id;

									$final_class = $base_class . $size_class . $cat_class . $last_class;

		                            echo '<div class="'.esc_attr($final_class).'">';
		                            $post_thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($this_post->ID),'full');
		                            $post_thumbnail_src_fit = wp_get_attachment_image_src(get_post_thumbnail_id($this_post->ID),'widget_more_posts_thumb');
		                            $img_alt = get_post_meta(get_post_thumbnail_id($this_post->ID), '_wp_attachment_image_alt', true);
		                            $img_post = get_post(get_post_thumbnail_id($this_post->ID));

                                    if ($display_style == "images_to_posts") {
										printf('<a href="%s" class="mosaic-overlay link fancybox" data-fancybox-group="gallery" title="%s"></a>', get_permalink($this_post->ID), esc_attr($img_post->post_title));
                                    } else {
										printf('<a href="%s" class="mosaic-overlay fancybox" data-fancybox-group="gallery" title="%s"></a>', esc_url($post_thumbnail_src[0]), esc_attr($img_post->post_title));
                                    }

		                            printf('<div class="mosaic-backdrop"><img src="%s" alt="%s" /></div>', esc_url($post_thumbnail_src_fit[0]), esc_attr($img_alt));
		                            echo '</div>';
		                            $post_counter++;
		                        }
									
							}

						}

					} else {
						echo "<ul>";
						for ($i = 0; $i < $num_posts; $i++) { 
							$this_post = $results_query[$i];
							echo "<li>";
							printf('<div class="meta"><span class="meta-date">%s</span></div>', esc_attr( mb_localize_datetime(get_the_time(get_option('date_format'), $this_post->ID)) ));
							printf('<h3><a href="%s">%s</a></h3>', esc_url(get_permalink($this_post->ID)), esc_attr($this_post->post_title));
							// if ($canon_options_post['show_meta_date'] == "checked") { printf('<div class="meta"><span class="meta-date">%s</span></div>', esc_attr( mb_localize_datetime(get_the_time(get_option('date_format'), $this_post->ID)) )); }

							echo "</li>";

						}
						echo "</ul>";

					}


				?>

			</div>

			<?php echo wp_kses_post($after_widget); ?>

			<?php
		}

	} //END CLASS

