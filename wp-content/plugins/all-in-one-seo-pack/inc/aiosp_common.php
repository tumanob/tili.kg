<?php

/**
 * @package All-in-One-SEO-Pack
 */
class aiosp_common {

	/**
	 * aiosp_common constructor.
	 *
	 * These are commonly used functions that can be pulled from anywhere.
	 * (or in some cases they're functions waiting for a home)
	 *
	 */
	function __construct() {
		//construct
	}


	/**
	 * @param null $p
	 *
	 * @return array|null|string|WP_Post
	 */
	static function get_blog_page( $p = null ) {
		static $blog_page = '';
		static $page_for_posts = '';
		if ( null === $p ) {
			global $post;
		} else {
			$post = $p;
		}
		if ( '' === $blog_page ) {
			if ( '' === $page_for_posts ) {
				$page_for_posts = get_option( 'page_for_posts' );
			}
			if ( $page_for_posts && is_home() && ( ! is_object( $post ) || ( $page_for_posts !== $post->ID ) ) ) {
				$blog_page = get_post( $page_for_posts );
			}
		}

		return $blog_page;
	}

	/**
	 * @param string $location
	 * @param string $title
	 * @param string $anchor
	 * @param string $target
	 * @param string $class
	 * @param string $id
	 *
	 * @return string
	 */
	static function get_upgrade_hyperlink( $location = '', $title = '', $anchor = '', $target = '', $class = '', $id = '' ) {

		$affiliate_id = '';

		//call during plugins_loaded
		$affiliate_id = apply_filters( 'aiosp_aff_id', $affiliate_id );

		//build URL
		$url = 'http://semperplugins.com/plugins/all-in-one-seo-pack-pro-version/';
		if ( $location ) {
			$url .= '?loc=' . $location;
		}
		if ( $affiliate_id ) {
			$url .= "?ap_id=$affiliate_id";
		}

		//build hyperlink
		$hyperlink = '<a ';
		if ( $target ) {
			$hyperlink .= "target=\"$target\" ";
		}
		if ( $title ) {
			$hyperlink .= "title=\"$title\" ";
		}
		$hyperlink .= "href=\"$url\">$anchor</a>";

		return $hyperlink;
	}

	static function get_upgrade_url() {
		//put build URL stuff in here
	}
}
