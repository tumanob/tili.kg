<?php
$wp_default_secret_key = 'впишите сюда уникальную фразу';

// Correct some overlapping issues
function ru_accomodate_markup() {
	global $locale;

	wp_enqueue_style($locale, content_url("languages/$locale.css"), array(), '20110630', 'all');
}
add_action('admin_print_styles', 'ru_accomodate_markup');

function ru_populate_options() {
	add_option('rss_language', 'ru');
}
add_action('populate_options', 'ru_populate_options');

function ru_restore_scripts_l10n() {
	global $wp_scripts;

	if ( is_a($wp_scripts, 'WP_Scripts') )
		do_action_ref_array( 'wp_default_scripts', array( &$wp_scripts ) );
}
add_action('init', 'ru_restore_scripts_l10n');

function ru_extend_press_this() {
	global $hook_suffix;

	if ( 'press-this.php' == $hook_suffix ) : ?>
<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready( function() {
	window.resizeTo(772, 540);
});
/* ]]> */
</script>
<?php
	endif;
}
add_action('admin_print_footer_scripts', 'ru_extend_press_this');
?>