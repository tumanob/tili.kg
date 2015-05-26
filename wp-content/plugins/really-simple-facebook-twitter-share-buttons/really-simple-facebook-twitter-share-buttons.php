<?php
/*
Plugin Name: Really Simple Share
Plugin URI: http://www.whiletrue.it/really-simple-facebook-twitter-share-buttons-for-wordpress/
Description: Puts Facebook, Twitter, LinkedIn, Google "+1", Pinterest and other share buttons of your choice above or below your posts.
Author: Dabelon, tanaylakhani
Version: 4.2.0
Author URI: http://www.readygraph.com
*/

/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2, 
    as published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

// RETRIEVE PLUGIN EXTERNAL FUNCTIONS

require_once('really-simple-share-options.php');
require_once('really-simple-share-counts.php');


// RETRIEVE OPTIONS

$really_simple_share_option = really_simple_share_get_options_stored();


// ACTION AND FILTERS

add_action('init', 'really_simple_share_init');
add_action('admin_menu', 'really_simple_share_menu');
add_filter('plugin_action_links', 'really_simple_share_add_settings_link', 10, 2);
add_shortcode( 'really_simple_share', 'really_simple_share_shortcode' );

if ($really_simple_share_option['scripts_at_bottom']) {
	add_action('wp_footer', 'really_simple_share_scripts');
} else {
	add_action('wp_head',   'really_simple_share_scripts');
}

if (($really_simple_share_option['active_buttons']['facebook_like'] && $really_simple_share_option['facebook_like_html5'])
  || $really_simple_share_option['active_buttons']['facebook_share_new']) {
	add_action('wp_footer', 'really_simple_share_facebook_like_html5_bottom_scripts');
}

if (!$really_simple_share_option['disable_default_styles']) {
	add_action('wp_print_styles', 'really_simple_share_style');
}

add_filter('the_content', 'really_simple_share_content');
if (!$really_simple_share_option['disable_excerpts']) {
	add_filter('the_excerpt', 'really_simple_share_excerpt');
}


// PUBLIC FUNCTIONS

function really_simple_share_scripts () {
  // IF PERFORMANCE MODE IS ACTIVE, CHECK SKIP BUTTONS
  if (really_simple_share_skip_buttons(true)) {
		return '';
  }

	really_simple_share_adjust_locale();
	
	global $really_simple_share_option;

	$out = '';

	if ($really_simple_share_option['active_buttons']['twitter']) {
		$out .= '
      !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
      ';
  }

	if ($really_simple_share_option['active_buttons']['google1'] 
	||  $really_simple_share_option['active_buttons']['google_share']
	||  $really_simple_share_option['active_buttons']['youtube']) {
		$out .= '
      window.___gcfg = {lang: "'.substr($really_simple_share_option['locale'],0,2).'"};
		  (function() {
		    var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
		    po.src = "https://apis.google.com/js/plusone.js";
		    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
		  })();
      ';
	}

	if ($really_simple_share_option['active_buttons']['pinterest']) {
		$hover = ($really_simple_share_option['pinterest_hover']!='') ? ' p.setAttribute(\'data-pin-hover\', true); ' : '';
		$out .= '
			(function(d){
				var pinit_already_loaded = false;
				if(document.getElementsByClassName && document.getElementsByTagName) {
					var pinit_class_tags = document.getElementsByClassName("really_simple_share_pinterest");
					for(i=0; i < pinit_class_tags.length; i++) {
						if(pinit_class_tags[i].getElementsByTagName("span").length > 0) {
							pinit_already_loaded = true;
						}	
					}
				}
				if (!pinit_already_loaded) {
				  var f = d.getElementsByTagName(\'SCRIPT\')[0], p = d.createElement(\'SCRIPT\');
				  p.type = \'text/javascript\';
				  '.$hover.'
				  p.async = true;
				  p.src = \'//assets.pinterest.com/js/pinit.js\';
				  f.parentNode.insertBefore(p, f);
				}
			}(document));
      ';
	}
  
  if ($out != '') {
  	echo '<script type="text/javascript">
        //<![CDATA[
        '.$out.'
        //]]>
  		</script>';
  }
}


function really_simple_share_facebook_like_html5_bottom_scripts () {
  // IF PERFORMANCE MODE IS ACTIVE, CHECK SKIP BUTTONS
  if (really_simple_share_skip_buttons(true)) {
		return '';
  }

	really_simple_share_adjust_locale();

	global $really_simple_share_option;

	$app_id = (is_numeric($really_simple_share_option['facebook_like_appid'])) ? '&appId='.$really_simple_share_option['facebook_like_appid'] : '';
	$out = '
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/'.$really_simple_share_option['locale'].'/sdk.js#xfbml=1'.$app_id.'&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, \'script\', \'facebook-jssdk\'));</script>';
	echo $out;
}


function really_simple_share_init ($force=false) {
	load_plugin_textdomain('really-simple-share', false, basename(dirname(__FILE__)).'/lang');

	// THE REST IS DISABLED IN THE ADMIN PAGES
	if (is_admin()) {
		wp_enqueue_script('jquery-ui-sortable');
    if (!$force) {
		  return;
    }
	}

  // IF PERFORMANCE MODE IS ACTIVE, CHECK SKIP BUTTONS
  if (really_simple_share_skip_buttons(true)) {
		return '';
  }
  
	global $really_simple_share_option;

	if ($really_simple_share_option['active_buttons']['linkedin']) {
		wp_enqueue_script('really_simple_share_linkedin', 'https://platform.linkedin.com/in.js', array(), false, $really_simple_share_option['scripts_at_bottom']);
	}
	// BUFFER JS ONLY WORKS ON BOTTOM
	if ($really_simple_share_option['active_buttons']['buffer'] and $really_simple_share_option['scripts_at_bottom']) {
		wp_enqueue_script('really_simple_share_buffer', 'http://static.bufferapp.com/js/button.js', array(), false, $really_simple_share_option['scripts_at_bottom']);
	}
	if ($really_simple_share_option['active_buttons']['flattr']) {
		wp_enqueue_script('really_simple_share_flattr', 'https://api.flattr.com/js/0.6/load.js?mode=auto&#038;ver=0.6', array(), false, $really_simple_share_option['scripts_at_bottom']);
	}
  // FRYPE LIB HAS TO BE IN THE HEADER
	if ($really_simple_share_option['active_buttons']['frype']) {
		wp_enqueue_script('really_simple_share_frype', 'https://www.draugiem.lv/api/api.js', array(), false);
	}
	// Readygraph Related Tags LIB HAS TO BE IN THE HEADER
	if ($really_simple_share_option['active_buttons']['readygraph_infolinks']) {
		//wp_enqueue_script('really_simple_share_frype', 'https://www.draugiem.lv/api/api.js', array(), false);
	}
	if ($really_simple_share_option['active_buttons']['tumblr']) {
		wp_enqueue_script('really_simple_share_tumblr', 'http://platform.tumblr.com/v1/share.js', array(), false, $really_simple_share_option['scripts_at_bottom']);
	}
	if ($really_simple_share_option['active_buttons']['bitcoin'] || $really_simple_share_option['active_buttons']['litecoin']) {
    // ALWAYS IN THE HEADER, OTHERWHISE THE WIDGET IS UNABLE TO LOAD
		wp_enqueue_script('really_simple_share_bitcoin', 'http://coinwidget.com/widget/coin.js');
	}
}    


function really_simple_share_style () {
  // IF PERFORMANCE MODE IS ACTIVE, CHECK SKIP BUTTONS
  if (really_simple_share_skip_buttons(true)) {
		return '';
  }

 	$myStyleUrl  = plugin_dir_url (__FILE__).'style.css';
	$myStyleFile = plugin_dir_path(__FILE__).'style.css';
	if ( file_exists($myStyleFile) ) {
	    wp_register_style('really_simple_share_style', $myStyleUrl);
	    wp_enqueue_style ('really_simple_share_style');
	}
}


function really_simple_share_menu () {
	if( file_exists(plugin_dir_path( __FILE__ ).'/readygraph-extension.php')) {
	global $menu_slug;
	add_menu_page( __( 'Really Simple Share', 'really-simple-share' ), __( 'Really Simple Share', 'really-simple-share' ), 'admin_dashboard', 'really-simple-share', 'readygraph_rsftsb_menu_page' );
	add_submenu_page('really-simple-share', 'Readygraph App', __( 'Readygraph App', 'really-simple-share' ), 'administrator', $menu_slug, 'readygraph_rsftsb_menu_page');
	add_submenu_page('really-simple-share', 'Share Options', __( 'Share Options', 'really-simple-share' ), 'administrator', 'really-simple-share-options', 'really_simple_share_options');
	add_submenu_page('really-simple-share', 'Share Counts', __( 'Share Counts', 'really-simple-share' ), 'administrator', 'really-simple-share-counts', 'really_simple_share_counts');
	add_submenu_page('really-simple-share', 'Go Premium', __( 'Go Premium', 'really-simple-share' ), 'administrator', 'readygraph-go-premium', 'readygraph_rsftsb_premium_page');
	}
	else {
	add_menu_page( __( 'Really Simple Share', 'really-simple-share' ), __( 'Really Simple Share', 'really-simple-share' ), 'admin_dashboard', 'really-simple-share', 'really_simple_share_options' );
	add_submenu_page('really-simple-share', 'Share Options', __( 'Share Options', 'really-simple-share' ), 'administrator', 'really-simple-share-options', 'really_simple_share_options');
	add_submenu_page('really-simple-share', 'Share Counts', __( 'Share Counts', 'really-simple-share' ), 'administrator', 'really-simple-share-counts', 'really_simple_share_counts');

	}
}

function readygraph_rsftsb_premium_page(){
	include('extension/readygraph/go-premium.php');
}
function readygraph_rsftsb_menu_page(){
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'signup-popup':
			include('extension/readygraph/signup-popup.php');
			break;
		case 'invite-screen':
			include('extension/readygraph/invite-screen.php');
			break;
		case 'social-feed':
			include('extension/readygraph/social-feed.php');
			break;
		case 'site-profile':
			include('extension/readygraph/site-profile.php');
			break;
		case 'customize-emails':
			include('extension/readygraph/customize-emails.php');
			break;
		case 'deactivate-readygraph':
			include('extension/readygraph/deactivate-readygraph.php');
			break;
		case 'welcome-email':
			include('extension/readygraph/welcome-email.php');
			break;
		case 'retention-email':
			include('extension/readygraph/retention-email.php');
			break;
		case 'invitation-email':
			include('extension/readygraph/invitation-email.php');
			break;	
		case 'faq':
			include('extension/readygraph/faq.php');
			break;
		case 'monetization-settings':
			include('extension/readygraph/monetization.php');
			break;
		default:
			include('extension/readygraph/admin.php');
			break;
	}

}


function really_simple_share_add_settings_link($links, $file) {
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
 
	if ($file == $this_plugin){
		$settings_link = '<a href="admin.php?page=really_simple_share_options">'.__("Settings").'</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
} 


function really_simple_share_content ($content) {
	return really_simple_share ($content, 'the_content');
}


function really_simple_share_excerpt ($content) {
	return really_simple_share ($content, 'the_excerpt');
}


// FUNCTION USED TO CHECK IF I NEED TO SKIP THE SHARE BUTTONS IN THE GIVEN CONTEXT
function really_simple_share_skip_buttons ($check_performance_mode = false) {
	global $really_simple_share_option;
	$option = $really_simple_share_option;
  
  if ($check_performance_mode) {
    // ONLY CHECK SKIP IF PERFORMANCE MODE IS ACTIVE
    if (isset($option['performance_mode']) && $option['performance_mode'] === false) {
      return false;
    }
  }

	$post_type = get_post_type();
  if (in_array($post_type, get_post_types(array('_builtin'=>false)))) {
		if (!$option['show_in_custom'][$post_type]) { return true; }
    return false;
  } else if (is_single()) {
		if (!$option['show_in']['posts']) { return true; }
    return false;
	} else if (is_singular() and !is_front_page()) {
		if (!$option['show_in']['pages']) {	return true; }
    return false;
	} else if (is_home() or is_front_page()) {
		if (!$option['show_in']['home_page']) {	return true; }
    return false;
	} else if (is_tag()) {
		if (!$option['show_in']['tags']) { return true; }
    return false;
	} else if (is_category()) {
		if (!$option['show_in']['categories']) { return true; }
    return false;
	} else if (is_date()) {
		if (!$option['show_in']['dates']) { return true; }
    return false;
	} else if (is_author()) {
		//IF DISABLED INSIDE PAGES
		if (!$option['show_in']['authors']) { return true; }
    return false;
	} else if (is_search()) {
		if (!$option['show_in']['search']) { return true; }
    return false;
	} else {
		// IF NONE OF PREVIOUS, IS DISABLED
		return true;
	}
}


function really_simple_share ($content, $filter, $link='', $title='', $author='', $force_button='') {
	static $last_execution = '';

	$content = do_shortcode( $content );
	
	// IF the_excerpt IS EXECUTED AFTER the_content MUST DISCARD ANY CHANGE MADE BY the_content
	if ($filter=='the_excerpt' and $last_execution=='the_content') {
		// WE TEMPORARILY REMOVE CONTENT FILTERING, THEN CALL THE_EXCERPT
		remove_filter('the_content', 'really_simple_share_content');
		$last_execution = 'the_excerpt';
		return the_excerpt();
	}
	if ($filter=='the_excerpt' and $last_execution=='the_excerpt') {
		// WE RESTORE THE PREVOIUSLY REMOVED CONTENT FILTERING, FOR FURTHER EXECUTIONS (POSSIBLY NOT INVOLVING 
		add_filter('the_content', 'really_simple_share_content');
	}

	// IF THE "DISABLE" CUSTOM FIELD IS FOUND, BLOCK EXECUTION
	// unless the shortcode was used in which case assume the disable
	// should be overridden, allowing us to disable general settings for a page
	// but insert buttons in a particular content area
	$custom_field_disable = get_post_custom_values('really_simple_share_disable');
	if ($custom_field_disable[0]=='yes' and $filter!='shortcode') {
		return $content;
	}
	
	//GET ARRAY OF STORED VALUES
	really_simple_share_adjust_locale();
	global $really_simple_share_option;
	$option = $really_simple_share_option;

	if ($filter!='shortcode') {
    if (really_simple_share_skip_buttons()) {
			return $content;
    }
    /*
    // OLD STYLE CHECK
		$post_type = get_post_type();
    if (in_array($post_type, get_post_types(array('_builtin'=>false)))) {
			if (!$option['show_in_custom'][$post_type]) { return $content; }
    } else if (is_single()) {
			if (!$option['show_in']['posts']) { return $content; }
		} else if (is_singular() and !is_front_page()) {
			if (!$option['show_in']['pages']) {	return $content; }
		} else if (is_home() or is_front_page()) {
			if (!$option['show_in']['home_page']) {	return $content; }
		} else if (is_tag()) {
			if (!$option['show_in']['tags']) { return $content; }
		} else if (is_category()) {
			if (!$option['show_in']['categories']) { return $content; }
		} else if (is_date()) {
			if (!$option['show_in']['dates']) { return $content; }
		} else if (is_author()) {
			//IF DISABLED INSIDE PAGES
			if (!$option['show_in']['authors']) { return $content; }
		} else if (is_search()) {
			if (!$option['show_in']['search']) { return $content; }
		} else {
			// IF NONE OF PREVIOUS, IS DISABLED
			return $content;
		}
    */
	}
	$first_shown = false; // NO PADDING FOR THE FIRST BUTTON
	
	// IF LINK OR TITLE ARE NOT SET, USE DEFAULT FUNCTIONS
	if ($link=='') {
		$link = ($option['use_shortlink']) ? wp_get_shortlink() : get_permalink();
	}
	if ($title=='') {
		$title = get_the_title();
		$author = get_the_author_meta('nickname');
	}	
	
	$height = ($option['layout']!='box') ? 33 : 66;
	$div_button_open = '<div style="min-height:'.$height.'px;" class="really_simple_share really_simple_share_'.$option['layout'].' robots-nocontent snap_nopreview">';

	$out = '';

	foreach (explode(',',$option['sort']) as $name) {
		if (!isset($option['active_buttons'][$name]) || !$option['active_buttons'][$name]) {
			continue;
		}
		
		// IF A SINGLE BUTTON IS FORCED (E.G. BY SHORTCODE, SKIP ALL OTHERS)
		if ($force_button!='' && $force_button!=$name) {
			continue;
		}
		
		// OPEN THE BUTTON DIV
		$out .= '<div class="really_simple_share_'.$name.'" style="width:'.$option['width_buttons'][$name].'px;">';
		
		if ($name == 'facebook_share') {
			// REMOVE HTTP:// FROM STRING
			$facebook_link = (substr($link,0,7)=='http://') ? substr($link,7) : $link;
			$out .= '<a name="fb_share" rel="nofollow" href="https://www.facebook.com/sharer.php?u='.rawurlencode($facebook_link).'&amp;t='.rawurlencode($title).'" title="Share on Facebook" target="_blank">'.stripslashes($option['facebook_share_text']).'</a>';
		}
		else if ($name == 'facebook_like') {
			$option_layout = ($option['layout']=='box') ? 'box_count' : 'button_count';
      $facebook_link = ($option['facebook_like_fixed_url']!='') ? $option['facebook_like_fixed_url'] : $link;

			if ($option['facebook_like_html5']) {
				// HTML5 VERSION
				$option_data_send = ($option['facebook_like_send']) ? 'data-share="true"' : '';
				$option_facebook_like_text = ($option['facebook_like_text']=='recommend') ? 'data-action="recommend"' : '';

				$out .= '<div class="fb-like" data-href="'.$facebook_link.'" data-layout="'.$option_layout.'" data-width="'.$option['width_buttons'][$name].'" '.$option_data_send.$option_facebook_like_text.'></div>';
			} else {
				$option_facebook_like_text = ($option['facebook_like_text']=='recommend') ? '&amp;action=recommend' : '';
  			$appid = (is_numeric($option['facebook_like_appid'])) ? '&amp;appId='.$option['facebook_like_appid'] : '';
  			$option_height = ($option['layout']=='box') ? 62 : 27;
			
				// IFRAME VERSION
				$out .= '<iframe src="//www.facebook.com/plugins/like.php?href='.rawurlencode($facebook_link).'&amp;layout='.$option_layout.'&amp;width='.$option['width_buttons'][$name].'&amp;height='.$option_height.'&amp;locale='.$option['locale'].$option_facebook_like_text.$appid.'" 
							scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$option['width_buttons'][$name].'px; height:'.$option_height.'px;" allowTransparency="true"></iframe>';
				// FACEBOOK LIKE SEND BUTTON ONLY AVAILABLE IN FBML MODE	
				if ($option['facebook_like_send']) {
					$out .= '</div>';
					static $facebook_like_send_script_inserted = false;
					if (!$facebook_like_send_script_inserted) {
					
						$out .= '<div id="fb-root"></div>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/'.$option['locale'].'/all.js#xfbml=1&status=0'.$app_id.'&version=v2.0";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, "script", "facebook-jssdk"));</script>';
						$facebook_like_send_script_inserted = true;
					}
					$out .= '
						<div class="really_simple_share_facebook_like_send">
						<div class="fb-send" data-href="'.$facebook_link.'"></div>';
				}
			}
		}
    else if ($name == 'facebook_share_new') {
			$option_layout = ($option['facebook_share_new_count']) ? 'button_count' : 'button';
			$option_layout = ($option['layout']=='box') ? 'box_count' : $option_layout;
      $facebook_link = ($option['facebook_like_fixed_url']!='') ? $option['facebook_like_fixed_url'] : $link;

			$out .= '<div class="fb-share-button" data-href="'.$facebook_link.'" data-type="'.$option_layout.'" data-width="'.$option['width_buttons'][$name].'"></div>';
    }
		else if ($name == 'linkedin') {
			$option_layout = ($option['layout']=='box') ? 'data-counter="top"' : 'data-counter="right"';
			$option_layout = ($option['linkedin_count']) ? $option_layout : '';
			$out .= '<script type="IN/Share" '.$option_layout.' data-url="'.$link.'"></script>';
		}
		else if ($name == 'buffer') {
			$option_layout = ($option['layout']=='box') ? 'data-count="vertical"' : 'data-count="horizontal"';
			$option_layout = ($option['buffer_count']) ? $option_layout : 'data-count="none"';
			$out .= '<a href="https://bufferapp.com/add" class="buffer-add-button" data-text="'.$title.'" data-url="'.$link.'" '.$option_layout.'></a>';
			// BUFFER JS ONLY WORKS ON BOTTOM
			if (!$really_simple_share_option['scripts_at_bottom']) {
				$out .= '<script type="text/javascript" src="http://static.bufferapp.com/js/button.js"></script>';
			}
		}
		else if ($name == 'digg') {
			$option_layout = ($option['layout']=='box') ? 'DiggMedium' : 'DiggCompact';
			// THE DIGG JS FILE DOES NOT ALWAYS WORK INSIDE THE <HEAD> SECTION, WE KEEP IT HERE
			$out .= '<script type="text/javascript" src="http://widgets.digg.com/buttons.js"></script>
					<a class="DiggThisButton '.$option_layout.'" href="http://digg.com/submit?url='.$link.'&amp;title='.htmlentities($title).'"></a>';
		}
		else if ($name == 'stumbleupon') {
			$option_layout = ($option['layout']=='box') ? '5' : '1';
			$out .= '<script type="text/javascript" src="https://www.stumbleupon.com/hostedbadge.php?s='.$option_layout.'&amp;r='.$link.'"></script>';
		}	
		else if ($name == 'hyves') {
			$out .= '<iframe src="http://www.hyves.nl/respect/button?url='.$link.'" 
						style="border: medium none; overflow:hidden; width:150px; height:21px;" scrolling="no" frameborder="0" allowTransparency="true" ></iframe>';
		}		
		else if ($name == 'reddit') {
			$option_layout = ($option['layout']=='box') ? '3' : '1';
			$out .= '<script type="text/javascript" src="http://www.reddit.com/static/button/button'.$option_layout.'.js?newwindow=1&amp;url='.$link.'"></script>';
		}	
		else if ($name == 'email') {
			$subject = ($option['email_subject']!='') ? $option['email_subject'] : $title;
			$out .= '<a href="mailto:?subject='.rawurlencode($subject).'&amp;body='.rawurlencode($subject.' - '.$link).'"><img src="'.plugins_url('images/email.png',__FILE__).'" alt="'.__('Email', 'really-simple-share').'" title="'.__('Email', 'really-simple-share').'" /> '.stripslashes($option['email_label']).'</a>';
		}
		else if ($name == 'print') {
			$out .= '<a href="javascript:window.print();void(0);"><img src="'.plugins_url('images/print.png',__FILE__).'" alt="'.__('Print', 'really-simple-share').'" title="'.__('Print', 'really-simple-share').'" /> '.stripslashes($option['print_label']).'</a>';
		}
		else if ($name == 'google1') {
			$option_layout = ($option['layout']=='button') ? 'data-size="medium"' : 'data-size="tall"';
      if ($option['layout']=='large_button') $option_layout = '';
			$data_count = ($option['google1_count']) ? '' : 'data-annotation="none"';
			$out .= '<div class="g-plusone" '.$option_layout.' data-href="'.$link.'" '.$data_count.'></div>';
		}
		else if ($name == 'google_share') {
			$option_layout = ($option['layout']=='box') ? 'vertical-bubble' : 'bubble';
      $data_count = ($option['google_share_count']) ? $option_layout : 'none';
      $option_size = ($option['layout']=='large_button') ? 'data-height="24"' : '';
      
			$out .= '<div class="g-plus" data-action="share" data-href="'.$link.'" data-annotation="'.$data_count.'" '.$option_size.'></div>';
		}
		else if ($name == 'youtube') {
			$option_layout = ($option['layout']=='box') ? 'full' : 'default';
			$out .= '<div class="g-ytsubscribe" data-channel="'.$option['youtube_channel'].'" data-layout="'.$option_layout.'"></div>';
		}
		else if ($name == 'flattr') {
			$option_layout = ($option['layout']=='box') ? '' : 'button:compact';
			$out .= '<a class="FlattrButton" style="display:none;" href="'.$link.'" title="'.strip_tags($title).'" rev="flattr;uid:'.$option['flattr_uid'].';language:'.$option['locale'].';category:text;tags:'.strip_tags(get_the_tag_list('', ',', '')).';'.$option_layout.';">'.$title.'</a>';
		}
		else if ($name == 'pinterest' and $option['pinterest_hover']!='hide') {
			$option_layout = ($option['layout']=='box') ? 'above' : 'beside';
			$option_layout = ($option['pinterest_count']) ? $option_layout : 'none';

			$media = '';
      $pinterest_title = $title;
			if (!$option['pinterest_multi_image'] and in_the_loop()) {
				// TRY TO USE THE THUMBNAIL, OTHERWHISE TRY TO USE THE FIRST ATTACHMENT
				$the_post_id = get_the_ID();
				if ( function_exists('has_post_thumbnail') and has_post_thumbnail($the_post_id) ) {
					$post_thumbnail_id = get_post_thumbnail_id($the_post_id);
					$media = wp_get_attachment_url($post_thumbnail_id);
            // TRY TO GET ALT ATTRIBUTE
            $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);
            if(count($alt) && $alt != '') {
              $pinterest_title = $alt;
            } else {
              // ELSE USE TITLE ATTRIBUTE
              $attachment = get_post( $post_thumbnail_id );
              $pinterest_title = $attachment->post_title;
            }
				}
				// IF NO MEDIA IS FOUND, LOOK FOR AN ATTACHMENT
				if ($media=='') {
					$args = array(
						'post_type'   => 'attachment',
						'numberposts' => 1,
						'post_status' => null,
						'post_parent' => $the_post_id
						);

					$attachments = get_posts( $args );

					if ( $attachments ) {
						$attachment = $attachments[0];
						$media = wp_get_attachment_url( $attachment->ID);
            // TRY TO GET ALT ATTRIBUTE
            $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
            if(count($alt) && $alt != '') {
              $pinterest_title = $alt;
            } else {
              // ELSE USE TITLE ATTRIBUTE
              $pinterest_title = $attachment->post_title;
            }
					}
				}
				// IF NO MEDIA IS FOUND, LOOK INSIDE THE CONTENT
				if ($media=='') {
					$output = @preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
					if (isset($matches [1] [0]))  {
						$media = $matches [1] [0];
					}
  				// TRY TO GET ALT ATTRIBUTE
					$output = @preg_match_all('/<img.+alt=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
					if (isset($matches [1] [0]) && $matches[1][0] != '')  {
						$pinterest_title = $matches [1] [0];
					} else {
    				// TRY TO GET TITLE ATTRIBUTE
  					$output = @preg_match_all('/<img.+title=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
  					if (isset($matches [1] [0]) && $matches[1][0] != '')  {
  						$pinterest_title = $matches [1] [0];
  					}
          }
				}
			}
				
			if ($media != '') {
				// ONE IMAGE
				$appended_url = '?url='.rawurlencode($link).'&media='.rawurlencode($media).'&description='.rawurlencode(strip_tags($pinterest_title));
				$data_pin_do = 'buttonPin';
			} else {
				// ANY IMAGE ON PAGE
				$appended_url = '';
				$data_pin_do = 'buttonBookmark';
			}
			
			// FIXED: ADD THE PROTOCOL OR IT WON'T WORK IN SOME SITES
			$out .= '<a data-pin-config="'.$option_layout.'" href="https://pinterest.com/pin/create/button/'.$appended_url.'" data-pin-do="'.$data_pin_do.'" ><img alt="Pin It" src="https://assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>';
		}
		else if ($name == 'tipy') {
			$option_layout = ($option['layout']=='box') ? 'tipy_button' : 'tipy_button_compact';
			$option_image  = ($option['layout']=='box') ? 'button' : 'button_compact';
			$out .= '<script type="text/javascript">
						(function() {
						var s = document.createElement("script"), s1 = document.getElementsByTagName("script")[0];
						s.type = "text/javascript";
						s.async = true;
						s.src = "https://www.tipy.com/button.js";
						s1.parentNode.insertBefore(s, s1);
						})();
					</script> 
					<a href="https://www.tipy.com/s/'.$option['tipy_uid'].'" class="'.$option_layout.'"><img src="http://www.tipy.com/'.$option_image.'.gif" border="0"></a>';
		}
		else if ($name == 'tumblr') {
			$out .= '<a href="https://www.tumblr.com/share/link?url='.rawurlencode($link).'&name='.rawurlencode($title).'" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url(\'http://platform.tumblr.com/v1/share_2.png\') top left no-repeat transparent;">Share on Tumblr</a>';
		}
		else if ($name == 'pinzout') {
			$out .= '<script src="http://media.pinzout.com/js/pinzit.js" type="text/javascript" charset="utf-8"></script>';
		}
		else if ($name == 'rss') {
			$the_post_id = get_the_ID();
			$out .= '<a href="'.get_post_comments_feed_link($the_post_id, 'rss2').'" title="'.$option['rss_text'].'"><img src="'.plugins_url('images/rss.png',__FILE__).'" alt="'.stripslashes($option['rss_text']).'" title="'.stripslashes($option['rss_text']).'" /> '.stripslashes($option['rss_text']).'</a>';
		}
		else if ($name == 'twitter') {
			$option_layout = ($option['layout']=='box') ? 'vertical' : 'horizontal';
			$data_count = ($option['twitter_count']) ? $option_layout : 'none';

      $option_size = ($option['layout']=='large_button') ? 'data-size="large"' : '';

			$related = array();
			if ($option['twitter_author']) {
				$related[] = stripslashes($author).':The author of this post';
			}
			if ($option['twitter_follow']!='') {
				$follow_array = array_filter(explode(',',$option['twitter_follow']));
				foreach ($follow_array as $name) {
					$related[] = trim($name);
				}
			}
			$data_related = (count($related)>0) ? ' data-related="'.implode(',',$related).'"' : '';
			
			$locale = ($option['locale']!='en_US') ? 'data-lang="'.substr($option['locale'],0,2).'"' : '';
			$out .= '<a href="https://twitter.com/share" class="twitter-share-button" data-count="'.$data_count.'" '
						.' data-text="'.strip_tags($title).stripslashes($option['twitter_text']).'" data-url="'.$link.'" '
						.' data-via="'.stripslashes($option['twitter_via']).'" '.$locale.' '.$option_size.' '.$data_related.'></a>';
		}
    else if ($name == 'bitcoin') {
      $out .= '<script type="text/javascript">
        CoinWidgetCom.go({
        	wallet_address: "'.$option['bitcoin_wallet'].'"
        	, counter: "count"
        	, lbl_button: "Donate"
        	, lbl_address: "My Bitcoin Address:"
        	, lbl_count: "donations"
        	, lbl_amount: "BTC"
        	, currency: "bitcoin", alignment: "bl", qrcode: true, auto_show: false
        });
        </script>';
		}
    else if ($name == 'litecoin') {
      $out .= '<script type="text/javascript">
        CoinWidgetCom.go({
        	wallet_address: "'.$option['litecoin_wallet'].'"
        	, counter: "count"
        	, lbl_button: "Donate"
        	, lbl_address: "My Litecoin Address:"
        	, lbl_count: "donations"
        	, lbl_amount: "LTC"
        	, currency: "litecoin", alignment: "bl", qrcode: true, auto_show: false
        });
        </script>';
    } else if ($name == 'specificfeeds') {
      $out .= '<a href="javascript:void(0);" onclick="window.open(\''.$option['specificfeeds_link'].'\',\'EmailSubscribe\',\'toolbar=yes,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=400,left=430,top=23\'); return false;">'
          .'<span class="super">'.__('Subscribe', 'really-simple-share').':</span> <img src="http://www.specificfeeds.com/theme/classic/img/sf_20.png" alt="SpecificFeeds" title="SpecificFeeds" /></a>';
    } else if ($name == 'specificfeeds_follow') {
      $button_text = ($option['specificfeeds_follow_text']) ? $option['specificfeeds_follow_text'] : 'Follow';
      $out .= '<a id="email_follow" href="#email_follow" onclick="var invite = new readygraph.framework.ui.Invite();invite.set(\'visible\', true);return false;">'
          .'<img src="'.plugins_url('images/specificfeeds_follow.png',__FILE__).'" alt="Email, RSS" title="Email, RSS" /> '.stripslashes($button_text).'</a>';
    } else if ($name == 'readygraph_infolinks') {
		
    } else if ($name == 'frype') {
      // GENERATE DIFFERENT IDS FOR BUTTONS IN THE SAME PAGE
      $random_id = rand(1,100000);
      $out .= '<div id="draugiemLike'.$random_id.'"></div><script type="text/javascript">var p = { popup:true, mobile:true }; new DApi.Like(p).append("draugiemLike'.$random_id.'");</script>';
		}
    
		// CLOSE THE BUTTON DIV
		$out .= '</div>';
	}
	
	$out .= '</div>
		<div class="really_simple_share_clearfix"></div>';

	// REMEMBER LAST FILTER EXECUTION TO HANDLE the_excerpt VS the_content	
	$last_execution = $filter;
	
	if ($filter=='shortcode') {
		return $div_button_open.$out;
	}

	// ABOVE PREPEND ABOVE TEXT
	$above_prepend_above = '';
	if ($option['above_prepend_above']!='') {
		$above_prepend_above = '<div class="really_simple_share_prepend_above robots-nocontent snap_nopreview">'.stripslashes($option['above_prepend_above']).'</div>';
	}
	// BELOW PREPEND ABOVE TEXT
	$below_prepend_above = '';
	if ($option['below_prepend_above']!='') {
		$below_prepend_above = '<div class="really_simple_share_prepend_above robots-nocontent snap_nopreview">'.stripslashes($option['below_prepend_above']).'</div>';
	}
	// ABOVE PREPEND INLINE TEXT
	$above_prepend_inline = '';
	if ($option['above_prepend_inline']!='') {
		$above_prepend_inline = '<div class="really_simple_share_prepend_inline">'.stripslashes($option['above_prepend_inline']).'</div>';
	}
	// BELOW PREPEND INLINE TEXT
	$below_prepend_inline = '';
	if ($option['below_prepend_inline']!='') {
		$below_prepend_inline = '<div class="really_simple_share_prepend_inline">'.stripslashes($option['below_prepend_inline']).'</div>';
	}

	if ($option['position']=='both') {
		return $above_prepend_above.$div_button_open.$above_prepend_inline.$out . $content . $below_prepend_above.$div_button_open.$below_prepend_inline.$out;
	} else if ($option['position']=='below') {
		return $content . $below_prepend_above.$div_button_open.$below_prepend_inline.$out;
	} else {
		return $above_prepend_above.$div_button_open.$above_prepend_inline.$out . $content;
	}
}


function really_simple_share_adjust_locale () {
	if (defined("ICL_LANGUAGE_CODE") and ICL_LANGUAGE_CODE!='') {
		global $really_simple_share_option, $wpdb, $table_prefix;
		$full_locale = $wpdb->get_var("select default_locale from ".$table_prefix."icl_languages where code = '".ICL_LANGUAGE_CODE."'");
		// FULL LOCALE IS SOMETIMES UNDEFINED, USE ICL_LANGUAGE_CODE AS FALLBACK
		$really_simple_share_option['locale'] = ($full_locale!='') ? $full_locale : ICL_LANGUAGE_CODE;
	}
}


// SHORTCODE FOR ALL ACTIVE BUTTONS
function really_simple_share_shortcode ($atts) {
	extract( shortcode_atts( array(
		'button' => '',
	), $atts ) );
	
	return really_simple_share ('', 'shortcode', '', '', '', $button);
}


//FUNCTION AVAILABLE FOR EXTERNAL INCLUSION, INSIDE THEMES AND OTHER PLUGINS
function really_simple_share_publish ($link='', $title='') {
	return really_simple_share ('', 'shortcode', $link, $title);
}



// PRIVATE FUNCTIONS

function really_simple_share_feed () {
	$feedurl = 'http://www.whiletrue.it/feed/';
	$select = 8;

	$rss = fetch_feed($feedurl);
	if (!is_wp_error($rss)) { // Checks that the object is created correctly
		$maxitems  = $rss->get_item_quantity($select);
		$rss_items = $rss->get_items(0, $maxitems);
	}
  $out = '';
	if (!empty($maxitems)) {
		$out .= '
			<div class="rss-widget">
				<ul>';
    foreach ($rss_items as $item) {
			$out .= '
						<li><a class="rsswidget" href="'.$item->get_permalink().'">'.$item->get_title().'</a> 
							<span class="rss-date">'.date_i18n(get_option('date_format') ,strtotime($item->get_date('j F Y'))).'</span></li>';
		}
		$out .= '
				</ul>
			</div>';
	}
	return $out;
}

function really_simple_share_box_content ($title, $content) {
	if (is_array($content)) {
		$content_string = '<table>';
		foreach ($content as $name=>$value) {
			$content_string .= '<tr>
				<td style="width:130px;">'.__($name, 'really-simple-share' ).':</td>	
				<td>'.$value.'</td>
				</tr>';
		}
		$content_string .= '</table>';
	} else {
		$content_string = $content;
	}

	$out = '
		<div class="postbox">
			<h3>'.__($title, 'really-simple-share' ).'</h3>
			<div class="inside">'.$content_string.'</div>
		</div>
		';
	return $out;
}

function really_simple_share_get_options_stored () {
	//GET ARRAY OF STORED VALUES
	$option = get_option('really_simple_share');
  if (!is_array($option)) {
    $option = array();
  } 
  
	if (isset($option['sort']) && $option['sort'] != '' && strpos($option['sort'], 'facebook_share_new')===false) {
		// Versions below 2.16.15 compatibility
		$option['width_buttons']['facebook_share_new'] = '110'; 
		$option['sort'] .= ',facebook_share_new';
	}	
	if (isset($option['sort']) && $option['sort'] != '' && strpos($option['sort'], 'bitcoin')===false) {
		// Versions below 3.0 compatibility
		$option['sort'] .= ',bitcoin,litecoin';
	}	
	if (isset($option['sort']) && $option['sort'] != '' && strpos($option['sort'], 'specificfeeds')===false) {
		// Versions below 3.1 compatibility
		$option['sort'] .= ',specificfeeds';
	}	
	if (isset($option['sort']) && $option['sort'] != '' && strpos($option['sort'], 'specificfeeds_follow')===false) {
		// Versions below 3.1.4 compatibility
  	$option['specificfeeds_follow_text'] = 'Follow';
		$option['sort'] = 'specificfeeds_follow,'.$option['sort'];
	}	
	if (isset($option['sort']) && $option['sort'] != '' && strpos($option['sort'], 'readygraph_infolinks')===false) {
		// Versions below 3.1.5 compatibility
		$option['sort'] .= ',readygraph_infolinks';
	}
	if (isset($option['sort']) && $option['sort'] != '' && strpos($option['sort'], 'frype')===false) {
		// Versions below 3.1.5 compatibility
		$option['sort'] .= ',frype';
	}	

	// MERGE DEFAULT AND STORED OPTIONS
	$option_default = really_simple_share_get_options_default();
	$option = array_merge($option_default, $option);

  // CHECK IF BUTTON ACTIVE IS SET
	foreach($option_default['active_buttons'] as $key=>$val) {
		if (!isset($option['active_buttons'][$key])) {
			$option['active_buttons'][$key] = $val;
		}
	}
	// CHECK IF BUTTON WIDTH IS SET
	foreach($option_default['width_buttons'] as $key=>$val) {
		if (!isset($option['width_buttons'][$key]) || $option['width_buttons'][$key] == '') {
			$option['width_buttons'][$key] = $val;
		}
	}	
	return $option;
}

function really_simple_share_get_options_default () {
	$option = array();
	$option['active_buttons'] = array('facebook_like'=>true, 
    'twitter'=>true, 'google1'=>true, 'specificfeeds_follow'=>true,'readygraph_infolinks'=>true,
    'facebook_share_new'=>false, 'google_share'=>false,
		'linkedin'=>false, 'digg'=>false, 'stumbleupon'=>false, 'hyves'=>false, 'email'=>false, 
		'reddit'=>false, 'flattr'=>false, 'pinterest'=>false, 'tipy'=>false, 'buffer'=>false, 
		'tumblr'=>false, 'facebook_share'=>false, 'pinzout'=>false, 'rss'=>false, 'print'=>false, 'youtube'=>false,
    'bitcoin'=>false, 'litecoin'=>false, 'specificfeeds'=>false, 'frype'=>false);
	$option['width_buttons'] = array('facebook_like'=>'100', 'facebook_share_new'=>'110', 'twitter'=>'100', 'linkedin'=>'100', 
		'digg'=>'100', 'stumbleupon'=>'100', 'hyves'=>'100', 'email'=>'40', 
		'reddit'=>'100', 'google1'=>'80', 'google_share'=>'110', 'flattr'=>'120', 'pinterest'=>'90', 'tipy'=>'120', 
		'buffer'=>'100', 'tumblr'=>'100', 'facebook_share'=>'100', 'pinzout'=>'75', 'rss'=>'150', 'print'=>'40', 'youtube'=>'140',
    'bitcoin'=>'120', 'litecoin'=>'120', 'specificfeeds'=>'110', 'specificfeeds_follow'=>'110','readygraph_infolinks'=>'110', 'frype'=>'110');
	$option['sort'] = implode(',',array('facebook_like', 'twitter', 'google1', 'specificfeeds_follow','readygraph_infolinks', 'facebook_share_new', 'google_share', 'linkedin', 'pinterest', 'digg', 'stumbleupon', 'hyves', 'email', 'reddit', 'flattr', 'tipy', 'buffer', 'tumblr', 'facebook_share', 'pinzout', 'rss', 'print', 'youtube','bitcoin', 'litecoin', 'specificfeeds', 'frype'));
	$option['position'] = 'below';
	$option['show_in'] = array('posts'=>true, 'pages'=>true, 'home_page'=>true, 'tags'=>true, 'categories'=>true, 'dates'=>true, 'authors'=>true, 'search'=>true);
	$option['show_in_custom'] = array();
	$option['layout'] = 'button';
	$option['locale'] = 'en_US';
	$option['above_prepend_above']  = '';
	$option['above_prepend_inline'] = '';
	$option['below_prepend_above']  = '';
	$option['below_prepend_inline'] = '';
	$option['disable_default_styles'] = false;
	$option['disable_excerpts'] = false;
	$option['use_shortlink'] = false;
	$option['scripts_at_bottom'] = true;
	$option['performance_mode'] = false;

	$option['facebook_like_appid'] = '';
	$option['facebook_like_html5'] = true;
	$option['facebook_like_text'] = 'like';
	$option['facebook_like_send'] = false;
	$option['facebook_like_fixed_url'] = '';
	$option['facebook_share_text'] = 'Share';
	$option['facebook_share_new_count'] = true;
	$option['bitcoin_wallet']  = '';
	$option['litecoin_wallet'] = '';
	$option['flattr_uid'] = '';
	$option['google1_count'] = true;
	$option['google_share_count'] = true;
	$option['email_label'] = '';
	$option['email_subject'] = '';
	$option['print_label'] = '';
	$option['linkedin_count'] = true;
	$option['pinterest_count'] = true;
	$option['pinterest_multi_image'] = false;
	$option['pinterest_hover'] = '';
	$option['rss_text'] = 'comments feed';
	$option['specificfeeds_link'] = '';
	$option['specificfeeds_follow_text'] = 'Follow';
	$option['tipy_uid'] = '';
	$option['twitter_count'] = true;
	$option['twitter_text'] = '';
	$option['twitter_author'] = false;
	$option['twitter_follow'] = '';
	$option['twitter_via'] = '';
	return $option;
}

function rsftsb_install() {
	add_option('readygraph_tutorial', 'true');
	add_option('readygraph_connect_anonymous', 'false');
	add_option('rg_rsftsb_plugin_do_activation_redirect', true);
	add_option('readygraph_related_tags_install', "true");
}
if( file_exists(plugin_dir_path( __FILE__ ).'/readygraph-extension.php' )) {
include "readygraph-extension.php";
}
else {

}
register_activation_hook(__FILE__, 'rsftsb_install');

function rsftsb_rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") 
           rsftsb_rrmdir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
  $del_url = plugin_dir_path( __FILE__ );
  unlink($del_url.'/readygraph-extension.php');
 $setting_url="admin.php?page=really_simple_share_options";
  echo'<script> window.location="'.admin_url($setting_url).'"; </script> ';
}
function rsftsb_delete_rg_options() {
delete_option('readygraph_access_token');
delete_option('readygraph_application_id');
delete_option('readygraph_refresh_token');
delete_option('readygraph_email');
delete_option('readygraph_settings');
delete_option('readygraph_delay');
delete_option('readygraph_enable_sidebar');
delete_option('readygraph_auto_select_all');
delete_option('readygraph_enable_notification');
delete_option('readygraph_enable_branding');
delete_option('readygraph_send_blog_updates');
delete_option('readygraph_send_real_time_post_updates');
delete_option('readygraph_popup_template');
delete_option('readygraph_upgrade_notice');
delete_option('readygraph_connect_anonymous');
delete_option('readygraph_connect_anonymous_app_secret');
}