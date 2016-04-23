<?php /* Template Name: Homepage */ ?>

<?php get_header(); ?>
<div class="dbcontent-main">
	<div class=" ulist">

		<div class="col-xs-12 col-sm-4 col-md-4 uitem">
			<h4>Курсы кыргызского</h4>
			<hr class="grey">
			<div class=" col-md-12 ">
				<center><a href="http://tili.kg/category/useful/courses"><img src="<?php echo get_template_directory_uri(); ?>/images/useful1.png" /></a></center>
			</div>
			<div class="col-md-12 utext">
				<a href="http://tili.kg/category/useful/courses">
					<span> Персонализированный путь обучения кыргызского языка. Каталог доступных курсов.</span>
				</a>
			</div>
			<div class="col-md-12 text-button grey">
				<a href="http://tili.kg/category/useful/courses" class="">
	        Начать обучение
				</a>
			</div>

		</div>

		<div class="col-xs-12 col-sm-4 col-md-4 uitem db-green">
			<h4>Полезное</h4>
			<hr class="white">
			<div class=" col-md-12 ">
				<center><a href="http://tili.kg/category/useful"><img src="<?php echo get_template_directory_uri(); ?>/images/useful2.png" class="" /></a></center>
			</div>
			<div class="col-md-12 utext">
				<a href="http://tili.kg/category/useful">
					<span> Книги, учебники, статьи, фильмы, музыка, клипы и многое другое для изучающих кыргызхский язык.</span>
				</a>
			</div>
			<div class="col-md-12 text-button">
				<a href="http://tili.kg/category/useful">
	        Переход в раздел
				</a>
			</div>

		</div>


		<div class="col-xs-12 col-sm-4 col-md-4 uitem db-lightgreen">
			<h4>Первые 200 слов</h4>
			<hr class="white">
			<div class=" col-md-12 ">
				<center><a href="http://tili.kg/top200/"><img src="<?php echo get_template_directory_uri(); ?>/images/useful3.png" class="" /></a></center>
			</div>
			<div class="col-md-12 utext">
				<a href="#">
					<span> Учите первые слова с картинками, озвученные диктором. Подойдет как детям так и взрослым.</span>
				</a>
			</div>
			<div class="col-md-12 text-button">
				<a href="http://tili.kg/top200/">
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
		<div class="phone-icon col-md-3 margin-0 hidden-xs hidden-sm">
			<img src="/wp-content/themes/TiLi/images/phone-bg.png" width="100%" alt="google play" />
		</div>
		<div class="col-md-9 margin-0">
			<h3>Наши приложения</h3>
			<hr class="grey">
			<div class="apps-content">
				<div class="col-xs-6 col-sm-4 col-md-4">
					<a href="http://play.google.com/store/search?q=pub:Tili.kg" class="glow"><img src="/wp-content/themes/TiLi/images/gplay-banner.png" alt="google play" /></a>
				</div>
				<div class="col-xs-6 col-sm-4 col-md-4">
					<a href="http://itunes.apple.com/us/app/tili.kg/id528317649?mt=8" class="glow"><img src="/wp-content/themes/TiLi/images/appstore-banner.png" alt="google play" /></a>
				</div>
				<div class="col-xs-6 col-sm-4 col-md-4">
					<a href="https://chrome.google.com/webstore/detail/%D0%BA%D0%B8%D1%80%D0%B3%D0%B8%D0%B7%D1%81%D0%BA%D0%BE-%D1%80%D1%83%D1%81%D1%81%D0%BA%D0%B8%D0%B9-%D1%81%D0%BB%D0%BE%D0%B2%D0%B0%D1%80%D1%8C/hojggilcgbfgflnmnjldhbdpomafihfd" class="glow"><img src="/wp-content/themes/TiLi/images/chrome-banner.png" alt="google play" /></a>
				</div>
				<div class="col-xs-6 col-sm-12 col-md-12">
					<a href="http://tili.kg/category/useful/apps" class="all-apps"> Все приложения</a>
				</div>
				<!-- Add the extra clearfix for only the required viewport -->
  			<div class="clearfix visible-xs-block"></div>



			</div>

		</div>
	</div>

	<div class="social-block col-md-12 margin-0">
		<div class="col-md-8 margin-0">
			<hr class="grey">
			<h3>Мы в социальных сетях</h3>
			<div class="socia-content">
				<div class="col-xs-4 col-sm-4 col-md-2  ">
					<a href="https://www.youtube.com/c/tilikg-edu"><img src="/wp-content/themes/TiLi/images/icons/ytube-icon.png" alt="google play" /></a>
				</div>
					<div class="col-xs-4 col-sm-4 col-md-2  ">
						<a href="https://www.facebook.com/tili.kg/"><img src="/wp-content/themes/TiLi/images/icons/fb-icon.png" alt="google play" /></a>
					</div>
					<div class="">
						<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Ftili.kg&amp;width=295&amp;height=258&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=false" scrolling="no" frameborder="0" style="/*margin-left: -160px; border:none; */overflow:hidden; width:295px; height:258px;" allowTransparency="true"></iframe>
					</div>

					<!-- Add the extra clearfix for only the required viewport -->
					<div class="clearfix"></div>
	</div>

		</div>
		<div class="social-icon col-md-4 pull-right margin-0">
			<img src="/wp-content/themes/TiLi/images/social-bg.png" alt="google play" width="100%"/>

		</div>
	</div>
</div>

</div>

</div>


<?php get_footer(); ?>
