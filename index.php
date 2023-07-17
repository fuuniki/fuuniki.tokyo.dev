<?php get_header(); ?>

<!-- contens start -->
<div class="p-mainvisual">
        <div class="p-mainvisual__bg">

          <div class="l-inner p-mainvisual__inner">
            <div class="slider">
        			<div class="slider-item"><img class="slider-img" src="<?php echo get_template_directory_uri(); ?>/assets/img/mainvisual/mv_01.jpg"></div>
              <div class="slider-item"><img class="slider-img" src="<?php echo get_template_directory_uri(); ?>/assets/img/mainvisual/mv_02.jpg"></div>
        			<div class="slider-item"><img class="slider-img" src="<?php echo get_template_directory_uri(); ?>/assets/img/mainvisual/mv_03.jpg"></div>
        		</div>
          </div>
        </div>
      </div>

      <div class="l-inner l-section">
        <h2 class="c-title">新着記事</h2>
        <div class="p-latestArticle">
          <?php
          // posts_per_pageで取得件数の指定、orderbyでソート順を新着順にしています。
          $args = array('posts_per_page' => 6, 'orderby' => 'date');
          $query = new WP_Query($args);
          ?>
          <?php if( $query->have_posts() ) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>

              <div class="c-card p-latestArticle__list">
                <a class="c-card__imgLink" href="<?php the_permalink(); ?>">
                  <?php
                  if(has_post_thumbnail()):
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
                  <a class="c-card__dateLink" href="<?php echo get_month_link( $year, $month ); ?>"><?php echo get_the_date(); ?></a>
                </div>
                <h3 class="c-card__title"><a class="c-card__titleLink" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <div class="c-card__categories">
                  <?php
									$categories = get_the_category();
									foreach($categories as $category) {
										echo '<a class="c-card__category" href="'. get_category_link( $category->term_id ) .'">'. $category->cat_name .'</a>';
									}
									 ?>
                </div>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>

        </div>

        <a class="c-button c-button__btnripple " href="<?php echo get_home_url();?>/article-list/">記事一覧はこちら</a>

      </div>

      

<!-- contens end -->

<?php get_footer(); ?>
