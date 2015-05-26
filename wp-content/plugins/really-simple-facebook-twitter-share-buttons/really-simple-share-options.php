<?php

function really_simple_share_options () {

	$option_name = 'really_simple_share';

	//must check that the user has the required capability 
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	$active_buttons = array(
		'facebook_like'=>'Facebook like',
		'twitter'=>'Twitter',
		'linkedin'=>'Linkedin',
		'google1'=>'Google "+1"',
		'facebook_share_new'=>'Facebook share (new)',
		'google_share'=>'Google share',
		'digg'=>'Digg',
		'stumbleupon'=>'Stumbleupon',
		'hyves'=>'Hyves (Duch social)',
		'reddit'=>'Reddit',
		'flattr'=>'Flattr',
		'email'=>'Email',
		'pinterest'=>'Pinterest',
		'tipy'=>'Tipy',
		'buffer'=>'Buffer',
		'tumblr'=>'Tumblr',
		'facebook_share'=>'Facebook share (old)',
		'pinzout' => 'Pinzout',
		'rss' => 'Comments RSS Feed',
		'print' => 'Print',
		'youtube'=>'Youtube',
		'bitcoin'=>'Bitcoin',
		'litecoin'=>'Litecoin',
		'specificfeeds'=>'SpecificFeeds',
		'specificfeeds_follow'=>'Email* & RSS (follow)',
		'readygraph_infolinks'=>'Related Tags',
		'frype' => 'Draugiem.lv (frype.com)',
	);	

	$show_in = array(
		'posts'=>'Single posts',
		'pages'=>'Pages',
		'home_page'=>'Home page',
		'tags'=>'Tags',
		'categories'=>'Categories',
		'dates'=>'Date based archives',
		'authors'=>'Author archives',
		'search'=>'Search results',
	);

  $custom_post_types = get_post_types(array('_builtin'=>false));

  $checkboxes = array(
    'disable_default_styles',
    'disable_excerpts',
    'use_shortlink',
    'scripts_at_bottom',
    'performance_mode',
    'facebook_like_html5',
    'facebook_like_send',
    'pinterest_multi_image',
    'google1_count',
    'google_share_count',
    'facebook_share_new_count',
    'linkedin_count',
    'pinterest_count',
    'buffer_count',
    'twitter_count',
    'twitter_author',
  );
	
	$out = '';
	
	// See if the user has posted us some information
	if( isset($_POST['really_simple_share_position']) && check_admin_referer('really_simple_share_settings','really_simple_share_settings_nonce')) {
		$option = array();

		if ($_POST['reset']=='reset') {
			$option = really_simple_share_get_options_default();
		} else {
			foreach (array_keys($active_buttons) as $item) {
				$option['active_buttons'][$item] = (isset($_POST['really_simple_share_active_'.$item]) and $_POST['really_simple_share_active_'.$item]=='on') ? true : false;
				$option['width_buttons'][$item]  = esc_html($_POST['really_simple_share_width_'.$item]);
			}
			foreach (array_keys($show_in) as $item) {
				$option['show_in'][$item] = (isset($_POST['really_simple_share_show_'.$item]) and $_POST['really_simple_share_show_'.$item]=='on') ? true : false;
			}
			foreach (array_keys($custom_post_types) as $item) {
				$option['show_in_custom'][$item] = (isset($_POST['really_simple_share_show_custom_'.$item]) and $_POST['really_simple_share_show_custom_'.$item]=='on') ? true : false;
			}
			$option['sort']                 = esc_html($_POST['really_simple_share_'.'sort']);
			$option['position']             = esc_html($_POST['really_simple_share_'.'position']);
			$option['layout']               = esc_html($_POST['really_simple_share_'.'layout']);
			$option['locale']               = esc_html($_POST['really_simple_share_'.'locale']);
			$option['above_prepend_above']  = esc_html($_POST['really_simple_share_'.'above_prepend_above']);
			$option['above_prepend_inline'] = esc_html($_POST['really_simple_share_'.'above_prepend_inline']);
			$option['below_prepend_above']  = esc_html($_POST['really_simple_share_'.'below_prepend_above']);
			$option['below_prepend_inline'] = esc_html($_POST['really_simple_share_'.'below_prepend_inline']);

			$option['facebook_like_appid'] = esc_html($_POST['really_simple_share_'.'facebook_like_appid']);
			$option['facebook_like_text']  = ($_POST['really_simple_share_'.'facebook_like_text']=='recommend') ? 'recommend' : 'like';
			$option['facebook_like_fixed_url'] = esc_html($_POST['really_simple_share_'.'facebook_like_fixed_url']);
			$option['facebook_share_text'] = esc_html($_POST['really_simple_share_'.'facebook_share_text']);
			$option['rss_text']            = esc_html($_POST['really_simple_share_'.'rss_text']);
			$option['pinterest_hover']     = esc_html($_POST['really_simple_share_'.'pinterest_hover']);
			$option['email_label']         = esc_html($_POST['really_simple_share_'.'email_label']);
			$option['email_subject']       = esc_html($_POST['really_simple_share_'.'email_subject']);
			$option['print_label']         = esc_html($_POST['really_simple_share_'.'print_label']);
			$option['bitcoin_wallet']      = esc_html($_POST['really_simple_share_'.'bitcoin_wallet']);
			$option['litecoin_wallet']     = esc_html($_POST['really_simple_share_'.'litecoin_wallet']);
			$option['flattr_uid']          = esc_html($_POST['really_simple_share_'.'flattr_uid']);
			$option['specificfeeds_link']  = esc_html($_POST['really_simple_share_'.'specificfeeds_link']);
			$option['specificfeeds_follow_text']  = esc_html($_POST['really_simple_share_'.'specificfeeds_follow_text']);
			$option['tipy_uid']            = esc_html($_POST['really_simple_share_'.'tipy_uid']);
			$option['twitter_text']        = esc_html($_POST['really_simple_share_'.'twitter_text']);
			$option['twitter_follow']      = esc_html($_POST['really_simple_share_'.'twitter_follow']);
			$option['twitter_via']         = esc_html($_POST['really_simple_share_'.'twitter_via']);
			$option['youtube_channel']     = esc_html($_POST['really_simple_share_'.'youtube_channel']);
      
      foreach ($checkboxes as $val) {
  			$option[$val]   = (isset($_POST['really_simple_share_'.$val]) && $_POST['really_simple_share_'.$val]  =='on') ? true : false;
      }
		}

		update_option($option_name, $option);
		// Put a settings updated message on the screen
		$out .= '<div class="updated"><p><strong>'.__('Settings updated', 'really-simple-share').'.</strong></p></div>';
	}
	
	//GET (EVENTUALLY UPDATED) ARRAY OF STORED VALUES
	$option = really_simple_share_get_options_stored();
	
	$sel_above = ($option['position']=='above') ? 'selected="selected"' : '';
	$sel_below = ($option['position']=='below') ? 'selected="selected"' : '';
	$sel_both  = ($option['position']=='both' ) ? 'selected="selected"' : '';

	$sel_button = ($option['layout']=='button') ? 'selected="selected"' : '';
	$sel_large_button = ($option['layout']=='large_button') ? 'selected="selected"' : '';
	$sel_box = ($option['layout']=='box') ? 'selected="selected"' : '';

	$sel_like      = ($option['facebook_like_text']=='like'     ) ? 'selected="selected"' : '';
	$sel_recommend = ($option['facebook_like_text']=='recommend') ? 'selected="selected"' : '';

	$sel_pinterest_hover_no    = ($option['pinterest_hover']=='')      ? 'selected="selected"' : '';
	$sel_pinterest_hover_hover = ($option['pinterest_hover']=='hover') ? 'selected="selected"' : '';
	$sel_pinterest_hover_hide  = ($option['pinterest_hover']=='hide' ) ? 'selected="selected"' : '';
	
  foreach ($checkboxes as $val) {
  	$$val = (isset($option[$val]) && $option[$val]) ? 'checked="checked"' : '';
  }
  
	
	// SETTINGS FORM

	$out .= '
	<style>
    #poststuff          { padding-top:10px; position:relative; }
    #poststuff .postbox { min-width: 200px; }
    #poststuff_left, #poststuff_right { float:none; width: 100%; min-width:550px; }
    
    @media all and (min-width: 970px) {
      #poststuff_left  { float:left;  width:74%; }
      #poststuff_right { float:right; width:25%; min-width:200px; }
    }
  
		#really_simple_share_form h3 { cursor: default; }
		#really_simple_share_form td { vertical-align:top; padding-bottom:15px; }
		#sortable { list-style-type: none; margin: 0; padding: 0; width:520px; }
		#sortable li { margin: 3px 0; padding: 4px 0 0 4px; height: 22px; cursor:pointer; border:1px solid gray;}
		#sortable li.button_active   { background: white; }
		#sortable li.button_active .button_title { font-weight: bold; }
		#sortable li.button_inactive { background: gray; }
		#sortable li.button_inactive .button_title { color: white; }
	</style>
	<script>
	jQuery(function() {
		var really_simple_sort = jQuery( "#sortable" ).sortable({ axis: "y",
			update:function(e,ui) {
				var order = really_simple_sort.sortable("toArray").join();
				jQuery("#really_simple_share_sort").val(order);
			}
		});
	});
	
	function really_simple_share_reset_default () {
		if (confirm("'.__('Are you sure?', 'really-simple-share').'")) { 
			document.getElementById("really_simple_share_reset").value = "reset";
			document.form1.submit();
		}
	}
	</script>

	
	<div class="wrap">
	<h2>'.__( 'Really Simple Share', 'really-simple-share').'</h2>
	<div id="poststuff">

	<div id="poststuff_left">

		<form id="really_simple_share_form" name="form1" method="post" action="">

		<div class="postbox">
		<h3>'.__("General options").'</h3>
		<div class="inside">
			<table>
			<tr><td style="width:130px;" colspan="2">'.__("Widget Settings", 'really-simple-share' ).':<br />
				<span class="description">'.__("Check to activate, Drag&Drop to sort, Adjust width in pixels", 'really-simple-share' ).'</span><br /><br />';
		
			$out .= '<ul id="sortable">';
			
			foreach (explode(',',$option['sort']) as $name) {
				$checked = ($option['active_buttons'][$name]) ? 'checked="checked"' : '';
				$options = '';
				$options2 = '';
        $li_style = '';
				switch ($name) {
					case 'facebook_like': 
						$options = 'App ID:
							<input type="text" name="really_simple_share_facebook_like_appid" value="'.stripslashes($option['facebook_like_appid']).'" style="width:120px; margin:0; padding:0;" />';
						break;
					case 'email': 
						$options = __('Text', 'really-simple-share').':
							<input type="text" name="really_simple_share_email_label" value="'.stripslashes($option['email_label']).'" size="25" style="width:160px; margin:0; padding:0;" />';
						break;
					case 'facebook_share': 
						$options = __('Text', 'really-simple-share').':
							<input type="text" name="really_simple_share_facebook_share_text" value="'.stripslashes($option['facebook_share_text']).'" style="width:160px; margin:0; padding:0;" />';
						break;
					case 'facebook_share_new': 
						$options = __('Counter', 'really-simple-share').': <input type="checkbox" name="really_simple_share_facebook_share_new_count" '.$facebook_share_new_count.' />';
						break;
					case 'print': 
						$options = __('Text', 'really-simple-share').':
							<input type="text" name="really_simple_share_print_label" value="'.stripslashes($option['print_label']).'" size="25" style="width:160px; margin:0; padding:0;" />';
						break;
					case 'rss': 
						$options = __('Text', 'really-simple-share').':
							<input type="text" name="really_simple_share_rss_text" value="'.stripslashes($option['rss_text']).'" style="width:160px; margin:0; padding:0;" />';
						break;
					case 'bitcoin': 
						$options = __('Wallet').':
							<input type="text" name="really_simple_share_bitcoin_wallet" value="'.stripslashes($option['bitcoin_wallet']).'" style="width:160px; margin:0; padding:0;" />';
						break;
					case 'litecoin': 
						$options = __('Wallet').':
							<input type="text" name="really_simple_share_litecoin_wallet" value="'.stripslashes($option['litecoin_wallet']).'" style="width:160px; margin:0; padding:0;" />';
						break;
					case 'flattr': 
						$options = 'Flattr UID:
							<input type="text" name="really_simple_share_flattr_uid" value="'.stripslashes($option['flattr_uid']).'" style="width:80px; margin:0; padding:0;" />
							<span class="description">'.__("(mandatory)", 'really-simple-share' ).'</span>';
						break;
					case 'google1': 
						$options = __('Counter', 'really-simple-share').': <input type="checkbox" name="really_simple_share_google1_count" '.$google1_count.' />';
						break;
					case 'google_share': 
						$options = __('Counter', 'really-simple-share').': <input type="checkbox" name="really_simple_share_google_share_count" '.$google_share_count.' />';
						break;
					case 'linkedin': 
						$options = __('Counter', 'really-simple-share').': <input type="checkbox" name="really_simple_share_linkedin_count" '.$linkedin_count.' />';
						break;
					case 'pinterest': 
						$options = __('Counter', 'really-simple-share').': <input type="checkbox" name="really_simple_share_pinterest_count" '.$pinterest_count.' />';
						break;
					case 'buffer': 
						$options = __('Counter', 'really-simple-share').': <input type="checkbox" name="really_simple_share_buffer_count" '.$buffer_count.' />';
						break;
					case 'specificfeeds': 
						$options = __('SF link', 'really-simple-share').': 
							<input type="text" name="really_simple_share_specificfeeds_link" value="'.stripslashes($option['specificfeeds_link']).'" style="width:100px; margin:0; padding:0;" />
							<span class="description">('.__("mandatory", 'really-simple-share' ).')</span>';
						$li_style = 'style="height:75px;"';
						$options2 = '<div style="clear:both; background-color: #ccc; font-size:10px;">'.__('SpecificFeeds allows your visitors to receive messages from your Blog/RSS Feed by email. It\'s 100% free and also has
              <a href="http://www.specificfeeds.com/rss" target="_blank">several other benefits</a>. Enter above the pop-up link you received after setting up your feed on 
              <a href="http://www.specificfeeds.com/rss" target="_blank">SpecificFeeds.com/rss</a>', 'really-simple-share' ).'</div>';
            break;
					case 'specificfeeds_follow': 
						$options = __('Text', 'really-simple-share').':
							<input type="text" name="really_simple_share_specificfeeds_follow_text" value="'.stripslashes($option['specificfeeds_follow_text']).'" style="width:160px; margin:0; padding:0;" />';
							$li_style = 'style="height:75px;"';
            $options2 = '<div style="clear:both; background-color: #ccc; font-size:10px;">'.__('*Email follow is powered by ReadyGraph. It allows your visitors to receive messages from your site.  Visitors don\'t have to leave your site to signup, and they can invite friends as well.  Optionally you can <a href="http://readygraph.com/" target="_blank">create your free account</a> here for full analytics and other features.  (<a href="http://readygraph.com/tos/" target="_blank">Terms</a> 
<a href="http://readygraph.com/privacy/" target="_blank">Privacy</a>)', 'really-simple-share' ).'</div>';
						break;
					case 'readygraph_infolinks':
						$li_style = 'style="height:57px;"'; 
						$options2 = '<div style="clear:both; background-color: #ccc; font-size:10px;">'.__('Related Tags powered by
Infolinks/ReadyGraph.  Connect account and collect revenue here if your site qualifies.  (<a href="http://readygraph.com/tos/" target="_blank">Terms</a> | <a href="http://readygraph.com/privacy/" target="_blank">Privacy</a> | <a href="mailto:info@readygraph.com" target="_blank">Questions?</a>)', 'really-simple-share' ).'</div>';
						break;
					case 'tipy': 
						$options = __('Tipy site id', 'really-simple-share').': 
							<input type="text" name="really_simple_share_tipy_uid" value="'.stripslashes($option['tipy_uid']).'" style="width:80px; margin:0; padding:0;" />
							<span class="description">('.__("mandatory", 'really-simple-share' ).')</span>';
						break;
					case 'twitter': 
						$options = __('Counter', 'really-simple-share').': <input type="checkbox" name="really_simple_share_twitter_count" '.$twitter_count.' />';
						break;
					case 'youtube': 
            $youtube_channel = (isset($option['youtube_channel'])) ? stripslashes($option['youtube_channel']) : '';
						$options = __('Channel name').':
							<input type="text" name="really_simple_share_youtube_channel" value="'.$youtube_channel.'" style="width:120px; margin:0; padding:0;" />';
						break;
				}
				$button_status = ($checked) ? 'active' : 'inactive';
				$out .= '<li class="ui-state-default button_'.$button_status.'" id="'.$name.'" '.$li_style.'>
						<div style="float:left; width:180px;" title="'.esc_html($active_buttons[$name]).' - '.$button_status.'">
							<input type="checkbox" class="button_activate" name="really_simple_share_active_'.$name.'" title="'.__('Activate button', 'really-simple-share').' '.$active_buttons[$name].'" '.$checked.' /> 
							<span class="button_title">'.esc_html($active_buttons[$name]).'</span>
						</div>
						<div style="float:left; width:70px;" title="'.__('Width of the transparent box surrounding the button (use it for spacing)', 'really-simple-share' ).'">
							<input type="text" name="really_simple_share_width_'.$name.'" value="'.stripslashes($option['width_buttons'][$name]).'" style="width:35px; margin:0; padding:0; text-align:right;" />px	
						</div>
						<div style="float:left; width:260px;">
							'.$options.'
						</div>
						'.$options2.'
					</li>';
			}

			$out .= '</ul>
				<input type="hidden" id="really_simple_share_sort" name="really_simple_share_sort" value="'.stripslashes($option['sort']).'" />
				';


			$out .= '</td></tr>
			<tr><td>'.__('Show buttons in these pages', 'really-simple-share' ).':</td>
			<td>';

			foreach ($show_in as $name => $text) {
				$checked = ($option['show_in'][$name]) ? 'checked="checked"' : '';
				$out .= '<div style="width:250px; float:left;">
						<input type="checkbox" name="really_simple_share_show_'.$name.'" '.$checked.' /> '
						. __($text, 'really-simple-share' ).' &nbsp;&nbsp;</div>';
			}

			$out .= '</td></tr>
			<tr><td>'.__("Position", 'really-simple-share' ).':</td>
			<td><select name="really_simple_share_position">
				<option value="above" '.$sel_above.' > '.__('only above the post', 'really-simple-share' ).'</option>
				<option value="below" '.$sel_below.' > '.__('only below the post', 'really-simple-share' ).'</option>
				<option value="both"  '.$sel_both.'  > '.__('above and below the post', 'really-simple-share' ).'</option>
				</select>
			</td></tr>
			<tr><td>'.__("Layout", 'really-simple-share' ).':</td>
			<td><select name="really_simple_share_layout">
				<option value="button" '.$sel_button.' > '.__('button', 'really-simple-share' ).'</option>
				<option value="large_button" '.$sel_large_button.' > '.__('large button', 'really-simple-share' ).'</option>
				<option value="box" '.$sel_box.' > '.__('box', 'really-simple-share' ).'</option>
				</select><br />
				<span class="description">'.__("Please note that the Large button is available only for some social networks (e.g. google+ and twitter), otherwhise Standard button will be displayed", 'really-simple-share' ).'
			</td></tr>
			<tr><td>'.__("Language", 'really-simple-share' ).':</td>
			<td><select name="really_simple_share_locale">
					<option value="en_US" '. ($option['locale'] == 'en_US' ? 'selected="1"' : '') . '>English (US)</option>
					<option value="ca_ES" '. ($option['locale'] == 'ca_ES' ? 'selected="1"' : '') . '>Catalan</option>
					<option value="cs_CZ" '. ($option['locale'] == 'cs_CZ' ? 'selected="1"' : '') . '>Czech</option>
					<option value="cy_GB" '. ($option['locale'] == 'cy_GB' ? 'selected="1"' : '') . '>Welsh</option>
					<option value="da_DK" '. ($option['locale'] == 'da_DK' ? 'selected="1"' : '') . '>Danish</option>
					<option value="de_DE" '. ($option['locale'] == 'de_DE' ? 'selected="1"' : '') . '>German</option>
					<option value="eu_ES" '. ($option['locale'] == 'eu_ES' ? 'selected="1"' : '') . '>Basque</option>
					<option value="en_PI" '. ($option['locale'] == 'en_PI' ? 'selected="1"' : '') . '>English (Pirate)</option>
					<option value="en_UD" '. ($option['locale'] == 'en_UD' ? 'selected="1"' : '') . '>English (Upside Down)</option>
					<option value="ck_US" '. ($option['locale'] == 'ck_US' ? 'selected="1"' : '') . '>Cherokee</option>
					<option value="es_LA" '. ($option['locale'] == 'es_LA' ? 'selected="1"' : '') . '>Spanish</option>
					<option value="es_CL" '. ($option['locale'] == 'es_CL' ? 'selected="1"' : '') . '>Spanish (Chile)</option>
					<option value="es_CO" '. ($option['locale'] == 'es_CO' ? 'selected="1"' : '') . '>Spanish (Colombia)</option>
					<option value="es_ES" '. ($option['locale'] == 'es_ES' ? 'selected="1"' : '') . '>Spanish (Spain)</option>
					<option value="es_MX" '. ($option['locale'] == 'es_MX' ? 'selected="1"' : '') . '>Spanish (Mexico)</option>
					<option value="es_VE" '. ($option['locale'] == 'es_VE' ? 'selected="1"' : '') . '>Spanish (Venezuela)</option>
					<option value="fb_FI" '. ($option['locale'] == 'fb_FI' ? 'selected="1"' : '') . '>Finnish (test)</option>
					<option value="fi_FI" '. ($option['locale'] == 'fi_FI' ? 'selected="1"' : '') . '>Finnish</option>
					<option value="fr_FR" '. ($option['locale'] == 'fr_FR' ? 'selected="1"' : '') . '>French (France)</option>
					<option value="gl_ES" '. ($option['locale'] == 'gl_ES' ? 'selected="1"' : '') . '>Galician</option>
					<option value="hu_HU" '. ($option['locale'] == 'hu_HU' ? 'selected="1"' : '') . '>Hungarian</option>
					<option value="it_IT" '. ($option['locale'] == 'it_IT' ? 'selected="1"' : '') . '>Italian</option>
					<option value="ja_JP" '. ($option['locale'] == 'ja_JP' ? 'selected="1"' : '') . '>Japanese</option>
					<option value="ko_KR" '. ($option['locale'] == 'ko_KR' ? 'selected="1"' : '') . '>Korean</option>
					<option value="nb_NO" '. ($option['locale'] == 'nb_NO' ? 'selected="1"' : '') . '>Norwegian (bokmal)</option>
					<option value="nn_NO" '. ($option['locale'] == 'nn_NO' ? 'selected="1"' : '') . '>Norwegian (nynorsk)</option>
					<option value="nl_NL" '. ($option['locale'] == 'nl_NL' ? 'selected="1"' : '') . '>Dutch</option>
					<option value="pl_PL" '. ($option['locale'] == 'pl_PL' ? 'selected="1"' : '') . '>Polish</option>
					<option value="pt_BR" '. ($option['locale'] == 'pt_BR' ? 'selected="1"' : '') . '>Portuguese (Brazil)</option>
					<option value="pt_PT" '. ($option['locale'] == 'pt_PT' ? 'selected="1"' : '') . '>Portuguese (Portugal)</option>
					<option value="ro_RO" '. ($option['locale'] == 'ro_RO' ? 'selected="1"' : '') . '>Romanian</option>
					<option value="ru_RU" '. ($option['locale'] == 'ru_RU' ? 'selected="1"' : '') . '>Russian</option>
					<option value="sk_SK" '. ($option['locale'] == 'sk_SK' ? 'selected="1"' : '') . '>Slovak</option>
					<option value="sl_SI" '. ($option['locale'] == 'sl_SI' ? 'selected="1"' : '') . '>Slovenian</option>
					<option value="sv_SE" '. ($option['locale'] == 'sv_SE' ? 'selected="1"' : '') . '>Swedish</option>
					<option value="th_TH" '. ($option['locale'] == 'th_TH' ? 'selected="1"' : '') . '>Thai</option>
					<option value="tr_TR" '. ($option['locale'] == 'tr_TR' ? 'selected="1"' : '') . '>Turkish</option>
					<option value="ku_TR" '. ($option['locale'] == 'ku_TR' ? 'selected="1"' : '') . '>Kurdish</option>
					<option value="zh_CN" '. ($option['locale'] == 'zh_CN' ? 'selected="1"' : '') . '>Simplified Chinese (China)</option>
					<option value="zh_HK" '. ($option['locale'] == 'zh_HK' ? 'selected="1"' : '') . '>Traditional Chinese (Hong Kong)</option>
					<option value="zh_TW" '. ($option['locale'] == 'zh_TW' ? 'selected="1"' : '') . '>Traditional Chinese (Taiwan)</option>
					<option value="fb_LT" '. ($option['locale'] == 'fb_LT' ? 'selected="1"' : '') . '>Leet Speak</option>
					<option value="af_ZA" '. ($option['locale'] == 'af_ZA' ? 'selected="1"' : '') . '>Afrikaans</option>
					<option value="sq_AL" '. ($option['locale'] == 'sq_AL' ? 'selected="1"' : '') . '>Albanian</option>
					<option value="hy_AM" '. ($option['locale'] == 'hy_AM' ? 'selected="1"' : '') . '>Armenian</option>
					<option value="az_AZ" '. ($option['locale'] == 'az_AZ' ? 'selected="1"' : '') . '>Azeri</option>
					<option value="be_BY" '. ($option['locale'] == 'be_BY' ? 'selected="1"' : '') . '>Belarusian</option>
					<option value="bn_IN" '. ($option['locale'] == 'bn_IN' ? 'selected="1"' : '') . '>Bengali</option>
					<option value="bs_BA" '. ($option['locale'] == 'bs_BA' ? 'selected="1"' : '') . '>Bosnian</option>
					<option value="bg_BG" '. ($option['locale'] == 'bg_BG' ? 'selected="1"' : '') . '>Bulgarian</option>
					<option value="hr_HR" '. ($option['locale'] == 'hr_HR' ? 'selected="1"' : '') . '>Croatian</option>
					<option value="nl_BE" '. ($option['locale'] == 'nl_BE' ? 'selected="1"' : '') . '>Dutch (Belgium)</option>
					<option value="en_GB" '. ($option['locale'] == 'en_GB' ? 'selected="1"' : '') . '>English (UK)</option>
					<option value="eo_EO" '. ($option['locale'] == 'eo_EO' ? 'selected="1"' : '') . '>Esperanto</option>
					<option value="et_EE" '. ($option['locale'] == 'et_EE' ? 'selected="1"' : '') . '>Estonian</option>
					<option value="fo_FO" '. ($option['locale'] == 'fo_FO' ? 'selected="1"' : '') . '>Faroese</option>
					<option value="fr_CA" '. ($option['locale'] == 'fr_CA' ? 'selected="1"' : '') . '>French (Canada)</option>
					<option value="ka_GE" '. ($option['locale'] == 'ka_GE' ? 'selected="1"' : '') . '>Georgian</option>
					<option value="el_GR" '. ($option['locale'] == 'el_GR' ? 'selected="1"' : '') . '>Greek</option>
					<option value="gu_IN" '. ($option['locale'] == 'gu_IN' ? 'selected="1"' : '') . '>Gujarati</option>
					<option value="hi_IN" '. ($option['locale'] == 'hi_IN' ? 'selected="1"' : '') . '>Hindi</option>
					<option value="is_IS" '. ($option['locale'] == 'is_IS' ? 'selected="1"' : '') . '>Icelandic</option>
					<option value="id_ID" '. ($option['locale'] == 'id_ID' ? 'selected="1"' : '') . '>Indonesian</option>
					<option value="ga_IE" '. ($option['locale'] == 'ga_IE' ? 'selected="1"' : '') . '>Irish</option>
					<option value="jv_ID" '. ($option['locale'] == 'jv_ID' ? 'selected="1"' : '') . '>Javanese</option>
					<option value="kn_IN" '. ($option['locale'] == 'kn_IN' ? 'selected="1"' : '') . '>Kannada</option>
					<option value="kk_KZ" '. ($option['locale'] == 'kk_KZ' ? 'selected="1"' : '') . '>Kazakh</option>
					<option value="la_VA" '. ($option['locale'] == 'la_VA' ? 'selected="1"' : '') . '>Latin</option>
					<option value="lv_LV" '. ($option['locale'] == 'lv_LV' ? 'selected="1"' : '') . '>Latvian</option>
					<option value="li_NL" '. ($option['locale'] == 'li_NL' ? 'selected="1"' : '') . '>Limburgish</option>
					<option value="lt_LT" '. ($option['locale'] == 'lt_LT' ? 'selected="1"' : '') . '>Lithuanian</option>
					<option value="mk_MK" '. ($option['locale'] == 'mk_MK' ? 'selected="1"' : '') . '>Macedonian</option>
					<option value="mg_MG" '. ($option['locale'] == 'mg_MG' ? 'selected="1"' : '') . '>Malagasy</option>
					<option value="ms_MY" '. ($option['locale'] == 'ms_MY' ? 'selected="1"' : '') . '>Malay</option>
					<option value="mt_MT" '. ($option['locale'] == 'mt_MT' ? 'selected="1"' : '') . '>Maltese</option>
					<option value="mr_IN" '. ($option['locale'] == 'mr_IN' ? 'selected="1"' : '') . '>Marathi</option>
					<option value="mn_MN" '. ($option['locale'] == 'mn_MN' ? 'selected="1"' : '') . '>Mongolian</option>
					<option value="ne_NP" '. ($option['locale'] == 'ne_NP' ? 'selected="1"' : '') . '>Nepali</option>
					<option value="pa_IN" '. ($option['locale'] == 'pa_IN' ? 'selected="1"' : '') . '>Punjabi</option>
					<option value="rm_CH" '. ($option['locale'] == 'rm_CH' ? 'selected="1"' : '') . '>Romansh</option>
					<option value="sa_IN" '. ($option['locale'] == 'sa_IN' ? 'selected="1"' : '') . '>Sanskrit</option>
					<option value="sr_RS" '. ($option['locale'] == 'sr_RS' ? 'selected="1"' : '') . '>Serbian</option>
					<option value="so_SO" '. ($option['locale'] == 'so_SO' ? 'selected="1"' : '') . '>Somali</option>
					<option value="sw_KE" '. ($option['locale'] == 'sw_KE' ? 'selected="1"' : '') . '>Swahili</option>
					<option value="tl_PH" '. ($option['locale'] == 'tl_PH' ? 'selected="1"' : '') . '>Filipino</option>
					<option value="ta_IN" '. ($option['locale'] == 'ta_IN' ? 'selected="1"' : '') . '>Tamil</option>
					<option value="tt_RU" '. ($option['locale'] == 'tt_RU' ? 'selected="1"' : '') . '>Tatar</option>
					<option value="te_IN" '. ($option['locale'] == 'te_IN' ? 'selected="1"' : '') . '>Telugu</option>
					<option value="ml_IN" '. ($option['locale'] == 'ml_IN' ? 'selected="1"' : '') . '>Malayalam</option>
					<option value="uk_UA" '. ($option['locale'] == 'uk_UA' ? 'selected="1"' : '') . '>Ukrainian</option>
					<option value="uz_UZ" '. ($option['locale'] == 'uz_UZ' ? 'selected="1"' : '') . '>Uzbek</option>
					<option value="vi_VN" '. ($option['locale'] == 'vi_VN' ? 'selected="1"' : '') . '>Vietnamese</option>
					<option value="xh_ZA" '. ($option['locale'] == 'xh_ZA' ? 'selected="1"' : '') . '>Xhosa</option>
					<option value="zu_ZA" '. ($option['locale'] == 'zu_ZA' ? 'selected="1"' : '') . '>Zulu</option>
					<option value="km_KH" '. ($option['locale'] == 'km_KH' ? 'selected="1"' : '') . '>Khmer</option>
					<option value="tg_TJ" '. ($option['locale'] == 'tg_TJ' ? 'selected="1"' : '') . '>Tajik</option>
					<option value="ar_AR" '. ($option['locale'] == 'ar_AR' ? 'selected="1"' : '') . '>Arabic</option>
					<option value="he_IL" '. ($option['locale'] == 'he_IL' ? 'selected="1"' : '') . '>Hebrew</option>
					<option value="ur_PK" '. ($option['locale'] == 'ur_PK' ? 'selected="1"' : '') . '>Urdu</option>
					<option value="fa_IR" '. ($option['locale'] == 'fa_IR' ? 'selected="1"' : '') . '>Persian</option>
					<option value="sy_SY" '. ($option['locale'] == 'sy_SY' ? 'selected="1"' : '') . '>Syriac</option>
					<option value="yi_DE" '. ($option['locale'] == 'yi_DE' ? 'selected="1"' : '') . '>Yiddish</option>
					<option value="gn_PY" '. ($option['locale'] == 'gn_PY' ? 'selected="1"' : '') . '>Guaran&igrave;</option>
					<option value="qu_PE" '. ($option['locale'] == 'qu_PE' ? 'selected="1"' : '') . '>Quechua</option>
					<option value="ay_BO" '. ($option['locale'] == 'ay_BO' ? 'selected="1"' : '') . '>Aymara</option>
					<option value="se_NO" '. ($option['locale'] == 'se_NO' ? 'selected="1"' : '') . '>Northern S&agrave;mi</option>
					<option value="ps_AF" '. ($option['locale'] == 'ps_AF' ? 'selected="1"' : '') . '>Pashto</option>
					<option value="tl_ST" '. ($option['locale'] == 'tl_ST' ? 'selected="1"' : '') . '>Klingon</option>						
				</select><br />
				<span class="description">'.__("Please note that not all languages are available for every button. If the WPML plugin is active, language is set automatically", 'really-simple-share' ).'
			</td></tr>
			</table>
		</div>
		</div>

    <h2>
      Advanced Options
      <button class="button" style="margin-left:20px;" onclick="javascript:jQuery(\'#really_simple_share_advanced\').toggle(); return false;">Click to show / hide</button>
    </h2>
    <div id="really_simple_share_advanced" style="display:none;">'
		.really_simple_share_box_content(__('Call to action, above the post', 'really-simple-share'), 
			array(
				__('On the above line', 'really-simple-share')=>'
					<input type="text" name="really_simple_share_above_prepend_above" value="'.stripslashes($option['above_prepend_above']).'" size="50" /><br />
				<span class="description">'.__("Optional text shown above the buttons, e.g. 'If you liked this post, say thanks by sharing it:'", 'really-simple-share' ).'</span>
				',
				__('Inline', 'really-simple-share')=>'
					<input type="text" name="really_simple_share_above_prepend_inline" value="'.stripslashes($option['above_prepend_inline']).'" size="25" /><br />
				<span class="description">'.__("Optional text shown inline before the buttons, e.g. 'Share this:'", 'really-simple-share' ).'</span>
				',
			)
		)
		.really_simple_share_box_content(__('Call to action, below the post', 'really-simple-share'), 
			array(
				__('On the above line', 'really-simple-share')=>'
					<input type="text" name="really_simple_share_below_prepend_above" value="'.stripslashes($option['below_prepend_above']).'" size="50" /><br />
				<span class="description">'.__("Optional text shown above the buttons, e.g. 'If you liked this post, say thanks by sharing it:'", 'really-simple-share' ).'</span>
				',
				__('Inline', 'really-simple-share')=>'
					<input type="text" name="really_simple_share_below_prepend_inline" value="'.stripslashes($option['below_prepend_inline']).'" size="25" /><br />
				<span class="description">'.__("Optional text shown inline before the buttons, e.g. 'Share this:'", 'really-simple-share' ).'</span>
				',
			)
		);
    
    $show_in_custom_types = '';
    if (count($custom_post_types)>0) {
			foreach ($custom_post_types as $name => $text) {
				$checked = ($option['show_in_custom'][$name]) ? 'checked="checked"' : '';
				$show_in_custom_types .= '<div style="width:250px; float:left;">
						<input type="checkbox" name="really_simple_share_show_custom_'.$name.'" '.$checked.' /> '
						. __($text, 'really-simple-share' ).' &nbsp;&nbsp;</div>';
			}
    }
    if ($show_in_custom_types == '') {
      $show_in_custom_types .= __('No custom type found', 'really-simple-share' );
    } else {
      $show_in_custom_types .= '<div style="clear:both;"><span class="description">'.__('Note: some of these post types are never displayed on the public site', 'really-simple-share' ).'</span></div>';
    }    
    
    $out .= really_simple_share_box_content(__('Advanced options', 'really-simple-share'), 
			array(
				__('Show share buttons in custom post types', 'really-simple-share')=>
          $show_in_custom_types
        ,
				__('Load scripts at the bottom of the body', 'really-simple-share')=>'
					<input type="checkbox" name="really_simple_share_scripts_at_bottom" '.$scripts_at_bottom.' />
					<span class="description">'.__("Checking it should increase the page loading speed. Warning: this requires the theme to have the wp_footer() hook in the appropriate place; if unsure, leave it unchecked", 'really-simple-share' ).'</span>
				',
				__('Performance mode', 'really-simple-share')=>'
					<input type="checkbox" name="really_simple_share_performance_mode" '.$performance_mode.' />
					<span class="description">'.__("Checking it should increase the page loading speed by skipping JS and CSS code on pages without active share buttons. Warning: this DISABLES the \"shortcode\" and \"template function\" features; if unsure, leave it unchecked", 'really-simple-share' ).'</span>
				',
				__('Disable default styles', 'really-simple-share')=>'
					<input type="checkbox" name="really_simple_share_disable_default_styles" '.$disable_default_styles.' />
				',
				__('Disable buttons on excerpts', 'really-simple-share')=>'
					<input type="checkbox" name="really_simple_share_disable_excerpts" '.$disable_excerpts.' />
					<span class="description">'.__("Try changing this if the buttons show bad in some pages or areas", 'really-simple-share' ).'</span>
				',
				__('Use Wordpress shortlink instead of permalink', 'really-simple-share')=>'
					<input type="checkbox" name="really_simple_share_use_shortlink" '.$use_shortlink.' />
					<span class="description">'.__("Warning: changing the link format may reset the button counters; if unsure, leave it unchecked", 'really-simple-share' ).'</span>
				'
			)
		)
		.really_simple_share_box_content(__('Facebook Like button options', 'really-simple-share'), 
			array(
				__('Button text', 'really-simple-share')=>'
					<select name="really_simple_share_facebook_like_text">
						<option value="like" '.$sel_like.' > '.__('like', 'really-simple-share' ).'</option>
						<option value="recommend" '.$sel_recommend.' > '.__('recommend', 'really-simple-share' ).'</option>
					</select>
				',
				__('Show Send button', 'really-simple-share')=>'
					<input type="checkbox" name="really_simple_share_facebook_like_send" '.$facebook_like_send.' />
				',
				__('Use Html5 code instead of iFrame', 'really-simple-share')=>'
					<input type="checkbox" name="really_simple_share_facebook_like_html5" '.$facebook_like_html5.' />
					<span class="description">'.__("Warning: this requires the theme to have the wp_footer() hook in the appropriate place. If unsure, leave it unchecked", 'really-simple-share' ).'</span>
				',
				__('Fixed sharing url', 'really-simple-share')=>'
					<input type="text" name="really_simple_share_facebook_like_fixed_url" value="'.stripslashes($option['facebook_like_fixed_url']).'" size="50" /><br />
			  	<span class="description">'.__("The optional url provided (e.g. http://www.yoursite.com/) will be linked to every FB Like button on the site, and used as a reference for share counts and clicks, instead of the single posts and pages. If unsure, leave it blank", 'really-simple-share' ).'</span>
				'
			)
		)
		.really_simple_share_box_content(__('Pinterest button options', 'really-simple-share'), 
			array(__('Always use multiple image selector', 'really-simple-share')=>'
					<input type="checkbox" name="really_simple_share_pinterest_multi_image" '.$pinterest_multi_image.' /> 
				',
				__('Use the PinIt image hover button', 'really-simple-share')=>'
				<select name="really_simple_share_pinterest_hover">
				<option value=""      '.$sel_pinterest_hover_no.'    > '.__('no',  'really-simple-share' ).'</option>
				<option value="hover" '.$sel_pinterest_hover_hover.' > '.__('yes', 'really-simple-share' ).'</option>
				<option value="hide"  '.$sel_pinterest_hover_hide.'  > '.__('yes, and hide PinIt on the button bar', 'really-simple-share' ).'</option>
				</select>
				'
			)
		)
		.really_simple_share_box_content(__('Twitter button options', 'really-simple-share'), 
			array(
				__('Additional text', 'really-simple-share')=>'
					<input type="text" name="really_simple_share_twitter_text" value="'.stripslashes($option['twitter_text']).'" size="25" /><br />
					<span class="description">'.__("Optional text added at the end of every tweet, e.g. ' (via @authorofblogentry)'.
					If you use it, insert an initial space or puntuation mark", 'really-simple-share' ).'</span>
				',
				__('Add author to follow list', 'really-simple-share')=>'
					<input type="checkbox" name="really_simple_share_twitter_author" '.$twitter_author.' />
					<span class="description">'.__("If checked, the (wordpress) nickname of the author of the post is always added to the follow list.", 'really-simple-share' ).'</span>
				',
				__('Add user to follow list', 'really-simple-share')=>'
					<input type="text" name="really_simple_share_twitter_follow" value="'.stripslashes($option['twitter_follow']).'" size="25" /><br />
					<span class="description">'.__("Optional related Twitter usernames (comma separated) added to the follow list", 'really-simple-share' ).'</span>
				',
				__('Via this user', 'really-simple-share')=>'
					<input type="text" name="really_simple_share_twitter_via" value="'.stripslashes($option['twitter_via']).'" size="25" /><br />
					<span class="description">'.__("Optional Twitter username attributed as the tweet author", 'really-simple-share' ).'</span>
				',
			)
		)
		.really_simple_share_box_content(__('Email button options', 'really-simple-share'), 
			array(
				__('Custom text for email subject and text', 'really-simple-share')=>'
					<input type="text" name="really_simple_share_email_subject" value="'.stripslashes($option['email_subject']).'" size="50" /><br />
				<span class="description">'.__("Optional text used instead of the article title", 'really-simple-share' ).'</span>
				',
			)
		)
    .'</div>'
		.wp_nonce_field('really_simple_share_settings','really_simple_share_settings_nonce')
		.'<p class="submit">
			<input type="hidden" name="reset" id="really_simple_share_reset" value="" />
			<input type="submit" name="Submit" class="button-primary" value="'.esc_attr('Save Changes').'" />
		</p>
		<p style="text-align:right;">
			<input type="button" name="reset" class="button" onclick="javascript:really_simple_share_reset_default(); return false;" value="'.esc_attr('Reset to Default values').'" />
		</p>
		</form>

	</div>
	
	<div id="poststuff_right">'
		
		.really_simple_share_box_content(__('Additional info', 'really-simple-share'), '
			<b>Selective use</b><br />
			If you want to place the active buttons only in selected posts, put the [really_simple_share] shortcode inside the post text.<br /><br />
			<b>Selective hide</b><br />
			If you want to hide the share buttons inside selected posts, set the "really_simple_share_disable" custom field with value "yes".
		')
		.really_simple_share_box_content(__('Really simple, isn\'t it?', 'really-simple-share'), '
			Most of the actual plugin features were requested by users and developed for the sake of doing it.<br /><br />
			If you want to be sure this passion lasts centuries, please consider donating some cents!<br /><br />
			<div style="text-align: center;">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input name="cmd" type="hidden" value="_s-xclick" /><input name="hosted_button_id" type="hidden" value="996W9HS5JSWN4" /><input alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" type="image" /><img src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" alt="" width="1" height="1" border="0" /></form>
			</div>
		')
		/*.really_simple_share_box_content('News by WhileTrue', really_simple_share_feed())*/
	.'</div>

	</div>
	</div>
	';
	echo $out; 
}
