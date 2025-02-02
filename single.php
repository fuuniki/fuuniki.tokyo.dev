<?php get_header(); ?>

<?php
    // 記事のビュー数を更新
    if (!is_user_logged_in() && !is_robots()) {
      setPostViews(get_the_ID());
    }
?>

<div class="l-inner">
	<div class="l-wrapperFlex">
		<main class="l-main p-archive">

			<?php
			if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
			}
			?>



			<article class="p-article">
				<div class="p-article__header">
					<h1 class="p-article__title"><?php the_title();?></h1>
					<div class="p-article__element">
						<?php $categories = get_the_category();
						if (!empty( $categories )) {
						?>
						<div class="p-article__elementList p-article__elementList--category">
							<?php

							//選択したカテゴリ全て表示
							foreach($categories as $category){
								echo '<a href="'.get_category_link($category->term_id).'">'.$category->name.'</a>';
							}
							?>
						</div>
						<?php } ?>

						<?php $tags = get_the_tags();
						if (!empty( $tags )) {
						?>
						<div class="p-article__elementList p-article__elementList--tag">
							<?php
							if($tags){
								foreach($tags as $tag){
									echo '<a href="'.get_tag_link($tag->term_id).'">'.$tag->name.'</a>';
								}
							}
							?>
						</div>
						<?php } ?>

						<div class="p-article__elementList p-article__elementList--date">
							<?php
							$year   = get_the_date( 'Y' );
							$month  = get_the_date( 'm' );
							?>
							<a href="<?php echo get_month_link( $year, $month ); ?>" rel="nofollow">
								更新日：<time><?php echo mysql2date('Y年n月j日', $post->post_date); ?></time>
							</a>
						</div>

						<?php
						// 撮影日のデータ取得
						$photo_date = get_post_meta(get_the_ID(), '_photo_date', true);
						if (!empty($photo_date)) :
							$photo_year = date('Y', strtotime($photo_date));
							$photo_month = date('m', strtotime($photo_date));
							// 撮影日の月別アーカイブリンクを生成
							$photo_archive_link = add_query_arg('photo_date', $photo_year . '-' . $photo_month, home_url());
							?>
							<div class="p-article__elementList p-article__elementList--shootingdate">
								<?php
								/*
								<a href="<?php echo esc_url($photo_archive_link); ?>" rel="nofollow">
									撮影日：<time><?php echo esc_html(date_i18n('Y年n月j日', strtotime($photo_date))); ?></time>
								</a>
								*/
								?>
								<span>
									撮影日：<time><?php echo esc_html(date_i18n('Y年n月j日', strtotime($photo_date))); ?></time>
								</span>
							</div>
						<?php endif; ?>

					</div>
					<?php
					if( has_post_thumbnail() ) { /* アイキャッチ画像が設定されているかの判定 */
					 ?>
					<img class="p-article__eyeCatching" src="<?php the_post_thumbnail_url() ?>" alt="">
					<?php } else {?>
					<img class="p-article__eyeCatching" src="<?php echo get_template_directory_uri(); ?>/assets/img/og/image.php?text=<?php the_title(); ?>" alt="">
					<?php }?>
				</div>
				<div class="p-article__content">
					<?php
					if(have_posts()){
						while(have_posts()){
							the_post();
							the_content();
						}
					} ?>
				</div>
				<div class="p-article__footer">
					<div class="p-sharebtn">
						<div class="p-sharebtn__message"></div>
						<div class="p-sharebtn__list">
							<div class="p-sharebtn__item p-sharebtn__item--twitter">
								<a href="http://twitter.com/share?url=<?php echo get_the_permalink();?>&text=<?php the_title();?>+%7C+ふうさんぽ" target="_blank"></a>
							</div>
							<div class="p-sharebtn__item p-sharebtn__item--facebook">
								<a href="https://www.facebook.com/share.php?u=<?php echo get_the_permalink();?>" rel="nofollow noopener noreferrer" target="_blank"></a>
							</div>
							<div class="p-sharebtn__item p-sharebtn__item--line">
								<a href="https://social-plugins.line.me/lineit/share?url=<?php echo get_the_permalink();?>" rel="nofollow noopener noreferrer" target="_blank">

								</a>
							</div>
						</div>
					</div>
					<div class="p-article__pager">

						<?php $nextpost = get_adjacent_post(false, '', false); if ($nextpost) : ?>
							<div class="p-article__pagerItem p-article__pager-next">
								<a href="<?php echo get_permalink($nextpost->ID); ?>">
									<?php
									if(get_the_post_thumbnail($nextpost->ID)):
									  echo get_the_post_thumbnail($nextpost->ID, 'top-thumb', array('alt'=>get_the_title($nextpost->ID) ));
									else:
										echo '<img src="'.get_template_directory_uri().'/assets/img/og/image.php?text='.esc_attr($nextpost->post_title).'" alt="'.get_the_title($nextpost->ID).'">';
									endif;
									?>
									<span class=""><?php echo esc_attr($nextpost->post_title); ?></span>
								</a>
							</div>
						<?php endif; ?>

						<?php $prevpost = get_adjacent_post(false, '', true); if ($prevpost) : ?>
							<div class="p-article__pagerItem p-article__pager-prev">
								<a href="<?php echo get_permalink($prevpost->ID); ?>">
									<span class=""><?php echo esc_attr($prevpost->post_title); ?></span>
									<?php
									if(get_the_post_thumbnail($prevpost->ID)):
									  echo get_the_post_thumbnail($prevpost->ID, 'top-thumb', array('alt'=>get_the_title($prevpost->ID) ));
									else:
										echo '<img src="'.get_template_directory_uri().'/assets/img/og/image.php?text='.esc_attr($prevpost->post_title).'" alt="'.get_the_title($prevpost->ID).'">';
									endif;
									?>
								</a>
							</div>
						<?php endif; ?>

					</div>
				</div>


			</article>

		</main>

		<?php get_sidebar() ; ?>

	</div>

</div>

<?php get_footer(); ?>
