<div class="post col-xs-6 col-md-2 col-sm-4">
				<div class="useful-item">
						<a href="<?php the_permalink() ?>">
							<div class="row">

									<div class="image-container col-xs-12 col-md-12 col-sm-12">
											<center><?php the_post_thumbnail('thumb'); ?>	</center>
									</div>
									<div class="sub col-xs-12 col-md-12 col-sm-12">
										<span class="categories"><?php the_category(', ') ?></span>
									</div>

									<div class="useful-content-container col-xs-12 col-md-12 col-sm-12">
											<?php the_title(); ?>
									</div>
									<div class="useful-button col-xs-12 col-md-12 col-sm-12">
										<a href="<?php the_permalink() ?>" rel="bookmark" class="btn btn-info btn-sm col-xs-12 col-md-12 col-sm-12"> Скачать</a>

									</div>
							</div>
						</a>
				</div>
</div>
