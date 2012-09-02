<?php
// имена полей мета данных пользователя
define ('LOGINZA_WP_USER_META_IDENTITY', 'loginza_identity');
define ('LOGINZA_WP_USER_META_PROVIDER', 'loginza_provider');
define ('LOGINZA_WP_USER_META_AVATAR', 'loginza_avatar');

class LoginzaWpUser {
	/**
	 * Данные для транслита
	*/
	private static $tran = array(
	'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ж'=>'g', 'з'=>'z',
	'и'=>'i', 'й'=>'y', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o', 'п'=>'p',
	'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u', 'ф'=>'f', 'ы'=>'i', 'э'=>'e', 'А'=>'A',
	'Б'=>'B', 'В'=>'V', 'Г'=>'G', 'Д'=>'D', 'Е'=>'E', 'Ж'=>'G', 'З'=>'Z', 'И'=>'I',
	'Й'=>'Y', 'К'=>'K', 'Л'=>'L', 'М'=>'M', 'Н'=>'N', 'О'=>'O', 'П'=>'P', 'Р'=>'R',
	'С'=>'S', 'Т'=>'T', 'У'=>'U', 'Ф'=>'F', 'Ы'=>'I', 'Э'=>'E', 'ё'=>"yo", 'х'=>"h",
	'ц'=>"ts", 'ч'=>"ch", 'ш'=>"sh", 'щ'=>"shch", 'ъ'=>"", 'ь'=>"", 'ю'=>"yu", 'я'=>"ya",
	'Ё'=>"YO", 'Х'=>"H", 'Ц'=>"TS", 'Ч'=>"CH", 'Ш'=>"SH", 'Щ'=>"SHCH", 'Ъ'=>"", 'Ь'=>"",
	'Ю'=>"YU", 'Я'=>"YA"
	);
	
	function __construct() {
		
	}
	public function update () {
		
	}
	static function create ($profile) {
		$user_data = array();
		
		// Имя пользователя
		$user_data['user_login'] = self::nicknameToLogin ($profile->nickname);
		// проверяем передан ли никнайм и его занятость
		if (!$user_data['user_login'] || self::loginExists ($user_data['user_login'])) {
			$user_data['user_login'] = self::generateLogin ($profile->identity);
		}
		// Ник
		if ($profile->nickname) {
			$user_data['user_nicename'] = $user_data['nickname'] = $profile->nickname;
		} elseif (!empty($profile->email) && preg_match('/^(.+)\@/i', $profile->email, $nickname)) {
			$user_data['user_nicename'] = $user_data['nickname'] = $nickname[1];
		} else {
			$user_data['user_nicename'] = $user_data['nickname'] = self::nicknameToLogin ($profile->identity);
		}

        // Имя пользователя
		$user_data['user_login'] = self::nicknameToLogin ($profile->nickname);
		// проверяем передан ли никнайм и его занятость
		if (!$user_data['user_login'] || self::loginExists ($user_data['user_login'])) {
			$user_data['user_login'] = self::nicknameToLogin($user_data['user_nicename']);

            $i = 1;
            $userLogin = $user_data['user_login'].'-'.$i;
            while (username_exists($userLogin)) {
                $userLogin = $user_data['user_login'].'-'.$i;
                $i++;
            }
            $user_data['user_login'] = $userLogin;
		}

		// Сайт
		if (!empty($profile->web->blog)) {
			$user_data['user_url'] = $profile->web->blog;
		} elseif (!empty($profile->web->default)) {
			$user_data['user_url'] = $profile->web->default;
		} else {
			$user_data['user_url'] = $profile->identity;
		}
		// jabber
		if ($profile->im->jabber) {
			$user_data['jabber'] = $profile->im->jabber;
		}
		// description
		if ($profile->biography) {
			$user_data['description'] = $profile->biography;
		}
		// Отображать как
		if ($profile->name->full_name) {
			$user_data['display_name'] = $profile->name->full_name;
			$name_parts = explode(" ", $profile->name->full_name);
			// имя и фамилия по умолчанию
			$user_data['first_name'] = $name_parts[0];
			$user_data['last_name'] = $name_parts[1];
		} elseif ($profile->name->first_name || $profile->name->last_name) {
			$user_data['display_name'] = trim($profile->name->first_name.' '.$profile->name->last_name);
		} elseif (!empty($user_data['nickname'])) {
			$user_data['display_name'] = $user_data['nickname'];
		} else {
			$user_data['display_name'] = $profile->identity;
		}
		// Имя
		if ($profile->name->first_name) {
			$user_data['first_name'] = $profile->name->first_name;
		}
		// Фамилия
		if ($profile->name->last_name) {
			$user_data['last_name'] = $profile->name->last_name;
		}
		
		// остальные данные
		$user_data['user_pass'] = self::genetarePassword();
		$user_data['user_email'] = $profile->email;
		
		// создаем пользователя
		$wp_id = wp_insert_user($user_data);
		if ( !is_wp_error($wp_id) && is_int($wp_id) ) {
			self::setIdentity($wp_id, $profile);
			// если есть аватарка
			if (!empty($profile->photo)) {
				update_usermeta($wp_id, LOGINZA_WP_USER_META_AVATAR, $profile->photo);
			}
			/**
			 * TODO
			 * Для тестов
			 */
			update_usermeta($wp_id, 'loginza_json_profile', json_encode($profile));
		}
		  
		return $wp_id;
	}
	static function setIdentity ($wp_id, $profile) {
		update_usermeta($wp_id, LOGINZA_WP_USER_META_IDENTITY, $profile->identity);
		update_usermeta($wp_id, LOGINZA_WP_USER_META_PROVIDER, $profile->provider);
	}
	static function loginExists ($login) {
  		return (get_userdatabylogin($login) != false);
	}
	static function nicknameToLogin ($nickname) {
		$nickname = strtr($nickname, self::$tran);
	    return trim(preg_replace('/[^\w]+/i', '-', $nickname), '-');
	}
	static function generateLogin ($identity) {
		//$parts = parse_url($identity);
		//return self::nicknameToLogin ($parts['host'].$parts['path']);
		return 'loginza'.self::shotmd5($identity);
	}
	private static function genetarePassword () {
		return wp_generate_password();
	}
	static function getUserByIdentity ($identity, &$WpDb) {
		$result = $WpDb->get_var($WpDb->prepare("
			SELECT user_id
			FROM $WpDb->usermeta
			WHERE meta_key = '".LOGINZA_WP_USER_META_IDENTITY."'
				AND meta_value = %s
		", $identity));
		return ($result) ? $result : null;
	}
	static function getIdentityByUser ($wp_id) {
		return get_usermeta($wp_id, LOGINZA_WP_USER_META_IDENTITY);
	}
	static function getAvatarByUser ($wp_id) {
		return get_usermeta($wp_id, LOGINZA_WP_USER_META_AVATAR);
	}
	private static function shotmd5($str) {
		$str = md5($str);
		
		// проверка необходимых функций
		if (!function_exists('bcadd')) {
			return $str;
		}
		
	    $base16 = '0123456789abcdef';
	    $base62 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    if (ereg('^['.$base16.']+$', $str)) {
	        $dig = '0';
	        for ($i=0; $i<strlen($str); $i++) {
	            if ($i != 0) $dig = bcmul($dig, strlen($base16));
	            $dig = bcadd($dig, strpos($base16, $str[$i]));
	        }
	        
	        $result = '';
	        do {
	            $result .= $base62[bcmod($dig, strlen($base62))];
	            $dig = bcdiv($dig, strlen($base62));
	        }
	        while (bccomp($dig, '0') != 0);
	        
	        return strrev($result);
	    }
		return false;
	}
}

?>