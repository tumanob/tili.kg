<?php
/*
Plugin Name: Simple Facebook Connect
Plugin URI: http://ottopress.com/wordpress-plugins/simple-facebook-connect/
Description: Makes it easy for your site to use Facebook Connect, in a wholly modular way.
Author: Otto
Version: 1.1
Author URI: http://ottodestruct.com
License: GPL2

    Copyright 2009-2011  Samuel Wood  (email : otto@ottodestruct.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/
function sfc_version() {
	return '1.1';
}

// require PHP 5
function sfc_activation_check(){
	if (version_compare(PHP_VERSION, '5', '<')) {
		deactivate_plugins(basename(__FILE__)); // Deactivate ourself
		wp_die(printf(__('Sorry, Simple Facebook Connect requires PHP 5 or higher. Your PHP version is "%s". Ask your web hosting service how to enable PHP 5 as the default on your servers.', 'sfc'), PHP_VERSION));
	}
}
register_activation_hook(__FILE__, 'sfc_activation_check');

// this will prevent the PHP 5 code from causing parsing errors on PHP 4 systems
if (!version_compare(PHP_VERSION, '5', '<')) {
	include 'sfc-base.php';
}

// plugin row links
add_filter('plugin_row_meta', 'sfc_donate_link', 10, 2);
function sfc_donate_link($links, $file) {
	if ($file == plugin_basename(__FILE__)) {
		$links[] = '<a href="'.admin_url('options-general.php?page=sfc').'">'.__('Settings', 'sfc').'</a>';
		$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=otto%40ottodestruct%2ecom">'.__('Donate', 'sfc').'</a>';
	}
	return $links;
}

// action links
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'sfc_settings_link', 10, 1);
function sfc_settings_link($links) {
	$links[] = '<a href="'.admin_url('options-general.php?page=sfc').'">'.__('Settings', 'sfc').'</a>';
	return $links;
}