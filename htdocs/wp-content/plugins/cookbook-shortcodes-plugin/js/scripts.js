"use strict";

/*************************************************************
SCRIPTS INDEX

TOGGLE
ACCORDION


*************************************************************/


/*************************************************************
TOGGLE
*************************************************************/

	jQuery(document).ready(function($){

		if ($('.sc_toggle-btn').size() > 0) {

			// initial states
			$('.sc_toggle-content:not(.active)').hide();

			// sc_toggle	  
			$('.sc_toggle-btn').click(function(e){
				var $this = $(this);
				e.preventDefault();
				$this.closest('li').find('.sc_toggle-content').not(':animated').slideToggle();
				$this.toggleClass("active");
			});
		}

	});

/*************************************************************
ACCORDION
*************************************************************/

	jQuery(document).ready(function($){

		if ($('.sc_accordion-btn').size() > 0) {
			
			// initial states
			$('.sc_accordion-content:not(.active)').hide();

			// sc_accordion	  
			$('.sc_accordion-btn').click(function(e){
				e.preventDefault();
				var $this = $(this);
				var $thisAccordionContent = $this.closest('li').find('.sc_accordion-content');
				var currentStatus = "";
				if ($this.attr('class').indexOf('active') != -1) {
					currentStatus = "active";
				}
				//first close all and remove active class
				$this.closest('.sc_accordion').find('li').each(function(index) {
					var $thisLi = $(this);
					$thisLi.find('.sc_accordion-btn').removeClass('active');
					$thisLi.find('.sc_accordion-content').slideUp('400', function() {
						$(this).removeClass('active');
					});
				});
				if (currentStatus != "active") {
					$thisAccordionContent.not(':animated').slideDown();
					$this.addClass('active');
					$thisAccordionContent.addClass('active');
				}
			});

		}
		
	});



/*************************************************************
FLEXSLIDER INIT 

UNCOMMENT TO USE THIS SHORTCODES INIT INSTEAD OF THEME INIT
*************************************************************/

	// jQuery(window).load(function($){
	// 	$ = jQuery;

	// 	if ($('.sc_flexslider').size() > 0) {


	// 		var canonAnimImgSliderSlidershow = true;

	// 		$('.sc_flexslider').flexslider({
	// 			slideshow: canonAnimImgSliderSlidershow,
	// 			slideshowSpeed: 3000,
	// 			animationSpeed: 800,
	// 			animation: "fade",
	// 			smoothHeight: true,
	// 			touch: true,
	// 			prevText: "S",
	// 			nextText: "s",
	// 			start: function(slider){
	// 				$('body').removeClass('loading');
	// 			}
	// 		});

	// 	}

	// 	if (($('.sc_flexslider-quote').size() > 0) && ($('#hp_tweets').size() === 0)) {

	// 		var canonAnimQuoteSliderSlidershow = true;

	// 		$('.sc_flexslider-quote').flexslider({
	// 			slideshow: canonAnimQuoteSliderSlidershow,
	// 			slideshowSpeed: 3000,
	// 			animationSpeed: 800,
	// 			animation: "fade",
	// 			smoothHeight: true,
	// 			touch: true,
	// 			directionNav: false,
	// 			start: function(slider){
	// 				$('body').removeClass('loading');
	// 			}
	// 		});	 

	// 	}

	// });

