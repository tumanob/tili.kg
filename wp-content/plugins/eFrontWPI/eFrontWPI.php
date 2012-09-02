<?php

/*	
Plugin Name: eFront Wordpress Login Integration
Plugin URI: http://www.computersolutions.cn/blog/eFront Integration/ 
Description:  Authenticates eFront usernames against Wordpress, and optionally creates a user in eFront.
Version: 1.0
Author: Lawrence Sheed. Portions of code based on Skippy Bosco's work on aMember / eFront integration.
Author URI: http://www.sheed.com
*/

require_once(ABSPATH . WPINC . '/registration.php');

//Admin
function eFrontWPI_menu()
{
    include 'eFrontWPI_admin.php';
}

function eFrontWPI_admin_actions()
{
    add_options_page("eFront WordPress Integration Options", "eFront WordPress Integration", 10, "eFrontWPI", "eFrontWPI_menu");
}

function eFrontWPI_activation_hook()
{
    //Store settings
    add_option("eFrontWPI_path", "");
    add_option("eFrontWPI_admin_user", "");
    add_option("eFrontWPI_admin_pass", "");
    add_option("eFrontWPI_create_login", "");
    add_option("eFrontWPI_token", "");

    //Setup the actual admin page in the eFrontWPI_admin.php page.

}

/* Start of main code *********************************************************/

$eFrontWPI_options = array(
    "path" => get_option("eFrontWPI_path"),
    "admin_user" => get_option("eFrontWPI_admin_user"),
    "admin_pass" => get_option("eFrontWPI_admin_pass"),
    "create_login" => get_option("eFrontWPI_create_login"),
    "token" => get_option("eFrontWPI_token"),
    "domain" => get_option("eFrontWPI_domain")
);

//Add the menu
add_action('admin_menu', 'eFrontWPI_admin_actions');

//Add filter
add_filter('authenticate', 'eFrontWPI_authenticate', 1, 3);

add_action('wp_logout', 'eFrontWPI_logout');
add_action('wp_authenticate', 'eFrontWPI_capture_login');
add_action('wp_login', 'eFrontWPI_on_login');

//Authenticate function

function eFrontWPI_logout()
{
    eFrontWPI_delete_cookie();
    return;
}

function eFrontWPI_capture_login($username, $password) {
    global $efront_user_username, $efront_user_password;
    $efront_user_username = $username;
    $efront_user_password = $password ? $password : $_POST['pwd'];
}
function eFrontWPI_on_login($username) {
    global $efront_user_username, $efront_user_password;
    if ($username == $efront_user_username) {
        $user = get_user_by('login', $username);
        if ($user->user_login == $username)
            eFrontWPI_update_user($user, $efront_user_username, $efront_user_password);
    }
}

function eFrontWPI_update_user($user, $username, $password) {
    eFrontWPI_perform_action("update_user&login=" . $username . "&password=" . $password . "&name=" . ($user->first_name) . "&surname=" . ($user->last_name) . "&email=" . ($user->user_email) . "&languages=english");
}

function eFrontWPI_authenticate($user, $username, $password)
{

    //Do our basic error checking
    if (is_a($user, 'WP_User')) {
        return $user;
    }

    if (empty($username) || empty($password)) {
        $error = new WP_Error();

        if (empty($username))
            $error->add('empty_username', __('<strong>ERROR</strong>: The username field is empty.'));

        if (empty($password))
            $error->add('empty_password', __('<strong>ERROR</strong>: The password field is empty.'));

        return $error;
    }

    //Attempt Login
    $user = get_userdatabylogin($username);

    if (!$user || (strtolower($user->user_login) != strtolower($username))) {
        do_action('wp_login_failed', $username);
        return new WP_Error('invalid_username', __('<strong>eFrontWPI</strong>: Login failed, invalid username.'));
    }
    else {
        eFrontWPI_DoLogin($user, $username, $password);
    }
}

function eFrontWPI_DoLogin($user, $username, $password)
{
    global $eFrontWPI_options;
    $result = eFrontWPI_perform_action("efrontlogin&login=" . $username);

    if (is_wp_error($result)) {
        echo $result->get_error_message();
        wp_die("error above", "", "");
    }
    elseif ($result == false || $result === null || strlen($result) == 0) {
        echo "Empty return value?";
        wp_die("hmm login issue", "", "");

    }

    if (strpos($result, 'user does not exist') == true) {
        if ($eFrontWPI_options['create_login'] == 'yes') {
            //Add the user if possible.
            eFrontWPI_perform_action("create_user&login=" . $username . "&password=" . $password . "&name=" . ($user->first_name) . "&surname=" . ($user->last_name) . "&email=" . ($user->user_email) . "&languages=english");
            eFrontWPI_perform_action("update_user&login=" . $username . "&password=" . $password . "&name=" . ($user->first_name) . "&surname=" . ($user->last_name) . "&email=" . ($user->user_email) . "&languages=english");
        }
    }
    eFrontWPI_set_cookie($username, $password);
    return;
}


function eFrontWPI_perform_action($action)
{
    if (!extension_loaded('curl')) {
        wp_die('eFrontWPI_fatal_error:  eFront Plugin: Sorry, but this plugin requires you have CURL installed.', "", "");
    }
    global $eFrontWPI_options, $result, $token;
    //Try get token from wordpress.
    if ($token == null) {
        $token = $eFrontWPI_options['token'];
    }
    //If nothing saved, get a new one.

    if ($token == null) {
        $token = eFrontWPI_get_token($token);
    }


    if (is_wp_error($token)) {
        echo $token->get_error_message();
        wp_die("returned an error from get_token.", "", "");
    }

    if ($token !== null && !is_wp_error($token)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_URL, $eFrontWPI_options['path'] . '?action=' . $action . '&token=' . $token);
        $result = @curl_exec($ch);

        //echo '<br>'.$eFrontWPI_options['path'].'?action='.$action.'&token='.$token.'<br>';
        if (curl_errno($ch)) {
            return new WP_Error('eFrontWPI_server_error', __('eFrontWPI: Error communicating with server'));
        } // ('.$this_config['path'].'). <br><br>action: '.$this_config['path'].'?action='.$action.'&token='.$token.'<br><br>response: '.curl_error($ch)); }
        //echo "after server error";
        if ($result === null) {
            return new WP_Error('eFrontWPI_response_error', __('eFront Plugin: Unable to communicate with server'));
        } //('.$this_config['path'].') or empty response performing action'); }
        //echo "after null error";
        if (strpos($result, '<status>error</status>') == true) {
            return $result;
        } //We check other errors this outside of this function.//new WP_Error('eFrontWPI_status_error', __('eFront Plugin: Warning performing action, received an error ?action='.$action.'&token='.$token.'<br><br>result: '.$result)); }
        //echo "after status error";
        if (strpos($result, '<message>Invalid token</message>') == true) {
            //echo "inside invalid token";
            $token = eFrontWPI_get_token($token);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_URL, $eFrontWPI_options['path'] . '?action=' . $action . '&token=' . $token);
//            var_dump($eFrontWPI_options['path'].'?action='.$action.'&token='.$token);die;
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                return new WP_Error('eFrontWPI_server_error', __('eFrontWPI: Error communicating with server'));
            } // ('.$this_config['path'].'). <br><br>action: '.$this_config['path'].'?action='.$action.'&token='.$token.'<br><br>response: '.curl_error($ch)); }
            if ($result === null) {
                return new WP_Error('eFrontWPI_response_error', __('eFront Plugin: Unable to communicate with server'));
            } //('.$this_config['path'].') or empty response performing action'); }
            if (strpos($result, '<status>error</status>') == true) {
                return new WP_Error('eFrontWPI_status_error', __('eFront Plugin: Warning performing action, received an error.'));
            } //$db->log_error('eFront Plugin: Warning performing action.<br><br>action: '.$this_config['path'].'?action='.$action.'&token='.$this_config['token'].'<br><br>result: '.$result); }
            if (strpos($result, '<message>Invalid token</message>') == true) {
                return new WP_Error('eFrontWPI_token_error', __('eFront Plugin: Bad Token'));
            }
        }
        curl_close($ch);
        return $result;
    }
    return false;
}

function eFrontWPI_get_token()
{
    global $eFrontWPI_options, $token;

    if (!extension_loaded('curl')) {
        wp_die('eFrontWPI_fatal_error:  eFront Plugin: Sorry, but this plugin requires you have CURL installed.', "", "");
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_URL, $eFrontWPI_options['path'] . '?action=token');
    $result = @curl_exec($ch);
    if (curl_errno($ch)) {
        return new WP_Error('eFrontWPI_server_error', __('eFrontWPI: Error communicating with server' . $eFrontWPI_options['path'] . '?action=token<br><br>response: ' . curl_error($ch)));
    }
    if ($result == null) {
        return new WP_Error('eFrontWPI_response_error', __('eFront Plugin: Unable to communicate with server'));
    } //$db->log_error('eFront Plugin: Warning communicating with server ('.$this_config['path'].') or empty response getting token'); }
    if (strpos($result, '<token>') == false) {
        return new WP_Error('eFrontWPI_token_error', __('eFront Plugin: Bad Token'));
    } //$db->log_error('eFront Plugin: Error getting token from: ['.$this_config['path'].'] <br><br>response:'.$result); }
    else {
        $token = new SimpleXMLElement($result);
        if ($token->status[0] == 'error') {
            return new WP_Error('eFrontWPI_token_status_error', __('eFront Plugin: Token Status error'));
        } //$db->log_error('eFront Plugin: Communicated with server ('.$this_config['path'].') but error getting token'); }
        else {
            $token = (string)$token->token[0]; //Force this mofo back into a string type instead of staying as a SimpleXML object..

            //Attempt to login as the Admin User
            curl_setopt($ch, CURLOPT_URL, $eFrontWPI_options['path'] . '?action=login&username=' . $eFrontWPI_options['admin_user'] . '&password=' . $eFrontWPI_options['admin_pass'] . '&token=' . $token);
            $result = @curl_exec($ch);
            //echo  "<br>".$eFrontWPI_options['path'].'?action=login&username='.$eFrontWPI_options['admin_user'].'&password='.$eFrontWPI_options['admin_pass'].'&token='.$token;
            if (curl_errno($ch)) {
                return new WP_Error('eFrontWPI_login_error', __('eFrontWPI: Error logging in as admin on server'));
            } //$db->log_error('eFront Plugin: Error logging into: ('.$this_config['path'].'). <br><br>action: '.$this_config['path'].'?action=token='.$token.'<br><br>response: '.curl_error($ch)); }
            //echo "after login error";
            if ($result == null) {
                return new WP_Error('eFrontWPI_server_error', __('eFrontWPI: Error communicating with server'));
            } //$db->log_error('eFront Plugin: Error communicating with server ('.$this_config['path'].') or empty response logging in as '.$this_config['login']); }
            //echo "after server error";
            if (strpos($result, '<status>ok') == false) {
                return new WP_Error('eFrontWPI_server_error', __('eFrontWPI: Attempted login but did not receive a good token reply.  Response was :' . $result));
            }
            //echo "after no good reply";
        }
    }
    curl_close($ch);

    update_option("eFrontWPI_token", $token); //Save our 30 min token to Wordpress, in case its useful

    return $token;
}

function eFrontWPI_delete_cookie()
{
    global $eFrontWPI_options;
    setcookie("cookie_login", "", time() - 3600000, '/', @$eFrontWPI_options['domain']);
    setcookie("cookie_password", "", time() - 3600000, '/', @$eFrontWPI_options['domain']);
    setcookie("PHPSESSID", "", time() - 3600000); //Kill the session id also, or eFront doesn't logout, sigh.
}

function eFrontWPI_set_cookie($username, $password)
{
    global $eFrontWPI_options;
    //G_MD5KEY from eFront libraries/globals.php
    //eFront needs a cookie also.
    define("G_MD5KEY", 'cDWQR#$Rcxsc');
    setcookie("cookie_login", $username, time() + 3600, '/', @$eFrontWPI_options['domain']);
    setcookie("cookie_password", md5($password . G_MD5KEY), time() + 3600, '/', @$eFrontWPI_options['domain']);
}

register_activation_hook(__FILE__, 'eFrontWPI_activation_hook');
