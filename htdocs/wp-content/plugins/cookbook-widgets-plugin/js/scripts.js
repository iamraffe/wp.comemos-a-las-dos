"use strict";

/*************************************************************
WIDGETS PLUGIN SCRIPTS

TWITTER FEED WITH THEME DESIGN
FACT BOX FITTEXT
TABS
ACCORDION
TOGGLE
ANIMATED NUMBER
DONUT CHART

*************************************************************/


/*************************************************************
TWITTER FEED WITH THEME DESIGN
*************************************************************/

	jQuery(document).ready(function($) {
		if ($('.twitter_theme_design').size() > 0) {

			var $twitterThemeDesignContainer = $('.twitter_theme_design');

			$twitterThemeDesignContainer.each(function(index) {

				var $this = $(this);

				var useThemeDesign = $this.attr('data-theme_design');
				if (useThemeDesign == "false") {
					$this.hide();
				} else {
					var $associatedTwitterWidget = $this.prev('.twitter_widget');
					$associatedTwitterWidget.hide();

					$(window).load(function() {
						//set vars
						var success = false;
						var delay = 100;
						var attempts = 10;

						for (var $i = 1; $i < attempts+1; $i++) {  
									
								setTimeout(function() {
									if (success === false) {
										var $twitterIframe = $this.prev('.twitter_widget').find('iframe');
									    if ($twitterIframe.contents().find('.timeline-Tweet').size() > 0) {
									    	success = true;	

											//get and post tweets
											var numTweets = $this.attr('data-num_tweets');
											var tweetCount = 0;
											$twitterIframe.contents().find('.timeline-Tweet').each(function(index, e){
												if (tweetCount == numTweets) return;
												var $this = $(this);
												var published = $this.find('time').text();
												var tweet = $this.find('.timeline-Tweet-text').html();
												var altTweet = "<li class='tweet'><span class='content'>" + tweet + "</span><span class='meta'>" + published + "</span></li>";
												var $associatedTwitterThemeDesignContainer = $twitterIframe.closest('.twitter_widget').next('.twitter_theme_design');
												$associatedTwitterThemeDesignContainer.find('ul').append(altTweet);
												tweetCount++;
											});
									    }
									}

								}, delay*$i);

						} // end fori

					}); // end on window load

				} // end if else

			}); // end each instance

		}

	});



/*************************************************************
FACT BOX FITTEXT
*************************************************************/

	jQuery(document).ready(function($) {
		
		if ($('.fittext').size() > 0) {
			if (typeof fitText == "function") {
				$('.fittext').each(function(index, el) {
					var $this = $(this);
					var ratio = $this.attr('data-ratio');
					fitText($this, ratio);
				});
			}
		}

	});



/*************************************************************
TABS

Works by determining the index of the tab clicked and pairing it with the content box that has the same index
*************************************************************/

	jQuery(document).ready(function($) {
		
		if ($('.canon-tabs li').size() > 0) {

			$('.canon-tabs li').on('click', function (event) {
				var $this = $(this);
				var $thisTabs = $this.closest('ul');
				var $thisTabsLIs = $thisTabs.find('li');
				var $thisTabsContainer = $thisTabs.next('.canon-tabs-container');
				var thisIndex = $thisTabsLIs.index($this);
				var $thisContentBoxes = $thisTabsContainer.find('.canon-tabs-content-box');
				var $associatedContentBox = $thisContentBoxes.eq(thisIndex);
				
				$thisTabsLIs.removeClass('active');
				$this.addClass('active');

				$thisContentBoxes.removeClass('active');
				$associatedContentBox.addClass('active');

			});
		}

	});

/*************************************************************
ACCORDION
*************************************************************/

	jQuery(document).ready(function($){

		if ($('.accordion-btn').size() > 0) {
			
			// initial states
			$('.accordion-content:not(.active)').hide();

			// accordion	  
			$('.accordion-btn').click(function(e){
				e.preventDefault();
				var $this = $(this);
				var $thisAccordionContent = $this.closest('li').find('.accordion-content');
				var currentStatus = "";
				if ($this.attr('class').indexOf('active') != -1) {
					currentStatus = "active";
				}
				//first close all and remove active class
				$this.closest('.accordion').find('li').each(function(index) {
					var $thisLi = $(this);
					$thisLi.find('.accordion-btn').removeClass('active');
					$thisLi.find('.accordion-content').slideUp('400', function() {
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
TOGGLE
*************************************************************/

	jQuery(document).ready(function($){

		if ($('.toggle-btn').size() > 0) {

			// initial states
			$('.toggle-content:not(.active)').hide();

			// toggle	  
			$('.toggle-btn').click(function(e){
				var $this = $(this);
				e.preventDefault();
				$this.closest('li').find('.toggle-content').not(':animated').slideToggle();
				$this.toggleClass("active");
			});
		}

	});



/*************************************************************
ANIMATED NUMBER
*************************************************************/

	jQuery(document).ready(function($){

		if ($('.canon_animated_number').size() > 0) {

			$('.canon_animated_number').each(function(index) {
				var $this = $(this);
				var number = parseInt($this.attr('data-number'));
				var useSeperator = $this.attr('data-seperator');
				var useSeperatorBoolean = (useSeperator == 'checked') ? true : false;
				var animationSpeed = parseInt($this.attr('data-animation_speed'));

				var $thisAnimatedNumberWrapper = $this.find('.canon_animated_number_wrapper');
				$thisAnimatedNumberWrapper.animateNumbers(number, useSeperatorBoolean, animationSpeed);
			});

		}

	});


