<?php /* Template Name: Homepage */ ?>


<?php get_header(); ?>

	<div id="wrapper" class="homepage-wrapper">
        <div id="111">
        		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        			<div class="post">
        				<?php the_content(); ?>
        			</div>
                    <?php endwhile; else : endif; ?>
        </div>

		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage') ) : ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>