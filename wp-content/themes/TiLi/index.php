<?php get_header(); ?>
	<div id="wrapper">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage') ) : ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>