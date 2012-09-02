<?php
/*
Copyright 2010 Sergey Arsenichev  (email: s.arsenichev@protechs.ru)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*
Plugin Name: loginza
Plugin URI: http://loginza.ru/wp-plugin
Description: Плагин позволяет использовать аккаунты популярных web сайтов (Вконтакте, Yandex, Google и тп. и OpenID) для авторизации в блоге. Разработан на основе сервиса Loginza.
Version: 1.2.0
Author: Sergey Arsenichev
Author URI: http://loginza.ru
*/
include_once( dirname( __FILE__ ) . '/loginza_config.php' );
include_once( dirname( __FILE__ ) . '/loginza_functions.php');

// рабочие классы
require_once LOGINZA_PLUGIN_DIR.'LoginzaWpUser.class.php';

// WP инклуды
if (file_exists(LOGINZA_HOME_DIR.'wp-load.php')) {
  // WP 2.6
  require_once(LOGINZA_HOME_DIR.'wp-load.php');
} else {
  // Before 2.6
  require_once(LOGINZA_HOME_DIR.'wp-config.php');
}
require_once(LOGINZA_HOME_DIR . 'wp-includes/registration.php');
require_once(LOGINZA_HOME_DIR . 'wp-includes/pluggable.php');

// инициализация плагина
add_action('wp_footer', 'loginza_ui_comment_form');
add_action('login_head', 'loginza_ui_login_form');
add_action('loginza_ui_login_form', 'loginza_ui_login_form');
add_action('show_user_profile', 'loginza_ui_user_profile');
add_action('parse_request', 'loginza_token_request'); 
add_filter('get_comment_author_link', 'loginza_comment_author_icon');
add_filter('get_avatar', 'loginza_comment_author_avatar');
add_filter('the_content', 'loginza_form_tag');
// admin
if (is_admin()) {
	add_action('admin_menu', 'loginza_admin_options');
}
/**
 * Модификация интерфейса WP
 * Заменяет стандартный интерфейс авторизации в комментариях, на интерфейс Loginza
 * 
 */
function loginza_ui_comment_form () {
	$WpUser = wp_get_current_user();
	// если пользователь авторизирован, то форму не показываем
  	if($WpUser->ID) return;
  	
  	$api_id = get_option(LOGINZA_OPTIONS_API_ID);
  	$api_key = get_option(LOGINZA_OPTIONS_API_KEY);

  	if (empty($api_id) || empty($api_key)) return;

  	// данные для шаблона
  	$tpl_data = array(
  		'returnto_url' => urlencode( loginza_get_current_url() ),
  		'api_id' => $api_id,
  		'providers_set' => get_option(LOGINZA_OPTIONS_PROVIDERS_SET),
  		'lang' => get_option(LOGINZA_OPTIONS_LANG),
  		'theme' => get_option(LOGINZA_OPTIONS_THEME),
  		'loginza_host' => LOGINZA_SERVER_HOST,
  		'plugin_dir' => get_option('siteurl').'/wp-content/plugins/loginza/'
  	);
  	// модификация текущей формы авторизации
  	echo loginza_fetch_template('html_comment_login_form.tpl', $tpl_data);
}
/**
 * Модификация интерфейса логин формы WP
 * Подставляет в главное окно авторизации (wp-login.php) виджет Loginza
 *
 */
function loginza_ui_login_form () {
	$api_id = get_option(LOGINZA_OPTIONS_API_ID);
  	$api_key = get_option(LOGINZA_OPTIONS_API_KEY);

  	if (empty($api_id) || empty($api_key)) return;

	$WpUser = wp_get_current_user();
	
	$return_to = get_option('siteurl');
	if($WpUser->ID) {
		$return_to .= '/?loginza_mapping='.$WpUser->ID;
	}
	
	// если есть ошибки
	$loginza_error = '';
	if (@$_GET['loginza_error'] == 'email'){
	    $loginza_error = 'Аккаунт с данным email уже зарегистрирован. <br/>Войдите используя логин и пароль от этого аккаунта и Вы сможете прикрепить дополнительный аккаунт стороннего провайдера на странице профиля.<br/><br/>';
	}
	
	// данные для шаблона
  	$tpl_data = array(
  		'returnto_url' => urlencode($return_to),
  		'api_id' => $api_id,
  		'providers_set' => get_option(LOGINZA_OPTIONS_PROVIDERS_SET),
  		'lang' => get_option(LOGINZA_OPTIONS_LANG),
  		'theme' => get_option(LOGINZA_OPTIONS_THEME),
  		'loginza_host' => LOGINZA_SERVER_HOST,
  		//'img_dir' => get_option('siteurl').'/wp-content/plugins/loginza/img/',
  		'loginza_error' => $loginza_error,
  		'plugin_dir' => get_option('siteurl').'/wp-content/plugins/loginza/'
  	);
	echo loginza_fetch_template('html_main_login_form.tpl', $tpl_data);
}
/**
 * Модификация страницы профиля пользователя
 * Добавляет "Прикрепленный аккаунт" и ссылку "изменить"
 *
 * @return unknown
 */
function loginza_ui_user_profile () {
	$api_id = get_option(LOGINZA_OPTIONS_API_ID);
  	$api_key = get_option(LOGINZA_OPTIONS_API_KEY);

  	if (empty($api_id) || empty($api_key)) return;

	$user = wp_get_current_user();
	if(!$user->ID) {
		return false;
	}
	$tpl_data = array();
	if ($user->{LOGINZA_WP_USER_META_IDENTITY}) {
		$tpl_data = array(
			'identity' => $user->{LOGINZA_WP_USER_META_IDENTITY},
			'provider' => $user->{LOGINZA_WP_USER_META_PROVIDER},
			'provider_ico' => loginza_get_provider_ico ($user->{LOGINZA_WP_USER_META_IDENTITY}),
		);
	} else {
		$tpl_data = array(
			'identity' => '<i>(пусто)</i>',
			'provider' => '',
			'provider_ico' => '',
		);
	}
	
	if (@$_GET['loginza_message'] == 'email') {
		$tpl_data['loginza_field'] = 'email';
		$tpl_data['loginza_message'] = '<i style="color:red;">Ваш провайдер авторизации не передал Ваш email адрес. Пожалуйста заполните поле email, так как оно может понадобится для восстановления пароля.</i>';
	}

	$tpl_data['providers_set'] = get_option(LOGINZA_OPTIONS_PROVIDERS_SET);
	$tpl_data['api_id'] = $api_id;
  	$tpl_data['lang'] = get_option(LOGINZA_OPTIONS_LANG);
  	$tpl_data['theme'] = get_option(LOGINZA_OPTIONS_THEME);
	$tpl_data['returnto_url'] = urlencode( get_option('siteurl').'/?loginza_mapping='.$user->ID.'&loginza_return='.urlencode( loginza_get_current_url() ) );
	$tpl_data['loginza_host'] = LOGINZA_SERVER_HOST;
	echo loginza_fetch_template('html_edit_profile.tpl', $tpl_data);
}
/**
 * Фильтр вывода автора комментария
 * Выводит иконку провайдера (ВКонтакте, Яндекс и тп.), через которого был авторизирован пользователь.
 *
 * @param unknown_type $author
 * @return unknown
 */
function loginza_comment_author_icon ($author) {
	global $comment;
	
	// получаем идентификатор Loginza пользователя
	$identity = LoginzaWpUser::getIdentityByUser($comment->user_id);
	
	// ищем имя хоста
	if ($identity) {
		return loginza_get_provider_ico ($identity).'&nbsp;'.$author;
	}
	
	return $author;
}
/**
 * Добавление аватарки в комментарий
 * Если у пользователя есть аватарка, то выводит ее в комментарии
 *
 * @param string $avatar
 * @return string
 */
function loginza_comment_author_avatar ($avatar) {
	//global $comment;
	
	if (in_the_loop() != false){
		$zero = 0;
		$comment = get_comment($zero);
		if (!is_wp_error($comment->user_id)){
		  $user = get_userdata($comment->user_id);
		  if (!is_wp_error($user)){
		    // получаем аватар Loginza пользователя
			$loginza_avatar = LoginzaWpUser::getAvatarByUser($comment->user_id);
		  }
		}
	} else {
//		$user = wp_get_current_user();
//		if (!is_wp_error($user)){
//			if($user->ID) {
//				$loginza_avatar = LoginzaWpUser::getAvatarByUser($user->ID);
//			}
//		}
	}
	
	if (!empty($loginza_avatar)) {
		return preg_replace('/src=([^\s]+)/i', 'src="'.$loginza_avatar.'"', $avatar);
	}
	return $avatar;
}
/**
 * Получает иконку провайдера
 * Возвращает html код иконки провайдера по идентификатору учетной записи. 
 * По умолчанию, если хост не определен, возвращает OpenID иконку.
 *
 * @param string $identity
 * @return string
 */
function loginza_get_provider_ico ($identity) {
	// соответствие хоста провайдера к имени иконки
	$providers = array(
	'yandex.ru' => 'yandex.png',
	'ya.ru' => 'yandex.png',
	'vkontakte.ru' => 'vkontakte.png',
	'vk.com' => 'vkontakte.png',
	'loginza.ru' => 'loginza.png',
	'myopenid.com' => 'myopenid.png',
	'livejournal.com' => 'livejournal.png',
	'google.ru' => 'google.png',
	'google.com' => 'google.png',
	'flickr.com' => 'flickr.png',
	'mail.ru' => 'mailru.png',
	'rambler.ru' => 'rambler.png',
	'webmoney.ru' => 'webmoney.png',
	'webmoney.com' => 'webmoney.png',
	'wmkeeper.com' => 'webmoney.png',
	'wordpress.com' => 'wordpress.png',
	'blogspot.com' => 'blogger.png',
	'diary.ru' => 'diary',
	'bestpersons.ru' => 'bestpersons.png',
	'facebook.com' => 'facebook.png',
	'twitter.com' => 'twitter.png',
	'last.fm' => 'lastfm.png',
	'lastfm.ru' => 'lastfm.png',
	'donoklassniki.ru' => 'donoklassniki.png',
	'linkedin.com' => 'linkedin.png',
	'livejournal.ru' => 'livejournal.png'
	);
	
	if (preg_match('/^https?:\/\/([^\.]+\.)?([a-z0-9\-\.]+\.[a-z]{2,5})/i', $identity, $matches)) {
		$icon_dir = get_option('siteurl').'/wp-content/plugins/loginza/img/';
		$provider_key = $matches[2];
		
		// если есть иконка для провайдера
		if (array_key_exists($provider_key, $providers)) {
			return '<img src="'.$icon_dir.$providers[$provider_key].'" alt="'.$provider_key.'" align="top" class="loginza_provider_ico"/>';
		}
	}
	return '<img src="'.$icon_dir.'openid.png" alt="OpenID" align="top" class="loginza_provider_ico"/>';
}
/**
 * Обработка тегов для вставки авторизации Loginza в страницы блога
 * Доступные теги:
 * [loginza]текст ссылки[/loginza] - не поддерживается с версии 1.2.0
 * [loginza:iframe]
 * [loginza:icons]
 *
 * @param string $message Содержимое страницы
 * @return string Содержимое страницы после обработки тегов
 */
function loginza_form_tag ($message) {
	if (!empty($message)) {
		$api_id = get_option(LOGINZA_OPTIONS_API_ID);
  		$api_key = get_option(LOGINZA_OPTIONS_API_KEY);

  		if (!empty($api_id) && !empty($api_key)) {
			$tpl_data = array (
				'loginza_host' => LOGINZA_SERVER_HOST, 
				'api_id' => $api_id,
				'returnto_url' => urlencode( loginza_get_current_url() ),
				'providers_set' => get_option(LOGINZA_OPTIONS_PROVIDERS_SET),
				'lang' => get_option(LOGINZA_OPTIONS_LANG),
				'theme' => get_option(LOGINZA_OPTIONS_THEME),
				//'img_dir' => get_option('siteurl').'/wp-content/plugins/loginza/img/',
				'plugin_dir' => get_option('siteurl').'/wp-content/plugins/loginza/'
			);
			// [loginza]текст ссылки[/loginza]
			//$message = preg_replace('/\['.LOGINZA_FORM_TAG.'\](.+)\[\/'.LOGINZA_FORM_TAG.'\]/is', '<a href="https://'.LOGINZA_SERVER_HOST.'/api/widget?token_url='.$tpl_data['returnto_url'].'&providers_set='.$tpl_data['providers_set'].'&lang='.$tpl_data['lang'].'&theme='.$tpl_data['theme'].'" class="loginza">\1</a>', $message);
			// [loginza:iframe]
			$message = preg_replace('/\['.LOGINZA_FORM_TAG.'\:iframe\]/is', loginza_fetch_template('html_iframe_form.tpl', $tpl_data), $message);
			// [loginza:icons]
			$message = preg_replace('/\['.LOGINZA_FORM_TAG.'\:icons\]/is', loginza_fetch_template('html_icons_form.tpl', $tpl_data), $message);
		}
	}
	return $message;
}
/**
 * Работа с шаблонами
 *
 * @param string $template Имя файла шаблона
 * @param array $data Значения для подстановки в шаблон
 * @return string Шаблон с подставленными значениями
 */
function loginza_fetch_template ($template, $data=null) {
	if (is_array($data)) {
		$data = loginza_fetch_template_data($data);
		return strtr(file_get_contents(LOGINZA_TEMPLATES_DIR.$template), $data);
	}
	
	return file_get_contents(LOGINZA_TEMPLATES_DIR.$template);
}
/**
 * Предобработка данных шаблона
 * Изменяет ключи массива (key -> %key%)
 *
 * @param array $data
 * @return array
 */
function loginza_fetch_template_data ($data) {
	$result = array();
	foreach ($data as $k => $v) {
		$result["%$k%"] = $v;
	}
	return $result;
}
/**
 * Обработка авторизации Loginza
 * Получает значение token и извлекает по нему профиль пользователя
 * через API запрос к Loginza.
 *
 */
function loginza_token_request () {
	global $wpdb;
	//var_dump($_REQUEST);
	if (empty($_REQUEST['token'])) {
		return;
	}
	$api_id = get_option(LOGINZA_OPTIONS_API_ID);
  	$api_key = get_option(LOGINZA_OPTIONS_API_KEY);

	// получение профиля
	$profile = loginza_api_request(LOGINZA_API_AUTHINFO
		.'?token='.$_POST['token']
		.'&id='.$api_id
		.'&sig='.md5($_POST['token'].$api_key)
	);
	$profile = json_decode($profile);
	
	// проверка на ошибки
	if (!is_object($profile) || !empty($profile->error_message) || !empty($profile->error_type)) {
		return;
	}
	
	// получаем текущего пользователя
	$WpUser = wp_get_current_user();
	
	// проверяем если данный идентификатор в базе
	$wpuid = LoginzaWpUser::getUserByIdentity($profile->identity, $wpdb);
	
	// если юзер не найден, проверяем его по другим identity относящимся к нему
	if (!$wpuid && is_array($profile->identities)) {
		for ($i=0,$toi=count($profile->identities); $i<$toi; $i++) {
			// поиск юзера
			$wpuid = LoginzaWpUser::getUserByIdentity($profile->identities[$i], $wpdb);
			// если юзер найден, прекращаем поиск, используем первый результат
			if ($wpuid) break;
		}
	}
	
	// если юзер авторизирован, прикрепляем к нету его идентификатор
	if ($WpUser->ID && @$_REQUEST['loginza_mapping'] == $WpUser->ID) {
		// такой идентификатор не прикреплен ни к кому
		if (!$wpuid) {
			// прикрепляем к нему идентификатор
			LoginzaWpUser::setIdentity($WpUser->ID, $profile);
			
			// обновление профиля
			$update_data = array();
			$update_data['ID'] = $WpUser->ID;
			
			// Отображать как
			if ($profile->name->full_name) {
				$update_data['display_name'] = $profile->name->full_name;
				$name_parts = explode(" ", $profile->name->full_name);
				// имя и фамилия по умолчанию
				$update_data['first_name'] = $name_parts[0];
				$update_data['last_name'] = $name_parts[1];
			} elseif ($profile->name->first_name || $profile->name->last_name) {
				$update_data['display_name'] = trim($profile->name->first_name.' '.$profile->name->last_name);
				// Имя
				if ($profile->name->first_name) {
					$update_data['first_name'] = $profile->name->first_name;
				}
				// Фамилия
				if ($profile->name->last_name) {
					$update_data['last_name'] = $profile->name->last_name;
				}
			}
			// если есть аватарка
			if (!empty($profile->photo)) {
				update_usermeta($WpUser->ID, LOGINZA_WP_USER_META_AVATAR, $profile->photo);
			}
			
			// обновление юзера
			if (count($update_data) > 1) {
				wp_update_user($update_data);
			}
		}
	} elseif (!$WpUser->ID) {
		// идентификатора нет
		if (!$wpuid) {
			if (empty($profile->email)) {
				// генерируем временный email
				$profile->email = LoginzaWpUser::generateLogin($profile->identity).'@'.parse_url(get_option('siteurl'), PHP_URL_HOST);
				
				// требуется отредактировать email
				$is_temporary_email = true;
			}
			
			// если НЕ передан email ИЛИ email в БД не зарегистрирован
			if (!email_exists($profile->email)) {
				// новый пользователь
				$wpuid = LoginzaWpUser::create($profile);
			} else {
				// редирект на страницу логина с ошибкой дубликата email
				wp_safe_redirect(get_option('siteurl').'/wp-login.php?loginza_error=email');
				die();
			}
	  	}
	  	
	  	// если пользователь вошел или зарегистрирован
	  	if ($wpuid) {
	  		// авторизируем нового пользователя
  			wp_set_auth_cookie($wpuid, true, false);
  			wp_set_current_user($wpuid);
  			
  			// если был установлен временный email
  			/*if (@$is_temporary_email) {
  				// редирект на страницу логина с ошибкой дубликата email
				wp_safe_redirect(get_option('siteurl').'/wp-admin/profile.php?loginza_message=email');
				die();
  			}*/
  		}
	}
	
	if (!empty($_GET['loginza_return'])) {
		$return_to = $_GET['loginza_return'];
	} else {
		$return_to = loginza_get_current_url();
	}
	// редирект
	wp_safe_redirect($return_to);
	die();
}
function loginza_get_current_url () {
	$url = array();
	// проверка https
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {
		$url['sheme'] = "https";
		$url['port'] = '443';
	} else {
		$url['sheme'] = 'http';
		$url['port'] = '80';
	}
	// хост
	$url['host'] = $_SERVER['HTTP_HOST'];
	// если не стандартный порт
	if (strpos($url['host'], ':') === false && $_SERVER['SERVER_PORT'] != $url['port']) {
		$url['host'] .= ':'.$_SERVER['SERVER_PORT'];
	}
	// строка запроса
	if (isset($_SERVER['REQUEST_URI'])) {
		$url['request'] = $_SERVER['REQUEST_URI'];
	} else {
		$url['request'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
		$query = $_SERVER['QUERY_STRING'];
		if (isset($query)) {
		  $url['request'] .= '?'.$query;
		}
	}
	
	return $url['sheme'].'://'.$url['host'].$url['request'];
}
function loginza_admin_options () {
	add_utility_page('Настройка Loginza', 'Loginza', 'administrator', 'LOGINZA', 'loginza_admin_page', WP_PLUGIN_URL.'/loginza/img/loginza.png');
	return true;
}
function loginza_admin_url () {
	return get_option('siteurl').'/wp-admin/admin.php?page=LOGINZA';
}
function loginza_admin_page () {
	// список доступных провайдеров
	$aval_providers = array(
		'google', 'yandex', 'mailruapi', 
		'vkontakte', 'facebook', 'twitter', 
		'loginza', 'myopenid', 'webmoney', 
		'rambler', 'flickr', 'lastfm', 
		'openid', 'mailru', 'verisign', 
		'aol', 'steam', 'livejournal',
		'odnoklassniki', 'linkedin'
	);
	$aval_langs = array(
		'ru' => 'Русский', 
		'uk' => 'Український',
		'be' => 'Беларускі',
		'en' => 'English',
		'fr' => 'Français'
	);

	$aval_themes = array(
		'grey' => 'Серая (Grey)'
	);
	
	// сохранение настроек АПИ
	if (isset($_POST['save_loginza_api'])) {
		update_option(LOGINZA_OPTIONS_API_ID, intval(@$_POST['api_id']));
		update_option(LOGINZA_OPTIONS_API_KEY, @$_POST['api_key']);

		// сообщение
		echo '<div class="updated"><p><strong>Настройки сохранены</strong></p></div>';
	}

	if (isset($_POST['save_loginza'])) {
		// сохраняем список провайдеров
		if (!empty($_POST['providers_set'])) {
			// разбор списка провайдеров
			$_POST['providers_set'] = explode(',', $_POST['providers_set']);
			
			$providers = array();
			$prefix = 'provider_';
			
			foreach ($_POST['providers_set'] as $provider) {
				if (strpos($provider, $prefix) === 0) {
					$providers[] = substr($provider, strlen($prefix));
				}
			}
			$providers = array_unique($providers);
			// если список не пуст, сохраняем
			if (count($providers)) {
				update_option(LOGINZA_OPTIONS_PROVIDERS_SET, implode(',', $providers));
			}
		}
		
		// сохранение языка
		if (!empty($_POST['lang'])) {
			$lang_option = '';
			if (array_key_exists($_POST['lang'], $aval_langs)) {
				$lang_option = $_POST['lang'];
			}
			update_option(LOGINZA_OPTIONS_LANG, $lang_option);
		}

		// сохранение темы
		if (!empty($_POST['theme'])) {
			$theme_option = '';
			if (array_key_exists($_POST['theme'], $aval_themes)) {
				$theme_option = $_POST['theme'];
			}
			update_option(LOGINZA_OPTIONS_THEME, $theme_option);
		}
		
		// сообщение
		echo '<div class="updated"><p><strong>Настройки сохранены</strong></p></div>';
	}
	// получение настроек
	// данные для шаблона
	$tpl_data = array();
	$tpl_data['api_id'] = htmlspecialchars( get_option(LOGINZA_OPTIONS_API_ID) );
	$tpl_data['api_key'] = htmlspecialchars( get_option(LOGINZA_OPTIONS_API_KEY) );

	$tpl_data['providers_set_avalible'] = $tpl_data['providers_set_saved'] = $tpl_data['lang'] = $tpl_data['theme'] = '';
	
	// блок Провайдеры
	// значение опции в настройках
	$providers_set_options = array();
	$providers_set_option = get_option(LOGINZA_OPTIONS_PROVIDERS_SET);
	
	// проверка наличия значения опции
	if (strlen($providers_set_option)) {
		$providers_set_options = explode(',', $providers_set_option);
	}
	
	// если есть настройка провайдеров
	if (count($providers_set_options) > 0){
		foreach ($providers_set_options as $provider) {
			$tpl_data['providers_set_saved'] .= '<li id="provider_'.$provider.'"><input type="button" value="X"/></li>';
		}
		// формируем список доступных провайдеров для добавления
		foreach ($aval_providers as $provider) {
			if (!in_array($provider, $providers_set_options)){
				$tpl_data['providers_set_avalible'] .= '<li id="provider_'.$provider.'"><input type="button" value="&larr;"/></li>';
			}
		}
	} else {
		// опция пуста, полный список провайдеров
		foreach ($aval_providers as $provider) {
			$tpl_data['providers_set_saved'] .= '<li id="provider_'.$provider.'"><input type="button" value="X"/></li>';
		}
	}
	
	// блок Язык
	$lang_option = get_option(LOGINZA_OPTIONS_LANG);
	foreach ($aval_langs as $lang => $lang_name) {
		$tpl_data['lang'] .= '<option value="'.$lang.'" '.($lang == $lang_option ? 'selected="selected"' : '').'>'.$lang_name.'</option>';
	}

	// блок Тема
	$theme_option = get_option(LOGINZA_OPTIONS_THEME);
	foreach ($aval_themes as $theme => $theme_name) {
		$tpl_data['theme'] .= '<option value="'.$theme.'" '.($theme == $theme_option ? 'selected="selected"' : '').'>'.$theme_name.'</option>';
	}
		
	$tpl_data['wp_plugin_url'] = WP_PLUGIN_URL;
	$tpl_data['wp_domain'] = urlencode($_SERVER['HTTP_HOST']);

	echo loginza_fetch_template('html_admin_options.tpl', $tpl_data);
}
?>