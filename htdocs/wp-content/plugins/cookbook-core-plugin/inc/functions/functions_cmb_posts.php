<?php

/**************************************
CUSTOM META FIELD
***************************************/

	//metaboxes
	add_action('add_meta_boxes', 'register_canon_cmb_posts');
	add_action ('save_post', 'update_canon_cmb_posts');

	function register_canon_cmb_posts () {
		add_meta_box('canon_cmb_posts','Cookbook Post Settings', 'display_canon_cmb_posts','post');
	}

	function display_canon_cmb_posts ($post) {

	/**************************************
	GET VALUES
	***************************************/

	// OPTIONS
		$default_excerpt_len = 300;

	//SET DEFAULTS
		$cmb_exist = get_post_meta($post->ID, 'cmb_exist', true);

		if (empty($cmb_exist)) {

			update_post_meta($post->ID, 'cmb_single_style', 'standard_sidebar');
			update_post_meta($post->ID, 'cmb_feature', 'image');

			update_post_meta($post->ID, 'cmb_hide_from_gallery', 'unchecked');
			update_post_meta($post->ID, 'cmb_hide_from_popular', 'unchecked');
			update_post_meta($post->ID, 'cmb_hide_feat_img', 'unchecked');

			update_post_meta($post->ID, 'cmb_post_show_tags', 'checked');

			update_post_meta($post->ID, 'cmb_post_show_info', 'unchecked');
			update_post_meta($post->ID, 'cmb_post_info_title', 'My Recipe');
			update_post_meta($post->ID, 'cmb_post_show_info_meta', 'checked');
			update_post_meta($post->ID, 'cmb_post_info_meta', array(
				0	=>	array (
					'label'		=> __('Prep Time', 'loc_cookbook_core_plugin'),
					'text'		=> __('15 mins', 'loc_cookbook_core_plugin'),
				),
				1	=>	array (
					'label'		=> __('Cook Time', 'loc_cookbook_core_plugin'),
					'text'		=> __('30 mins', 'loc_cookbook_core_plugin'),
				),
				2	=>	array (
					'label'		=> __('Yields', 'loc_cookbook_core_plugin'),
					'text'		=> __('18', 'loc_cookbook_core_plugin'),
				),
			));
			update_post_meta($post->ID, 'cmb_post_show_info_ul', 'checked');
			update_post_meta($post->ID, 'cmb_post_info_ul_title', 'Ingredients');
			update_post_meta($post->ID, 'cmb_post_info_ul', array(
				0	=>	array (
					'text'		=> __('2 Cups - Organic Plain Flour', 'loc_cookbook_core_plugin'),
				),
			));
			update_post_meta($post->ID, 'cmb_post_show_info_ol', 'checked');
			update_post_meta($post->ID, 'cmb_post_info_ol_title', 'Method');
			update_post_meta($post->ID, 'cmb_post_info_ol', array(
				0	=>	array (
					'text'		=> __('Heat oven to 190°C/fan 170°C/gas 5', 'loc_cookbook_core_plugin'),
				),
			));
			update_post_meta($post->ID, 'cmb_post_info_extra_title', 'Additional Info');
			update_post_meta($post->ID, 'cmb_post_info_extra_text', '');

			update_post_meta($post->ID, 'cmb_post_show_ratings', 'unchecked');
			update_post_meta($post->ID, 'cmb_post_ratings_title', __('Review', 'loc_cookbook_core_plugin'));
			update_post_meta($post->ID, 'cmb_post_ratings_parameters', array(
				0	=>	array (
					'name'		=> __('My First Parameter', 'loc_cookbook_core_plugin'),
					'score'		=> '5.0',
				),
			));

			update_post_meta($post->ID, 'cmb_post_show_related', 'unchecked');
			update_post_meta($post->ID, 'cmb_post_show_author', 'unchecked');
			update_post_meta($post->ID, 'cmb_post_related_title', 'Related Posts');
			update_post_meta($post->ID, 'cmb_post_related_shows', 'same_cat');
			update_post_meta($post->ID, 'cmb_post_related_num_posts', '4');

		}


	// GENERAL
		$cmb_single_style = get_post_meta($post->ID, 'cmb_single_style', true);
		$cmb_feature = get_post_meta($post->ID, 'cmb_feature', true);
		$cmb_media_link = get_post_meta($post->ID, 'cmb_media_link', true);
		$cmb_byline = get_post_meta($post->ID, 'cmb_byline', true);
		$cmb_multi_intro = get_post_meta($post->ID, 'cmb_multi_intro', true);
		$cmb_hide_from_popular = get_post_meta($post->ID, 'cmb_hide_from_popular', true);
		$cmb_hide_feat_img = get_post_meta($post->ID, 'cmb_hide_feat_img', true);
		$cmb_sidebar_id = get_post_meta($post->ID, 'cmb_sidebar_id', true);

	// POST COMPONENTS
		$cmb_post_show_tags = get_post_meta($post->ID, 'cmb_post_show_tags', true);

		$cmb_post_show_info = get_post_meta($post->ID, 'cmb_post_show_info', true);
		$cmb_post_info_title = get_post_meta($post->ID, 'cmb_post_info_title', true);
		$cmb_post_show_info_meta = get_post_meta($post->ID, 'cmb_post_show_info_meta', true);
		$cmb_post_info_meta = get_post_meta($post->ID, 'cmb_post_info_meta', true);
		$cmb_post_show_info_ul = get_post_meta($post->ID, 'cmb_post_show_info_ul', true);
		$cmb_post_info_ul_title = get_post_meta($post->ID, 'cmb_post_info_ul_title', true);
		$cmb_post_info_ul= get_post_meta($post->ID, 'cmb_post_info_ul', true);
		$cmb_post_show_info_ol = get_post_meta($post->ID, 'cmb_post_show_info_ol', true);
		$cmb_post_info_ol_title = get_post_meta($post->ID, 'cmb_post_info_ol_title', true);
		$cmb_post_info_ol= get_post_meta($post->ID, 'cmb_post_info_ol', true);
		$cmb_post_info_extra_title = get_post_meta($post->ID, 'cmb_post_info_extra_title', true);
		$cmb_post_info_extra_text = get_post_meta($post->ID, 'cmb_post_info_extra_text', true);

		$cmb_post_show_ratings = get_post_meta($post->ID, 'cmb_post_show_ratings', true);
		$cmb_post_ratings_overall_score = get_post_meta($post->ID, 'cmb_post_ratings_overall_score', true);
		$cmb_post_ratings_out_of_total = get_post_meta($post->ID, 'cmb_post_ratings_out_of_total', true);
		$cmb_post_ratings_title = get_post_meta($post->ID, 'cmb_post_ratings_title', true);
		$cmb_post_ratings_summary = get_post_meta($post->ID, 'cmb_post_ratings_summary', true);
		$cmb_post_show_parameters = get_post_meta($post->ID, 'cmb_post_show_parameters', true);
		$cmb_post_ratings_parameters = get_post_meta($post->ID, 'cmb_post_ratings_parameters', true);

		$cmb_post_show_author = get_post_meta($post->ID, 'cmb_post_show_author', true);
		$cmb_post_show_related = get_post_meta($post->ID, 'cmb_post_show_related', true);
		$cmb_post_related_title = get_post_meta($post->ID, 'cmb_post_related_title', true);
		$cmb_post_related_shows = get_post_meta($post->ID, 'cmb_post_related_shows', true);
		$cmb_post_related_num_posts = get_post_meta($post->ID, 'cmb_post_related_num_posts', true);


	// POST SLIDER
		$cmb_post_show_post_slider = get_post_meta($post->ID, 'cmb_post_show_post_slider', true);
		$cmb_post_slider_source = get_post_meta($post->ID, 'cmb_post_slider_source', true);
	


	// FAILSAFE
		if (empty($cmb_post_ratings_parameters)) { 
			$cmb_post_ratings_parameters = array(
				0	=>	array (
					'name'		=> 'My First Parameter',
					'score'		=> '5.0',
				),
			);	
		}

	/**************************************
	DISPLAY CONTENT

			GENERAL
			POST COMPONENT: INFO BOX
			POST COMPONENT: RATINGS
			POST COMPONENT: TAGS
			POST COMPONENT: AUTHOR BOX
			POST COMPONENT: RELATED
			POST SLIDER

	***************************************/
		?>

		<!-- 
		--------------------------------------------------------------------------
			GENERAL
	    -------------------------------------------------------------------------- 
		-->

		<div class="option_heading">
			<span><?php _e("General", "loc_cookbook_core_plugin"); ?></span>
		</div>

		<!-- specific post format options: quote -->
		<div class="options_post_format default-hidden" data-post_format="quote">
			
			<?php
				
				fw_cmb_option(array(
					'type'					=> 'text',
					'title' 				=> __('Quote byline', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_byline',
					'class' 				=> 'widefat',
					'post_id'				=> $post->ID,
				)); 
							
			?>

		</div>


		<?php
			
			fw_cmb_option(array(
				'type'						=> 'select',
				'title' 					=> __('Post style', 'loc_cookbook_core_plugin'),
				'slug' 						=> 'cmb_single_style',
				'select_options'			=> array(
					'standard'				=> __('Standard post no sidebar', 'loc_cookbook_core_plugin'),
					'standard_sidebar'		=> __('Standard post with sidebar', 'loc_cookbook_core_plugin'),
					'multi'					=> __('Multi-post no sidebar', 'loc_cookbook_core_plugin'),
					'multi_sidebar'			=> __('Multi-post with sidebar', 'loc_cookbook_core_plugin'),
				),
				'post_id'					=> $post->ID,
			)); 

		?>

		<div class="dynamic_option default-hidden" data-listen_to="#cmb_single_style" data-listen_for="multi multi_sidebar">

			<?php
				
				fw_cmb_option(array(
					'type'					=> 'textarea',
					'title' 				=> __('Multi post intro', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_multi_intro',
					'cols'					=> '100',
					'rows'					=> '5',
					'class'					=> 'widefat',
					'post_id'				=> $post->ID,
				)); 

			?>

		</div>

		<div class="dynamic_option default-hidden" data-listen_to="#cmb_single_style" data-listen_for="standard standard_sidebar">

			<?php
							
				fw_cmb_option(array(
					'type'					=> 'select',
					'title' 				=> __('Feature style', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_feature',
					'select_options'		=> array(
						'image'				=> __('Featured image', 'loc_cookbook_core_plugin'),
						'media'				=> __('Use embeddable media instead of featured image', 'loc_cookbook_core_plugin'),
						'media_in_lightbox'	=> __('Use featured image but open media link in lightbox', 'loc_cookbook_core_plugin'),
					),
					'post_id'				=> $post->ID,
				)); 
							
				fw_cmb_option(array(
					'type'					=> 'textarea',
					'title' 				=> __('Featured media - <i>(optional)</i>', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_media_link',
					'cols'					=> '100',
					'rows'					=> '5',
					'class'					=> 'widefat',
					'post_id'				=> $post->ID,
				)); 


			?>

		</div>

		<?php
		
			
			fw_cmb_option(array(
				'type'					=> 'checkbox_multiple',
				'checkboxes'			=> array(
					'cmb_hide_from_popular'		=> __('Hide from popular lists', 'loc_cookbook_core_plugin'),
				),
				'post_id'				=> $post->ID,
			)); 

		?>

		<div class="dynamic_option default-hidden" data-listen_to="#cmb_single_style" data-listen_for="standard standard_sidebar">

			<?php
				
				if (has_post_thumbnail($post->ID)) {
				?>
					<div class="option_item">
						<input type="hidden" name="cmb_hide_feat_img" value="unchecked" />
						<input type='checkbox' id='cmb_hide_feat_img' name='cmb_hide_feat_img' value='checked' <?php checked($cmb_hide_feat_img == "checked"); ?>>
						<label for='cmb_hide_feat_img'><?php _e("Hide featured image in post", "loc_cookbook_core_plugin"); ?></label>
					</div>
						
				<?php
				}
			
			?>	

		</div>


		<?php 

			// get array of registered sidebars
			$registered_sidebars_array = array();

			foreach ($GLOBALS['wp_registered_sidebars'] as $key => $value) {
				array_push($registered_sidebars_array, $value);
			}


		?>

		<div class="dynamic_option default-hidden" data-listen_to="#cmb_single_style" data-listen_for="standard_sidebar multi_sidebar">

			<div class="option_item">
				<label for='cmb_sidebar_id'><?php _e("Select sidebar", "loc_cookbook_core_plugin"); ?></label><br>
				<select name="cmb_sidebar_id">
					<?php 
						for ($i = 0; $i < count($registered_sidebars_array); $i++) { 
						?>
		     				<option value="<?php echo esc_attr($registered_sidebars_array[$i]['id']); ?>" <?php if (isset($cmb_sidebar_id)) {if ($cmb_sidebar_id ==  $registered_sidebars_array[$i]['id']) echo "selected='selected'";} ?>><?php echo  $registered_sidebars_array[$i]['name']; ?></option> 
						<?php
						}
					?>
				</select> 
			</div>

		</div>




		<!-- 
		--------------------------------------------------------------------------
			POST COMPONENT: INFO BOX
	    -------------------------------------------------------------------------- 
		-->

		<div class="option_heading">
			<span><?php _e("Post Component: Recipe box", "loc_cookbook_core_plugin"); ?></span>
		</div>

		<div class="option_item">
			<input type="hidden" name="cmb_post_show_info" value="unchecked" />
			<input type='checkbox' id='cmb_post_show_info' name='cmb_post_show_info' value='checked' <?php checked($cmb_post_show_info == "checked"); ?>>
			<label for='cmb_post_show_info'><?php _e("Show recipe box", "loc_cookbook_core_plugin"); ?></label><br>
		</div>

		<div class="dynamic_option default-hidden" data-listen_to="#cmb_post_show_info" data-listen_for="checked">
		
		<!-- INFO BOX TITLE -->

			<?php
							
				fw_cmb_option(array(
					'type'					=> 'text',
					'title' 				=> __('Title', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_post_info_title',
					'class' 				=> 'widefat',
					'post_id'				=> $post->ID,
				)); 

			?>

		<!-- INFO BOX META -->

			<div class="option_item info-meta-fields">

				<input type="hidden" name="cmb_post_show_info_meta" value="unchecked" />
				<input type='checkbox' id='cmb_post_show_info_meta' name='cmb_post_show_info_meta' value='checked' <?php checked($cmb_post_show_info_meta == "checked"); ?>>
				<label for='cmb_post_show_info_meta'><?php _e("Show meta", "loc_cookbook_core_plugin"); ?></label><br>

				<ul>
					<?php
						
						for ($i = 0; $i < 3; $i++) {  
						?>

							<li>
								<label><?php _e("Meta field label", "loc_cookbook_core_plugin"); ?></label>
								<input type='text' name="cmb_post_info_meta[<?php echo esc_attr($i); ?>][label]" class="li_option parameter_name" value="<?php if (!empty($cmb_post_info_meta[$i]['label'])) { echo htmlspecialchars($cmb_post_info_meta[$i]['label']); } ?>">
								<label><?php _e("text", "loc_cookbook_core_plugin"); ?> </label>
								<input type='text' name="cmb_post_info_meta[<?php echo esc_attr($i); ?>][text]" class="li_option parameter_score" value="<?php if (!empty($cmb_post_info_meta[$i]['text'])) { echo htmlspecialchars($cmb_post_info_meta[$i]['text']); } ?>">
							</li>
							
						<?php
						}
					
					?>
				</ul>

			</div>

		<!-- INFO BOX UNORDERED LIST -->

			<div class="option_item info-ul cmb-ul-sortable">

				<input type="hidden" name="cmb_post_show_info_ul" value="unchecked" />
				<input type='checkbox' id='cmb_post_show_info_ul' name='cmb_post_show_info_ul' value='checked' <?php checked($cmb_post_show_info_ul == "checked"); ?>>
				<label for='cmb_post_show_info_ul'><?php _e("Show ingredients list", "loc_cookbook_core_plugin"); ?></label><br>

				<?php
								
					fw_cmb_option(array(
						'type'					=> 'text',
						'title' 				=> __('Ingredients list title', 'loc_cookbook_core_plugin'),
						'slug' 					=> 'cmb_post_info_ul_title',
						'class' 				=> 'widefat',
						'post_id'				=> $post->ID,
					)); 

				?>

				<ul class="ul_sortable" data-split_index="1">

					<?php
						
						for ($i = 0; $i < count($cmb_post_info_ul); $i++) {  
						?>

							<li>
								<input type='text' name="cmb_post_info_ul[<?php echo esc_attr($i); ?>][text]" class="li_option parameter_name" value="<?php if (!empty($cmb_post_info_ul[$i]['text'])) { echo htmlspecialchars($cmb_post_info_ul[$i]['text']); } ?>">
								<button type="button" class="button ul_del_this"><?php _e("delete", "loc_cookbook_core_plugin"); ?></button>
							</li>
							
						<?php
						}
					
					?>
				</ul>
				<div class="ul_control" data-min="1" data-max="1000">
					<input type="button" class="button ul_add" value="<?php _e("Add", "loc_cookbook_core_plugin"); ?>" />
				</div>

			</div>

		<!-- INFO BOX ORDERED LIST -->

			<div class="option_item info-ol cmb-ul-sortable">

				<input type="hidden" name="cmb_post_show_info_ol" value="unchecked" />
				<input type='checkbox' id='cmb_post_show_info_ol' name='cmb_post_show_info_ol' value='checked' <?php checked($cmb_post_show_info_ol == "checked"); ?>>
				<label for='cmb_post_show_info_ol'><?php _e("Show method list", "loc_cookbook_core_plugin"); ?></label><br>

				<?php
								
					fw_cmb_option(array(
						'type'					=> 'text',
						'title' 				=> __('Method list title', 'loc_cookbook_core_plugin'),
						'slug' 					=> 'cmb_post_info_ol_title',
						'class' 				=> 'widefat',
						'post_id'				=> $post->ID,
					)); 

				?>

				<ul class="ul_sortable" data-split_index="1">

					<?php
						
						for ($i = 0; $i < count($cmb_post_info_ol); $i++) {  
						?>

							<li>
								<input type='text' name="cmb_post_info_ol[<?php echo esc_attr($i); ?>][text]" class="li_option parameter_name" value="<?php if (!empty($cmb_post_info_ol[$i]['text'])) { echo htmlspecialchars($cmb_post_info_ol[$i]['text']); } ?>">
								<button type="button" class="button ul_del_this"><?php _e("delete", "loc_cookbook_core_plugin"); ?></button>
							</li>
							
						<?php
						}
					
					?>
				</ul>
				<div class="ul_control" data-min="1" data-max="1000">
					<input type="button" class="button ul_add" value="<?php _e("Add", "loc_cookbook_core_plugin"); ?>" />
				</div>

			</div>

		<!-- INFO BOX ADDITIONAL INFO -->

			<?php

				fw_cmb_option(array(
					'type'					=> 'text',
					'title' 				=> __('Additional info title', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_post_info_extra_title',
					'class' 				=> 'widefat',
					'post_id'				=> $post->ID,
				)); 

				fw_cmb_option(array(
					'type'					=> 'textarea',
					'title' 				=> __('Additional info text <i>(accepts shortcodes and some HTML)</i>', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_post_info_extra_text',
					'cols'					=> '100',
					'rows'					=> '5',
					'class'					=> 'widefat',
					'post_id'				=> $post->ID,
				)); 

			?>


		</div>

		<!-- 
		--------------------------------------------------------------------------
			POST COMPONENT: RATINGS
	    -------------------------------------------------------------------------- 
		-->

		<div class="option_heading">
			<span><?php _e("Post Component: Ratings", "loc_cookbook_core_plugin"); ?></span>
		</div>

		<div class="option_item">
			<input type="hidden" name="cmb_post_show_ratings" value="unchecked" />
			<input type='checkbox' id='cmb_post_show_ratings' name='cmb_post_show_ratings' value='checked' <?php checked($cmb_post_show_ratings == "checked"); ?>>
			<label for='cmb_post_show_ratings'><?php _e("Show ratings", "loc_cookbook_core_plugin"); ?></label><br>
		</div>

		<div class="dynamic_option default-hidden" data-listen_to="#cmb_post_show_ratings" data-listen_for="checked">
		
			<?php
							
				fw_cmb_option(array(
					'type'					=> 'text',
					'title' 				=> __('Title', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_post_ratings_title',
					'class' 				=> 'widefat',
					'post_id'				=> $post->ID,
				)); 

				fw_cmb_option(array(
					'type'					=> 'text',
					'title' 				=> __('Overall score <i>(if decimal score remember to use period as decimal mark)</i>', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_post_ratings_overall_score',
					'class' 				=> 'widefat',
					'post_id'				=> $post->ID,
				)); 

				fw_cmb_option(array(
					'type'					=> 'text',
					'title' 				=> __('Out of a total <i>(required for parameters)</i>', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_post_ratings_out_of_total',
					'class' 				=> 'widefat',
					'post_id'				=> $post->ID,
				)); 

				fw_cmb_option(array(
					'type'					=> 'textarea',
					'title' 				=> __('Summary', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_post_ratings_summary',
					'cols'					=> '100',
					'rows'					=> '5',
					'class'					=> 'widefat',
					'post_id'				=> $post->ID,
				)); 


			?>

			<div class="option_item ratings-parameters cmb-ul-sortable">

				<input type="hidden" name="cmb_post_show_parameters" value="unchecked" />
				<input type='checkbox' id='cmb_post_show_parameters' name='cmb_post_show_parameters' value='checked' <?php checked($cmb_post_show_parameters == "checked"); ?>>
				<label for='cmb_post_show_parameters'><?php _e("Show parameters", "loc_cookbook_core_plugin"); ?></label><br>

				<ul class="ul_sortable" data-split_index="1">

					<?php
						
						for ($i = 0; $i < count($cmb_post_ratings_parameters); $i++) {  
						?>

							<li>
								<label><?php _e("Parameter name", "loc_cookbook_core_plugin"); ?></label>
								<input type='text' name="cmb_post_ratings_parameters[<?php echo esc_attr($i); ?>][name]" class="li_option parameter_name" value="<?php if (!empty($cmb_post_ratings_parameters[$i]['name'])) { echo htmlspecialchars($cmb_post_ratings_parameters[$i]['name']); } ?>">
								<label><?php _e("Score", "loc_cookbook_core_plugin"); ?> </label>
								<input type='text' name="cmb_post_ratings_parameters[<?php echo esc_attr($i); ?>][score]" class="li_option parameter_score" value="<?php if (!empty($cmb_post_ratings_parameters[$i]['score'])) { echo htmlspecialchars($cmb_post_ratings_parameters[$i]['score']); } ?>">
								<button type="button" class="button ul_del_this float-right"><?php _e("delete", "loc_cookbook_core_plugin"); ?></button>
							</li>
							
						<?php
						}
					
					?>
				</ul>
				<div class="ul_control" data-min="1" data-max="1000">
					<input type="button" class="button ul_add" value="<?php _e("Add", "loc_cookbook_core_plugin"); ?>" />
				</div>


			</div>
			

		</div>

		
		<!-- 
		--------------------------------------------------------------------------
			POST COMPONENT: TAGS
	    -------------------------------------------------------------------------- 
		-->

		<div class="option_heading">
			<span><?php _e("Post Component: Tags", "loc_cookbook_core_plugin"); ?></span>
		</div>

		<div class="option_item">
			<input type="hidden" name="cmb_post_show_tags" value="unchecked" />
			<input type='checkbox' id='cmb_post_show_tags' name='cmb_post_show_tags' value='checked' <?php checked($cmb_post_show_tags == "checked"); ?>>
			<label for='cmb_post_show_tags'><?php _e("Show tags", "loc_cookbook_core_plugin"); ?></label><br>
		</div>



		<!-- 
		--------------------------------------------------------------------------
			POST COMPONENT: AUTHOR BOX
	    -------------------------------------------------------------------------- 
		-->

		<div class="option_heading">
			<span><?php _e("Post Component: About the Author", "loc_cookbook_core_plugin"); ?></span>
		</div>

		<div class="option_item">
			<input type="hidden" name="cmb_post_show_author" value="unchecked" />
			<input type='checkbox' id='cmb_post_show_author' name='cmb_post_show_author' value='checked' <?php checked($cmb_post_show_author == "checked"); ?>>
			<label for='cmb_post_show_author'><?php _e("Show About the Author box", "loc_cookbook_core_plugin"); ?></label><br>
		</div>


		<!-- 
		--------------------------------------------------------------------------
			POST COMPONENT: RELATED
	    -------------------------------------------------------------------------- 
		-->

		<div class="option_heading">
			<span><?php _e("Post Component: Related posts", "loc_cookbook_core_plugin"); ?></span>
		</div>

		<div class="option_item">
			<input type="hidden" name="cmb_post_show_related" value="unchecked" />
			<input type='checkbox' id='cmb_post_show_related' name='cmb_post_show_related' value='checked' <?php checked($cmb_post_show_related == "checked"); ?>>
			<label for='cmb_post_show_related'><?php _e("Show related posts", "loc_cookbook_core_plugin"); ?></label><br>
		</div>

		<div class="dynamic_option default-hidden" data-listen_to="#cmb_post_show_related" data-listen_for="checked">

			<?php
				
				fw_cmb_option(array(
					'type'					=> 'text',
					'title' 				=> __('Title', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_post_related_title',
					'class' 				=> 'widefat',
					'post_id'				=> $post->ID,
				)); 
			
			?>

			<!-- DYNAMIC SELECT -->
			<?php 

				$cat_list = get_categories(array(
					'hide_empty' => 0
				));
				$cat_list = array_values($cat_list);

			 ?>
			<div class="option_item">
				<label><?php _e("Show", "loc_cookbook_core_plugin"); ?></label><br>
				<select class='block_option' id="show" name="cmb_post_related_shows"> 
	     			<option value="same_cat" <?php if ($cmb_post_related_shows == "same_cat") { echo "selected='selected'";} ?>><?php _e("Same category as post", "loc_cookbook_core_plugin"); ?></option> 
	     			<option value="latest_posts" <?php if ($cmb_post_related_shows == "latest_posts") { echo "selected='selected'";} ?>><?php _e("Latest posts", "loc_cookbook_core_plugin"); ?></option> 
	     			<option value="random_posts" <?php if ($cmb_post_related_shows == "random_posts") { echo "selected='selected'";} ?>><?php _e("Random posts", "loc_cookbook_core_plugin"); ?></option> 
	     			<option value="latest_posts"></option> 

	     			<option value="popular_views" <?php if ($cmb_post_related_shows == "popular_views") { echo "selected='selected'";} ?>><?php _e("Popular posts by views", "loc_cookbook_core_plugin"); ?>	</option> 
 					<option value="popular_comments" <?php if ($cmb_post_related_shows == "popular_comments") { echo "selected='selected'";} ?>><?php _e("Popular posts by comments", "loc_cookbook_core_plugin"); ?>	</option> 
	     			<option value="latest_posts"></option> 

				<?php 
					for ($i = 0; $i < count($cat_list); $i++) { 
					?>
	     				<option value="postcat_<?php echo esc_attr($cat_list[$i]->slug); ?>" <?php if ($cmb_post_related_shows == "postcat_" . $cat_list[$i]->slug) { echo "selected='selected'";} ?>><?php echo esc_attr($cat_list[$i]->name); ?> <?php _e("category", "loc_cookbook_core_plugin"); ?></option> 
					<?php
					}
				?>
				</select> 
			</div>

			<?php
				
				fw_cmb_option(array(
					'type'					=> 'number',
					'title' 				=> __('Number of items to display at a time', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_post_related_num_posts',
					'min'					=> '1',										// optional
					'max'					=> '10000',									// optional
					'step'					=> '1',										// optional
					'width_px'				=> '60',									// optional
					'post_id'				=> $post->ID,
				)); 

			?>		

		</div>

		<!-- 
		--------------------------------------------------------------------------
			POST SLIDER
	    -------------------------------------------------------------------------- 
		-->

		<div class="dynamic_option default-hidden" data-listen_to="#cmb_single_style" data-listen_for="standard standard_sidebar">

			<div class="option_heading">
				<span><?php _e("Post Slider", "loc_cookbook_core_plugin"); ?></span>
			</div>

			<div class="option_item">
				<input type="hidden" name="cmb_post_show_post_slider" value="unchecked" />
				<input type='checkbox' id='cmb_post_show_post_slider' name='cmb_post_show_post_slider' value='checked' <?php checked($cmb_post_show_post_slider == "checked"); ?>>
				<label for='cmb_post_show_post_slider'><?php _e("Show post slider", "loc_cookbook_core_plugin"); ?></label><br>
			</div>

			<div class="dynamic_option default-hidden" data-listen_to="#cmb_post_show_post_slider" data-listen_for="checked">

				<ul class="wp_galleries_source_hints">
					<li><?php _e("The post slider will replace the featured image at the top of the post.", "loc_cookbook_core_plugin"); ?></li>
					<li><?php _e("Add WordPress galleries using the Add Media button. You can add as many WordPress galleries as you would like.", "loc_cookbook_core_plugin"); ?></li>
					<li><?php _e("The images from these WordPress galleries will be used in the post slider.", "loc_cookbook_core_plugin"); ?></li>
					<li><?php _e("The images will appear in the same order as they appear in the galleries. Duplicate images will be removed.", "loc_cookbook_core_plugin"); ?></li>
				</ul>

				<?php 

					wp_editor($cmb_post_slider_source, 'cmb_post_slider_source', array(
					    'textarea_name' 		=> 'cmb_post_slider_source',
					    'teeny' 				=> true,
					    'media_buttons' 		=> true,
		    			'tinymce' 				=> true,
		    			'quicktags'				=> true,
		    			'textarea_rows' 		=> 20,
		    			'editor_class'			=> 'post_slider_source'
					));

				?>

			</div>
			
		</div>







		<!-- add nonce -->
		<input type="hidden" name="cmb_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />
		<input type="hidden" name="cmb_exist" value="true" />






		<?php	
	}



/**************************************
UPDATE
***************************************/

	function update_canon_cmb_posts ($post_id) {
		// avoid activation on irrelevant admin pages
		if (!isset($_POST['cmb_nonce'])) {
			return false;		
		}

		// verify nonce.    
		if (!wp_verify_nonce($_POST['cmb_nonce'], basename(__FILE__)) || !isset($_POST['cmb_nonce'])) {
			return false;
		}

		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		} else {

		// FAILSAFE FOR SORTABLE ARRAYS
			$_POST['cmb_post_info_ul'] = array_values($_POST['cmb_post_info_ul']);
			$_POST['cmb_post_info_ol'] = array_values($_POST['cmb_post_info_ol']);
			$_POST['cmb_post_ratings_parameters'] = array_values($_POST['cmb_post_ratings_parameters']);

		// GENERAL
			if (isset($_POST['cmb_single_style'])) { update_post_meta($post_id, 'cmb_single_style', $_POST['cmb_single_style']); } else { update_post_meta($post_id, 'cmb_single_style', null); };
			if (isset($_POST['cmb_feature'])) { update_post_meta($post_id, 'cmb_feature', $_POST['cmb_feature']); } else { update_post_meta($post_id, 'cmb_feature', null); };
			if (isset($_POST['cmb_media_link'])) { update_post_meta($post_id, 'cmb_media_link', $_POST['cmb_media_link']); } else { update_post_meta($post_id, 'cmb_media_link', null); };
			if (isset($_POST['cmb_byline'])) { update_post_meta($post_id, 'cmb_byline', $_POST['cmb_byline']); } else { update_post_meta($post_id, 'cmb_byline', null); };
			if (isset($_POST['cmb_multi_intro'])) { update_post_meta($post_id, 'cmb_multi_intro', $_POST['cmb_multi_intro']); } else { update_post_meta($post_id, 'cmb_multi_intro', null); };
			if (isset($_POST['cmb_hide_from_popular'])) { update_post_meta($post_id, 'cmb_hide_from_popular', $_POST['cmb_hide_from_popular']); } else { update_post_meta($post_id, 'cmb_hide_from_popular', null); };
			if (isset($_POST['cmb_hide_feat_img'])) { update_post_meta($post_id, 'cmb_hide_feat_img', $_POST['cmb_hide_feat_img']); } else { update_post_meta($post_id, 'cmb_hide_feat_img', null); };
			if (isset($_POST['cmb_sidebar_id'])) { update_post_meta($post_id, 'cmb_sidebar_id', $_POST['cmb_sidebar_id']); } else { update_post_meta($post_id, 'cmb_sidebar_id', null); };

		// POST COMPONENTS
			if (isset($_POST['cmb_post_show_tags'])) { update_post_meta($post_id, 'cmb_post_show_tags', $_POST['cmb_post_show_tags']); } else { update_post_meta($post_id, 'cmb_post_show_tags', null); };
			
			if (isset($_POST['cmb_post_show_info'])) { update_post_meta($post_id, 'cmb_post_show_info', $_POST['cmb_post_show_info']); } else { update_post_meta($post_id, 'cmb_post_show_info', null); };
			if (isset($_POST['cmb_post_info_title'])) { update_post_meta($post_id, 'cmb_post_info_title', $_POST['cmb_post_info_title']); } else { update_post_meta($post_id, 'cmb_post_info_title', null); };
			if (isset($_POST['cmb_post_show_info_meta'])) { update_post_meta($post_id, 'cmb_post_show_info_meta', $_POST['cmb_post_show_info_meta']); } else { update_post_meta($post_id, 'cmb_post_show_info_meta', null); };
			if (isset($_POST['cmb_post_info_meta'])) { update_post_meta($post_id, 'cmb_post_info_meta', $_POST['cmb_post_info_meta']); } else { update_post_meta($post_id, 'cmb_post_info_meta', null); };
			if (isset($_POST['cmb_post_show_info_ul'])) { update_post_meta($post_id, 'cmb_post_show_info_ul', $_POST['cmb_post_show_info_ul']); } else { update_post_meta($post_id, 'cmb_post_show_info_ul', null); };
			if (isset($_POST['cmb_post_info_ul_title'])) { update_post_meta($post_id, 'cmb_post_info_ul_title', $_POST['cmb_post_info_ul_title']); } else { update_post_meta($post_id, 'cmb_post_info_ul_title', null); };
			if (isset($_POST['cmb_post_info_ul'])) { update_post_meta($post_id, 'cmb_post_info_ul', $_POST['cmb_post_info_ul']); } else { update_post_meta($post_id, 'cmb_post_info_ul', null); };
			if (isset($_POST['cmb_post_show_info_ol'])) { update_post_meta($post_id, 'cmb_post_show_info_ol', $_POST['cmb_post_show_info_ol']); } else { update_post_meta($post_id, 'cmb_post_show_info_ol', null); };
			if (isset($_POST['cmb_post_info_ol_title'])) { update_post_meta($post_id, 'cmb_post_info_ol_title', $_POST['cmb_post_info_ol_title']); } else { update_post_meta($post_id, 'cmb_post_info_ol_title', null); };
			if (isset($_POST['cmb_post_info_ol'])) { update_post_meta($post_id, 'cmb_post_info_ol', $_POST['cmb_post_info_ol']); } else { update_post_meta($post_id, 'cmb_post_info_ol', null); };
			if (isset($_POST['cmb_post_info_extra_title'])) { update_post_meta($post_id, 'cmb_post_info_extra_title', $_POST['cmb_post_info_extra_title']); } else { update_post_meta($post_id, 'cmb_post_info_extra_title', null); };
			if (isset($_POST['cmb_post_info_extra_text'])) { update_post_meta($post_id, 'cmb_post_info_extra_text', $_POST['cmb_post_info_extra_text']); } else { update_post_meta($post_id, 'cmb_post_info_extra_text', null); };

			if (isset($_POST['cmb_post_show_ratings'])) { update_post_meta($post_id, 'cmb_post_show_ratings', $_POST['cmb_post_show_ratings']); } else { update_post_meta($post_id, 'cmb_post_show_ratings', null); };
			if (isset($_POST['cmb_post_ratings_overall_score'])) { update_post_meta($post_id, 'cmb_post_ratings_overall_score', $_POST['cmb_post_ratings_overall_score']); } else { update_post_meta($post_id, 'cmb_post_ratings_overall_score', null); };
			if (isset($_POST['cmb_post_ratings_out_of_total'])) { update_post_meta($post_id, 'cmb_post_ratings_out_of_total', $_POST['cmb_post_ratings_out_of_total']); } else { update_post_meta($post_id, 'cmb_post_ratings_out_of_total', null); };
			if (isset($_POST['cmb_post_ratings_title'])) { update_post_meta($post_id, 'cmb_post_ratings_title', $_POST['cmb_post_ratings_title']); } else { update_post_meta($post_id, 'cmb_post_ratings_title', null); };
			if (isset($_POST['cmb_post_ratings_summary'])) { update_post_meta($post_id, 'cmb_post_ratings_summary', $_POST['cmb_post_ratings_summary']); } else { update_post_meta($post_id, 'cmb_post_ratings_summary', null); };
			if (isset($_POST['cmb_post_show_parameters'])) { update_post_meta($post_id, 'cmb_post_show_parameters', $_POST['cmb_post_show_parameters']); } else { update_post_meta($post_id, 'cmb_post_show_parameters', null); };
			if (isset($_POST['cmb_post_ratings_parameters'])) { update_post_meta($post_id, 'cmb_post_ratings_parameters', $_POST['cmb_post_ratings_parameters']); } else { update_post_meta($post_id, 'cmb_post_ratings_parameters', null); };

			if (isset($_POST['cmb_post_show_author'])) { update_post_meta($post_id, 'cmb_post_show_author', $_POST['cmb_post_show_author']); } else { update_post_meta($post_id, 'cmb_post_show_author', null); };
			if (isset($_POST['cmb_post_show_related'])) { update_post_meta($post_id, 'cmb_post_show_related', $_POST['cmb_post_show_related']); } else { update_post_meta($post_id, 'cmb_post_show_related', null); };
			if (isset($_POST['cmb_post_related_title'])) { update_post_meta($post_id, 'cmb_post_related_title', $_POST['cmb_post_related_title']); } else { update_post_meta($post_id, 'cmb_post_related_title', null); };
			if (isset($_POST['cmb_post_related_shows'])) { update_post_meta($post_id, 'cmb_post_related_shows', $_POST['cmb_post_related_shows']); } else { update_post_meta($post_id, 'cmb_post_related_shows', null); };
			if (isset($_POST['cmb_post_related_num_posts'])) { update_post_meta($post_id, 'cmb_post_related_num_posts', $_POST['cmb_post_related_num_posts']); } else { update_post_meta($post_id, 'cmb_post_related_num_posts', null); };


		// POST SLIDER
			if (isset($_POST['cmb_post_show_post_slider'])) { update_post_meta($post_id, 'cmb_post_show_post_slider', $_POST['cmb_post_show_post_slider']); } else { update_post_meta($post_id, 'cmb_post_show_post_slider', null); };
			if (isset($_POST['cmb_post_slider_source'])) { update_post_meta($post_id, 'cmb_post_slider_source', $_POST['cmb_post_slider_source']); } else { update_post_meta($post_id, 'cmb_post_slider_source', null); };

			if (isset($_POST['cmb_exist'])) { update_post_meta($post_id, 'cmb_exist', $_POST['cmb_exist']); } else { update_post_meta($post_id, 'cmb_exist', null); };

		}

	}


