<?php /* Template Name: Homepage */ ?>


<?php get_header(); ?>
<div class="dbcontent-main">
	<div class=" ulist">

		<div class="col-md-4 uitem">
			<h4>Курс языка</h4>
			<hr class="grey">
			<div class=" col-md-12 ">
				<center><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/useful1.png" /></a></center>
			</div>
			<div class="col-md-12 utext">
				<a href="#">
					<span> Книги, учебники, статьи, фильмы, музыка, клипы ...</span>
				</a>
			</div>
			<div class="col-md-12 text-button grey">
				<a href="#" class="">
	        Начать обучение
				</a>
			</div>

		</div>

		<div class="col-md-4 uitem db-green">
			<h4>Полезное</h4>
			<hr class="white">
			<div class=" col-md-12 ">
				<center><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/useful2.png" class="" /></a></center>
			</div>
			<div class="col-md-12 utext">
				<a href="#">
					<span> Книги, учебники, статьи, фильмы, музыка, клипы ...</span>
				</a>
			</div>
			<div class="col-md-12 text-button">
				<a href="#">
	        Переход в раздел
				</a>
			</div>

		</div>


		<div class="col-md-4 uitem db-lightgreen">
			<h4>Первые 200 слов</h4>
			<hr class="white">
			<div class=" col-md-12 ">
				<center><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/useful3.png" class="" /></a></center>
			</div>
			<div class="col-md-12 utext">
				<a href="#">
					<span> Книги, учебники, статьи, фильмы, музыка, клипы ...</span>
				</a>
			</div>
			<div class="col-md-12 text-button">
				<a href="#">
	        Выучить слова
				</a>
			</div>

		</div>

	</div>

</div>

	<div id="wrapper" class="homepage-wrapper">

        <div id="hpagecontent">
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
