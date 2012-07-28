<?php
/*
 * This is the main code for the SFC Base system. It's included by the main "Simple Facebook Connect" plugin.
 */

// Load the textdomain
load_plugin_textdomain('sfc', false, dirname(plugin_basename(__FILE__)));

global $sfc_plugin_list;
$sfc_plugin_list = array(
	'plugin_login'=>'sfc-login.php',
	'plugin_like'=>'sfc-like.php',
	'plugin_publish'=>'sfc-publish.php',
	'plugin_widgets'=>'sfc-widgets.php',
	'plugin_comments'=>'sfc-comments.php',
	'plugin_getcomm'=>'sfc-getcomm.php',
	'plugin_register'=>'sfc-register.php',
	'plugin_share'=>'sfc-share.php',
	'plugin_photos'=>'sfc-photos.php',
);

// load all the subplugins
add_action('plugins_loaded','sfc_plugin_loader');
function sfc_plugin_loader() {
	global $sfc_plugin_list;
	$options = get_option('sfc_options');
	if (!empty($options)) foreach ($options as $key=>$value) {
		if ($value === 'enable' && array_key_exists($key, $sfc_plugin_list)) {
			include_once($sfc_plugin_list[$key]);
		}
	}
}

// fix up the html tag to have the FBML extensions
add_filter('language_attributes','sfc_lang_atts');
function sfc_lang_atts($lang) {
    return ' xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" '.$lang;
}

// basic XFBML load into footer
add_action('wp_footer','sfc_add_base_js',20); // 20, to put it at the end of the footer insertions. sub-plugins should use 30 for their code
function sfc_add_base_js() {
	$options = get_option('sfc_options');
	sfc_load_api($options['appid']);
};

function sfc_load_api($appid) {

	// allow locale overrides
	if ( defined( 'SFC_LOCALE' ) ) {
		$locale = SFC_LOCALE;
	} else {
		// validate that they're using a valid locale string
		$sfc_valid_fb_locales = array(
			'ca_ES', 'cs_CZ', 'cy_GB', 'da_DK', 'de_DE', 'eu_ES', 'en_PI', 'en_UD', 'ck_US', 'en_US', 'es_LA', 'es_CL', 'es_CO', 'es_ES', 'es_MX',
			'es_VE', 'fb_FI', 'fi_FI', 'fr_FR', 'gl_ES', 'hu_HU', 'it_IT', 'ja_JP', 'ko_KR', 'nb_NO', 'nn_NO', 'nl_NL', 'pl_PL', 'pt_BR', 'pt_PT',
			'ro_RO', 'ru_RU', 'sk_SK', 'sl_SI', 'sv_SE', 'th_TH', 'tr_TR', 'ku_TR', 'zh_CN', 'zh_HK', 'zh_TW', 'fb_LT', 'af_ZA', 'sq_AL', 'hy_AM',
			'az_AZ', 'be_BY', 'bn_IN', 'bs_BA', 'bg_BG', 'hr_HR', 'nl_BE', 'en_GB', 'eo_EO', 'et_EE', 'fo_FO', 'fr_CA', 'ka_GE', 'el_GR', 'gu_IN',
			'hi_IN', 'is_IS', 'id_ID', 'ga_IE', 'jv_ID', 'kn_IN', 'kk_KZ', 'la_VA', 'lv_LV', 'li_NL', 'lt_LT', 'mk_MK', 'mg_MG', 'ms_MY', 'mt_MT',
			'mr_IN', 'mn_MN', 'ne_NP', 'pa_IN', 'rm_CH', 'sa_IN', 'sr_RS', 'so_SO', 'sw_KE', 'tl_PH', 'ta_IN', 'tt_RU', 'te_IN', 'ml_IN', 'uk_UA',
			'uz_UZ', 'vi_VN', 'xh_ZA', 'zu_ZA', 'km_KH', 'tg_TJ', 'ar_AR', 'he_IL', 'ur_PK', 'fa_IR', 'sy_SY', 'yi_DE', 'gn_PY', 'qu_PE', 'ay_BO',
			'se_NO', 'ps_AF', 'tl_ST'
		);

		$locale = get_locale();
		if ( !in_array($locale, $sfc_valid_fb_locales) ) {
			$locale = 'en_US';	// default if they're using one FB doesn't like
		}
	}
?>
<div id="fb-root"></div>
<script type="text/javascript">
  window.fbAsyncInit = function() {
    FB.init({appId: '<?php echo $appid; ?>', status: true, cookie: true, xfbml: true, oauth: true });
    <?php do_action('sfc_async_init'); // do any other actions sub-plugins might need to do here ?>
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/<?php echo $locale; ?>/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>
<?php
}

// add the admin settings and such
add_action('admin_init', 'sfc_admin_init',9); // 9 to force it first, subplugins should use default
function sfc_admin_init(){
	$options = get_option('sfc_options');
	if (empty($options['app_secret']) || empty($options['appid'])) {
		add_action('admin_notices', create_function( '', "echo '<div class=\"error\"><p>".sprintf(__('Simple Facebook Connect needs configuration information on its <a href="%s">settings</a> page.', 'sfc'), admin_url('options-general.php?page=sfc'))."</p></div>';" ) );
	} else {
		add_action('admin_print_footer_scripts','sfc_add_base_js',20);
	}
	wp_enqueue_script('jquery');
	register_setting( 'sfc_options', 'sfc_options', 'sfc_options_validate' );
	add_settings_section('sfc_main', __('Main Settings', 'sfc'), 'sfc_section_text', 'sfc');
	if (!defined('SFC_APP_ID')) add_settings_field('sfc_appid', __('Facebook Application ID', 'sfc'), 'sfc_setting_appid', 'sfc', 'sfc_main');
	if (!defined('SFC_APP_SECRET')) add_settings_field('sfc_app_secret', __('Facebook Application Secret', 'sfc'), 'sfc_setting_app_secret', 'sfc', 'sfc_main');
	if (!defined('SFC_FANPAGE')) add_settings_field('sfc_fanpage', __('Facebook Fan Page', 'sfc'), 'sfc_setting_fanpage', 'sfc', 'sfc_main');

	add_settings_section('sfc_plugins', __('SFC Plugins', 'sfc'), 'sfc_plugins_text', 'sfc');
	add_settings_field('sfc_subplugins', __('Plugins', 'sfc'), 'sfc_subplugins', 'sfc', 'sfc_plugins');
	
	add_settings_section('sfc_meta', __('Facebook Metadata', 'sfc'), 'sfc_meta_text', 'sfc');
	add_settings_field('sfc_default_image', __('Default Image', 'sfc'), 'sfc_default_image', 'sfc', 'sfc_meta');
	add_settings_field('sfc_default_description', __('Default Description', 'sfc'), 'sfc_default_description', 'sfc', 'sfc_meta');
}

// add the admin options page
add_action('admin_menu', 'sfc_admin_add_page');
function sfc_admin_add_page() {
	global $sfc_options_page;
	$sfc_options_page = add_options_page(__('Simple Facebook Connect', 'sfc'), __('Simple Facebook Connect', 'sfc'), 'manage_options', 'sfc', 'sfc_options_page');
}

function sfc_plugin_help($contextual_help, $screen_id, $screen) {
	global $sfc_options_page;
	if ($screen_id == $sfc_options_page) {
		$home = home_url('/');
		$contextual_help = __("
<p>To connect your site to Facebook, you will need a Facebook Application.
If you have already created one, please insert your Application Secret and Application ID below.</p>
<p><strong>Can't find your key?</strong></p>
<ol>
<li>Get a list of your applications from here: <a target='_blank' href='https://developers.facebook.com/apps'>Facebook Application List</a></li>
<li>Select the application you want, then copy and paste the Application Secret and Application ID from there.</li>
</ol>

<p><strong>Haven't created an application yet?</strong> Don't worry, it's easy!</p>
<ol>
<li>Go to this link to create your application: <a target='_blank' href='https://developers.facebook.com/apps'>Facebook Application List</a></li>
<li>After creating the application, put <strong>%s</strong> in as the Connect URL on the Connect Tab.</li>
<li>You can get the information from the application on the
<a target='_blank' href='https://developers.facebook.com/apps'>Facebook Application List</a> page.</li>
<li>Select the application you created, then copy and paste the Application Secret, and Application ID from there.</li>
</ol>

<h3>SFC-Plugins</h3>
<p>Each separate plugin can be enabled or disabled using the checkboxes below. Only enable the plugins you want to use, and the rest will not run at all! Here's a quick description of each plugin:</p>
<ul>
<li><strong>Login</strong> - The Login plugin allows your users to login using their Facebook Credentials. To do this, 
	it adds a Facebook button on the Login screen. There is also a button on the Users' profile screen to allow them 
	to connect or disconnect their account from Facebook. The User's Facebook ID number will be stored as usermeta 
	and can be used for many things.</p></li>
<li><strong>Register</strong> - The Register plugin changes the normal WordPress user registration mechanism into the 
	Facebook Register plugin mechanism. This lets users easily register using their Facebook credentials, or to 
	register without having any credentials. Users who register with FB credentials will automatically be able to 
	Login using their FB credentials in the Login plugin. As an added bonus, FB Register adds a CAPTCHA to the 
	registration process, helping to eliminate spam registrations.</p></li>
<li><strong>Like</strong> - The Like plugin will let you automatically or manually add Like and Send buttons to all 
	the Posts and Pages on your site.</p></li>
<li><strong>Share</strong> - The Share plugin will let you automatically add a second Like button to all the Posts and 
	Pages on your site. This is styled to look similar to the older, now removed, \"Share\" feature Facebook used 
	to offer, but it doesn't have the same kind of popup dialog any longer.</p></li>
<li><strong>Publish</strong> - The Publish plugin will let you automatically send new posts and pages to either your 
	site's main Facebook Page or your personal Facebook Profile. Automatically posted entries also get metadata 
	about the Facebook post saved about them, for use by other plugins.</p></li>
<li><strong>Widgets</strong> - The Widgets plugin adds several widgets that can be used by your site's sidebar (or 
	any other widget areas in your theme). Most of these come from the 
	<a href='http://developers.facebook.com/docs/plugins/'>Facebook Social Plugins</a>.</p></li>
<li><strong>Comments</strong> - The Comments plugin will let your users use Facebook credentials to make comments, and 
	offer those users an option to share their comments, and your post, on Facebook. This basically eliminates the 
	need for users to type in their Names and Email addresses. Note that some themes do checking for these \"required\" 
	elements via Javascript. Because Facebook Comments get these fields filled on the back end, the theme may need to 
	be modified to both display the button or to eliminate the javascript requirements checks.</p></li>
<li><strong>Integrate Comments</strong> - The Comment Integration plugin will interact with the saved data from the 
	automatic publishing plugin, and periodically poll Facebook for new comments made to your auto-published stories. 
	Comments will then be pulled from Facebook and integrated into the normally displayed comments stream.</p></li>
<li><strong>Photos</strong> - The Photos plugin adds a new tab to the Media Uploader on the Edit Post pages, which will 
	show your Facebook photo albums and let you easily embed pictures from Facebook into your posts.</p></li>
", 'sfc');
	}
	
	$contextual_help = sprintf( $contextual_help, $home );
	return $contextual_help;
}
//add_action('contextual_help', 'sfc_plugin_help', 10, 3);

// display the admin options page
function sfc_options_page() {
?>
	<div class="wrap">
	<h2><?php _e('Simple Facebook Connect', 'sfc'); ?></h2>
	<p><?php _e('Options relating to the Simple Facebook Connect plugins.', 'sfc'); ?> </p>
	<form method="post" action="options.php">
	<?php settings_fields('sfc_options'); ?>
	<table><tr><td>
	<?php do_settings_sections('sfc'); ?>
	</td><td style='vertical-align:top;'>
	<div style='width:20em; float:right; background: #ffc; border: 1px solid #333; margin: 2px; padding: 5px'>
			<h3 align='center'><?php _e('About the Author', 'sfc'); ?></h3>
		<p><a href="http://ottopress.com/blog/wordpress-plugins/simple-facebook-connect/">Simple Facebook Connect</a> is developed and maintained by <a href="http://ottodestruct.com">Otto</a>.</p>
			<p>He blogs at <a href="http://ottodestruct.com">Nothing To See Here</a> and <a href="http://ottopress.com">Otto on WordPress</a>, posts photos on <a href="http://www.flickr.com/photos/otto42/">Flickr</a>, and chats on <a href="http://twitter.com/otto42">Twitter</a>.</p>
			<p>You can follow his site on either <a href="http://www.facebook.com/apps/application.php?id=116002660893">Facebook</a> or <a href="http://twitter.com/ottodestruct">Twitter</a>, if you like.</p>
			<p>If you'd like to <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=otto%40ottodestruct%2ecom">buy him a beer</a>, then he'd be perfectly happy to drink it.</p>
		</div>
<?php /*
	<div style='width:20em; float:right; background: #fff; border: 1px solid #333; margin: 2px; padding: 5px'>
		<h3 align='center'><?php _e('Facebook Platform Status', 'sfc'); ?></h3>
		<?php @wp_widget_rss_output('http://www.facebook.com/feeds/api_messages.php',array('show_date' => 1, 'items' => 10) ); ?>
	</div>
*/ ?>
	</td></tr></table>
	<?php submit_button(); ?>
	</form>
	</div>

<?php
}

function sfc_section_text() {
	$options = get_option('sfc_options');
	if (empty($options['app_secret']) || empty($options['appid'])) {
?>
<p><?php _e('To connect your site to Facebook, you will need a Facebook Application.
If you have already created one, please insert your Application Secret and Application ID below.', 'sfc'); ?></p>
<p><strong><?php _e('Can\'t find your key?', 'sfc'); ?></strong></p>
<ol>
<li><?php _e('Get a list of your applications from here: <a target="_blank" href="https://developers.facebook.com/apps">Facebook Application List</a>', 'sfc'); ?></li>
<li><?php _e('Select the application you want, then copy and paste the Application Secret and Application ID from there.', 'sfc'); ?></li>
</ol>

<p><strong><?php _e('Haven\'t created an application yet?', 'sfc'); ?></strong> <?php _e('Don\'t worry, it\'s easy!', 'sfc'); ?></p>
<ol>
<li><?php _e('Go to this link to create your application: <a target="_blank" href="https://developers.facebook.com/apps">Facebook Application Setup</a>', 'sfc'); ?></li>
<li><?php $home = home_url('/'); _e("After creating the application, put <strong>{$home}</strong> in as the Connect URL on the Connect Tab.", 'sfc'); ?></li>
<li><?php _e('You can get the API information from the application on the
<a target="_blank" href="https://developers.facebook.com/apps">Facebook Application List</a> page.', 'sfc'); ?></li>
<li><?php _e('Select the application you created, then copy and paste the Application Secret and Application ID from there.', 'sfc'); ?></li>
<li><?php _e('You can find a walkthrough guide to configuring your Facebook application here: <a href="http://ottopress.com/2010/how-to-setup-your-facebook-connect-application/">How to Setup Your Facebook Application</a>', 'sfc'); ?></li>
</ol>
<?php
	}
}

// this will override all the main options if they are pre-defined
function sfc_override_options($options) {
	if (defined('SFC_APP_SECRET')) $options['app_secret'] = SFC_APP_SECRET;
	if (defined('SFC_APP_ID')) $options['appid'] = SFC_APP_ID;
	if (defined('SFC_FANPAGE')) $options['fanpage'] = SFC_FANPAGE;
	return $options;
}
add_filter('option_sfc_options', 'sfc_override_options');

function sfc_setting_app_secret() {
	if (defined('SFC_APP_SECRET')) return;
	$options = get_option('sfc_options');
	echo "<input type='text' id='sfcappsecret' name='sfc_options[app_secret]' value='{$options['app_secret']}' size='40' /> ";
	_e('(required)', 'sfc');
	if (!empty($options['appid'])) printf(__('<p>Here is a <a href=\'http://www.facebook.com/apps/application.php?id=%s&amp;v=wall\'>link to your applications wall</a>. There you can give it a name, upload a profile picture, things like that. Look for the "Edit Application" link to modify the application.</p>', 'sfc'), $options['appid']);
}

function sfc_setting_appid() {
	if (defined('SFC_APP_ID')) return;
	$options = get_option('sfc_options');
	echo "<input type='text' id='sfcappid' name='sfc_options[appid]' value='{$options['appid']}' size='40' /> ";
	_e('(required)', 'sfc');
}

function sfc_setting_fanpage() {
	if (defined('SFC_FANPAGE')) return;
	$options = get_option('sfc_options'); ?>

<p><?php _e('Some sites use Fan Pages on Facebook to connect with their users. The Application wall acts as a
Fan Page in all respects, however some sites have been using Fan Pages previously, and already have
communities and content built around them. Facebook offers no way to migrate these, so the option to
use an existing Fan Page is offered for people with this situation. Note that this doesn\'t <em>replace</em>
the application, as that is not optional. However, you can use a Fan Page for specific parts of the
SFC plugin, such as the Fan Box, the Publisher, and the Chicklet.', 'sfc'); ?></p>

<p><?php _e('If you have a <a href="http://www.facebook.com/pages/manage/">Fan Page</a> that you want to use for
your site, enter the ID of the page here. Most users should leave this blank.', 'sfc'); ?></p>

<?php
	echo "<input type='text' id='sfcfanpage' name='sfc_options[fanpage]' value='{$options['fanpage']}' size='40' />";
}

function sfc_plugins_text() {
?>
<p><?php _e('SFC is a modular system. Click the checkboxes by the sub-plugins of SFC that you want to use. All of these are optional.', 'sfc'); ?></p>
<?php
}

function sfc_subplugins() {
	$options = get_option('sfc_options');
	if ($options['appid']) {
	?>
	<p><label><input type="checkbox" name="sfc_options[plugin_login]" value="enable" <?php @checked('enable', $options['plugin_login']); ?> /> <?php _e('Login with Facebook','sfc'); ?></label></p>
	<p><label><input type="checkbox" name="sfc_options[plugin_register]" value="enable" <?php @checked('enable', $options['plugin_register']); ?> /> <?php _e('User registration (must also enable Login)','sfc'); ?></label></p>
	<p><label><input type="checkbox" name="sfc_options[plugin_like]" value="enable" <?php @checked('enable', $options['plugin_like']); ?> /> <?php _e('Like Button','sfc'); ?></label></p>
	<p><label><input type="checkbox" name="sfc_options[plugin_share]" value="enable" <?php @checked('enable', $options['plugin_share']); ?> /> <?php _e('Share Button','sfc'); ?></label></p>
	<p><label><input type="checkbox" name="sfc_options[plugin_publish]" value="enable" <?php @checked('enable', $options['plugin_publish']); ?> /> <?php _e('Publisher (send posts to Facebook)','sfc'); ?></label></p>
	<p><label><input type="checkbox" name="sfc_options[plugin_widgets]" value="enable" <?php @checked('enable', $options['plugin_widgets']); ?> /> <?php _e('Sidebar widgets (enables all widgets, use the ones you want)','sfc'); ?></label></p>
	<p><label><input type="checkbox" name="sfc_options[plugin_comments]" value="enable" <?php @checked('enable', $options['plugin_comments']); ?> /> <?php _e('Allow FB Login to Comment (for non-registered users)','sfc'); ?></label></p>
	<p><label><input type="checkbox" name="sfc_options[plugin_getcomm]" value="enable" <?php @checked('enable', $options['plugin_getcomm']); ?> /> <?php _e('Integrate FB Comments (needs automatic publishing enabled)','sfc'); ?></label></p>
	<p><label><input type="checkbox" name="sfc_options[plugin_photos]" value="enable" <?php @checked('enable', $options['plugin_photos']); ?> /> <?php _e('Photo Posting (integrate FB Photo Albums into the Media display)','sfc'); ?></label></p>
	<?php
	do_action('sfc_subplugins');
	}
}

function sfc_meta_text() {
?>
<p><?php _e('SFC automatically populates your site with OpenGraph meta tags for Facebook and other sites to use for things like sharing and publishing.', 'sfc'); ?></p>
<?php
}

function sfc_default_image() {
	$options = get_option('sfc_options');
	?>
	<p><label><?php _e('SFC will automatically choose images from your content if they are available. When they are not available, you can specify the URL to a default image to use here.','sfc'); ?><br />
	<input type="text" name="sfc_options[default_image]" value="<?php echo esc_url($options['default_image']); ?>" size="80" placeholder="http://example.com/path/to/image.jpg"/></label></p>
	<?php
}

function sfc_default_description() {
	$options = get_option('sfc_options');
	?>
	<p><label><?php _e('SFC will automatically create descriptions for single post pages based on the excerpt of the content. For other pages, you can put in a default description here.','sfc'); ?><br />
	<textarea cols="80" rows="3" name="sfc_options[default_description]"><?php echo esc_textarea($options['default_description']); ?></textarea></label></p>
	<?php
}

// validate our options
function sfc_options_validate($input) {
	if (!defined('SFC_APP_SECRET')) {
		// secrets are 32 bytes long and made of hex values
		$input['app_secret'] = trim($input['app_secret']);
		if(! preg_match('/^[a-f0-9]{32}$/i', $input['app_secret'])) {
		  $input['app_secret'] = '';
		}
	}

	if (!defined('SFC_APP_ID')) {
		// app ids are big integers
		$input['appid'] = trim($input['appid']);
		if(! preg_match('/^[0-9]+$/i', $input['appid'])) {
		  $input['appid'] = '';
		}
	}

	if (!defined('SFC_FANPAGE')) {
		// fanpage ids are big integers
		$input['fanpage'] = trim($input['fanpage']);
		if(! preg_match('/^[0-9]+$/i', $input['fanpage'])) {
		  $input['fanpage'] = '';
		}
	}

	$input = apply_filters('sfc_validate_options',$input); // filter to let sub-plugins validate their options too
	return $input;
}

// the cookie is signed using our application secret, so it's unfakable as long as you don't give away the secret
function sfc_cookie_parse() {
	$options = get_option('sfc_options');
	$args = array();
	
	if (list($encoded_sig, $payload) = explode('.', $_COOKIE['fbsr_'. $options['appid']], 2) ) {
		$sig = sfc_base64_url_decode($encoded_sig);  
		if (hash_hmac('sha256', $payload, $options['app_secret'], true) == $sig) {
			$args = json_decode(sfc_base64_url_decode($payload), true);
		}
	}
	
	return $args;
}

// this is not a hack or a dangerous function.. the base64 decode is required because Facebook is sending back base64 encoded data in the signed_request bits. 
// See http://developers.facebook.com/docs/authentication/signed_request/ for more info
function sfc_base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}


// this function checks if the current FB user is a fan of your page.
// Returns true if they are, false otherwise.
function sfc_is_fan($pageid='0') {
	$user = sfc_cookie_parse();
	if (!isset($user['user_id'])) {
		return false; // user isn't "connected", so we don't know who they are, so we can't check to see if they're a fan
	}

	$options = get_option('sfc_options');

	if ($pageid == '0') {
		if ($options['fanpage']) $pageid = $options['fanpage'];
		else $pageid = $options['appid'];
	}

	if ($options['fanpage']) $token = $options['page_access_token'];
	else $token = $options['app_access_token'];

	$fbresp = sfc_remote($user['user_id'], "likes/{$pageid}", array('access_token'=>$token));

	if ( isset( $fbresp['data'][0]['name'] ) ) {
		return true;
	} else {
		return false;
	}
}

function sfc_remote($obj, $connection='', $args=array(), $type = 'GET') {

	$type = strtoupper($type);
	
	if (empty($obj)) return null;
		
	$url = 'https://graph.facebook.com/'. $obj;
	if (!empty($connection)) $url .= '/'.$connection;
	if ($type == 'GET') $url .= '?'.http_build_query($args);
	$args['sslverify']=false;

	if ($type == 'POST') {
		$data = wp_remote_post($url, $args);
	} else if ($type == 'GET') {
		$data = wp_remote_get($url, $args);
	} 
	
	if ($data && !is_wp_error($data)) {
		$resp = json_decode($data['body'],true);
		return $resp;
	}
	
	return false;
}

// code to create a pretty excerpt given a post object
function sfc_base_make_excerpt($post) { 
	
	if (!empty($post->post_excerpt)) $text = $post->post_excerpt;
	else $text = $post->post_content;
	
	$text = strip_shortcodes( $text );

	remove_filter( 'the_content', 'wptexturize' );
	$text = apply_filters('the_content', $text);
	add_filter( 'the_content', 'wptexturize' );

	$text = str_replace(']]>', ']]&gt;', $text);
	$text = wp_strip_all_tags($text);
	$text = str_replace(array("\r\n","\r","\n"),' ',$text);

	$excerpt_more = apply_filters('excerpt_more', '[...]');
	$excerpt_more = html_entity_decode($excerpt_more, ENT_QUOTES, 'UTF-8');
	$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

	$max = min(1000,apply_filters('sfc_excerpt_length',1000));
	$max -= strlen ($excerpt_more) + 1;
	$max -= strlen ('</fb:intl>') * 2 - 1;

	if ($max<1) return ''; // nothing to send
	
	if (strlen($text) >= $max) {
		$text = substr($text, 0, $max);
		$words = explode(' ', $text);
		array_pop ($words);
		array_push ($words, $excerpt_more);
		$text = implode(' ', $words);
	}

	return $text;
}

// code to find any and all images in a post's actual content, given a post object (returns array of urls)
// this should give the best representative sample of images from the post to push to FB
function sfc_base_find_images(&$post) { 
	
	$images = array();
	
	// first we apply the filters to the content, just in case they're using shortcodes or oembed to display images
	if ($post->filtered_content) $content = $post->filtered_content;
	else $content = $post->filtered_content = apply_filters('the_content', $post->post_content);
	
	// next, we get the post thumbnail, put it first in the image list
	if ( current_theme_supports('post-thumbnails') && has_post_thumbnail($post->ID) ) {
		$thumbid = get_post_thumbnail_id($post->ID);
		$att = wp_get_attachment_image_src($thumbid, 'full');
		if (!empty($att[0])) {
			$images[] = $att[0];
		}
	}
	
	if (is_attachment() && 	preg_match('!^image/!', get_post_mime_type( $post ))) {	
	    $images[] = wp_get_attachment_url($post->ID);
	}
	
	// now search for images in the content itself
	if ( preg_match_all('/<img\s+(.+?)>/', $content, $matches) ) {
		foreach($matches[1] as $match) {
			foreach ( wp_kses_hair($match, array('http')) as $attr)
				$img[strtolower($attr['name'])] = $attr['value'];
			if ( isset($img['src']) ) {
				if ( !isset( $img['class'] ) || ( isset( $img['class'] ) && false === straipos( $img['class'], apply_filters( 'sfc_img_exclude', array( 'wp-smiley' ) ) ) ) ) { // ignore smilies
					if ( !in_array( $img['src'], $images ) 
						&& strpos( $img['src'], 'fbcdn.net' ) === false // exclude any images on facebook's CDN
						&& strpos( $img['src'], '/plugins/' ) === false // exclude any images put in from plugin dirs
						) {
						$images[] = $img['src'];
					}
				}
			}
		}
	}
	
	return $images;
}

// tries to find any video content in a post for meta stuff (only finds first video embed)
function sfc_base_find_video(&$post) {

	$vid = array();
	
	// first we apply the filters to the content, just in case they're using shortcodes or oembed to display videos
	if ($post->filtered_content) $content = $post->filtered_content;
	else $content = $post->filtered_content = apply_filters('the_content', $post->post_content);

	// look for an embed to add with video_src (simple, just add first embed)
	if ( preg_match('/<embed\s+(.+?)>/i', $content, $matches) ) {
		foreach ( wp_kses_hair($matches[1], array('http')) as $attr) 
			$embed[strtolower($attr['name'])] = $attr['value'];
		
		$embed['src'] = preg_replace('/&.*$/','', $embed['src']);
		if (preg_match('@http://[^/]*?youtube\.com/@i', $embed['src']) ) {
			$embed['src'] = preg_replace('/[?&#].*$/','', $embed['src']);
		}

		if ( isset($embed['src']) ) $vid[''] = $embed['src'];
		if ( isset($embed['height']) ) $vid[':height'] = $embed['height'];
		if ( isset($embed['width']) ) $vid[':width'] = $embed['width'];
		if ( isset($embed['type']) ) $vid[':type'] = $embed['type'];
	}
	
	return $vid;
}

// add meta tags for *everything*
add_action('wp_head','sfc_base_meta');
function sfc_base_meta() {
	global $post;
	
	$fbmeta = array();
	
	$options = get_option('sfc_options');
	// exclude bbPress post types 
	if ( function_exists('bbp_is_custom_post_type') && bbp_is_custom_post_type() ) return;

	$excerpt = '';
	if (is_singular()) {
	
		global $wp_the_query;
		if ( $id = $wp_the_query->get_queried_object_id() ) {
			$post = get_post( $id );
		}
		
		// get the content from the main post on the page
		$content = sfc_base_make_excerpt($post);
		$images = sfc_base_find_images($post);
		$video = sfc_base_find_video($post);
		if (!empty($video) && preg_match('@http://[^/]*?youtube\.com/(?:v/|p/|embed/p/|embed/|watch\?[vp]=)([^/?&]+)@i', $video[''], $matches) ) {
			array_unshift($images, "http://img.youtube.com/vi/{$matches[1]}/0.jpg");
		}
		
		$title = get_the_title();
		$permalink = get_permalink();
		
		$fbmeta['og:type'] = 'article';
		$fbmeta['og:title'] = esc_attr($title);
		$fbmeta['og:url'] = esc_url($permalink);
		$fbmeta['og:description'] = esc_attr($content);

		if (!empty($images)) {
			foreach ($images as $image) {
				$fbmeta['og:image'][] = $image;
			}
		} else if (!empty($options['default_image'])) {
			$fbmeta['og:image'][] = $options['default_image'];
		}
		
		if (!empty($video)) {
			foreach ($video as $type=>$value) {
				$fbmeta["og:video{$type}"][] = $value;
			}
		}
	} else { // non singular pages need images and descriptions too
		if (!empty($options['default_image'])) {
			$fbmeta['og:image'][] = $options['default_image'];
		}
		if (!empty($options['default_description'])) { 
			$fbmeta['og:description'] = esc_attr($options['default_description']);
		}
	}
		
	if (is_home()) {
		$fbmeta['og:type'] = 'blog';
		$fbmeta['og:title'] = get_bloginfo("name");
		$fbmeta['og:url'] = esc_url(get_bloginfo("url"));
	}
	
	// stuff on all pages
	$fbmeta['og:site_name'] = get_bloginfo("name");
	$fbmeta['fb:app_id'] = esc_attr($options["appid"]);
	
	$fbmeta = apply_filters('sfc_base_meta',$fbmeta);
	
	foreach ($fbmeta as $prop=>$content) {
		if (is_array($content)) {
			foreach ($content as $item) {
				echo "<meta property='{$prop}' content='{$item}' />\n";
				if ($prop == 'og:image') echo "<link rel='image_src' href='{$item}' />\n";
			}
		} else {
			echo "<meta property='{$prop}' content='{$content}' />\n";
			if ($prop == 'og:image') echo "<link rel='image_src' href='{$content}' />\n";
		}
	}
}

// finds a item from an array in a string
if (!function_exists('straipos')) :
function straipos($haystack,$array,$offset=0)
{
   $occ = array();
   for ($i = 0;$i<sizeof($array);$i++)
   {
       $pos = strpos($haystack,$array[$i],$offset);
       if (is_bool($pos)) continue;
       $occ[$pos] = $i;
   }
   if (sizeof($occ)<1) return false;
   ksort($occ);
   reset($occ);
   list($key,$value) = each($occ);
   return array($key,$value);
}
endif;
