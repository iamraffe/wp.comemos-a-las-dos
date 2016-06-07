<?php

/****************************
SHORTCODE MECHANICS

LOAD TINYMCE PLUGINS
FIX SHORTCODE EMPTY PARAGRAPHS (AUTOFORMATTING)

****************************/


/****************************
LOAD TINYMCE PLUGINS
****************************/

	add_action('init', 'canon_sc_addbuttons');
	function canon_sc_addbuttons() {
		add_filter("mce_external_plugins", "canon_sc_add_tinymce_plugin");
		add_filter('mce_buttons', 'canon_sc_register_button');
	}

	function canon_sc_add_tinymce_plugin($plugin_array) {
		global $wp_version;

		// if WP version < 3.9 then load the legacy script
		if (version_compare($wp_version, '3.9') >= 0) {
			$filename = "tinymce_scripts.js.php";
		} else {
			$filename = "tinymce_scripts_legacy.js.php";
		}

		$plugin_array['canon_tinymce_shortcodes_plugin'] = plugins_url('', __FILE__)  . "/" . $filename;
		return $plugin_array;
	}
		 
	function canon_sc_register_button($buttons) {
	   array_push($buttons,"canon_tinymce_shortcodes_select"); //"seperator" will make a short space between buttons
	   return $buttons;
	}
	 
/****************************
FIX SHORTCODE EMPTY PARAGRAPHS (AUTOFORMATTING)
****************************/

	add_filter('the_content', 'shortcode_empty_paragraph_fix');
    function shortcode_empty_paragraph_fix($content)
    {   
        $array = array (
            '<p>[' => '[', 
            ']</p>' => ']', 
            ']<br />' => ']'
        );
        $content = strtr($content, $array);
        return $content;
    }


/****************************
THE SHORTCODES

LEAD
HIGHLIGHT
HORIZONTAL RULER
BUTTON
MESSAGE
TOGGLES
TOGGLE
ACCORDIONS
ACCORDION
LIGHTBOX
1C_LIGHTBOX_IMAGE
2C_LIGHTBOX_IMAGE
3C_LIGHTBOX_IMAGE
LIGHTBOX MEDIA
IMG_SLIDER
IMG_SLIDE
QUOTE_SLIDER
QUOTE_SLIDE
COLUMNS
COLUMN
GRAPHS
GRAPH
BLOCKQUOTE
LOREM

*****************************/


/****************************
LEAD
****************************/
add_shortcode('lead', 'sc_lead');
function sc_lead ($atts, $content) {
	
	extract(shortcode_atts(array (

		// empty

	), $atts));

	$output = "";
	$content = do_shortcode($content);
	$output .= "<p class='lead'>$content</p>";

	return $output;						
}

/****************************
HIGHLIGHT
****************************/
add_shortcode('highlight', 'sc_highlight');
function sc_highlight ($atts, $content) {
	
	extract(shortcode_atts(array (

		// empty

	), $atts));

	$output = "";
	$content = do_shortcode($content);
	$output .= "<span class='highlight'>$content</span>";

	return $output;						
}

/****************************
HORIZONTAL RULER
****************************/
add_shortcode('hr', 'sc_hr');
function sc_hr ($atts, $content) {
	
	extract(shortcode_atts(array (

		'style'				=> 'solid',

	), $atts));

	if ($style == "solid|dash|dots") { $style = "solid"; }
	$class = ($style != "solid") ? " class='$style'" : "";

	$output = "";
	$output .= "<hr$class/>";

	return $output;						
}


/****************************
BUTTON
****************************/
add_shortcode('button', 'sc_button');
function sc_button ($atts, $content) {
	
	extract(shortcode_atts(array (

		'url'				=> 'http://www.themecanon.com',
		'target'			=> '_self',
		'style'				=> 'normal',

	), $atts));

	if ($url == "url") { $url = "http://www.themecanon.com"; }
	if ($target == "_blank|_self") { $target = "_self"; }
	if ($style == "xsmall|small|normal") { $style = "normal"; }

	switch ($style) {
		case 'xsmall':
			$class = "btn xsmall-btn";
			break;
		case 'small':
			$class = "btn small-btn";
			break;
		default:
			$class = "btn";
			break;
	}

	$output = "";
	$output .= "<a href='$url' target='$target' class='$class'>$content</a>";

	return $output;						
}


/****************************
MESSAGE
****************************/
add_shortcode('message', 'sc_message');
function sc_message ($atts, $content) {
	
	extract(shortcode_atts(array (

		'type'				=> 'notice',

	), $atts));

	if ($type == "success|error|info|notice") { $type = "notice"; }

	$class = "message " . $type;

	$output = "";
	$output .= "<div class='$class'><em class='fa'></em>";
	$output .= do_shortcode($content);
	$output .= "</div>";

	return $output;						
}

/****************************
TOGGLES
****************************/
add_shortcode('toggles', 'sc_toggles');
function sc_toggles ($atts, $content) {
	
	extract(shortcode_atts(array (

		// empty

	), $atts));

	$output = "";
	$output .= "<ul class='sc_toggle'>";
	$output .= do_shortcode($content);
	$output .= "</ul>";

	return $output;						
}


/****************************
TOGGLE
****************************/
add_shortcode('toggle', 'sc_toggle');
function sc_toggle ($atts, $content) {
	
	extract(shortcode_atts(array (

		'title'				=> 'Toggle trigger',
		'active'			=> 'no',

	), $atts));

	if ($active == "yes|no") { $active = "no"; }
	$trigger_class = ($active == "yes") ? "sc_toggle-btn active" : "sc_toggle-btn";
	$content_class = ($active == "yes") ? "sc_toggle-content active" : "sc_toggle-content" ;
	$content = do_shortcode($content);

	$output = "";
	$output .= "<li>";
	$output .= "<a href='#' class='$trigger_class'>$title</a>";
	$output .= "<div class='$content_class'>";
	$output .= do_shortcode($content);
	$output .= "</div>";
	$output .= "</li>";

	return $output;						
}

/****************************
ACCORDIONS
****************************/
add_shortcode('accordions', 'sc_accordions');
function sc_accordions ($atts, $content) {
	
	extract(shortcode_atts(array (

		// empty

	), $atts));

	$output = "";
	$output .= "<ul class='sc_accordion'>";
	$output .= do_shortcode($content);
	$output .= "</ul>";

	return $output;						
}


/****************************
ACCORDION
****************************/
add_shortcode('accordion', 'sc_accordion');
function sc_accordion ($atts, $content) {
	
	extract(shortcode_atts(array (

		'title'				=> 'Accordion trigger',
		'active'			=> 'no',

	), $atts));

	if ($active == "yes|no") { $active = "no"; }
	$trigger_class = ($active == "yes") ? "sc_accordion-btn active" : "sc_accordion-btn";
	$content_class = ($active == "yes") ? "sc_accordion-content active" : "sc_accordion-content" ;
	$content = do_shortcode($content);

	$output = "";
	$output .= "<li>";
	$output .= "<a href='#' class='$trigger_class'>$title</a>";
	$output .= "<div class='$content_class'>";
	$output .= do_shortcode($content);
	$output .= "</div>";
	$output .= "</li>";

	return $output;						
}


/****************************
LIGHTBOX
****************************/
add_shortcode('lightbox', 'sc_lightbox');
function sc_lightbox ($atts, $content) {
	
	extract(shortcode_atts(array (

		// empty

	), $atts));

	$output = "";
	$output .= "<div class='clearfix'>";
	$output .= do_shortcode($content);
	$output .= "</div>";

	return $output;						
}


/****************************
1C_LIGHTBOX_IMAGE
****************************/
add_shortcode('1c_lightbox_image', 'sc_1c_lightbox_image');
function sc_1c_lightbox_image ($atts, $content) {
	
	extract(shortcode_atts(array (

		'title'				=> 'Image',
		'src'				=> '',
		'group'				=> 'all',

	), $atts));

	if ($group == "gallery|all") { $group = "all"; }

	$fancybox_group = ($group == "all") ? "" : "data-fancybox-group='" . $group ."'" ;

	$output = "";
	$output .= "<div class='mosaic-block circle'>";
	$output .= "<a href='$src' class='mosaic-overlay fancybox' $fancybox_group title='$title'></a>";
	$output .= "<div class='mosaic-backdrop'>";
	$output .= "<img src='$src' alt='$title' />";
	$output .= "</div>";
	$output .= "</div>";

	return $output;						
}

/****************************
2C_LIGHTBOX_IMAGE
****************************/
add_shortcode('2c_lightbox_image', 'sc_2c_lightbox_image');
function sc_2c_lightbox_image ($atts, $content) {
	
	extract(shortcode_atts(array (

		'title'				=> 'Image',
		'group'				=> 'all',
		'src'				=> '',
		'last'				=> 'no'

	), $atts));

	if ($group == "gallery|all") { $group = "all"; }

	$fancybox_group = ($group == "all") ? "" : "data-fancybox-group='" . $group ."'" ;

	$class = ($last == "yes") ? 'mosaic-block circle half last' : 'mosaic-block circle half';

	$output = "";
	$output .= "<div class='$class'>";
	$output .= "<a href='$src' class='mosaic-overlay fancybox' $fancybox_group title='$title'></a>";
	$output .= "<div class='mosaic-backdrop'>";
	$output .= "<img src='$src' alt='$title' />";
	$output .= "</div>";
	$output .= "</div>";

	return $output;						
}

/****************************
3C_LIGHTBOX_IMAGE
****************************/
add_shortcode('3c_lightbox_image', 'sc_3c_lightbox_image');
function sc_3c_lightbox_image ($atts, $content) {
	
	extract(shortcode_atts(array (

		'title'				=> 'Image',
		'group'				=> 'all',
		'src'				=> '',
		'last'				=> 'no'

	), $atts));

	if ($group == "gallery|all") { $group = "all"; }

	$fancybox_group = ($group == "all") ? "" : "data-fancybox-group='" . $group ."'" ;

	$class = ($last == "yes") ? 'mosaic-block circle third last' : 'mosaic-block circle third';

	$output = "";
	$output .= "<div class='$class'>";
	$output .= "<a href='$src' class='mosaic-overlay fancybox' $fancybox_group title='$title'></a>";
	$output .= "<div class='mosaic-backdrop'>";
	$output .= "<img src='$src' alt='$title' />";
	$output .= "</div>";
	$output .= "</div>";

	return $output;						
}

/****************************
LIGHTBOX MEDIA
****************************/
add_shortcode('lightbox_media', 'sc_lightbox_media');
function sc_lightbox_media ($atts, $content) {
	
	extract(shortcode_atts(array (

		'title'				=> 'Image',
		'group'				=> 'all',
		'src'				=> '',

	), $atts));

	if ($group == "gallery|all") { $group = "all"; }

	$fancybox_group = ($group == "all") ? "" : "data-fancybox-group='" . $group ."'" ;

	$output = "";
	$output .= "<div class='clearfix'>";
	$output .= "<div class='mosaic-block circle'>";
	$output .= "<a href='$content' class='mosaic-overlay fancybox-media fancybox.iframe play' $fancybox_group rel='gallery'></a>";
	$output .= "<div class='mosaic-backdrop'>";
	$output .= "<img src='$src' alt='$title' />";
	$output .= "</div>";
	$output .= "</div>";
	$output .= "</div>";

	return $output;						
}


/****************************
IMG_SLIDER
****************************/
add_shortcode('img_slider', 'sc_img_slider');
function sc_img_slider ($atts, $content) {
	
	extract(shortcode_atts(array (

		// empty

	), $atts));

	$output = "";
	$output .= "<div class='flexslider flexslider-default sc_flexslider'><ul class='slides'>";
	$output .= do_shortcode($content);
	$output .= "</ul></div>";

	return $output;						
}


/****************************
IMG_SLIDE
****************************/
add_shortcode('img_slide', 'sc_img_slide');
function sc_img_slide ($atts, $content) {
	
	extract(shortcode_atts(array (

		'alt'				=> 'alt',
		'src'				=> '',

	), $atts));

	$output = "";
	$output .= "<li>";
	$output .= "<img src='$src' alt='$alt'/>";
	$output .= "</li>";

	return $output;						
}

/****************************
QUOTE_SLIDER
****************************/
add_shortcode('quote_slider', 'sc_quote_slider');
function sc_quote_slider ($atts, $content) {
	
	extract(shortcode_atts(array (

		// empty

	), $atts));

	$output = "";
	$output .= "<div class='flexslider flexslider-quote sc_flexslider-quote sc_quote_slider'><ul class='slides'>";
	$output .= do_shortcode($content);
	$output .= "</ul></div>";

	return $output;						
}


/****************************
QUOTE_SLIDE
****************************/
add_shortcode('quote_slide', 'sc_quote_slide');
function sc_quote_slide ($atts, $content) {
	
	extract(shortcode_atts(array (

		'byline'			=> 'anonymous',

	), $atts));

	$output = "";
	$output .= "<li>";
	$output .= "<blockquote>$content<cite>$byline</cite></blockquote>";
	$output .= "</li>";

	return $output;						
}

/****************************
COLUMNS
****************************/
add_shortcode('columns', 'sc_columns');
function sc_columns ($atts, $content) {
	
	extract(shortcode_atts(array (

		// empty

	), $atts));

	$output = "";
	$output .= "<div class='clearfix'>";
	$output .= do_shortcode($content);
	$output .= "</div>";

	return $output;						
}


/****************************
COLUMN
****************************/
add_shortcode('column', 'sc_column');
function sc_column ($atts, $content) {
	
	extract(shortcode_atts(array (

		'size'			=> 'third',
		'last'			=> 'no',

	), $atts));

	if ($size == "half|third|fourth|two-thirds|three-fourths") { $size = "third"; }
	if ($last == "yes|no") { $last = "no"; }
	$class = $size;
	$class = ($last == "yes") ? $class . " last" : $class;


	$output = "";
	$output .= "<div class='$class'>";
	$output .= do_shortcode($content);
	$output .= "</div>";

	return $output;						
}


/****************************
GRAPHS
****************************/
add_shortcode('graphs', 'sc_graphs');
function sc_graphs ($atts, $content) {
	
	extract(shortcode_atts(array (

		// empty

	), $atts));

	$output = "";
	$output .= "<ol class='sc_graphs'>";
	$output .= do_shortcode($content);
	$output .= "</ol>";

	return $output;						
}


/****************************
GRAPH
****************************/
add_shortcode('graph', 'sc_graph');
function sc_graph ($atts, $content) {
	
	extract(shortcode_atts(array (

		'percentage'			=> '50',
		'color'					=>  '#ff6666',

	), $atts));

	if ($percentage == "10|20|30|40|50|60|70|80|90|100") { $percentage = "50"; }
	if ($color == "green|yellow|red|blue|#ff6666") { $color = "#ff6666"; }

	$output = "";
	$output .= "<li><div class='per-$percentage' style='background-color:$color;'>";
	$output .= "$content <span>$percentage%</span>";
	$output .= "</div></li>";

	return $output;						
}

/****************************
BLOCKQUOTE
****************************/
add_shortcode('blockquote', 'sc_blockquote');
function sc_blockquote ($atts, $content) {
	
	extract(shortcode_atts(array (

		'size'			=> 'full',
		'align'			=> 'left',
		'byline'		=> '',

	), $atts));

	if ($size == "full|half|third|fourth|two-thirds|three-fourths") { $size = "full"; }
	if ($align == "left|right") { $align = "left"; }

	$class = "sc_blockquote " . $size;
	$class = ($align == "left") ? $class .= " left" : $class .= " right last";

	$output = "";
	$output .= "<blockquote class='$class'>";
	$output .= do_shortcode($content);
	if (!empty($byline)) { $output .= "<cite> - $byline</cite>"; }
	$output .= "</blockquote>";


	return $output;						
}



/****************************
LOREM
****************************/
add_shortcode('lorem', 'sc_lorem');
function sc_lorem ($atts, $content) {
	
	extract(shortcode_atts(array (

		'paragraphs'	=> '1',

	), $atts));

	if ($paragraphs > 10) { $paragraphs = 10; }

	$fulltext = "
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sed lorem a libero condimentum euismod ornare et turpis. Integer posuere ornare nulla, cursus viverra risus lobortis ullamcorper. Maecenas ut diam nec quam volutpat sollicitudin egestas et nulla. Suspendisse aliquam dolor egestas eros placerat porttitor. Nam dictum ultrices elit eu ullamcorper. Duis auctor sem a felis vulputate lobortis. Praesent auctor nunc nulla, a blandit lacus. Proin molestie volutpat facilisis. Pellentesque accumsan, elit quis lobortis eleifend, sem nisl ultrices velit, placerat vulputate purus neque et eros. Nullam elit dui, mollis id euismod id, pretium sed augue. Integer tristique tincidunt sem sed faucibus. Praesent commodo pulvinar mollis. Nulla mollis convallis nulla vitae tincidunt. Phasellus in dictum urna.
	\x00	 
		Pellentesque tincidunt feugiat ipsum, non aliquet nisl scelerisque at. Integer aliquam vehicula bibendum. Ut vitae dui at eros volutpat hendrerit. In euismod nisl luctus elit tempor semper. Maecenas semper congue mi vitae tristique. In vitae lacinia ipsum. Maecenas elementum interdum enim, feugiat interdum odio volutpat sed. Ut in nisi turpis. Cras elit nibh, scelerisque vel auctor semper, malesuada id eros. Duis pellentesque hendrerit tortor a facilisis. Maecenas aliquam tempor diam eleifend rutrum. Donec sed orci sapien, eu fermentum tellus. Nullam cursus metus quis arcu feugiat auctor id sit amet dui. Etiam et lectus ut mi tristique bibendum ac et libero. Quisque tellus odio, congue non mollis id, iaculis id lorem.
	\x00		 
		Ut molestie, ante lacinia imperdiet tincidunt, ligula nibh feugiat lacus, ac tempor velit neque ut diam. Aliquam magna felis, suscipit et varius nec, tincidunt ac tellus. Nunc diam mi, tristique nec convallis id, congue eget eros. Aenean euismod eros vel tortor pellentesque semper. Morbi vitae turpis nunc, id rutrum purus. Aenean in lacus a dui malesuada pretium sed feugiat metus. Mauris vel turpis erat, ullamcorper hendrerit nunc. Sed rhoncus leo id purus egestas semper. Nulla sed quam dui. Cras in convallis tortor.
	\x00		 
		Morbi faucibus pretium pellentesque. Cras pretium auctor ligula ac venenatis. Pellentesque at justo orci, pharetra cursus turpis. Aliquam erat volutpat. Vestibulum orci felis, cursus eu ultricies viverra, iaculis eu enim. Mauris sagittis mauris posuere odio commodo non molestie sem sollicitudin. Nullam a fringilla sem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum viverra, justo eu tincidunt aliquam, enim leo dictum libero, at tincidunt nisi est eu elit. Fusce quis urna tortor, vel vulputate libero. Proin venenatis sem eget est pretium lobortis. Maecenas luctus fermentum nibh, ac laoreet felis gravida ac.
	\x00		 
		Nunc lectus arcu, lacinia nec sollicitudin eu, pretium at leo. Mauris leo arcu, congue nec mollis at, venenatis eu neque. Quisque augue magna, laoreet vitae blandit non, suscipit vel metus. Mauris congue viverra mollis. Etiam eget augue vitae felis dapibus rhoncus at a quam. Nam placerat vehicula venenatis. Cras nec odio at metus euismod molestie. Cras nec orci nec leo ultrices pulvinar ac vitae arcu. Fusce blandit, quam a facilisis faucibus, risus sapien ultrices leo, id sagittis magna enim non urna. Vestibulum fringilla, lorem eu bibendum sollicitudin, risus magna porttitor lectus, in porttitor justo urna a nisl. Ut eget libero nec enim scelerisque cursus ac nec justo. Nunc tellus mauris, consequat non viverra quis, pharetra ut ipsum.
	\x00		 
		Fusce nec lectus turpis, sed sodales lorem. Integer tristique lacinia tellus, a dictum elit lobortis et. Ut dictum, lectus eu commodo lacinia, diam ante congue ligula, sit amet placerat lectus ligula hendrerit massa. In hac habitasse platea dictumst. Vestibulum turpis ante, rutrum at consectetur at, feugiat sed mauris. Pellentesque scelerisque ultrices libero ultrices lacinia. Pellentesque id enim id mi ultricies dictum id vitae ante. Nam pulvinar molestie purus vel rhoncus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam placerat lacus quis enim auctor malesuada. Etiam eget mauris ut augue vulputate imperdiet. Sed dapibus libero consectetur sem sodales mollis. Ut ornare eleifend lectus at gravida. Morbi mollis scelerisque feugiat. Cras commodo, purus ac eleifend posuere, est nunc laoreet quam, a elementum sapien eros sed quam. Vestibulum vitae erat eu purus auctor vulputate.
	\x00		 
		Mauris purus nisl, dapibus vel volutpat sit amet, lobortis non justo. Duis mollis consectetur sem ac lacinia. In hac habitasse platea dictumst. Maecenas ut purus turpis, eu volutpat sapien. Vestibulum dolor orci, congue sit amet pulvinar in, adipiscing at urna. Nunc condimentum tincidunt quam in pulvinar. Nam non tellus dui, eu tincidunt massa. Sed lacus lorem, consequat nec mattis a, posuere at augue. Nullam lacinia suscipit lorem ac faucibus. Duis sollicitudin porta nisi, at aliquam neque congue nec. Maecenas luctus, ligula quis sagittis placerat, sapien mauris sagittis quam, non faucibus ipsum mauris accumsan nulla. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus tempus risus quam. Pellentesque mollis tellus quis justo egestas viverra. Vestibulum molestie tortor at ipsum consequat eu laoreet mi volutpat. Curabitur suscipit posuere libero, id adipiscing nisl imperdiet sed.
	\x00		 
		Fusce varius porta dictum. Duis lobortis mi vitae purus sagittis id rutrum nisi semper. Suspendisse varius luctus eros quis scelerisque. Curabitur dictum condimentum augue eget elementum. Pellentesque magna lorem, auctor vitae venenatis in, hendrerit non mi. Nunc sit amet justo in elit volutpat consectetur. Nulla aliquet pellentesque laoreet. Morbi ut nunc ante, sit amet fringilla leo. Nullam non est dolor, vitae rhoncus turpis.
	\x00		 
		Quisque et sapien magna, at cursus mauris. Nam quis massa nec lacus scelerisque malesuada vel ut nulla. Sed quis quam non justo pellentesque sagittis. Aliquam a arcu ac urna vehicula hendrerit. Morbi leo ligula, tincidunt semper tincidunt sit amet, condimentum non ante. Ut non arcu sit amet eros mollis accumsan. Vestibulum iaculis, purus eget sagittis molestie, odio nisi tincidunt ipsum, sed pulvinar tortor magna a odio. Quisque viverra viverra nibh sed sollicitudin. Maecenas gravida, augue ut elementum accumsan, metus tellus posuere libero, id scelerisque ante urna at odio. Nam faucibus libero eget arcu elementum iaculis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
	\x00		 
		Suspendisse risus neque, pulvinar id sagittis nec, viverra eget mi. Proin vel leo sed risus tempor porttitor eu eu velit. Praesent placerat arcu ac lorem varius vitae dapibus est varius. Vestibulum auctor diam quis dolor laoreet sit amet porta libero molestie. Maecenas quis sapien non mi venenatis molestie eget nec ipsum. Donec et nibh et leo aliquet rhoncus id nec sapien. Nullam vulputate urna et nisi egestas sagittis. Donec magna elit, molestie non placerat lobortis, ullamcorper elementum purus. Quisque venenatis, justo at dignissim sagittis, nibh purus tristique augue, ut gravida augue dolor quis nisl. Duis at enim a nunc porttitor commodo eget quis mauris. Fusce hendrerit eleifend lectus at blandit. Fusce pharetra mauris quis justo porta eget consequat tortor aliquam. Sed eu enim id est lobortis luctus. Praesent rhoncus pulvinar enim sed mattis. Nulla vitae dolor at orci porta imperdiet eu sagittis velit. Sed porttitor turpis quis turpis tempus fringilla.
 	";

 	$fulltext_array = explode("\x00", $fulltext);
 	$output = "";
 	
 	for ($i = 0; $i < $paragraphs; $i++) {  
 		$output .= "<p>$fulltext_array[$i]</p>";
 	}

	return $output;						
}

