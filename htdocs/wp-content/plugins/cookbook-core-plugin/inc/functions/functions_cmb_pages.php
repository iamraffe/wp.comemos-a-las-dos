<?php

/**************************************
CUSTOM META FIELD
***************************************/

	//metaboxes
	add_action('add_meta_boxes', 'register_canon_cmb_pages');
	add_action ('save_post', 'update_canon_cmb_pages');

	function register_canon_cmb_pages () {
		add_meta_box('canon_cmb_pages','Cookbook Page Settings', 'display_canon_cmb_pages','page','normal','high');
	}

	function display_canon_cmb_pages ($post) {

	/**************************************
	GET VALUES
	***************************************/

		//to be or not to be
		$cmb_exist = get_post_meta($post->ID, 'cmb_exist', true);

		//defaults
		if (empty($cmb_exist)) {

			// general
			update_post_meta($post->ID, 'cmb_page_hide_title', 'unchecked');

			update_post_meta($post->ID, 'cmb_page_sidebar_id', 'canon_page_sidebar_widget_area');

			update_post_meta($post->ID, 'cmb_gallery_style', 'one');
			update_post_meta($post->ID, 'cmb_gallery_num_columns', 1);

			update_post_meta($post->ID, 'cmb_sitemap_location', 'primary_menu');

		}

		// general
		$cmb_page_hide_title = get_post_meta($post->ID, 'cmb_page_hide_title', true);

		//sidebar specific
		$cmb_page_sidebar_id = get_post_meta($post->ID, 'cmb_page_sidebar_id', true);

		//gallery specific
		$cmb_gallery_style = get_post_meta($post->ID, 'cmb_gallery_style', true);
		$cmb_gallery_num_columns = get_post_meta($post->ID, 'cmb_gallery_num_columns', true);
		$cmb_gallery_source = get_post_meta($post->ID, 'cmb_gallery_source', true);

		//sitemap specific
		$cmb_sitemap_location = get_post_meta($post->ID, 'cmb_sitemap_location', true);

		//make sure (empty) arrays are defined as arrays
		if (empty($cmb_pages_contact)) $cmb_pages_contact = array();


	/**************************************
	DISPLAY CONTENT
	
			GENERAL
			TEMPLATE SPECIFIC: HIDE HEADER ELEMENTS
			TEMPLATE SPECIFIC: SIDEBAR 
			TEMPLATE SPECIFIC: GALLERY 
			TEMPLATE SPECIFIC: CONTACT
			TEMPLATE SPECIFIC: SITEMAP

	***************************************/

		?>

	<!-- TEMPLATE SPECIFIC: DEFAULT EMPTY -->

		<div class="option_item default-hidden option_template_specific 
						option_index

		">
			<i><?php _e("No additional page settings available for this template type.", "loc_cookbook_core_plugin"); ?></i>
		</div>

		<!-- 
		--------------------------------------------------------------------------
			GENERAL
	    -------------------------------------------------------------------------- 
		-->

<!-- 		<div class="">

				<div class="option_item">
					<input type="hidden" name="cmb_page_hide_title" value="unchecked" />
					<input type='checkbox' id="cmb_page_hide_title" name='cmb_page_hide_title' value='checked' <?php if(!empty($cmb_page_hide_title)) { checked($cmb_page_hide_title == "checked"); } ?>>
					<label for='cmb_page_hide_title'><?php _e("Hide title", "loc_cookbook_core_plugin"); ?></label><br>

				</div>

		</div>
 -->

		<!-- 
		--------------------------------------------------------------------------
			TEMPLATE SPECIFIC: HIDE HEADER ELEMENTS
	    -------------------------------------------------------------------------- 
		-->

		<div class="default-hidden option_template_specific option_page-sidebar option_page-slider option_page option_default">

				<div class="option_item">
					<input type="hidden" name="cmb_page_hide_title" value="unchecked" />
					<input type='checkbox' id="cmb_page_hide_title" name='cmb_page_hide_title' value='checked' <?php if(!empty($cmb_page_hide_title)) { checked($cmb_page_hide_title == "checked"); } ?>>
					<label for='cmb_page_hide_title'><?php _e("Hide title", "loc_cookbook_core_plugin"); ?></label><br>

				</div>

		</div>


		<!-- 
		--------------------------------------------------------------------------
			TEMPLATE SPECIFIC: SIDEBAR 
	    -------------------------------------------------------------------------- 
		-->

		<div class=" default-hidden option_template_specific option_page-sidebar option_page-sitemap">

			<?php 

				// get array of registered sidebars
				$registered_sidebars_array = array();

				foreach ($GLOBALS['wp_registered_sidebars'] as $key => $value) {
					array_push($registered_sidebars_array, $value);
				}


			?>

			<div class="option_item"> 
				<label for='cmb_page_sidebar_id'><?php _e("Select sidebar", "loc_cookbook_core_plugin"); ?></label><br>
				<select name="cmb_page_sidebar_id">
					<?php 
						for ($i = 0; $i < count($registered_sidebars_array); $i++) { 
						?>
		     				<option value="<?php echo esc_attr($registered_sidebars_array[$i]['id']); ?>" <?php if (isset($cmb_page_sidebar_id)) {if ($cmb_page_sidebar_id ==  $registered_sidebars_array[$i]['id']) echo "selected='selected'";} ?>><?php echo  $registered_sidebars_array[$i]['name']; ?></option> 
						<?php
						}
					?>
				</select> 
			</div>

		</div>

		<!-- 
		--------------------------------------------------------------------------
			TEMPLATE SPECIFIC: GALLERY 
	    -------------------------------------------------------------------------- 
		-->

		<div class=" default-hidden option_template_specific option_page-gallery">

			<div class="option_heading">
				<span><?php _e("Gallery Settings", "loc_cookbook_core_plugin"); ?></span>
			</div>

			<?php
				
				fw_cmb_option(array(
					'type'					=> 'select',
					'title' 				=> __('Gallery Style', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_gallery_style',
					'select_options'		=> array(
						'slider'				=> __('Gallery Slider', 'loc_cookbook_core_plugin'),
						'isotope'				=> __('Gallery Isotope', 'loc_cookbook_core_plugin'),
					),
					'post_id'				=> $post->ID,
				)); 

				fw_cmb_option(array(
					'type'					=> 'number',
					'title' 				=> __('Isotope gallery: number of columns', 'loc_cookbook_core_plugin'),
					'slug' 					=> 'cmb_gallery_num_columns',
					'min'					=> '1',										// optional
					'max'					=> '5',									// optional
					'step'					=> '1',										// optional
					'width_px'				=> '60',									// optional
					'post_id'				=> $post->ID,
				)); 

			?>

			<div class="option_item">

				<ul class="wp_galleries_source_hints">
					<li><?php _e("Add WordPress galleries using the Add Media button. You can add as many WordPress galleries as you would like.", "loc_cookbook_core_plugin"); ?></li>
					<li><?php _e("You can add a caption to each image when creating your WordPress gallery.", "loc_cookbook_core_plugin"); ?></li>
					<li><?php _e("The images and captions from these WordPress galleries will be used in the gallery.", "loc_cookbook_core_plugin"); ?></li>
					<li><?php _e("The images will appear in the same order as they appear in the galleries. Duplicate images will be removed.", "loc_cookbook_core_plugin"); ?></li>
					<li><?php _e('You can use the Text editor to rearrange the WordPress gallery shortcodes', "loc_cookbook_core_plugin"); ?></li>
					<li><?php _e('You can use the Text editor to add a category attribute to the shortcodes e.g. [gallery ids="1,2,3" category="My Category"]', "loc_cookbook_core_plugin"); ?></li>
				</ul>

				<?php 

					wp_editor($cmb_gallery_source, 'cmb_gallery_source', array(
					    'textarea_name' 		=> 'cmb_gallery_source',
					    'teeny' 				=> true,
					    'media_buttons' 		=> true,
		    			'tinymce' 				=> true,
		    			'quicktags'				=> true,
		    			'textarea_rows' 		=> 30,
		    			'editor_class'			=> 'gallery_source'
					));

				?>

			</div>

		</div>



		<!-- 
		--------------------------------------------------------------------------
			TEMPLATE SPECIFIC: SITEMAP
	    -------------------------------------------------------------------------- 
		-->

		<div class=" default-hidden option_template_specific option_page-sitemap">

			<div class="option_content_container">

     			<?php $registered_nav_menus = get_registered_nav_menus(); ?>

				<div class="option_item">
					<label for='cmb_sitemap_location'><?php _e("Display as sitemap", "loc_cookbook_core_plugin"); ?></label><br>
					<select id="cmb_sitemap_location" name="cmb_sitemap_location"> 

		     			<?php 
		     				foreach ($registered_nav_menus as $location => $description) {
		     				?>
		     					<option value="<?php echo esc_attr($location); ?>" <?php if (isset($cmb_sitemap_location)) {if ($cmb_sitemap_location == $location) echo "selected='selected'";} ?>><?php echo esc_attr($description); ?></option> 
		     				<?php	     						
		     				}
		     			?>

					</select> 
				</div>


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

	function update_canon_cmb_pages ($post_id) {
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

			//make sure $_POST['cmb_gallery_cat'] is defined
			if (!isset($_POST['cmb_gallery_cat'])) { $_POST['cmb_gallery_cat'] = array(); }

			// general
			if (isset($_POST['cmb_page_hide_title'])) { update_post_meta($post_id, 'cmb_page_hide_title', $_POST['cmb_page_hide_title']); } else { update_post_meta($post_id, 'cmb_page_hide_title', null); };

			//sidebar specific
			if (isset($_POST['cmb_page_sidebar_id'])) { update_post_meta($post_id, 'cmb_page_sidebar_id', $_POST['cmb_page_sidebar_id']); } else { update_post_meta($post_id, 'cmb_page_sidebar_id', null); };

			//gallery specific
			if (isset($_POST['cmb_gallery_style'])) { update_post_meta($post_id, 'cmb_gallery_style', $_POST['cmb_gallery_style']); } else { update_post_meta($post_id, 'cmb_gallery_style', null); };
			if (isset($_POST['cmb_gallery_num_columns'])) { update_post_meta($post_id, 'cmb_gallery_num_columns', $_POST['cmb_gallery_num_columns']); } else { update_post_meta($post_id, 'cmb_gallery_num_columns', null); };
			if (isset($_POST['cmb_gallery_source'])) { update_post_meta($post_id, 'cmb_gallery_source', $_POST['cmb_gallery_source']); } else { update_post_meta($post_id, 'cmb_gallery_source', null); };

			//sitemap specific
			if (isset($_POST['cmb_sitemap_location'])) { update_post_meta($post_id, 'cmb_sitemap_location', $_POST['cmb_sitemap_location']); } else { update_post_meta($post_id, 'cmb_sitemap_location', null); };

			if (isset($_POST['cmb_exist'])) { update_post_meta($post_id, 'cmb_exist', $_POST['cmb_exist']); } else { update_post_meta($post_id, 'cmb_exist', null); };
				
		}
	}


