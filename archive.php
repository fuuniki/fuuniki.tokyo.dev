<?php get_header(); ?>

<div class="l-inner">
	<div class="l-wrapperFlex">
		<main class="l-main p-archive">

			<?php
			if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
			}
			?>

			<?php if(is_category()): // カテゴリアーカイブの場合 ?>
			<h2 class="p-archive__heading"><?php single_cat_title(); ?> カテゴリの記事一覧です</h2>
			<?php elseif(is_tag()): // タグアーカイブ場合 ?>
			<h2 class="p-archive__heading"><?php single_cat_title(); ?> タグの記事一覧です</h2>
			<?php elseif(is_date()): // 日付アーカイブページの場合 ?>
			<h2 class="p-archive__heading">
				<?php
				if(is_month()) {
					$tit_monthnum = get_query_var('monthnum'); // 月の値を取り出す
					echo get_query_var('year').'年'. sprintf("%02d",$tit_monthnum).'月'; // 値を二桁に変更
				} elseif (is_day()) {
					$tit_monthnum = get_query_var('monthnum'); // 月の値を取り出す
					$tit_day = get_query_var('day'); // 日の値を取り出す
					echo get_query_var('year').'年'. sprintf("%02d",$tit_monthnum).'月'. sprintf("%02d",$tit_day).'日'; // 値を二桁に変更
				}
				?>
				の記事一覧です
			</h2>
			<?php else: ?>
			<h2 class="p-archive__heading">その他アーカイブです</h2>
			<?php endif; ?>

			<div class="p-archive__entries">
				<?php if(is_category() || is_date() || is_tag() ) :?>
					<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : the_post(); ?>
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
									$day  = get_the_date( 'd' );
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
					<?php else : ?>
    				<p>記事がありませんでした</p>
  				<?php endif; ?>
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

		</main>

		<?php get_sidebar() ; ?>

	</div>

</div>

<?php get_footer(); ?>
