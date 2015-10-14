<?php /* Template Name: Homepage */ ?>


<?php get_header(); ?>

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

	<div class="dbcontent">
		<div class="row ulist">
			<div class="col-md-12 uitem">
				<div class="col-md-2 ">
					<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/useful1.png" class="pull-right" /></a>
				</div>
				<div class="col-md-9 utext">
					<a href="#">
						<h2>Всё полезное для изучения киргизского языка</h2>
						<span> Книги, учебники, статьи, фильмы, музыка, клипы ...</span>
					</a>
				</div>
			</div>
			<div class="col-md-12 uitem">
				<div class="col-md-2 ">
					<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/useful2.png" class="pull-right" /></a>
				</div>
				<div class="col-md-9 utext">
					<a href="#">
						<h2>Наши приложения</h2>
						<span> Скачивайте наши приложения для iPhone и Android.</span>
					</a>
				</div>
			</div>
			<div class="col-md-12 uitem">
				<div class="col-md-2 ">
					<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/useful3.png" class="pull-right" /></a>
				</div>
				<div class="col-md-9 utext">
					<a href="#">
						<h2>Расширения для браузера  Goolge Chrome</h2>
						<span> Удобные расширения для браузера.</span>
					</a>
				</div>
			</div>
			<div class="col-md-12 uitem">
				<div class="col-md-2 ">
					<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/useful4.png" class="pull-right" /></a>
				</div>
				<div class="col-md-9 utext">
					<a href="#">
						<h2>200 первых слов на киргизском языке</h2>
						<span> Удобно учить первые слова с озвучиванием.</span>
					</a>
				</div>
			</div>
		</div>

	</div>
<?php get_footer(); ?>
