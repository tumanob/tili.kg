<?php
  // Extension Configuration
  //
  $plugin_slug = basename(dirname(__FILE__));
  $menu_slug = 'readygraph-app';
  $main_plugin_title = 'Really Simple Share';
	add_action( 'wp_ajax_rsftsb-myajax-submit', 'rsftsb_myajax_submit' );
function rsftsb_myajax_submit() {
	global $wpdb;
	$monetize = $_POST['readygraph_monetize'];
	if ($monetize == "true"){
	update_option('readygraph_enable_monetize',"true");
	}
	else{
	update_option('readygraph_enable_monetize',"false");
	}
	wp_die();
}
  // ReadyGraph Engine Hooker
  //
  include_once('extension/readygraph/extension.php');
 
  function on_plugin_activated_readygraph_rsftsb_redirect(){
	
	global $menu_slug;
    $setting_url="admin.php?page=$menu_slug";    
    if (get_option('rg_rsftsb_plugin_do_activation_redirect', false)) {  
      delete_option('rg_rsftsb_plugin_do_activation_redirect'); 
      wp_redirect(admin_url($setting_url)); 
    }  
  }
  

  add_action('admin_notices', 'add_readygraph_plugin_warning');
if(get_option('readygraph_application_id') && strlen(get_option('readygraph_application_id')) > 0){
if (get_option('readygraph_enable_monetize', '') == "true" || strlen(get_option('readygraph_access_token','')) > 0) {
  add_action('wp_footer', 'readygraph_rsftsb_client_script_head');
}
if (!get_option('readygraph_related_tags')){
  $app_id = get_option('readygraph_application_id');
  delete_option('readygraph_related_tags_install');
  $url = 'https://readygraph.com/api/v1/wp-monetize/';
  $response = wp_remote_post($url, array( 'body' => array('app_id' => $app_id, 'related_tags' => 'true')));
  if ( is_wp_error( $response ) ) {
	} else {
  update_option('readygraph_related_tags', "true");
  }
}
}
  add_action('admin_init', 'on_plugin_activated_readygraph_rsftsb_redirect');
	add_option('readygraph_rsftsb_connect_notice','true');

function rg_rsftsb_popup_options_enqueue_scripts() {
    if ( get_option('readygraph_popup_template') == 'default-template' ) {
        wp_enqueue_style( 'default-template', plugin_dir_url( __FILE__ ) .'extension/readygraph/assets/css/default-popup.css' );
    }
    if ( get_option('readygraph_popup_template') == 'red-template' ) {
        wp_enqueue_style( 'red-template', plugin_dir_url( __FILE__ ) .'extension/readygraph/assets/css/red-popup.css' );
    }
    if ( get_option('readygraph_popup_template') == 'blue-template' ) {
        wp_enqueue_style( 'blue-template', plugin_dir_url( __FILE__ ) .'extension/readygraph/assets/css/blue-popup.css' );
    }
	if ( get_option('readygraph_popup_template') == 'black-template' ) {
        wp_enqueue_style( 'black-template', plugin_dir_url( __FILE__ ) .'extension/readygraph/assets/css/black-popup.css' );
    }
	if ( get_option('readygraph_popup_template') == 'gray-template' ) {
        wp_enqueue_style( 'gray-template', plugin_dir_url( __FILE__ ) .'extension/readygraph/assets/css/gray-popup.css' );
    }
	if ( get_option('readygraph_popup_template') == 'green-template' ) {
        wp_enqueue_style( 'green-template', plugin_dir_url( __FILE__ ) .'extension/readygraph/assets/css/green-popup.css' );
    }
	if ( get_option('readygraph_popup_template') == 'yellow-template' ) {
        wp_enqueue_style( 'yellow-template', plugin_dir_url( __FILE__ ) .'extension/readygraph/assets/css/yellow-popup.css' );
    }
    if ( get_option('readygraph_popup_template') == 'custom-template' ) {
        
		wp_enqueue_style( 'custom-template', plugin_dir_url( __FILE__ ) .'extension/readygraph/assets/css/custom-popup.css' );
    }	
}
add_action( 'admin_enqueue_scripts', 'rg_rsftsb_popup_options_enqueue_scripts' );
add_action( 'wp_enqueue_scripts', 'rg_rsftsb_popup_options_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'rg_rsftsb_enqueue_color_picker' );

function rg_rsftsb_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'rsftsb-script-handle', plugins_url('/extension/readygraph/assets/js/my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

function rsftsb_post_updated_send_email( $post_id ) {

	// If this is just a revision, don't send the email.
	if ( wp_is_post_revision( $post_id ) )
		return;
	if (!get_option('readygraph_access_token')){
		return;
	}
	if(get_option('readygraph_application_id') && strlen(get_option('readygraph_application_id')) > 0 && get_option('readygraph_send_blog_updates') == "true"){

	$post_title = get_the_title( $post_id );
	$post_url = get_permalink( $post_id );
	$post_image = wp_get_attachment_url(get_post_thumbnail_id($post_id));
	$post_content = get_post($post_id);
	$post_excerpt = (isset($post_content->post_excerpt) && (!empty($post_content->post_excerpt))) ? $post_content->post_excerpt : wp_trim_words(strip_tags(strip_shortcodes($post_content->post_content)),500);
	$url = 'http://readygraph.com/api/v1/post.json/';
	if (get_option('readygraph_send_real_time_post_updates')=='true'){
	$response = wp_remote_post($url, array( 'body' => array('is_wordpress'=>1, 'is_realtime'=>1, 'message' => $post_title, 'message_link' => $post_url,'message_excerpt' => $post_excerpt,'client_key' => get_option('readygraph_application_id'), 'email' => get_option('readygraph_email'))));
	}
	else {
	$response = wp_remote_post($url, array( 'body' => array('is_wordpress'=>1, 'message' => $post_title, 'message_link' => $post_url,'message_excerpt' => $post_excerpt,'client_key' => get_option('readygraph_application_id'), 'email' => get_option('readygraph_email'))));
	}
	if ( is_wp_error( $response ) ) {
	$error_message = $response->get_error_message();

	} 	else {

	}
	$app_id = get_option('readygraph_application_id');
	wp_remote_get( "http://readygraph.com/api/v1/tracking?event=post_created&app_id=$app_id" );
	}
	else{
	}

}
add_action('future_to_publish','rsftsb_post_updated_send_email');
add_action('new_to_publish','rsftsb_post_updated_send_email');
add_action('draft_to_publish','rsftsb_post_updated_send_email');

function rsftsb_wordpress_sync_users( $app_id ){
	global $wpdb;
   	$query = "SELECT email as email, date as user_date FROM {$wpdb->prefix}subscribe2 ";
	$subscribe2_users = $wpdb->get_results($query);
	$emails = "";
	$dates = "";
	$count = 0;
	$count = mysql_num_rows($subscribe2_users);
	wp_remote_get( "http://readygraph.com/api/v1/tracking?event=wp_user_synced&app_id=$app_id&count=$count" );
	foreach($subscribe2_users as $user) {
		$emails .= $user->email . ","; 
		$dates .= $user->user_date . ",";
	}
	$url = 'https://readygraph.com/api/v1/wordpress-sync-enduser/';
	$response = wp_remote_post($url, array( 'body' => array('app_id' => $app_id, 'email' => rtrim($emails, ", "), 'user_registered' => rtrim($dates, ", "))));
}

function rsftsb_rg_connect(){
	if(get_option('readygraph_connect_anonymous') != "true"){
	$url = 'https://readygraph.com/api/v1/wordpress-rg-connect-anonymous/';
	$randon_string = get_random_string();
	$response = wp_remote_post($url, array( 'body' => array('app_secret' => $randon_string, 'website' => home_url())));
	if ( is_wp_error( $response ) ) {
	$error_message = $response->get_error_message();
	} 	else {
	$result = json_decode($response['body'],true);
	$app_id = $result['data']['app_id'];
	update_option('readygraph_connect_anonymous', 'true');
	update_option('readygraph_application_id', $app_id);
	update_option('readygraph_connect_anonymous_app_secret', $randon_string);
	}
}
}
function get_random_string()
{
	$valid_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$length = 10;
    $random_string = "";
    $num_valid_chars = strlen($valid_chars);
    for ($i = 0; $i < $length; $i++)
    {
        $random_pick = mt_rand(1, $num_valid_chars);
        $random_char = $valid_chars[$random_pick-1];
        $random_string .= $random_char;
    }
    return $random_string;
}

?>