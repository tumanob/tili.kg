<?php get_header(); ?>
	<div id="wrapper">
		<div class="catlist">
			<?php wp_nav_menu(array('menu'=>'categories')); ?>
		</div>
		<div class="posts">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div class="post">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<div class="sub"><span class="date"><?php the_time('d.m.Y') ?></span> | <span class="categories">Рубрика: <?php the_category(', ') ?></span></div>
<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('thumb'); ?></a>
				<?php the_excerpt(); ?>
			</div>
		<?php endwhile; else : endif; ?>
		</div>
	</div>
<?php get_footer(); ?>