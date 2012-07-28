<?php
// настройки
define('LOGINZA_SERVER_HOST', 'loginza.ru');
define('LOGINZA_API_AUTHINFO', 'http://'.LOGINZA_SERVER_HOST.'/api/authinfo');
define('LOGINZA_HOME_DIR', dirname(dirname(dirname(dirname(__FILE__)))).'/');
define('LOGINZA_PLUGIN_DIR', realpath(dirname(__FILE__)).'/');
define('LOGINZA_TEMPLATES_DIR', LOGINZA_PLUGIN_DIR.'templates/');
define('LOGINZA_FORM_TAG', 'loginza');
// имена настроек
define('LOGINZA_OPTIONS_LANG', 'loginza_lang');
define('LOGINZA_OPTIONS_PROVIDERS_SET', 'loginza_providers_set');
define('LOGINZA_OPTIONS_THEME', 'loginza_theme');
define('LOGINZA_OPTIONS_API_ID', 'loginza_widget_id');
define('LOGINZA_OPTIONS_API_KEY', 'loginza_widget_key');
?>