<?php get_header(); ?>
	<div id="wrapper">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div class="post ">
				<h1><?php the_title(); ?></h1>
                <?php if(in_category('7')) {} else { ?>
                                    					<div class="sub"><span class="date"><?php the_time('d.m.Y') ?></span> | <span class="categories">Рубрика: <?php the_category(', ') ?></span></div>
                                    				<?php } ?>
                <div class="col-xs-12 col-md-4 col-sm-12">
                    <?php the_post_thumbnail('medium'); ?>
                </div>
                <div class="col-xs-12 col-md-8 col-sm-12">
                    <?php the_content(); ?>
                </div>



			</div>
			<?php comments_template( '', true ); ?>
            <?php endwhile; else : endif; ?>            
	</div>
<?php get_footer(); ?>