<?php
/*
Plugin Name: Quick Chat
Plugin URI: http://www.techytalk.info/quick-chat
Description: Quick Chat is WordPress chat plugin with support for translation, chat rooms, words filtering, emoticons, user list, gravatars and more.
Author: Marko Martinović
Version: 2.40
Author URI: http://www.techytalk.info
License: GPL2

Copyright 2011.  Marko Martinović  (email : marko AT techytalk.info)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

global $default_quick_chat_db_version;
global $default_badwords_list;
global $default_disallow_usernames_list;
global $default_name;
global $default_keep_around_count;
global $default_guest_num_digits;
global $default_timeout_refresh_users;
global $default_timeout_refresh_messages;
global $default_manual_gmt_offset;

global $quick_chat_options;
global $quick_chat_db_version;
global $quick_chat_url;
global $quick_chat_path;
global $quick_chat_is_embedded_array;
global $quick_chat_smile_array;
global $quick_chat_data_array;
global $quick_chat_last_timestamp;
global $quick_chat_user_ip;
global $quick_chat_user_status;
global $quick_chat_user_name;
global $quick_chat_no_participation;
global $quick_chat_date_format;
global $quick_chat_time_format;
global $quick_chat_gmt_offset;
global $quick_chat_adsense_content;
global $quick_chat_user_email_md5;
global $quick_chat_preselected_langcode;
global $quick_chat_is_bot;
global $quick_chat_ip_blocked;
global $quick_chat_must_login;
global $quick_chat_bot_array;

$default_badwords_list = '4r5e, 5h1t, 5hit, a55, anal, anus, ar5e, arrse, arse, ass, ass-fucker, asses, assfucker, assfukka, asshole, assholes, asswhole, a_s_s, b!tch, b00bs, b17ch, b1tch, ballbag, balls, ballsack, bastard, beastial, beastiality, bellend, bestial, bestiality, bi+ch, biatch, bitch, bitcher, bitchers, bitches, bitchin, bitching, bloody, blow job, blowjob, blowjobs, boiolas, bollock, bollok, boner, boob, boobs, booobs, boooobs, booooobs, booooooobs, breasts, buceta, bugger, bum, bunny fucker, butt, butthole, buttmuch, buttplug, c0ck, c0cksucker, carpet muncher, cawk, chink, cipa, cl1t, clit, clitoris, clits, cnut, cock, cock-sucker, cockface, cockhead, cockmunch, cockmuncher, cocks, cocksuck , cocksucked , cocksucker, cocksucking, cocksucks , cocksuka, cocksukka, cok, cokmuncher, coksucka, coon, cox, crap, cum, cummer, cumming, cums, cumshot, cunilingus, cunillingus, cunnilingus, cunt, cuntlick , cuntlicker , cuntlicking , cunts, cyalis, cyberfuc, cyberfuck , cyberfucked , cyberfucker, cyberfuckers, cyberfucking , d1ck, damn, dick, dickhead, dildo, dildos, dink, dinks, dirsa, dlck, dog-fucker, doggin, dogging, donkeyribber, doosh, duche, dyke, ejaculate, ejaculated, ejaculates , ejaculating , ejaculatings, ejaculation, ejakulate, f u c k, f u c k e r, f4nny, fag, fagging, faggitt, faggot, faggs, fagot, fagots, fags, fanny, fannyflaps, fannyfucker, fanyy, fatass, fcuk, fcuker, fcuking, feck, fecker, felching, fellate, fellatio, fingerfuck , fingerfucked , fingerfucker , fingerfuckers, fingerfucking , fingerfucks , fistfuck, fistfucked , fistfucker , fistfuckers , fistfucking , fistfuckings , fistfucks , flange, fook, fooker, fuck, fucka, fucked, fucker, fuckers, fuckhead, fuckheads, fuckin, fucking, fuckings, fuckingshitmotherfucker, fuckme , fucks, fuckwhit, fuckwit, fudge packer, fudgepacker, fuk, fuker, fukker, fukkin, fuks, fukwhit, fukwit, fux, fux0r, f_u_c_k, gangbang, gangbanged , gangbangs , gaylord, gaysex, goatse, God, god-dam, god-damned, goddamn, goddamned, hardcoresex , hell, heshe, hoar, hoare, hoer, homo, hore, horniest, horny, hotsex, jack-off , jackoff, jap, jerk-off , jism, jiz , jizm , jizz, kawk, knob, knobead, knobed, knobend, knobhead, knobjocky, knobjokey, kock, kondum, kondums, kum, kummer, kumming, kums, kunilingus, l3i+ch, l3itch, labia, lmfao, lust, lusting, m0f0, m0fo, m45terbate, ma5terb8, ma5terbate, masochist, master-bate, masterb8, masterbat*, masterbat3, masterbate, masterbation, masterbations, masturbate, mo-fo, mof0, mofo, mothafuck, mothafucka, mothafuckas, mothafuckaz, mothafucked , mothafucker, mothafuckers, mothafuckin, mothafucking , mothafuckings, mothafucks, mother fucker, motherfuck, motherfucked, motherfucker, motherfuckers, motherfuckin, motherfucking, motherfuckings, motherfuckka, motherfucks, muff, mutha, muthafecker, muthafuckker, muther, mutherfucker, n1gga, n1gger, nazi, nigg3r, nigg4h, nigga, niggah, niggas, niggaz, nigger, niggers , nob, nob jokey, nobhead, nobjocky, nobjokey, numbnuts, nutsack, orgasim , orgasims , orgasm, orgasms , p0rn, pawn, pecker, penis, penisfucker, phonesex, phuck, phuk, phuked, phuking, phukked, phukking, phuks, phuq, pigfucker, pimpis, piss, pissed, pisser, pissers, pisses , pissflaps, pissin , pissing, pissoff , poop, porn, porno, pornography, pornos, prick, pricks , pron, pube, pusse, pussi, pussies, pussy, pussys , rectum, retard, rimjaw, rimming, s hit, s.o.b., sadist, schlong, screwing, scroat, scrote, scrotum, semen, sex, sh!+, sh!t, sh1t, shag, shagger, shaggin, shagging, shemale, shi+, shit, shitdick, shite, shited, shitey, shitfuck, shitfull, shithead, shiting, shitings, shits, shitted, shitter, shitters , shitting, shittings, shitty , skank, slut, sluts, smegma, smut, snatch, son-of-a-bitch, spac, spunk, s_h_i_t, t1tt1e5, t1tties, teets, teez, testical, testicle, tit, titfuck, tits, titt, tittie5, tittiefucker, titties, tittyfuck, tittywank, titwank, tosser, turd, tw4t, twat, twathead, twatty, twunt, twunter, v14gra, v1gra, vagina, viagra, vulva, w00se, wang, wank, wanker, wanky, whoar, whore, willies, willy, xrated, xxx';
$default_ip_blocklist = '';
$default_disallow_usernames_list = 'admin, moderator';
$default_name = __('Guest_','quick-chat');
$default_keep_around_count = '0';
$default_guest_num_digits = '3';
$default_quick_chat_db_version = '18';
$default_timeout_refresh_users = '30';
$default_timeout_refresh_messages = '2';
$default_adsense_content = '';
$default_manual_gmt_offset = '0';

$quick_chat_options = get_option('quick_chat_options');
$quick_chat_preselected_langcode = 'en';
$quick_chat_db_version = get_option('quick_chat_db_version');
$quick_chat_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$quick_chat_path = WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$quick_chat_data_array = array();
$quick_chat_is_embedded_array = array();
$quick_chat_user_ip = (isset($_SERVER['HTTP_X_FORWARD_FOR'])) ? $_SERVER['HTTP_X_FORWARD_FOR'] : $_SERVER['REMOTE_ADDR'];
$quick_chat_date_format = get_option('date_format');
$quick_chat_time_format = get_option('time_format');
$quick_chat_gmt_offset = get_option('gmt_offset');

$quick_chat_smile_array = array(
               ':)' => 'smile',
		':(' => 'sad',
		';)' => 'wink',
		':P' =>'razz',
		':D' =>'grin',
		':|' => 'plain',
		':O' => 'surprise',
		':?' => 'confused',
		'8)' => 'glasses',
		'8o' => 'eek',
		'B)' => 'cool',
		':-)' => 'smile-big',
		':-(' => 'crying',
		':-*' => 'kiss',
		'O:-D' => 'angel',
		'&gt;:-D' => 'devilish',
		':o)' => 'monkey',
		':idea:' =>'idea',
		':important:' => 'important',
		':help:' => 'help',
		':error:' => 'error',
		':warning:' => 'warning',
		':favorite:' => 'favorite'
                );

$quick_chat_bot_array = array(  'google',
                                'msnbot',
                                'ia_archiver',
                                'lycos',
                                'jeeves',
                                'scooter',
                                'fast-webcrawler',
                                'slurp@inktomi',
                                'turnitinbot',
                                'technorati',
                                'yahoo',
                                'findexa',
                                'findlinks',
                                'gaisbo',
                                'zyborg',
                                'surveybot',
                                'bloglines',
                                'blogsearch',
                                'pubsub',
                                'syndic8',
                                'userland',
                                'gigabot',
                                'become.com',
                                'baidu',
                                'yandex',
                                'amazonaws.com');

function quick_chat_get_version() {
    $plugin_data = get_plugin_data( __FILE__ );
    $plugin_version = $plugin_data['Version'];
    return $plugin_version;
}

function quick_chat_init(){
    global $wpdb;
    global $quick_chat_user_status;
    global $quick_chat_ip_blocked;
    global $quick_chat_options;
    global $quick_chat_user_ip;
    global $quick_chat_user_name;
    global $quick_chat_user_email_md5;
    global $quick_chat_no_participation;
    global $quick_chat_gmt_offset;
    global $quick_chat_is_bot;
    global $quick_chat_must_login;
    global $quick_chat_bot_array;

    $quick_chat_users_table_name = $wpdb->prefix . 'quick_chat_users';

    $plugin_path = dirname(plugin_basename(__FILE__));
    load_plugin_textdomain('quick-chat', false, $plugin_path.'/languages/');

    $quick_chat_gmt_offset += $quick_chat_options['manual_gmt_offset'];

    if(is_user_logged_in()){
        if(current_user_can('manage_options')){
            $quick_chat_user_status = 0;
        }else{
            $quick_chat_user_status = 1;
        }

        global $current_user;
        get_currentuserinfo();

        if(isset($_COOKIE['quick_chat_alias_'.$current_user->ID])){
            $quick_chat_user_name =  stripslashes($_COOKIE['quick_chat_alias_'.$current_user->ID]);
        } else{
            setcookie('quick_chat_alias_'.$current_user->ID, $current_user->user_login, 0, COOKIEPATH, COOKIE_DOMAIN);
            $quick_chat_user_name =  $current_user->user_login;
        }

        $quick_chat_user_email_md5 = md5(strtolower($current_user->user_email));
    } else{
        $quick_chat_user_status = 2;

        if(isset($_COOKIE['quick_chat_alias'])){
            $quick_chat_user_name = stripslashes($_COOKIE['quick_chat_alias']);
        } else{
            $maxNumWidthNumDigits = '';
            $numDigits = $quick_chat_options['guest_num_digits'];
            for($i=0; $i<$numDigits; $i++){
                $maxNumWidthNumDigits .= '9';
            }
            $quick_chat_user_name = __($quick_chat_options['default_name'],'quick-chat').mt_rand(0, $maxNumWidthNumDigits);
            setcookie('quick_chat_alias', $quick_chat_user_name, 0, COOKIEPATH, COOKIE_DOMAIN);
        }
        $quick_chat_user_email_md5 = '';
    }

    $quick_chat_no_participation = 0;

    $quick_chat_is_bot = 0;
    foreach ($quick_chat_bot_array as $quick_chat_bot){
        if(stripos($_SERVER['HTTP_USER_AGENT'], $quick_chat_bot) !== false ) {
            $quick_chat_is_bot = 1;
            $quick_chat_no_participation = 1;
            break;
        }
    }

    if($quick_chat_is_bot == 0){
        $quick_chat_ip_blocked = 0;
        if( isset($quick_chat_options['ip_blocklist'])
            &&
            $quick_chat_user_status != 0
            &&
            strpos($quick_chat_options['ip_blocklist'], $quick_chat_user_ip) !== false){
                $quick_chat_ip_blocked = 1;
                $quick_chat_no_participation = 1;
        }

        if($quick_chat_ip_blocked == 0){
            $quick_chat_must_login = 0;
            if( isset($quick_chat_options['only_logged_in_users'])
                &&
                $quick_chat_user_status == 2){
                $quick_chat_must_login = 1;
                $quick_chat_no_participation = 1;
            }
        }
    }
}
add_action('init','quick_chat_init');

function quick_chat_load_stylesheet() {
    global $quick_chat_url;
    global $quick_chat_path;
    global $wp_styles;

    $my_style_url = $quick_chat_url . 'css/quick-chat.css';
    $my_style_file = $quick_chat_path . 'css/quick-chat.css';

    $stupid_ie_style_url = $quick_chat_url . 'css/quick-chat-ie.css';
    $stupid_ie_style_file = $quick_chat_path . 'css/quick-chat-ie.css';

    if (file_exists($my_style_file)) {
        wp_enqueue_style('quick_chat_style_sheet', $my_style_url);
    }

    if (file_exists($stupid_ie_style_file)) {
        wp_enqueue_style('quick_chat_ie_style_sheet', $stupid_ie_style_url, array('quick_chat_style_sheet'));
        $wp_styles->add_data('quick_chat_ie_style_sheet', 'conditional', 'lt IE 8');
    }
}
add_action('wp_print_styles', 'quick_chat_load_stylesheet');

function quick_chat_filter($text, $replace_inside_words){
    global $quick_chat_options;

    if(isset($quick_chat_options['badwords_list']) && ($quick_chat_options['badwords_list'] != '')){
        $strings = explode(',', $quick_chat_options['badwords_list']);
        foreach($strings as $word){
            $word = trim($word);

            $replacement = str_repeat('*', strlen($word));

            if($replace_inside_words){
                $text = str_ireplace($word, $replacement, $text);
            }
            else{
                $text = preg_replace('/\b'.$word.'\b/i', $replacement, $text);
            }
        }
    }
    return $text;
}


function quick_chat_install() {
    global $wpdb;
    global $default_badwords_list;
    global $default_disallow_usernames_list;
    global $default_quick_chat_db_version;
    global $default_name;
    global $default_keep_around_count;
    global $default_guest_num_digits;
    global $quick_chat_options;
    global $quick_chat_db_version;
    global $default_ip_blocklist;
    global $default_timeout_refresh_users;
    global $default_adsense_content;
    global $default_timeout_refresh_messages;
    global $default_manual_gmt_offset;

    $quick_chat_messages_table_name = $wpdb->prefix . 'quick_chat_messages';
    $quick_chat_users_table_name = $wpdb->prefix . 'quick_chat_users';

    if($quick_chat_db_version < 12){
        // Quick Chat cannot be upgraded from 1.x to 2.x
        $quick_chat_messages_uninstall_table_name = $wpdb->prefix . 'quick_chat';
        $quick_chat_options = get_option('quick_chat_options');
        $query = $wpdb->query('DROP TABLE IF EXISTS '.$quick_chat_messages_uninstall_table_name.';');
    }

    if ($quick_chat_db_version < 15){
        // This is upgrade from v14 database to v15 database, added id auto increment to users table, impossible to do alter, nuke it (QC v2.30)
        $query = $wpdb->query('DROP TABLE IF EXISTS '.$quick_chat_users_table_name.';');
    }

    $messages_table_exists = ($wpdb->get_var('SHOW TABLES LIKE \''.$quick_chat_messages_table_name.'\';') == $quick_chat_messages_table_name) ? 1: 0;
    $users_table_exists = ($wpdb->get_var('SHOW TABLES LIKE \''.$quick_chat_users_table_name.'\';') == $quick_chat_users_table_name) ? 1: 0;

    if($messages_table_exists == 0) {
       $sql_messages = 'CREATE TABLE '.$quick_chat_messages_table_name.' (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        room VARCHAR(50) NOT NULL DEFAULT "default",
        timestamp TIMESTAMP NOT NULL,
        alias VARCHAR(100) NOT NULL default "",
        md5email CHAR(32) NOT NULL default "",
        status TINYINT(1) NOT NULL DEFAULT 2,
        ip VARCHAR(39) NOT NULL,
        message TEXT NOT NULL,
        INDEX (timestamp ASC),
        INDEX (room ASC)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8, COLLATE utf8_general_ci;';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_messages);

   } else{
        if($quick_chat_db_version < 14){
            // This is upgrade from v13 database to v14 database, we need to alter table (QC v2.20)
            $query = $wpdb->query('ALTER TABLE '.$quick_chat_messages_table_name.' ADD COLUMN md5email CHAR(32) NOT NULL DEFAULT "" AFTER alias;');
        }

        if($quick_chat_db_version < 18){
            // This is upgrade from v16 database to v18 database, we need to alter table (QC v2.40)
            $query = $wpdb->query('ALTER TABLE '.$quick_chat_messages_table_name.' CHANGE COLUMN alias alias VARCHAR(255) NOT NULL DEFAULT "";');
        }
   }

    if($users_table_exists == 0) {
        $sql_users = 'CREATE TABLE '.$quick_chat_users_table_name.' (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	status TINYINT(1) NOT NULL DEFAULT 2,
	room VARCHAR(50) NOT NULL DEFAULT "default",
	timestamp_polled TIMESTAMP NOT NULL,
        timestamp_joined TIMESTAMP NOT NULL,
	alias VARCHAR(255) NOT NULL default "",
	ip VARCHAR(39) NOT NULL default "" ,
	INDEX (timestamp_polled ASC, timestamp_joined ASC),
        UNIQUE KEY roomalias (room, alias)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8, COLLATE utf8_general_ci;';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_users);

    } else{
        // Future upgrades
    }

    if($quick_chat_db_version < 12){
        // Quick Chat cannot be upgraded from 1.x to 2.x
        if(get_option('quick_chat_options')) delete_option('quick_chat_options');
        if(get_option('quick_chat_db_version')) delete_option('quick_chat_db_version');
        if(get_option('widget_quick-chat-widget')) delete_option('widget_quick-chat-widget');
    }

    if($quick_chat_db_version < 13){
        if(!isset($quick_chat_options['adsense_content'])) {
            $quick_chat_options['adsense_content'] = $default_adsense_content;
        }
    }

    if($quick_chat_db_version < 14){
        $widget_options = get_option('widget_quick-chat-widget');
        if(isset($widget_options) && is_array($widget_options)){
            foreach($widget_options as &$option){
                if (is_array($option) && !empty($option)){
                        $option['gravatars'] = 1;
                        $option['gravatars_size'] = 32;
                }
            }
            update_option('widget_quick-chat-widget', $widget_options);
        }
    }

    if($quick_chat_db_version < 15){
        if(!isset($quick_chat_options['timeout_refresh_messages'])) {
            $quick_chat_options['timeout_refresh_messages'] = $default_timeout_refresh_messages;
        }

        if(isset($quick_chat_options['timeout_consider_offline'])) {
            unset($quick_chat_options['timeout_consider_offline']);
        }
    }

    if($quick_chat_db_version < 16){
        $widget_options = get_option('widget_quick-chat-widget');
        if(isset($widget_options) && is_array($widget_options)){
            foreach($widget_options as &$option){
                if (is_array($option) && !empty($option)){
                        $option['loggedin_visible'] = 1;
                        $option['guests_visible'] = 1;
                }
            }
            update_option('widget_quick-chat-widget', $widget_options);
        }
    }

    if($quick_chat_db_version < 18){
        if(!isset($quick_chat_options['manual_gmt_offset'])) {
            $quick_chat_options['manual_gmt_offset'] = $default_manual_gmt_offset;
        }

        // Remove few options to simplify code (server performance)
        if(isset($quick_chat_options['keep_first_last'])) {
            unset($quick_chat_options['keep_first_last']);
        }

        if(isset($quick_chat_options['allow_guests_choice'])) {
            unset($quick_chat_options['allow_guests_choice']);
        }

        if(isset($quick_chat_options['allow_logged_in_choice'])) {
            unset($quick_chat_options['allow_logged_in_choice']);
        }

        // Increase users and messages refresh times (server performance)
        if(isset($quick_chat_options['timeout_refresh_users'])) {
            $quick_chat_options['timeout_refresh_users'] = $default_timeout_refresh_users;
        }

        if(isset($quick_chat_options['timeout_refresh_messages'])) {
            $quick_chat_options['timeout_refresh_messages'] = $default_timeout_refresh_messages;
        }
    }

    if(!isset($quick_chat_options['hyperlinks'])) {
        $quick_chat_options['hyperlinks'] = '1';
    }

    if(!isset($quick_chat_options['disallow_logged_in_usernames'])) {
        $quick_chat_options['disallow_logged_in_usernames'] = '1';
    }

    if(!isset($quick_chat_options['timeout_refresh_users'])) {
        $quick_chat_options['timeout_refresh_users'] = $default_timeout_refresh_users;
    }

    if(!isset($quick_chat_options['default_name'])) {
        $quick_chat_options['default_name'] = $default_name;
    }

    if(!isset($quick_chat_options['badwords_list'])) {
        $quick_chat_options['badwords_list'] = $default_badwords_list;
    }

    if(!isset($quick_chat_options['keep_around_count'])) {
        $quick_chat_options['keep_around_count'] = $default_keep_around_count;
    }

    if(!isset($quick_chat_options['guest_num_digits'])) {
        $quick_chat_options['guest_num_digits'] = $default_guest_num_digits;
    }

    if(!isset($quick_chat_options['ip_blocklist'])) {
        $quick_chat_options['ip_blocklist'] = $default_ip_blocklist;
    }

    if(!isset($quick_chat_options['disallow_usernames_list'])) {
        $quick_chat_options['disallow_usernames_list'] = $default_disallow_usernames_list;
    }

    update_option('quick_chat_db_version', $default_quick_chat_db_version);
    update_option('quick_chat_options', $quick_chat_options);
}

function quick_chat_update_db_check() {
    global $quick_chat_db_version;
    global $default_quick_chat_db_version;

    if ($quick_chat_db_version != $default_quick_chat_db_version) {
        quick_chat_install();
    }
}
add_action('plugins_loaded', 'quick_chat_update_db_check');

function quick_chat_username_check_ajax_handler(){
    global $quick_chat_options;
    global $quick_chat_user_status;
    global $quick_chat_no_participation;
    global $wpdb;

    check_ajax_referer('quick_chat_username_check_nonce', 'quick_chat_username_check_nonce');

    if($quick_chat_no_participation == 0){
        $quick_chat_users_table_name = $wpdb->prefix . 'quick_chat_users';

        $username_invalid = 0;
        $username_bad_words = 0;
        $username_exists = 0;
        $username_blocked = 0;

        if($_POST['username_check'] != $_POST['username_old']){
            global $current_user;
            get_currentuserinfo();
            $_POST['username_check'] = trim(stripslashes($_POST['username_check']));
            $_POST['room_name'] = trim(stripslashes($_POST['room_name']));

            if  (
                    ($_POST['username_check'] == '')
                    ||
                    (isset($quick_chat_options['disallow_special_usernames']) && !validate_username($_POST['username_check']))
                )
                $username_invalid = 1;

            if  (   $username_invalid == 0
                    &&
                    (quick_chat_filter($_POST['username_check'], true) != $_POST['username_check'])
                )
                $username_bad_words = 1;

            global $wp_version;
            if (version_compare($wp_version, '3.1', '<')){
                require_once(ABSPATH . WPINC . '/registration.php');
            }

            if($username_bad_words == 0 && (!is_user_logged_in() || (is_user_logged_in() && strcasecmp($_POST['username_check'], $current_user->user_login) != 0))){

                if($username_exists == 0){
                    global $wpdb;
                    $quick_chat_users_table_name = $wpdb->prefix . 'quick_chat_users';

                    $users = $wpdb->get_results('SELECT * FROM '.$quick_chat_users_table_name.' WHERE room = "'.$_POST['room_name'].'" ORDER BY alias ASC' );

                    if($users){
                        foreach($users as $u){
                            if($u->alias == $_POST['username_check']){
                                $username_exists = 1;
                                break;
                            }
                        }
                    }
                }

                if($quick_chat_user_status != 0 && isset($quick_chat_options['disallow_logged_in_usernames'])){
                    if(username_exists($_POST['username_check']) != null){
                        $username_exists = 1;
                    }
                }

                if($username_exists == 0 && $quick_chat_user_status != 0 && isset($quick_chat_options['disallow_usernames_list']) && ($quick_chat_options['disallow_usernames_list'] != '')){
                    $blocked_usernames = explode(',', $quick_chat_options['disallow_usernames_list']);
                    foreach ($blocked_usernames as $blocked_username) {
                        if(stripos($quick_chat_options['disallow_usernames_list'], $_POST['username_check']) !== false){
                            $username_blocked = 1;
                            break;
                        }
                    }
                }
            }

            if($username_exists == 0 && $username_blocked == 0 && $username_invalid == 0 && $username_bad_words == 0){
                if ($quick_chat_user_status == 2){
                    setcookie('quick_chat_alias', $_POST['username_check'], 0, COOKIEPATH, COOKIE_DOMAIN);
                }else{
                    setcookie('quick_chat_alias_'.$current_user->ID, $_POST['username_check'], 0, COOKIEPATH, COOKIE_DOMAIN);
                }
                quick_chat_cleanup_users();
                quick_chat_update_users($_POST['room_name'], $_POST['username_check']);
            }
        }

        $response = json_encode(array('quick_chat_no_participation' => 0, 'username' => $_POST['username_check'], 'username_exists'=> $username_exists , 'username_blocked'=> $username_blocked, 'username_invalid'=> $username_invalid, 'username_bad_words'=> $username_bad_words, 'quick_chat_username_check_nonce'=> wp_create_nonce('quick_chat_username_check_nonce')));
    }else{
        $response = json_encode(array('quick_chat_no_participation' => 1, 'quick_chat_username_check_nonce'=> wp_create_nonce('quick_chat_username_check_nonce')));
    }

    header( "Content-Type: application/json" );
    echo $response;
    exit;
}
add_action( 'wp_ajax_nopriv_quick-chat-ajax-username-check', 'quick_chat_username_check_ajax_handler' );
add_action( 'wp_ajax_quick-chat-ajax-username-check', 'quick_chat_username_check_ajax_handler' );

function quick_chat_delete_ajax_handler(){
    global $wpdb;
    global $quick_chat_options;
    $quick_chat_messages_table_name = $wpdb->prefix . 'quick_chat_messages';

    check_ajax_referer('quick_chat_delete_nonce', 'quick_chat_delete_nonce');

    $deleted_ids;
    foreach ($_POST['to_delete_ids'] as $value) {
        $wpdb->query('DELETE FROM '.$quick_chat_messages_table_name.' WHERE id ='.$value);
    }

    $messages = quick_chat_fetch_messages($_POST['to_delete_room_name']);

    $response = json_encode(array('quick_chat_messages' => $messages,
        'quick_chat_delete_nonce'=> wp_create_nonce('quick_chat_delete_nonce')));

    header( "Content-Type: application/json" );
    echo $response;
    exit;
}
add_action( 'wp_ajax_nopriv_quick-chat-ajax-delete', 'quick_chat_delete_ajax_handler' );
add_action( 'wp_ajax_quick-chat-ajax-delete', 'quick_chat_delete_ajax_handler' );

function quick_chat_ban_ajax_handler(){
    global $quick_chat_options;

    check_ajax_referer('quick_chat_ban_nonce', 'quick_chat_ban_nonce');

    if($quick_chat_options['ip_blocklist'] != '')
        $ip_blocklist = array_map('trim',explode(",", $quick_chat_options['ip_blocklist']));
    else
        $ip_blocklist = array();

    foreach ($_POST['to_ban_ips'] as $ban_ip) {
        $ip_blocklist[] = $ban_ip;
    }

    $quick_chat_options['ip_blocklist'] = implode(", ", array_unique($ip_blocklist));

    update_option('quick_chat_options', $quick_chat_options);

    $response = json_encode(array('quick_chat_ban_nonce'=> wp_create_nonce('quick_chat_ban_nonce')));

    header( "Content-Type: application/json" );
    echo $response;
    exit;
}
add_action( 'wp_ajax_nopriv_quick-chat-ajax-ban', 'quick_chat_ban_ajax_handler' );
add_action( 'wp_ajax_quick-chat-ajax-ban', 'quick_chat_ban_ajax_handler' );

function quick_chat_new_message_ajax_handler(){
    global $wpdb;
    global $quick_chat_options;
    global $quick_chat_user_status;
    global $quick_chat_user_name;
    global $quick_chat_user_ip;
    global $quick_chat_user_email_md5;
    global $quick_chat_no_participation;

    $quick_chat_messages_table_name = $wpdb->prefix . 'quick_chat_messages';

    check_ajax_referer('quick_chat_new_message_nonce', 'quick_chat_new_message_nonce');

    $_POST['message'] = wp_kses(trim(stripslashes($_POST['message'])),'');

    if($quick_chat_no_participation == 0 && $_POST['message'] != ''){

        if($quick_chat_user_status != 0){
            $_POST['message'] = quick_chat_filter($_POST['message'], (isset($quick_chat_options['replace_inside_bad_words'])? true:false));
        }

        if(isset($quick_chat_options['hyperlinks'])){
            $_POST['message'] = links_add_target(make_clickable($_POST['message']));
        }

        $rows_affected = $wpdb->query('INSERT INTO '.$quick_chat_messages_table_name.' (room, timestamp, alias, md5email, status, ip, message) VALUES ("'.$wpdb->escape($_POST['room']).'", NOW(), "'.$wpdb->escape($quick_chat_user_name).'", "'.$quick_chat_user_email_md5.'", '.$quick_chat_user_status.', "'.$quick_chat_user_ip.'", "'.$wpdb->escape($_POST['message']).'");');
    }
    $response = json_encode(array('quick_chat_no_participation' => $quick_chat_no_participation, 'quick_chat_new_message_nonce'=> wp_create_nonce('quick_chat_new_message_nonce')));

    header( "Content-Type: application/json" );
    echo $response;
    exit;
}
add_action( 'wp_ajax_nopriv_quick-chat-ajax-new-message', 'quick_chat_new_message_ajax_handler' );
add_action( 'wp_ajax_quick-chat-ajax-new-message', 'quick_chat_new_message_ajax_handler' );

function quick_chat_update_messages_ajax_handler(){
    global $wpdb;
    global $quick_chat_options;
    global $quick_chat_date_format;
    global $quick_chat_time_format;
    global $quick_chat_gmt_offset;
    global $quick_chat_no_participation;
    $quick_chat_messages_table_name = $wpdb->prefix . 'quick_chat_messages';

    check_ajax_referer('quick_chat_update_messages_nonce', 'quick_chat_update_messages_nonce');

    $last_room = end($_POST['quick_chat_rooms']);

    ob_start();
    header( "Content-Type: application/json" );
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

    $startTime = time();
    while((time()-$startTime)<=20){

        $sql = 'SELECT id, room, timestamp, UNIX_TIMESTAMP(timestamp) as unix_timestamp, alias, md5email, status, message FROM '.$quick_chat_messages_table_name. ' WHERE (';

        foreach($_POST['quick_chat_rooms'] as $room){
            $sql .= 'room = "'.$room.'"';
            if($room != $last_room) $sql .= ' OR ';
        }

        $sql .= ') AND timestamp > FROM_UNIXTIME('.$_POST['quick_chat_last_timestamp'].') ORDER BY unix_timestamp ASC;';

        $messages = $wpdb->get_results($sql);
        if($messages){
            foreach($messages as $v){
                $v->timestring = date_i18n($quick_chat_date_format.' - '.$quick_chat_time_format, $v->unix_timestamp+($quick_chat_gmt_offset* 3600));
            }
            $response = json_encode(array('quick_chat_no_participation' => $quick_chat_no_participation, 'quick_chat_success'=> 1,'quick_chat_messages'=>$messages,'quick_chat_update_messages_nonce'=> wp_create_nonce('quick_chat_update_messages_nonce')));

            echo $response;
            ob_flush(); flush();
            exit;
        }else{
            sleep($quick_chat_options['timeout_refresh_messages']);
        }
    }

    $response = json_encode(array('quick_chat_no_participation' => $quick_chat_no_participation, 'quick_chat_success'=> 0, 'quick_chat_update_messages_nonce'=> wp_create_nonce('quick_chat_update_messages_nonce')));

    echo $response;
    ob_flush(); flush();
    exit;
}
add_action( 'wp_ajax_nopriv_quick-chat-ajax-update-messages', 'quick_chat_update_messages_ajax_handler' );
add_action( 'wp_ajax_quick-chat-ajax-update-messages', 'quick_chat_update_messages_ajax_handler' );

function quick_chat_update_users_ajax_handler(){
    global $wpdb;
    global $quick_chat_options;
    global $quick_chat_no_participation;
    $quick_chat_messages_table_name = $wpdb->prefix . 'quick_chat_messages';

    check_ajax_referer('quick_chat_update_users_nonce', 'quick_chat_update_users_nonce');

    $_POST['to_update_user_name'] = stripslashes($_POST['to_update_user_name']);
    $_POST['to_update_room_name'] = stripslashes($_POST['to_update_room_name']);

    quick_chat_cleanup_users();

    if($quick_chat_no_participation == 0){
        quick_chat_update_users($_POST['to_update_room_name'], $_POST['to_update_user_name']);
    }

    $response = json_encode(array('quick_chat_no_participation' => $quick_chat_no_participation, 'quick_chat_users_list' => quick_chat_fetch_users($_POST['to_update_room_name']),
        'quick_chat_update_users_nonce'=> wp_create_nonce('quick_chat_update_users_nonce')));

    header( "Content-Type: application/json" );
    echo $response;
    exit;
}
add_action( 'wp_ajax_nopriv_quick-chat-ajax-update-users', 'quick_chat_update_users_ajax_handler' );
add_action( 'wp_ajax_quick-chat-ajax-update-users', 'quick_chat_update_users_ajax_handler' );

function quick_chat_js() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'quick_chat_js');

function quick_chat_localize(){
    global $quick_chat_last_timestamp;
    if($quick_chat_last_timestamp != null){
        global $quick_chat_url;
        global $quick_chat_user_status;
        global $quick_chat_no_participation;
        global $quick_chat_smile_array;
        global $quick_chat_data_array;
        global $quick_chat_options;
        global $quick_chat_preselected_langcode;

        $quick_chat_js_vars = array   (
            'quick_chat_url' => $quick_chat_url,
            'quick_chat_ajaxurl' => admin_url('admin-ajax.php'),
            'quick_chat_user_status' => $quick_chat_user_status,
            'quick_chat_audio_enable' => (isset($quick_chat_options['message_sound_default_on'])) ? 1 : 0,
            'quick_chat_default_langugage_code' => $quick_chat_preselected_langcode,
            'quick_chat_bing_appid' => (isset($quick_chat_options['bing_appid']) ? $quick_chat_options['bing_appid']:'') ,
            'quick_chat_cookiepath' => COOKIEPATH,
            'quick_chat_cookie_domain' => COOKIE_DOMAIN,
            'quick_chat_no_participation' => $quick_chat_no_participation,
            'quick_chat_delete_what_string' => __('You must select at least one message','quick-chat'),
            'quick_chat_delete_confirm_string' => __('Are you sure you want to permanently delete selected messages?','quick-chat'),
            'quick_chat_ban_who_string' => __('You must select at least one user','quick-chat'),
            'quick_chat_ban_confirm_string' => __('Are you sure you want to add selected users to your Quick Chat admin options IP blocklist?','quick-chat'),
            'quick_chat_reply_to_string' => __('Reply to','quick-chat'),
            'quick_chat_username_exists_string' => __('Already taken!','quick-chat'),
            'quick_chat_username_blocked_string' => __('Not allowed!','quick-chat'),
            'quick_chat_username_invalid_string' => __('Illegal characters!','quick-chat'),
            'quick_chat_username_bad_words_string' => __('Profanity!','quick-chat'),
            'quick_chat_select_language_string' =>__('Select language:','quick-chat'),
            'quick_chat_translate_string' => __('Translate','quick-chat'),
            'quick_chat_username_check_nonce' => wp_create_nonce('quick_chat_username_check_nonce'),
            'quick_chat_delete_nonce' => wp_create_nonce('quick_chat_delete_nonce'),
            'quick_chat_ban_nonce' => wp_create_nonce('quick_chat_ban_nonce'),
            'quick_chat_new_message_nonce' => wp_create_nonce('quick_chat_new_message_nonce'),
            'quick_chat_update_messages_nonce'=> wp_create_nonce('quick_chat_update_messages_nonce'),
            'quick_chat_update_users_nonce' => wp_create_nonce('quick_chat_update_users_nonce'),
            'quick_chat_last_timestamp' => $quick_chat_last_timestamp,
            'quick_chat_username_check_wait_string' => __('Checking...','quick-chat'),
            'quick_chat_timeout_refresh_users' => $quick_chat_options['timeout_refresh_users'] * 1000
        );

        ?>
        <script type='text/javascript'>
        /* <![CDATA[ */
        var quick_chat_js_vars = <?php echo json_encode($quick_chat_js_vars); ?>;
        var quick_chat_l10n_after = <?php echo json_encode(array('quick_chat_smile_array' => $quick_chat_smile_array, 'quick_chat_data_array'=> $quick_chat_data_array)); ?>;
        /* ]]> */
        </script>

        <script type="text/javascript" src="<?php echo $quick_chat_url.'js/jquery.translate.min.js' ?>"></script><?php

        if(isset($quick_chat_options['debug_mode'])){
            ?><script type="text/javascript" src="<?php echo $quick_chat_url.'js/quick-chat.js' ?>"></script><?php
        } else{
            ?><script type="text/javascript" src="<?php echo $quick_chat_url.'js/quick-chat.min.js' ?>"></script><?php
        }
    }
}
add_action('wp_print_footer_scripts', 'quick_chat_localize');

function quick_chat_init_fn(){
    register_setting('quick_chat_options', 'quick_chat_options', 'quick_chat_options_validate' );

    add_settings_section('donate_section', __('Donating or getting help','quick-chat'), 'quick_chat_section_donate_fn', __FILE__);
    add_settings_section('general_section', __('General options','quick-chat'), 'quick_chat_section_general_fn', __FILE__);
    add_settings_section('filter_section', __('Filter options','quick-chat'), 'quick_chat_section_filter_fn', __FILE__);
    add_settings_section('security_section', __('Security options','quick-chat'), 'quick_chat_section_security_fn', __FILE__);
    add_settings_section('appearance_section', __('Appearance options','quick-chat'), 'quick_chat_section_appearance_fn', __FILE__);

    add_settings_field('quick_chat_debug_mode', __('Debug mode (enable only when debugging):','quick-chat'), 'quick_chat_setting_debug_mode_fn', __FILE__, 'general_section');
    add_settings_field('quick_chat_message_sound_default_on', __('Incoming message sound notification on by default:','quick-chat'), 'quick_chat_setting_message_sound_default_on_fn', __FILE__, 'general_section');
    add_settings_field('quick_chat_def_name', __('Chat name prefix for guest users:','quick-chat'), 'quick_chat_setting_defname_fn', __FILE__, 'general_section');
    add_settings_field('quick_chat_guest_num_digits', __('Maximum number of digits for random guests chat user name suffix:','quick-chat'), 'quick_chat_setting_guest_num_digits_fn', __FILE__, 'general_section');
    add_settings_field('quick_chat_keep_around_count', __('Keep total number of messages inside every chat room automatically around this value (enter "0" to disable this feature):','quick-chat'), 'quick_chat_setting_keep_around_count_fn', __FILE__, 'general_section');
    add_settings_field('quick_chat_timeout_refresh_users', __('Timeout for refreshing list of online users (seconds):','quick-chat'), 'quick_chat_setting_timeout_refresh_users_fn', __FILE__, 'general_section');
    add_settings_field('quick_chat_timeout_refresh_messages', __('Timeout for refreshing list of messages (seconds):','quick-chat'), 'quick_chat_setting_timeout_refresh_messages_fn', __FILE__, 'general_section');

    add_settings_field('quick_chat_hyperlinks', __('Convert URLs to hyperlinks:','quick-chat'), 'quick_chat_setting_hyperlinks_fn', __FILE__, 'filter_section');
    add_settings_field('quick_chat_replace_inside_bad_words', __('Filter bad words contained inside other words:','quick-chat'), 'quick_chat_setting_replace_inside_bad_words_fn', __FILE__, 'filter_section');
    add_settings_field('quick_chat_disallow_special_usernames', __('Disallow using special characters inside chat user names (including special locale characters):','quick-chat'), 'quick_chat_setting_disallow_special_usernames_fn', __FILE__, 'filter_section');
    add_settings_field('quick_chat_bad_words', __('Bad words list (comma separated):','quick-chat'), 'quick_chat_setting_badwords_fn', __FILE__, 'filter_section');

    add_settings_field('quick_chat_only_logged_in_users', __('Only logged in users can participate in chat:','quick-chat'), 'quick_chat_setting_only_logged_in_users_fn', __FILE__, 'security_section');
    add_settings_field('quick_chat_disallow_logged_in_usernames', __('Protect registered users user names from being used by other users:','quick-chat'), 'quick_chat_setting_disallow_logged_in_usernames_fn', __FILE__, 'security_section');
    add_settings_field('quick_chat_disallow_usernames_list', __('Restricted chat user names list (comma separated):','quick-chat'), 'quick_chat_setting_disallow_usernames_list_fn', __FILE__, 'security_section');
    add_settings_field('quick_chat_ip_blocklist', __('Deny chat access to the following IP addresses (comma separated):','quick-chat'), 'quick_chat_setting_ip_blocklist_fn', __FILE__, 'security_section');

    add_settings_field('quick_chat_hide_widget_if_embedded', __('Hide Quick Chat sidebar widget on pages where same chat room is embedded using shortcode:','quick-chat'), 'quick_chat_setting_hide_widget_if_embedded_fn', __FILE__, 'appearance_section');
    add_settings_field('quick_chat_hide_linkhome', __('Hide "Powered by Quick Chat" link (big thanks for not hiding it):','quick-chat'), 'quick_chat_setting_hide_linkhome_fn', __FILE__, 'appearance_section');
    add_settings_field('quick_chat_manual_gmt_offset', __('Manual timestamp offset when displaying messages (+/- hours):','quick-chat'), 'quick_chat_manual_gmt_offset_fn', __FILE__, 'appearance_section');
    add_settings_field('quick_chat_bing_appid', __('Bing Translator AppID (40 character key to enable translation features, get one for free <a href="http://www.bing.com/developers/appids.aspx" target="_blank">here</a>):','quick-chat'), 'quick_chat_bing_appid_fn', __FILE__, 'appearance_section');
    add_settings_field('quick_chat_adsense_code', __('Advertisement code for your AdSense or other ads placed between chat user name input box and message text input box:','quick-chat'), 'quick_chat_setting_adsense_content_fn', __FILE__, 'appearance_section');

    add_settings_field('quick_chat_paypal', __('Donate using PayPal (sincere thank you for your help):','quick-chat'), 'quick_chat_setting_paypal_fn', __FILE__, 'donate_section');
    add_settings_field('quick_chat_version', __('Quick Chat version:','quick-chat'), 'quick_chat_setting_version_fn', __FILE__, 'donate_section');
    add_settings_field('quick_chat_faq', __('Quick Chat FAQ:','quick-chat'), 'quick_chat_setting_faq_fn', __FILE__, 'donate_section');
    add_settings_field('quick_chat_changelog', __('Quick Chat changelog:','quick-chat'), 'quick_chat_setting_changelog_fn', __FILE__, 'donate_section');
    add_settings_field('quick_chat_support_page', __('Quick Chat support page:','quick-chat'), 'quick_chat_setting_support_page_fn', __FILE__, 'donate_section');
}
add_action('admin_init', 'quick_chat_init_fn' );

function quick_chat_add_page_fn() {
    add_options_page('Quick Chat '.__('options page','quick-chat'), 'Quick Chat ', 'manage_options', __FILE__, 'quick_chat_options_page_fn');
}
add_action('admin_menu', 'quick_chat_add_page_fn');

function quick_chat_section_donate_fn() {
    echo '<p>';
    _e('If you find Quick Chat useful you can donate to help it\'s development. Also you can get help with Quick Chat:','quick-chat');
    echo '</p>';
}

function quick_chat_section_general_fn() {
    echo '<p>';
    _e('Here you can control all general options:','quick-chat');
    echo '</p>';
}

function quick_chat_section_filter_fn() {
    echo '<p>';
    _e('Here you can control Quick Chat message and chat user names filter:','quick-chat');
    echo '</p>';
}

function quick_chat_section_security_fn() {
    echo '<p>';
    _e('In this section you can control security options:','quick-chat');
    echo '</p>';
}

function quick_chat_section_appearance_fn() {
    echo '<p>';
    _e('Here are the Quick Chat appearance options:','quick-chat');
    echo '</p>';
}

function quick_chat_setting_timeout_refresh_users_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_timeout_refresh_users" name="quick_chat_options[timeout_refresh_users]" size="10" type="text" value="'.$quick_chat_options['timeout_refresh_users'].'" />';
}

function quick_chat_setting_timeout_refresh_messages_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_timeout_refresh_messages" name="quick_chat_options[timeout_refresh_messages]" size="10" type="text" value="'.$quick_chat_options['timeout_refresh_messages'].'" />';
}

function quick_chat_setting_faq_fn() {
    global $quick_chat_url;
    echo '<a href="http://wordpress.org/extend/plugins/quick-chat/faq/" target="_blank">'.__('FAQ','quick-chat').'</a>';
}

function quick_chat_setting_version_fn() {
    global $quick_chat_url;
    echo quick_chat_get_version();
}

function quick_chat_setting_changelog_fn() {
    global $quick_chat_url;
    echo '<a href="http://wordpress.org/extend/plugins/quick-chat/changelog/" target="_blank">'.__('Changelog','quick-chat').'</a>';
}

function quick_chat_setting_support_page_fn() {
    global $quick_chat_url;
    echo '<a href="http://www.techytalk.info/quick-chat/" target="_blank">'.__('Quick Chat at TechyTalk.info','quick-chat').'</a>';
}

function quick_chat_setting_paypal_fn() {
    global $quick_chat_url;
    echo '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CZQW2VZNHMGGN" target="_blank"><img src="'.$quick_chat_url.'img/paypal.gif" /></a>';
}

function quick_chat_setting_defname_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_def_name" name="quick_chat_options[default_name]" size="10" type="text" value="'.__($quick_chat_options['default_name'],'quick-chat').'" />';
}

function quick_chat_setting_keep_around_count_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_keep_around_count" name="quick_chat_options[keep_around_count]" size="10" type="text" value="'.$quick_chat_options['keep_around_count'].'" />';
}

function quick_chat_setting_guest_num_digits_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_guest_num_digits" name="quick_chat_options[guest_num_digits]" size="10" type="text" value="'.$quick_chat_options['guest_num_digits'].'" />';
}

function quick_chat_setting_badwords_fn() {
    global $quick_chat_options;
    echo '<textarea id="quick_chat_bad_words" name="quick_chat_options[badwords_list]" rows="5" cols="50" type="textarea">'.$quick_chat_options['badwords_list'].'</textarea>';
}

function quick_chat_setting_disallow_special_usernames_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_disallow_special_usernames" name="quick_chat_options[disallow_special_usernames]" type="checkbox" value="1" ';
    if(isset($quick_chat_options['disallow_special_usernames'])) echo 'checked="checked"';
    echo '/>';
}

function quick_chat_setting_replace_inside_bad_words_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_replace_inside_bad_words" name="quick_chat_options[replace_inside_bad_words]" type="checkbox" value="1" ';
    if(isset($quick_chat_options['replace_inside_bad_words'])) echo 'checked="checked"';
    echo '/>';
}

function quick_chat_setting_hyperlinks_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_hyperlinks" name="quick_chat_options[hyperlinks]" type="checkbox" value="1" ';
    if(isset($quick_chat_options['hyperlinks'])) echo 'checked="checked"';
    echo '/>';
}

function quick_chat_setting_hide_widget_if_embedded_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_hide_widget_if_embedded" name="quick_chat_options[hide_widget_if_embedded]" type="checkbox" value="1" ';
    if(isset($quick_chat_options['hide_widget_if_embedded'])) echo 'checked="checked"';
    echo '/>';
}

function quick_chat_setting_hide_linkhome_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_hide_linkhome" name="quick_chat_options[hide_linkhome]" type="checkbox" value="1" ';
    if(isset($quick_chat_options['hide_linkhome'])) echo 'checked="checked"';
    echo '/>';
}

function quick_chat_setting_debug_mode_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_debug_mode" name="quick_chat_options[debug_mode]" type="checkbox" value="1" ';
    if(isset($quick_chat_options['debug_mode'])) echo 'checked="checked"';
    echo '/>';
}

function quick_chat_setting_only_logged_in_users_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_only_logged_in_users" name="quick_chat_options[only_logged_in_users]" type="checkbox" value="1" ';
    if(isset($quick_chat_options['only_logged_in_users'])) echo 'checked="checked"';
    echo '/>';
}

function quick_chat_setting_message_sound_default_on_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_message_sound_default_on" name="quick_chat_options[message_sound_default_on]" type="checkbox" value"1" ';
    if(isset($quick_chat_options['message_sound_default_on'])) echo 'checked="checked"';
    echo '/>';
}

function quick_chat_setting_disallow_logged_in_usernames_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_disallow_logged_in_usernames" name="quick_chat_options[disallow_logged_in_usernames]" type="checkbox" value"1" ';
    if(isset($quick_chat_options['disallow_logged_in_usernames'])) echo 'checked="checked"';
    echo '/>';
}

function quick_chat_setting_disallow_usernames_list_fn() {
    global $quick_chat_options;
    echo '<textarea id="quick_chat_disallow_usernames_list" name="quick_chat_options[disallow_usernames_list]" rows="5" cols="50" type="textarea">'.$quick_chat_options['disallow_usernames_list'].'</textarea>';
}

function quick_chat_setting_ip_blocklist_fn() {
    global $quick_chat_options;
    echo '<textarea id="quick_chat_ip_blocklist" name="quick_chat_options[ip_blocklist]" rows="5" cols="50" type="textarea">'.$quick_chat_options['ip_blocklist'].'</textarea>';
}

function quick_chat_setting_adsense_content_fn(){
    global $quick_chat_options;
    echo '<textarea id="quick_chat_adsense_content" name="quick_chat_options[adsense_content]" rows="5" cols="50" type="textarea">'.$quick_chat_options['adsense_content'].'</textarea>';
}

function quick_chat_bing_appid_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_bing_appid" name="quick_chat_options[bing_appid]" size="40" type="text" value="'.((isset($quick_chat_options['bing_appid'])) ? $quick_chat_options['bing_appid']:'').'" />';
}

//
function quick_chat_manual_gmt_offset_fn() {
    global $quick_chat_options;
    echo '<input id="quick_chat_manual_gmt_offset" name="quick_chat_options[manual_gmt_offset]" size="10" type="text" value="'.$quick_chat_options['manual_gmt_offset'].'" />';
}

function quick_chat_options_page_fn(){
?>
    <div class="wrap">
        <div class="icon32" id="icon-options-general"><br></div>
        <h2>Quick Chat</h2>
        <form action="options.php" method="post">
        <?php settings_fields('quick_chat_options'); ?>
        <?php do_settings_sections(__FILE__); ?>
        <p class="submit">
                <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
        </p>
        </form>
    </div>
<?php
}

function quick_chat_options_validate($input) {
    global $default_name;
    global $default_keep_around_count;
    global $default_guest_num_digits;
    global $default_timeout_refresh_users;
    global $default_timeout_refresh_messages;
    global $default_manual_gmt_offset;

    if(!is_numeric($input['keep_around_count']) || $input['keep_around_count'] < 0){
        $input['keep_around_count'] =  $default_keep_around_count;
    }

    if(!is_numeric($input['timeout_refresh_users']) || ($input['timeout_refresh_users'] < 1)){
        $input['timeout_refresh_users'] =  $default_timeout_refresh_users;
    } else{
        $input['timeout_refresh_users'] = floor($input['timeout_refresh_users']);
    }

    if(!is_numeric($input['timeout_refresh_messages']) || ($input['timeout_refresh_messages'] < 1)){
        $input['timeout_refresh_messages'] =  $default_timeout_refresh_messages;
    } else{
        $input['timeout_refresh_messages'] = floor($input['timeout_refresh_messages']);
    }

    $input['badwords_list'] =  wp_filter_nohtml_kses(trim($input['badwords_list']));

    $input['ip_blocklist'] =  wp_filter_nohtml_kses(trim($input['ip_blocklist']));

    $input['disallow_usernames_list'] =  wp_filter_nohtml_kses(trim($input['disallow_usernames_list']));

    if(!is_numeric($input['guest_num_digits'])){
        $input['guest_num_digits'] =  $default_guest_num_digits;
    } else if($input['guest_num_digits'] < 1){
        $input['guest_num_digits'] =  '1';
    } elseif($input['guest_num_digits'] > 10){
        $input['guest_num_digits'] =  '10';
    }

    if(strlen($input['bing_appid']) != 40){
        unset($input['bing_appid']);
    }


    if(!is_numeric($input['manual_gmt_offset']) || $input['manual_gmt_offset'] < -12 || $input['manual_gmt_offset'] >12){
        $input['manual_gmt_offset'] =  $default_manual_gmt_offset;
    } else{
        $input['manual_gmt_offset'] = floor($input['manual_gmt_offset']);
    }

    return $input;
}

function quick_chat_update_users($room, $quick_chat_user_name) {
    global $wpdb;
    global $quick_chat_user_status;
    global $quick_chat_user_ip;
    $quick_chat_users_table_name = $wpdb->prefix . 'quick_chat_users';

    $rows_affected = $wpdb->query(' INSERT INTO '.$quick_chat_users_table_name.' SET status = '.$quick_chat_user_status.', room = "'.$room.'", timestamp_polled = NOW(), timestamp_joined = NOW(), alias = "'.$wpdb->escape($quick_chat_user_name).'", ip = "'.$quick_chat_user_ip.'" ON DUPLICATE KEY UPDATE timestamp_polled = NOW();');
}

function quick_chat_cleanup_users() {
    global $wpdb;
    global $quick_chat_options;
    $quick_chat_users_table_name = $wpdb->prefix . 'quick_chat_users';

    $wpdb->get_results('DELETE FROM '.$quick_chat_users_table_name.' WHERE timestamp_polled < TIMESTAMPADD(SECOND,-'.($quick_chat_options['timeout_refresh_users']*2).',NOW());');
}

function quick_chat_fetch_users($room) {
    global $wpdb;
    global $quick_chat_user_status;
    $quick_chat_users_table_name = $wpdb->prefix . 'quick_chat_users';

    $sql = 'SELECT status, alias';
    if($quick_chat_user_status == 0){
        $sql .= ', id, ip';
    }
    $sql .= ' FROM '.$quick_chat_users_table_name.' WHERE room = "'.$room.'" ORDER BY timestamp_joined ASC';

    $users = $wpdb->get_results($sql);

    return $users;
}

function quick_chat_fetch_messages($room){
    global $wpdb;
    global $quick_chat_date_format;
    global $quick_chat_time_format;
    global $quick_chat_gmt_offset;
    $quick_chat_messages_table_name = $wpdb->prefix . 'quick_chat_messages';

    $messages = $wpdb->get_results($sql = 'SELECT id, room, timestamp, UNIX_TIMESTAMP(timestamp) as unix_timestamp, alias, md5email, status, ip, message FROM '.$quick_chat_messages_table_name. ' WHERE room = "'.$room.'" ORDER BY unix_timestamp ASC');

    foreach($messages as $v){
        $v->timestring = date_i18n($quick_chat_date_format.' - '.$quick_chat_time_format, $v->unix_timestamp+($quick_chat_gmt_offset* 3600));
    }
    return $messages;
}

function quick_chat_build_users_html($room, $height, $userlist_position) {
    ob_start();
    global $wpdb;
    global $quick_chat_user_status;
    global $quick_chat_user_name;
    global $quick_chat_no_participation;


    $users = quick_chat_fetch_users($room);

    if($userlist_position == 'right')
        echo '<div class="quick-chat-users-container quick-chat-users-container-right" style="height: '.$height.'px;">';
    else if ($userlist_position == 'top')
        echo '<div class="quick-chat-users-container quick-chat-users-container-top">';
    else if ($userlist_position == 'left')
        echo '<div class="quick-chat-users-container quick-chat-users-container-left" style="height: '.$height.'px;">';

    $string_all = '';

    if($users){
        foreach($users as $u){
            $user_status_class = '';
            if($u->status == 0){
                $user_status_class = 'quick-chat-admin';
            } else if($u->status == 1){
                $user_status_class = 'quick-chat-loggedin';
            } else if($u->status == 2){
                $user_status_class = 'quick-chat-guest';
            }
            $string_all .= '<div class="quick-chat-single-user '.$user_status_class.'">';

            if($u->alias == $quick_chat_user_name || $quick_chat_no_participation == 1)
                    $string_all .= $u->alias;
            else{
                if($quick_chat_user_status == 0){
                    $string_all .= '<input class="quick-chat-to-ban-boxes" type="checkbox" name="quick-chat-to-ban[]" value="'.$u->ip.'" data-user-id="'.$u->id.'"/>';
                }
                $string_all .= '<a href="" title="'.__('Reply to','quick-chat').' '.$u->alias.'">'.$u->alias.'</a>';
            }
            if ($userlist_position == 'top' && $u != end($users)){
                $string_all .= ',';
            }
            $string_all .= '</div>';
        }
        echo $string_all;
    }
    echo '</div>';
    $content =  ob_get_contents();
    ob_end_clean();
    return $content;
}

function quick_chat_build_history_html($room, $gravatars, $gravatars_size) {
    ob_start();
    global $wpdb;
    global $quick_chat_smile_array;
    global $quick_chat_options;
    global $quick_chat_url;
    global $quick_chat_last_timestamp;
    global $quick_chat_user_status;
    global $quick_chat_user_name;
    global $quick_chat_no_participation;

    $quick_chat_messages_table_name = $wpdb->prefix . 'quick_chat_messages';

    $string = '';

    if($quick_chat_last_timestamp == NULL) $quick_chat_last_timestamp = time();

    $messages = quick_chat_fetch_messages($room);

    if($messages){
        if($quick_chat_options['keep_around_count'] != 0 && (count($messages) > (intval($quick_chat_options['keep_around_count'] * 1.2)))){
            $wpdb->query( 'DELETE FROM '.$quick_chat_messages_table_name.' WHERE id < ( '.$wpdb->get_var('SELECT max(id) FROM '.$quick_chat_messages_table_name).' - '.intval($quick_chat_options['keep_around_count'] * 0.8).' )');
            $messages = quick_chat_fetch_messages($room);
        }

        foreach($messages as $v){
            foreach($quick_chat_smile_array as $smile_sign => $smile_img) $v->message = str_replace($smile_sign, '<div class="quick-chat-smile-in-message quick-chat-smile quick-chat-smile-'.$smile_img.'" title="'.$smile_sign.'"></div>', $v->message);

            $user_status_class = '';
            if($v->status == 0){
                $user_status_class = 'quick-chat-admin';
            } else if($v->status == 1){
                $user_status_class = 'quick-chat-loggedin';
            } else if($v->status == 2){
                $user_status_class = 'quick-chat-guest';
            }

            $string .= '<div class="quick-chat-history-message-alias-container '.$user_status_class.'"><div class="quick-chat-history-header">';

            if($gravatars == 1){
                $string .= '<img class="quick-chat-history-gravatar" style="width:'.$gravatars_size.'px; height:'.$gravatars_size.'px;" src="http://0.gravatar.com/avatar/'.$v->md5email.'?s='.$gravatars_size.'&d=http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s='.$gravatars_size.'&r=G"/>';
            }
            $string .= '<div class="quick-chat-history-alias">';

            if($v->alias == $quick_chat_user_name || $quick_chat_no_participation == 1)
                $string .= $v->alias;
            else
                $string .= '<a style="text-decoration: none;" href="" title="'.__('Reply to','quick-chat').' '.$v->alias.'">'.$v->alias.'</a>';

            $string .= '</div>';

            $string .= '<div class="quick-chat-history-timestring">'.$v->timestring.'</div>';

            $string .= '</div><div class="quick-chat-history-message">'.$v->message.'</div>';

            $string .= '<div class="quick-chat-history-links">';

            if(isset($quick_chat_options['bing_appid'])){
                $string .= '<div class="quick-chat-translate-link">';
                    $string .= ' <a style="text-decoration: none;" href="">'.__('Translate','quick-chat').'</a> ';
                $string .= '</div>';
            }

            if($quick_chat_user_status == 0){
                $string .= '<input class="quick-chat-to-delete-boxes" type="checkbox" name="quick-chat-to-delete[]" value="'.$v->id.'" />';
            }

            $string .= '</div>';

            $string .= '</div>';
        }
        echo $string;
    }

    $content =  ob_get_contents();
    ob_end_clean();
    return $content;
}

// quick_chat_display_chat() renamed to quick_chat()
function quick_chat_display_chat($height, $room, $userlist, $userlist_position, $gravatars, $gravatars_size, $send_button, $loggedin_visible, $guests_visible) {
    return quick_chat($height, $room, $userlist, $userlist_position, $gravatars, $gravatars_size, $send_button, $loggedin_visible, $guests_visible);
}

function quick_chat($height = 300, $room = 'default', $userlist = 1, $userlist_position = 'left', $gravatars = 1, $gravatars_size = 32, $send_button = 0, $loggedin_visible = 1, $guests_visible = 1) {
    $content = '';
    ob_start();
    global $quick_chat_smile_array;
    global $quick_chat_options;
    global $quick_chat_url;
    global $wpdb;
    global $current_user;
    global $quick_chat_audio_enable;
    global $quick_chat_data_array;
    global $quick_chat_user_status;
    global $quick_chat_ip_blocked;
    global $quick_chat_no_participation;
    global $quick_chat_user_name;
    global $quick_chat_is_bot;
    global $quick_chat_must_login;

    quick_chat_cleanup_users();

    if($quick_chat_no_participation == 0){
        $user_name = htmlspecialchars($quick_chat_user_name, ENT_QUOTES);
        quick_chat_update_users($room, $quick_chat_user_name);
    }

    $chat_id = wp_generate_password(12,false,false);
    $quick_chat_data_array[$chat_id] = array(   'quick_chat_room_name' => $room,
                                                'quick_chat_username' => $quick_chat_user_name,
                                                'quick_chat_userlist_position' => $userlist_position,
                                                'quick_chat_gravatars_size'=> $gravatars_size,
                                                'quick_chat_gravatars'=> $gravatars,
                                                'quick_chat_scroll_enable'=> 1);

    echo '<div class="quick-chat-container" data-chat-id="'.$chat_id.'">';
    if(isset($quick_chat_options['bing_appid'])) echo '<div class="quick-chat-language-container"></div>';

    if($userlist == 1){
        echo quick_chat_build_users_html($room, $height, $userlist_position);
    }

    echo '<div class="quick-chat-history-container" style="height: '.$height.'px;">';
        echo quick_chat_build_history_html($room, $gravatars, $gravatars_size);
    echo '</div>';

    echo '  <div class="quick-chat-links">';
        if ($quick_chat_user_status == 0){
            echo '<div class="quick-chat-left-link quick-chat-ban-link">
                <a title="'.__('Add this user\'s IP address to your IP block list','quick-chat').'" href="">'.__('Ban','quick-chat').'</a>
            </div>';

        }

        if ($quick_chat_user_status == 0){
            echo '  <div class="quick-chat-right-link quick-chat-select-all-link">
                        <a title="'.__('Select/deselect all messages toggle','quick-chat').'" href="">'.__('Toggle','quick-chat').'</a>
                    </div>
                    <div class="quick-chat-right-link quick-chat-delete-link">
                        <a title="'.__('Delete selected messages','quick-chat').'" href="">'.__('Delete','quick-chat').'</a>
                    </div>';
        }
        echo '<div class="quick-chat-right-link quick-chat-scroll-link">
            <a style="text-decoration: none;"';
            echo ' title="'.__('Enable/disable auto scroll when new message arrives','quick-chat').'" href="">'.__('Scroll','quick-chat').'
            </a>
        </div>';
        echo '<div style="display: none;" class="quick-chat-right-link quick-chat-sound-link">
            <a title="'.__('Enable/disable sound notification when new message arrives','quick-chat').'" href="">'.__('Sound','quick-chat').'
            </a>
        </div>';
    echo '</div>';

    if($quick_chat_no_participation == 1){
        if($quick_chat_is_bot == 1){
            echo '<div class="quick-chat-bootom-notice"></div>';
        }else if($quick_chat_ip_blocked == 1){
            echo '<div class="quick-chat-bootom-notice">'.__('Your IP address is banned from chat.','quick-chat').'</div>';
        } else if($quick_chat_must_login == 1){
            echo '<div class="quick-chat-bootom-notice">'.__('You must login if you want to participate in chat.','quick-chat').'</div>';
        }
    }else {
        echo '<div class="quick-chat-alias-container">';
            echo '<input class="quick-chat-alias" type="text" autocomplete="off" maxlength="30" value="'.$user_name.'" />';
            echo '<span class="quick-chat-username-status"></span>';
        echo '</div>';

        if($quick_chat_options['adsense_content'] != ''){
            echo '<div class="quick-chat-adsense">'.$quick_chat_options['adsense_content'].'</div>';
        }

        echo '<textarea class="quick-chat-message"></textarea>';
        if($send_button == 1){
            echo '<input class="quick-chat-send-button" type="button" value="'.__('Send','quick-chat').'">';
        }

        echo '<div class="quick-chat-smilies-container">';
        foreach($quick_chat_smile_array as $smile_sign => $smile_img) echo '<div class="quick-chat-smile-container quick-chat-smile quick-chat-smile-'.$smile_img.'" title="'.$smile_sign.'"></div>';
        echo '</div>';
    }

    if(!isset($quick_chat_options['hide_linkhome'])){
        echo '<a class="quick-chat-linkhome" href="http://www.techytalk.info/quick-chat" target="_blank">'.__('Powered by Quick Chat','quick-chat').'</a>';
    }
    echo '</div>';

    $content =  ob_get_contents();
    ob_end_clean();
    return $content;
}

class Quick_Chat extends WP_Widget {
    public $name = 'Quick Chat';
    /* Widget control settings. */
    public $control_options = array(
       'width' => 250,
       'height' => 300,
       'id_base' => 'quick-chat-widget');

    public function __construct() {
        $widget_options = array(
          'classname' => __CLASS__,
          'description' => __('Quick Chat is quick and elegant WordPress chat plugin that does not waste your bandwidth.','quick-chat'));

        parent::__construct($this->control_options['id_base'], $this->name, $widget_options);
    }

    function form ($instance) {
        $defaults = array('title'=>'Quick Chat','widgetheight' => 400, 'gravatars' => 1, 'gravatars_size' => 32,'room' => 'default','userlist' => 1, 'userlist_position' => 'Top', 'loggedin_visible' => 1, 'guests_visible' => 1);
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title') ?>:</label>
        <input type="text" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title') ?> " value="<?php echo $instance['title'] ?>" size="10">
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('room'); ?>"><?php _e('Chat room name:') ?></label>
        <input type="text" name="<?php echo $this->get_field_name('room') ?>" id="<?php echo $this->get_field_id('room') ?> " value="<?php echo $instance['room'] ?>" size="10">
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('widgetheight'); ?>"><?php _e('Message container height:','quick-chat') ?></label>
        <input type="text" name="<?php echo $this->get_field_name('widgetheight') ?>" id="<?php echo $this->get_field_id('widgetheight') ?> " value="<?php echo $instance['widgetheight'] ?>" size="2">
        px
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('gravatars'); ?>"><?php _e('Include gravatars:','quick-chat') ?></label>
        <input id="<?php echo $this->get_field_id('gravatars') ?>" name="<?php echo $this->get_field_name('gravatars') ?>" type="checkbox" value="1"
        <?php if(isset($instance['gravatars'])) echo 'checked="checked"' ?> />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('gravatars_size'); ?>"><?php _e('Gravatars size:','quick-chat') ?></label>
        <input type="text" name="<?php echo $this->get_field_name('gravatars_size') ?>" id="<?php echo $this->get_field_id('gravatars_size') ?> " value="<?php echo $instance['gravatars_size'] ?>" size="2">
        px
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('userlist'); ?>"><?php _e('Include user list:','quick-chat') ?></label>
        <input id="<?php echo $this->get_field_id('userlist') ?>" name="<?php echo $this->get_field_name('userlist') ?>" type="checkbox" value="1"
        <?php if(isset($instance['userlist'])) echo 'checked="checked"' ?> />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('userlist_position'); ?>"><?php _e('User list position:','quick-chat') ?></label>
        <select id="<?php echo $this->get_field_id('userlist_position') ?>" name="<?php echo $this->get_field_name('userlist_position') ?>">
            <option <?php if(isset($instance['userlist_position']) && $instance['userlist_position'] == 'Right') echo 'selected="selected"' ?> >Right</option>
            <option <?php if(isset($instance['userlist_position']) && $instance['userlist_position'] == 'Left') echo 'selected="selected"' ?> >Left</option>
            <option <?php if(isset($instance['userlist_position']) && $instance['userlist_position'] == 'Top') echo 'selected="selected"' ?> >Top</option>
        </select>
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('send_button'); ?>"><?php _e('Include send button:','quick-chat') ?></label>
        <input id="<?php echo $this->get_field_id('send_button') ?>" name="<?php echo $this->get_field_name('send_button') ?>" type="checkbox" value="1"
        <?php if(isset($instance['send_button'])) echo 'checked="checked"' ?> />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('loggedin_visible'); ?>"><?php _e('Visible to logged in users:','quick-chat') ?></label>
        <input id="<?php echo $this->get_field_id('loggedin_visible') ?>" name="<?php echo $this->get_field_name('loggedin_visible') ?>" type="checkbox" value="1"
        <?php if(isset($instance['loggedin_visible'])) echo 'checked="checked"' ?> />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('guests_visible'); ?>"><?php _e('Visible to guest users:','quick-chat') ?></label>
        <input id="<?php echo $this->get_field_id('guests_visible') ?>" name="<?php echo $this->get_field_name('guests_visible') ?>" type="checkbox" value="1"
        <?php if(isset($instance['guests_visible'])) echo 'checked="checked"' ?> />
        </p>
        <?php
    }

    function update ($new_instance, $old_instance) {
        $instance = $old_instance;

        if(is_numeric($new_instance['widgetheight']) && $new_instance['widgetheight'] != 0){
            $instance['widgetheight'] = $new_instance['widgetheight'];
        }
        $instance['title'] = $new_instance['title'];

        $instance['gravatars'] = $new_instance['gravatars'];

        if(is_numeric($new_instance['gravatars_size']) && $new_instance['gravatars_size'] != 0){
            $instance['gravatars_size'] = $new_instance['gravatars_size'];
        }

        $instance['userlist'] = $new_instance['userlist'];

        $instance['send_button'] = $new_instance['send_button'];

        $instance['loggedin_visible'] = $new_instance['loggedin_visible'];

        $instance['guests_visible'] = $new_instance['guests_visible'];

        $instance['userlist_position'] = $new_instance['userlist_position'];

        if($new_instance['room'] != ''){
            $instance['room'] = $new_instance['room'];
        }
        return $instance;
    }

    function widget ($args,$instance) {
        global $quick_chat_user_status;
        global $quick_chat_options;
        global $quick_chat_is_embedded_array;
        extract($args);
        $title = $instance['title'];
        $widgetheight = $instance['widgetheight'];
        $userlist = (isset($instance['userlist']))? 1: 0;
        $userlist_position = strtolower($instance['userlist_position']);
        $room = $instance['room'];
        $gravatars = (isset($instance['gravatars']))? 1: 0;
        $send_button = (isset($instance['send_button']))? 1: 0;
        $loggedin_visible = (isset($instance['loggedin_visible']))? 1: 0;
        $guests_visible = (isset($instance['guests_visible']))? 1: 0;
        $gravatars_size = (isset($instance['gravatars_size']))? $instance['gravatars_size']: 32;

        if( (
            $quick_chat_user_status == 0
            ||
            ($quick_chat_user_status < 2 && $loggedin_visible == 1)
            ||
            ($quick_chat_user_status == 2 && $guests_visible == 1)
            )
            &&
            (
                !isset($quick_chat_options['hide_widget_if_embedded'])
                ||
                !isset($quick_chat_is_embedded_array[$room])
            )
            ){
            echo $before_widget;
            echo $before_title.$title.$after_title;

            echo quick_chat($widgetheight, $room, $userlist, $userlist_position, $gravatars, $gravatars_size, $send_button);

            echo $after_widget;
        }
    }
}

function quick_chat_load_widgets() {
  register_widget('Quick_Chat');
}
add_action('widgets_init', 'quick_chat_load_widgets');

function quick_chat_shortcode_handler( $atts, $content=null, $code="" ) {
    global $quick_chat_user_status;
    global $quick_chat_is_embedded_array;

    extract(shortcode_atts( array(	'height' => 400,
                                        'room' => 'default',
                                        'userlist' => 1,
                                        'userlist_position' => 'left',
                                        'gravatars' => 1,
                                        'gravatars_size' => 32,
                                        'send_button' => 0,
                                        'loggedin_visible' => 1,
                                        'guests_visible' => 1),
                                        $atts ));

    $quick_chat_is_embedded_array[$room] = 1;

    $content = '';
        if(
        $quick_chat_user_status == 0
        ||
        ($quick_chat_user_status < 2 && $loggedin_visible == 1)
        ||
        ($quick_chat_user_status == 2 && $guests_visible == 1)
        ){
            $content = quick_chat($height, $room, $userlist, $userlist_position, $gravatars, $gravatars_size, $send_button, $loggedin_visible, $guests_visible);
        }
    return $content;
}
add_shortcode( 'quick-chat', 'quick_chat_shortcode_handler' );

function quick_chat_uninstall() {
    global $wpdb;
    $quick_chat_messages_table_name = $wpdb->prefix . 'quick_chat_messages';
    $quick_chat_users_table_name = $wpdb->prefix . 'quick_chat_users';

    if(get_option('quick_chat_options')) delete_option('quick_chat_options');
    if(get_option('quick_chat_db_version')) delete_option('quick_chat_db_version');
    if(get_option('widget_quick-chat-widget')) delete_option('widget_quick-chat-widget');
    $query = $wpdb->query('DROP TABLE IF EXISTS '.$quick_chat_messages_table_name.';');
    $query = $wpdb->query('DROP TABLE IF EXISTS '.$quick_chat_users_table_name.';');
}
register_uninstall_hook(__FILE__, 'quick_chat_uninstall');
?>
