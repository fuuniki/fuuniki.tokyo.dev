<?php
/**
* Template Name: 全記事一覧 */
?>

<?php get_header(); ?>

<div class="l-inner">
	<div class="l-wrapperFlex">
		<main class="l-main p-archive">

			<div class="p-archive__entries">
				<?php
				$paged = (int) get_query_var('paged');
				$args = array(
					'posts_per_page' => 6,
					'paged' => $paged,
					'orderby' => 'post_date',
					'order' => 'DESC',
					'post_type' => 'post',
					'post_status' => 'publish'
				);
				$the_query = new WP_Query($args);
				?>
				<?php
				if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) : $the_query->the_post();
				?>
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

				<?php endwhile; endif; ?>

			</div>

			<div class="p-archive__pager">
				<?php
				//pager
				if ($the_query->max_num_pages > 1) {
					echo paginate_links(array(
						'base' => get_pagenum_link(1) . '%_%',
						'format' => 'page/%#%/',
						'current' => max(1, $paged),
						'total' => $the_query->max_num_pages,
						'prev_next'    => false,
						'end_size'     => 1,
						'mid_size'     => 2
					));
				}
				?>
				<?php wp_reset_postdata(); ?>
			</div>





		</main>

		<?php get_sidebar() ; ?>

	</div>

</div>

<?php get_footer(); ?>
