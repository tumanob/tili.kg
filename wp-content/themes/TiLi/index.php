<?php get_header(); ?>
	<div id="wrapper" class="homepage-wrapper">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage') ) : ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>