<?php

function really_simple_share_counts () {
  $how_many_posts = 60;

	//must check that the user has the required capability 
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

  // INITIALIZE ALL SCRIPTS
	global $really_simple_share_option;
  
  // DISABLE PERFORMANCE MODE LOCALLY, TO ENABLE STATS
  $really_simple_share_option['performance_mode'] = false;
  
  really_simple_share_init(true);
  really_simple_share_scripts();
  if (($really_simple_share_option['active_buttons']['facebook_like'] and $really_simple_share_option['facebook_like_html5'])
  || $really_simple_share_option['active_buttons']['facebook_share_new']) {
  	really_simple_share_facebook_like_html5_bottom_scripts();
  }
  really_simple_share_style();
  
  $out = '
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
    
    .really_simple_share_counts { width: 55%; }
	</style>
  <div class="wrap">
	<h2>'.__( 'Really Simple Share', 'really-simple-share').'
    - '.__( 'Post/Page Counts', 'really-simple-share').'
  </h2>
	<div id="poststuff">

	<div id="poststuff_left">
    <p>'.sprintf(__('Here they are, your <strong>%u most recent posts/pages</strong>, along with their share button counts.', 'really-simple-share'), $how_many_posts).'</p>
    <p>'.__('Please wait a moment, while the counters load.', 'really-simple-share').'</p>';

  $the_query = new WP_Query( 'post_type=any&post_status=publish&posts_per_page='.$how_many_posts );

  if ( $the_query->have_posts() ) {
 		$out .= '<table class="wp-list-table widefat">
      <tr><th>Post/Page</th><th>Share buttons</th></tr>';
  	while ( $the_query->have_posts() ) {
  		$the_query->the_post();
  		$out .= '<tr class="alternate">
        <td> <a href="'.admin_url('post.php?action=edit&post='.get_the_ID()).'">' . get_the_title() . '</a> | ' . get_the_date() . '</td>
        <td class="really_simple_share_counts">' . really_simple_share_publish(get_permalink(), get_the_title()) . '</td>
        </tr>';
  	}
 		$out .= '</table>';
  } else {
    $out .= __('No post or pages found.', 'really-simple-share');
  }
  /* Restore original Post Data */
  wp_reset_postdata();

  $out .= '
	</div>
	
	<div id="poststuff_right">'
		.really_simple_share_box_content('PremiumPress Shopping Cart', '
			<a target="_blank" href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=26764&amp;AFFSRC=really_simple_share_plugin">
				<img border="0" src="http://shopperpress.com/inc/images/banners/180x150.png" style="display: block; margin-left: auto; margin-right: auto;">
			</a>
		')
		.really_simple_share_box_content(__('Really simple, isn\'t it?', 'really-simple-share'), '
			Most of the actual plugin features were requested by users and developed for the sake of doing it.<br /><br />
			If you want to be sure this passion lasts centuries, please consider donating some cents!<br /><br />
			<div style="text-align: center;">
			<form method="post" action="https://www.paypal.com/cgi-bin/webscr">
			<input value="_s-xclick" name="cmd" type="hidden">
			<input value="-----BEGIN PKCS7-----MIIHTwYJKoZIhvcNAQcEoIIHQDCCBzwCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYBjBrEfO5IbCpY2PiBRKu6kRYvZGlqY388pUSKw/QSDOnTQGmHVVsHZsLXulMcV6SoWyaJkfAO8J7Ux0ODh0WuflDD0W/jzCDzeBOs+gdJzzVTHnskX4qhCrwNbHuR7Kx6bScDQVmyX/BVANqjX4OaFu+IGOGOArn35+uapHu49sDELMAkGBSsOAwIaBQAwgcwGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIYfy9OpX6Q3OAgagfWQZaZq034sZhfEUDYhfA8wsh/C29IumbTT/7D0awQDNLaElZWvHPkp+r86Nr1LP6HNOz2hbVE8L1OD5cshKf227yFPYiJQSE9VJbr0/UPHSOpW2a0T0IUnn8n1hVswQExm2wtJRKl3gd6El5TpSy93KbloC5TcWOOy8JNfuDzBQUzyjwinYaXsA6I7OT3R/EGG/95FjJY8/XBfFFYTrlb5yc//f1vx6gggOHMIIDgzCCAuygAwIBAgIBADANBgkqhkiG9w0BAQUFADCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wHhcNMDQwMjEzMTAxMzE1WhcNMzUwMjEzMTAxMzE1WjCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBAMFHTt38RMxLXJyO2SmS+Ndl72T7oKJ4u4uw+6awntALWh03PewmIJuzbALScsTS4sZoS1fKciBGoh11gIfHzylvkdNe/hJl66/RGqrj5rFb08sAABNTzDTiqqNpJeBsYs/c2aiGozptX2RlnBktH+SUNpAajW724Nv2Wvhif6sFAgMBAAGjge4wgeswHQYDVR0OBBYEFJaffLvGbxe9WT9S1wob7BDWZJRrMIG7BgNVHSMEgbMwgbCAFJaffLvGbxe9WT9S1wob7BDWZJRroYGUpIGRMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbYIBADAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBBQUAA4GBAIFfOlaagFrl71+jq6OKidbWFSE+Q4FqROvdgIONth+8kSK//Y/4ihuE4Ymvzn5ceE3S/iBSQQMjyvb+s2TWbQYDwcp129OPIbD9epdr4tJOUNiSojw7BHwYRiPh58S1xGlFgHFXwrEBb3dgNbMUa+u4qectsMAXpVHnD9wIyfmHMYIBmjCCAZYCAQEwgZQwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tAgEAMAkGBSsOAwIaBQCgXTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3DQEJBTEPFw0xMTAzMTAxMzUzNDdaMCMGCSqGSIb3DQEJBDEWBBT5lwavPufWPe9sjAVQlKR5SOVaSDANBgkqhkiG9w0BAQEFAASBgBLEVoF+xLmNqdUTymWD1YqBhsE92g0pSMbtk++Nvhp6LfBCTf0qAZlYZuVx8Toq+yEiqOlGQLLVuYwihkl15ACiv/8K3Ns3Ddl/LXIdCYhMbAm5DIJmQ0nIfQaZcp7CVLVnNjTKF+xTqHKdrOltyL27e1bF8P9Ndqfxnwn3TYD+-----END PKCS7----- " name="encrypted" type="hidden"> 
			<input alt="PayPal - The safer, easier way to pay online!" name="submit" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/en_US/i/btn/btn_donateCC_LG.gif" type="image"> 
			<img height="1" width="1" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/it_IT/i/scr/pixel.gif" border="0"> 
			</form>
			</div>
		')
		.really_simple_share_box_content('News by WhileTrue', really_simple_share_feed())
	.'</div>

	</div>
	</div>';
  
  echo $out;
}
