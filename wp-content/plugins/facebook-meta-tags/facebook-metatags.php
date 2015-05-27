<?php 
/*
Plugin Name: Facebook Meta Tags
Plugin URI: http://shailan.com/facebook-meta-tags/
Description: This plugin adds required meta tags for facebook sharing. It makes featured images as sharing thumbnail. It also adds other required meta using post features.
Version: 1.0
Author: Matt Say
Author URI: http://shailan.com

*/

function insert_facebook_metatags(){
	global $wp_query;
	global $post;
	
	$thePostID = $wp_query->post->ID;
	
	$additional_tags = array();
	
	if( is_single() || is_page() && !is_front_page() ){
		$the_post = get_post($thePostID); 
		// The title
		$title = apply_filters('the_title', $the_post->post_title);
		
		// Description
		if($the_post->post_excerpt){
			$desc = trim(esc_html(strip_tags(do_shortcode( apply_filters('the_excerpt', $the_post->post_excerpt) ))));
		} else {
                $text = strip_shortcodes( $the_post->post_content );
                $text = apply_filters('the_content', $text);
                $text = str_replace(']]>', ']]&gt;', $text);
                $text = addslashes( strip_tags($text) );
                $excerpt_length = apply_filters('excerpt_length', 55);
               
                $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
                if ( count($words) > $excerpt_length ) {
                        array_pop($words);
                        $text = implode(' ', $words);
                        $text = $text . "...";
                } else {
                        $text = implode(' ', $words);
                }
		
			$desc =  $text;
		} 
		
		$url = get_permalink( $the_post );
		
		// Tags
		$tags = get_the_tags();
		$tag_list = array();
		if($tags){
			foreach ($tags as $tag){
				$tag_list[] = $tag->name;
			}
		}
		$tags = implode( ",", $tag_list );
		
		if( 'video' == get_post_format() ){ // Video post
		
			$type = "video.other";
			
			$additional_tags[] = "\n\t<meta property=\"video:tag\" content=\"$tags\" />"; 			
		
		} else { // Default post
		
			$type = "article";
			
			// Author
			/*$author = get_the_author();
			$additional_tags[] = "\n\t<meta property=\"article:author\" content=\"$author\" />"; */
			
			// Category
			$category = get_the_category(); 
			$section =  $category[0]->cat_name;
			$additional_tags[] = "\n\t<meta property=\"article:section\" content=\"$section\" />"; 
			$additional_tags[] = "\n\t<meta property=\"article:tag\" content=\"$tags\" />"; 
		}
		
		// Post thumbnail
		if( has_post_thumbnail( $thePostID )){
			$thumb_id = get_post_thumbnail_id( $thePostID );
			$image = wp_get_attachment_image_src( $thumb_id, array(800,800) );
			$thumbnail = $image[0];
		} else {
		
			// checking if logo is set through options page.
			$thumbnail = get_sfmt_setting('default_logo');
			
		}
		
	} elseif( is_home() || is_front_page() ){
		$title = get_bloginfo('name');
		$desc = get_sfmt_setting('home_desc');
		$type = "blog";
		$url = get_home_url();
		$thumbnail = get_sfmt_setting('default_logo');
	} else {
		$title = get_bloginfo('name');
		$desc = get_sfmt_setting('home_desc');
		$type = "blog";
		$url = get_home_url();
		$thumbnail = get_sfmt_setting('default_logo');
	}
	
	$site_name = get_bloginfo();
		
	echo "\n<!-- Generated with Facebook Meta Tags plugin by Shailan ( http://shailan.com/ ) --> ";
	echo "\n\t<meta property=\"og:title\" content=\"$title\" />";
    echo "\n\t<meta property=\"og:type\" content=\"$type\" />";
    echo "\n\t<meta property=\"og:url\" content=\"$url\" />";
    echo "\n\t<meta property=\"og:image\" content=\"$thumbnail\" />";
    echo "\n\t<meta property=\"og:site_name\" content=\"$site_name\" />";
	
	// Admins
	if( '' != get_sfmt_setting('site_admins') ){
		echo "\n\t<meta property=\"fb:admins\" content=\"".get_sfmt_setting('site_admins')."\"/>";
	}
	
	// Application ID
	if( '' != get_sfmt_setting('app_id') ){
		echo "\n\t<meta property=\"fb:app_id\" content=\"".get_sfmt_setting('app_id')."\"/>";
	}

    echo "\n\t<meta property=\"og:description\"
          content=\"$desc\" />";
		  
	echo implode($additional_tags);
				   
	echo "\n<!-- End of Facebook Meta Tags -->\n";
	
}

add_action('wp_head', 'insert_facebook_metatags');

if ( function_exists( 'add_theme_support' ) ) { add_theme_support( 'post-thumbnails', array('post', 'page') ); }
if ( function_exists( 'add_image_size' ) ) { add_image_size( 'facebook-metatags', 300, 300, true ); }

/* OPTIONS PAGE WORKS */

// Plugin options page

class shailan_facebook_metatags {

/*
*	CONSTRUCTOR
*/
    function shailan_facebook_metatags() {
		
		$this->version = "1.0";
		$this->settings_key = "shailan_facebook_metatags";
		$this->options_page = "facebook-metatags-options";
		
		// Include options array
		require_once("shailan-fmt-options.php");
		$this->options = $options;
		$this->settings = $this->get_plugin_settings();
		
		add_action('admin_menu', array( &$this, 'admin_menu') );
    }
	
/*
*	ADMIN MENU
*/
	function admin_menu(){

	if ( @$_GET['page'] == $this->options_page ) {		
		
		if ( @$_REQUEST['action'] && 'save' == $_REQUEST['action'] ) {
		
			// Save settings
			// Get settings array
			$settings = $this->get_plugin_settings();
			
			// Set updated values
			foreach($this->options as $option){					
				if( $option['type'] == 'checkbox' && empty( $_REQUEST[ $option['id'] ] ) ) {
					$settings[ $option['id'] ] = 'off';
				} else {
					$settings[ $option['id'] ] = $_REQUEST[ $option['id'] ]; 
				}
			}
			
			// Save the settings
			update_option( $this->settings_key, $settings );
			header("Location: admin.php?page=" . $this->options_page . "&saved=true&message=1");
			die;
		} else if( @$_REQUEST['action'] && 'reset' == $_REQUEST['action'] ) {
			
			// Start a new settings array
			$settings = array();
			delete_option( $this->settings_key );
			
			// Save the settings
			// update_option( $this->settings_key, $settings );			
			header("Location: admin.php?page=" . $this->options_page . "&reset=true&message=2");
			die;
		}
		
		// Enqueue scripts & styles
		wp_enqueue_script( "jquery" );
		wp_enqueue_style( "facebook-meta-tags-admin", WP_PLUGIN_URL . "/facebook-meta-tags/admin.css", false, "1.0", "all");	
		wp_enqueue_style( "google-droid-sans", "http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold&v1", false, "1.0", "all");	
		
		
	}

	$page = add_options_page( __('Facebook Metatags Options', 'facebook-metatags') , __('Facebook Meta', 'facebook-metatags'), 'administrator', $this->options_page, array( &$this, 'options_page') );
}

/*
*	GET SETTINGS FUNCTION
*/

	function get_plugin_settings(){
		$settings = get_option( $this->settings_key );		
		
		if(FALSE === $settings){ // Options doesn't exist, install standard settings
			// Create settings array
			$settings = array();
			// Set default values
			foreach($this->options as $option){
				if( array_key_exists( 'id', $option ) )
					$settings[ $option['id'] ] = $option['std'];
			}
			
			$settings['version'] = $this->version;
			// Save the settings
			update_option( $this->settings_key, $settings );
		} else { // Options exist, update if necessary
			
			if( !empty( $settings['version'] ) ){ $ver = $settings['version']; } 
			else { $ver = ''; }
			
			if($ver != $this->version){ // Update needed
			
				// Add missing keys
				foreach($this->options as $option){
					if( array_key_exists ( 'id' , $option ) && !array_key_exists ( $option['id'] ,$settings ) ){
						$settings[ $option['id'] ] = $option['std'];
					}
				}
				
				update_option( $this->settings_key, $settings );
				
				return $settings; 
			} else { 
			
				// Everythings gonna be alright. Return.
				return $settings;
			} 
		}		
	}
	
/*
*	UPDATE SETTINGS FUNCTION
*/
	
	function update_plugin_setting( $key, $value ){
		$settings = $this->get_plugin_settings();
		$settings[$key] = $value;
		update_option( $this->settings_key, $settings );
	}
	
/*
*	GET ONE SETTING FUNCTION
*/
	
	function get_plugin_setting( $key, $default = '' ) {
		$settings = $this->get_plugin_settings();
		if( array_key_exists($key, $settings) ){
			return $settings[$key];
		} else {
			return $default;
		}
		
		return FALSE;
	}

/*
*	OPTIONS PAGE
*/
	function options_page(){
	global $options, $current;

	$title = "Facebook Meta Tags Options";
	
	$options = $this->options;	
	$current = $this->get_plugin_settings();
	
	$messages = array( 
		"1" => __("Settings saved.", "facebook-metatags"),
		"2" => __("Settings reset.", "facebook-metatags")
	);
	
	$navigation = '<div id="stf_nav"><a href="http://shailan.com/wordpress/plugins/facebook-meta-tags-plugin/">Plugin page</a> | <a href="http://shailan.com/wordpress/plugins/facebook-meta-tags-plugin/help/">Usage</a> | <a href="http://shailan.com/donate/">Donate</a> | <a href="http://shailan.com/wordpress/">Get more plugins..</a></div>
	
<div class="stf_share">
	<div class="share-label">
		Like this plugin? 
	</div>
	<div class="share-button tweet">
		<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://shailan.com/wordpress/plugins/facebook-meta-tags-plugin/" data-text="I am using #Facebook Meta Tags plugin on my #wordpress #blog, Check this out!" data-count="horizontal" data-via="shailancom">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	</div>
	<div class="share-button facebook">
		<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
		<fb:like href="http://shailan.com/wordpress/plugins/facebook-meta-tags-plugin/" ref="plugin_options" show_faces="false" width="300" font="segoe ui"></fb:like>
	</div>
</div>
	
	';
	
	$footer_text = '<em><a href="http://shailan.com/wordpress/plugins/facebook-meta-tags-plugin/">Facebook Meta Tags</a> by <a href="http://shailan.com/">SHAILAN</a></em>';
	
	include_once( "template-page-options.php" );

	}
}

global $sFmt;
$sFmt = New shailan_facebook_metatags();

function get_sfmt_setting( $key, $default = '' ) {
	$settings = get_option( "shailan_facebook_metatags" );		
	if( array_key_exists($key, $settings) ){
		return $settings[$key];
	} else {
		return $default;
	}
	
	return FALSE;
}


/**
 * Returns link to debug page on facebook linter
 * Usage: <?php if( function_exists('sfmt_debug_link') ){ echo "<a href=\"" . sfmt_debug_link() . "\">Debug Facebook Meta</a>"; } ?> 
 */
function sfmt_debug_link(){
	global $post;
	return "https://developers.facebook.com/tools/debug/og/object?q=" . urlencode( get_permalink( $post->ID ) ); 
}

?>