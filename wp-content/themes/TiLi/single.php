<?php get_header(); ?>
	<div id="wrapper">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div class="post">
				<h2><?php the_title(); ?></h2>
				<?php if(in_category('7')) {} else { ?>
					<div class="sub"><span class="date"><?php the_time('d.m.Y') ?></span> | <span class="categories">Рубрика: <?php the_category(', ') ?></span></div>
				<?php } ?>
				<?php the_content(); ?>				
			</div>
			<?php comments_template( '', true ); ?>
            <?php endwhile; else : endif; ?>            
	</div>
<?php get_footer(); ?>