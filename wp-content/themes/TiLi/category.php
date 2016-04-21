<?php get_header(); ?>
	<div id="wrapper">
		<div class="catlist">
			<h1><?php echo single_cat_title(); ?></h1>
			<hr class="grey"></hr>
			<?php //wp_nav_menu(array('menu'=>'categories')); ?>
		</div>
		<div class="posts row">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div class="post col-xs-12 col-md-6 col-sm-6">

                <div class="row">
                    <div class="col-xs-5 col-md-4 col-sm-4">
                       <a href="<?php the_permalink() ?>" rel="bookmark" class="col-xs-8 col-md-12 col-sm-12" style="padding: 0px;"><?php the_post_thumbnail('thumb'); ?></a>
                          <div class="sub col-xs-12 col-md-12 col-sm-12"> <span class="categories">Рубрика: <?php the_category(', ') ?></span></div>

                    </div>
                    <div class="col-xs-7 col-md-8 col-sm-8">
                         <?php //the_excerpt(); ?>
                        <h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <a href="<?php the_permalink() ?>" rel="bookmark" class="btn btn-info btn-sm col-xs-12 col-md-12 col-sm-12"> Скачать</a>

                    </div>
                </div>

			</div>
		<?php endwhile; else : endif; ?>
		</div>
	</div>
<?php get_footer(); ?>
