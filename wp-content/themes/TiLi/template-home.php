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
<div class="home-apps-sicial">
	<div class="apps">
		<div class="phone-icon col-md-3 margin-0">
			<img src="/wp-content/themes/TiLi/images/phone-bg.png" width="100%" alt="google play" />
		</div>
		<div class="col-md-9 margin-0">
			<h3>Наши приложения</h3>
			<hr class="grey">
			<div class="apps-content">
				<div class="col-md-4">
					<a href="#" class="glow"><img src="/wp-content/themes/TiLi/images/gplay-banner.png" alt="google play" /></a>
				</div>
				<div class="col-md-4">
					<a href="#" class="glow"><img src="/wp-content/themes/TiLi/images/appstore-banner.png" alt="google play" /></a>
				</div>
				<div class="col-md-4">
					<a href="#" class="glow"><img src="/wp-content/themes/TiLi/images/chrome-banner.png" alt="google play" /></a>
				</div>
				<div class="col-md-12">
					<a href="#" class="all-apps"> Все приложения</a>
				</div>



			</div>

		</div>
	</div>

	<div class="social-block col-md-12 margin-0">
		<div class="col-md-8 margin-0">
			<hr class="grey">
			<h3>Мы в социальных сетях</h3>
			<div class="socia-content">
					<div class="col-md-2 ">
						<img src="/wp-content/themes/TiLi/images/icons/fb-icon.png" alt="google play" />
					</div>
					<div class="col-md-2">
						<img src="/wp-content/themes/TiLi/images/icons/gplus-icon.png" alt="google play" />
					</div>
					<div class="col-md-2">
						<img src="/wp-content/themes/TiLi/images/icons/fb-icon.png" alt="google play" />
					</div>
	</div>

		</div>
		<div class="social-icon col-md-4 pull-right margin-0">
			<img src="/wp-content/themes/TiLi/images/social-bg.png" alt="google play" width="100%"/>

		</div>
	</div>
</div>

</div>

<div class="main-contacts col-md-12">
	<div class="center-block col-md-8" style="float: none;" >
		<?php
		// Use shortcodes for contact form
			echo do_shortcode( '[contact-form-7 id="464" title="form1"]' );

		?>
	</div>


</div>


<?php get_footer(); ?>
