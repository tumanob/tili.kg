<?php get_header(); ?>
	<div id="wrapper">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div class="post">
				<h2><?php the_title(); ?></h2>
				<?php the_content(); ?>
			</div>
            <?php endwhile; else : endif; ?>            
	</div>
<?php get_footer(); ?>