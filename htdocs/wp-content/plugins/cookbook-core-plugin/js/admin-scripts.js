"use strict";

/*************************************************************
CORE PLUGIN BACKEND SCRIPTS

CMB POST: POST FORMAT SPECIFIC OPTIONS
CMB POST: FEATURE STYLE SELECT

CMB PAGE: PAGE TEMPLATE SPECIFIC OPTIONS

*************************************************************/

/*************************************************************
CMB POST: POST FORMAT SPECIFIC OPTIONS
*************************************************************/

	jQuery(document).ready(function($) {

		//post format specific options

		//init
		if ($('#post-formats-select').size() > 0) {

			var td_format = $('#post-formats-select input[checked="checked"]').val();
			$('.options_post_format[data-post_format="'+ td_format + '"]').show();

			//on change
			$('#post-formats-select input').on('change', function() {
				var $this=$(this);
				td_format = $this.val();
				$('.options_post_format').slideUp();
				$('.options_post_format[data-post_format="'+ td_format + '"]').slideDown();

			});

		}

	});


/*****************************************
CMB POST: FEATURE STYLE SELECT
*****************************************/

	jQuery(document).ready(function($) {

		if ($('#cmb_feature').size() > 0) {

			//init
			updateFeatureStyle();

			//on change
			$('#cmb_feature').on('change', function(event) {
				updateFeatureStyle();	
			});


		}

		function updateFeatureStyle () {
			var $featureSelect = $('#cmb_feature');
			var $relatedInput = $featureSelect.closest('.option_item').next('.option_item');
			var $relatedInputLabel = $relatedInput.find('label');
			var featureSelectValue = $featureSelect.val();
			var helpMsg = "";

			if (featureSelectValue == "media") {
				$relatedInput.slideDown();
				helpMsg = "Featured media - <i>(use embeddable code e.g. &lt;iframe&gt; for externally hosted media or HTML5 &lt;video&gt; for self hosted media)</i>";
				$relatedInputLabel.html(helpMsg);

					
			} else if (featureSelectValue == "media_in_lightbox") {
				$relatedInput.slideDown();
				helpMsg = "Featured media - <i>(use standard media link e.g. http://vimeo.com/22428395 or player link http://player.vimeo.com/video/22428395)</i>";
				$relatedInputLabel.html(helpMsg);
					
			} else {
				$relatedInput.slideUp();
			}
		}

	});



/*************************************************************
CMB PAGE: PAGE TEMPLATE SPECIFIC OPTIONS
*************************************************************/

	jQuery(document).ready(function($) {
		//template specific options init
		if ($('#page_template').size() > 0) {

			var selectValue = $('#page_template option[selected="selected"]').val();
			if (typeof selectValue != 'undefined') {
				selectValue = selectValue.split('.');
				$('.option_' + selectValue[0]).show();
			} else {
				$('.option_default').show();
			}

			//on change
			$('#page_template').on('change', function () {
				//first hide all
				$('.option_template_specific').hide();
				//then show relevant
				selectValue = $(this).val();
				selectValue = selectValue.split('.');
				$('.option_' + selectValue[0]).show();
			});

		}

		//options container toggle
		$('.option_heading').on('click', function(e) {
			var $this = $(this);
			$this.next('.option_content_container').slideToggle();
		})

	});




