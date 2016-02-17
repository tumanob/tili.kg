<?php get_header(); ?>

	<div id="wrapper">
		<div class="catlist">
			<h1><?php echo single_cat_title(); ?> </h1>
			<hr class="grey"></hr>

			<div class="category-menu-useful"> <?php wp_nav_menu(array('menu'=>'categories'));?> </div>

		</div>

		<div class="posts row">

			<div class="newuseful">

				<div class="catlist">
					<h1>Новинки</h1>
				</div>

				<?php $the_query = new WP_Query( array('posts_per_page'=>6,'cat'=> '4,5,6,11,12' )); ?>
				<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>

						<?php get_template_part( 'useful', 'newitem' ); ?>


						<?php
								endwhile;
								wp_reset_postdata();
						?>

			</div>
			<hr class="grey" style="width: 95%;">

			<?php
						$categories = get_categories( array( 'child_of' => 4 ));
						//print_r($categories);
								foreach ( $categories as $category ) {
									?>
									<div class="useful-category">

										<div class="catlist">

											<h1><a href="<?php echo esc_url( get_category_link( $category->cat_ID ) ); ?>" > <?php echo $category->name;?> </a></h1>
										</div>

										<?php $the_query = new WP_Query( array('posts_per_page'=>20,'cat'=> $category->cat_ID )); ?>
										<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>

												<?php get_template_part( 'useful', 'items' ); ?>


												<?php
														endwhile;
														wp_reset_postdata();
												?>

									</div>
									<hr class="grey" style="width: 95%;     margin-bottom: 50px;">
									<div class="clear">

									</div>
									<?php
										//echo $category->cat_ID."---";
									}
			?>

		</div>
	</div>
<?php get_footer(); ?>
