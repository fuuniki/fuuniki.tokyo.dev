<?php get_header(); ?>

<div class="l-inner">
	<div class="l-wrapperFlex">
		<main class="l-main p-archive">

			<?php
			if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
			}
			?>

			<h2 class="p-archive__heading">
				<?php
				if (isset($_GET['s']) && empty($_GET['s'])) {
					echo '検索キーワード未入力';
				} else {
					echo ($_GET['s'].' の検索結果：'.$wp_query->found_posts .'件');
				}
				?>
			</h2>
			<?php if(isset($_GET['s']) && empty($_GET['s'])) : ?>
			<P>入力してください</P>
			<?php else: ?>
				<div class="p-archive__entries">
					<?php query_posts($query_string.'&posts_per_page=30'); ?>
					<?php if(have_posts()): while(have_posts()):the_post(); ?>
						<div class="c-card p-archive__list">
							<a class="c-card__imgLink" href="<?php the_permalink(); ?>">
								<?php
								if(has_post_thumbnail()):
									//$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
									//echo '<img class="c-card__img" src="'.$url.'" alt="">';
									echo get_the_post_thumbnail($post->ID, 'top-thumb');
								else:
								?>
								<img class="c-card__img" src="<?php echo get_template_directory_uri(); ?>/assets/img/og/image.php?text=<?php the_title(); ?>" alt="">
								<?php endif; ?>

							</a>
							<div class="c-card__date">
								<?php
								$year   = get_the_date( 'Y' );
								$month  = get_the_date( 'm' );
								?>
								<a class="c-card__dateLink" href="<?php echo get_month_link( $year, $month ); ?>"><time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time></a>
							</div>
							<h3 class="c-card__title"><a class="c-card__titleLink" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="c-card__categories p-archive__categories">
								<?php
								$categories = get_the_category();
								foreach($categories as $category) {
									echo '<a class="c-card__category p-archive__category" href="'. get_category_link( $category->term_id ) .'">'. $category->cat_name .'</a>';
								}
								 ?>
							</div>
							<p class="c-card__text">
								<?php
								$content = get_the_content();
								$content = wp_strip_all_tags( $content );
								$content = strip_shortcodes( $content );
								echo $content;
								?>
							</p>
						</div>
					<?php endwhile; ?>
					<?php else: ?>
					<P>記事はありません</P>
					<?php endif; ?>


				</div>

				<div class="p-archive__pager">
					<?php

					$args = array(
						'end_size'     => 1,
						'mid_size'     => 2,
						'prev_next'    => false,
					);

					the_posts_pagination($args);
					?>
				</div>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

		</main>

		<?php get_sidebar() ; ?>

	</div>

</div>

<?php get_footer(); ?>
