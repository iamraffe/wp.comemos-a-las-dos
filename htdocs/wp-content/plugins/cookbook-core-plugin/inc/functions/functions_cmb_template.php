<?php

/**************************************
CUSTOM META FIELD

CHANGE
start by erasing unused sections
templateslug (usually: namespace_templatelowercase e.g. td_projects)
project

***************************************/

	//metaboxes
	add_action('add_meta_boxes', 'register_cmb_timedrop_project_settings');
	add_action ('save_post', 'update_cmb_timedrop_project_settings');

	function register_cmb_timedrop_project_settings () {
		add_meta_box('cmb_timedrop_project_settings','Timedrop project settings', 'display_cmb_timedrop_project_settings','templateslug','normal','high');
	}

	function display_cmb_timedrop_project_settings ($post) {

	/**************************************
	GET VALUES
	***************************************/

	// OPTIONS
		$default_somevariable = 90;

	// DETAILS
		$cmb_projects_client = get_post_meta($post->ID, 'cmb_projects_client', true);
		$cmb_projects_date = get_post_meta($post->ID, 'cmb_projects_date', true);
		$cmb_projects_url = get_post_meta($post->ID, 'cmb_projects_url', true);


	// SLIDER
		$cmb_slider_feature = get_post_meta($post->ID, 'cmb_slider_feature', true);
		$cmb_slider_use_cap_header = get_post_meta($post->ID, 'cmb_slider_use_cap_header', true);
		$cmb_slider_cap_header = get_post_meta($post->ID, 'cmb_slider_cap_header', true);
		$cmb_slider_use_cap_text = get_post_meta($post->ID, 'cmb_slider_use_cap_text', true);
		$cmb_slider_cap_text = get_post_meta($post->ID, 'cmb_slider_cap_text', true);
		$cmb_slider_use_media = get_post_meta($post->ID, 'cmb_slider_use_media', true);
		$cmb_slider_media = get_post_meta($post->ID, 'cmb_slider_media', true);

		$cmb_exist = get_post_meta($post->ID, 'cmb_exist', true);

		//defaults
		if (empty($cmb_exist)) {
			$cmb_comp_feat_img = "checked";
			$cmb_comp_title = "checked";
			$cmb_comp_excerpt = "checked";
			$cmb_comp_meta = "checked";
			$cmb_excerpt = mb_make_excerpt($post->post_content, $default_excerpt_len, true);

			$cmb_slider_use_cap_header = "checked";
			$cmb_slider_cap_header = $post->post_title;
			$cmb_slider_use_cap_text = "checked";
			$cmb_slider_cap_text = mb_make_excerpt($post->post_content, $default_cap_text_len, true);
		}

	/**************************************
	DISPLAY CONTENT
	***************************************/

		?>

	<!-- DETAILS -->

		<div class="option_heading">
			<span>Details</span>
		</div>

		<div class="option_item">
			<label for='cmb_projects_client'><?php _e("Client", "loc_cookbook_core_plugin"); ?></label><br>
			<input type='text' id='cmb_projects_client' name='cmb_projects_client' class='widefat' value='<?php if (!empty($cmb_projects_client)) echo htmlspecialchars($cmb_projects_client); ?>'>
		</div>

		<div class="option_item">
			<label for='cmb_projects_date'>Project date</label><br>
			<input type='text' id='cmb_projects_date' name='cmb_projects_date' class='widefat' value='<?php if (!empty($cmb_projects_date)) echo esc_attr($cmb_projects_date); ?>'>
		</div>

		<div class="option_item">
			<label for='cmb_projects_url'>Project URL</label><br>
			<input type='text' id='cmb_projects_url' name='cmb_projects_url' class='widefat' value='<?php if (!empty($cmb_projects_url)) echo esc_attr($cmb_projects_url); ?>'>
		</div>

		<div class="option_item">
			<label for='cmb_projects_excerpt'>Excerpt</label><br>
			<textarea id='cmb_projects_excerpt' name='cmb_projects_excerpt' class='widefat'><?php if (!empty($cmb_projects_excerpt)) echo esc_attr($cmb_projects_excerpt); ?></textarea>
			<button type="button" name="button_generate_excerpt" id='button_generate_excerpt' class="button-secondary auto_generate" value="<?php echo mb_make_excerpt($post->post_content, $default_excerpt_len, true); ?>">Auto-generate</button>
		</div>

	<!-- SLIDER -->

		<div class="option_heading">
			<span>Slider</span>
		</div>

		<div class="option_item">
			<input type='checkbox' id='cmb_slider_feature' name='cmb_slider_feature' value='checked' <?php checked(!empty($cmb_slider_feature)); ?>>
			<label for='cmb_slider_feature'>Feature this post in slider</label>
		</div>

		<div id="popup_cmb_slider_options">

			<div class="option_item">
				<input type='checkbox' id='cmb_slider_use_cap_header' name='cmb_slider_use_cap_header' value='checked' <?php checked(!empty($cmb_slider_use_cap_header)); ?>>
				<label for='cmb_slider_use_cap_header'>Use caption header</label>
				<input type='text' id='cmb_slider_cap_header' name='cmb_slider_cap_header' class='widefat' value='<?php if (!empty($cmb_slider_cap_header)) echo esc_attr($cmb_slider_cap_header); ?>'>
				<button type="button" name="button_generate_header" id='button_generate_header' class="button-secondary auto_generate" value="<?php echo esc_attr($post->post_title); ?>">Auto-generate</button>
			</div>

			<div class="option_item">
				<input type='checkbox' id='cmb_slider_use_cap_text' name='cmb_slider_use_cap_text' value='checked' <?php checked(!empty($cmb_slider_use_cap_text)); ?>>
				<label for='cmb_slider_use_cap_text'>Use caption text</label>
				<textarea id='cmb_slider_cap_text' name='cmb_slider_cap_text' class='widefat'><?php if (!empty($cmb_slider_cap_text)) echo esc_attr($cmb_slider_cap_text); ?></textarea>
				<button type="button" name="button_generate_text" id='button_generate_text' class="button-secondary auto_generate" value="<?php echo mb_make_excerpt($post->post_content, $default_cap_text_len, true); ?>">Auto-generate</button>
			</div>

			<div class="option_item">
				<input type='checkbox' id='cmb_slider_use_media' name='cmb_slider_use_media' value='checked' <?php checked(!empty($cmb_slider_use_media)); ?>>
				<label for='cmb_slider_use_media'>Use media in slider</label>
				<input type='text' id='cmb_slider_media' name='cmb_slider_media' class='widefat' value='<?php if (!empty($cmb_slider_media)) echo esc_attr($cmb_slider_media); ?>'>
				<span class="item_hint">(Use media instead of featured image in slider. Remember to adjust sizes. Works best with width: 100% and height: 420px. NB: increases load times.</span>
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

	function update_cmb_timedrop_project_settings ($post_id) {
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

		//DETAILS
			update_post_meta($post_id, 'cmb_projects_client', $_POST['cmb_projects_client']);
			update_post_meta($post_id, 'cmb_projects_date', $_POST['cmb_projects_date']);
			update_post_meta($post_id, 'cmb_projects_url', $_POST['cmb_projects_url']);

		//SLIDER
			update_post_meta($post_id, 'cmb_slider_feature', $_POST['cmb_slider_feature']);
			update_post_meta($post_id, 'cmb_slider_use_cap_header', $_POST['cmb_slider_use_cap_header']);
			update_post_meta($post_id, 'cmb_slider_cap_header', $_POST['cmb_slider_cap_header']);
			update_post_meta($post_id, 'cmb_slider_use_cap_text', $_POST['cmb_slider_use_cap_text']);
			update_post_meta($post_id, 'cmb_slider_cap_text', $_POST['cmb_slider_cap_text']);
			update_post_meta($post_id, 'cmb_slider_use_media', $_POST['cmb_slider_use_media']);
			update_post_meta($post_id, 'cmb_slider_media', $_POST['cmb_slider_media']);

			update_post_meta($post_id, 'cmb_exist', $_POST['cmb_exist']);
				
		}
	}


