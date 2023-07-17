<aside class="l-aside">
  <div class="l-aside__module">
    <h2 class="c-title">サイト内検索はこちら</h2>
    <div class="side-module-body">
      <div class="side-module-search-box">
        <!-- form要素のaction属性にはWordPressのホームURLを指定 -->
        <form role="search" method="get" id="searchform" class="search-form c-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
          <label class="screen-reader-text c-search__readerText" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
          <input type="text" name="s" id="s" class="search-module-input c-search__input" value="<?php echo get_search_query(); ?>" placeholder="記事を検索" required="">
          <input type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" id="searchsubmit" class="search-module-button c-search__submit">
        </form>
      </div>
    </div>
  </div>
  <div class="l-aside__module p-side__module-articleList">
    <h2 class="c-title">新着記事</h2>
    <?php
    // posts_per_pageで取得件数の指定、orderbyでソート順を新着順にしています。
    $args = array('posts_per_page' => 3, 'orderby' => 'date');
    $query = new WP_Query($args);
    ?>
    <?php if( $query->have_posts() ) : ?>
      <?php while ($query->have_posts()) : $query->the_post(); ?>
        <div class="c-card p-side__articleList">
          <a class="c-card__imgLink" href="<?php the_permalink(); ?>">
            <?php
            if(has_post_thumbnail()):
              echo get_the_post_thumbnail($post->ID, 'side-thumb');
            else:
            ?>
            <img class="c-card__img" src="<?php echo get_template_directory_uri(); ?>/assets/img/side-link.jpg" alt="">
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
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>記事がありません</p>
    <?php endif; ?>
  </div>
  <div class="l-aside__module">
    <h2 class="c-title">カテゴリー</h2>
    <ul class="p-side__list">
      <?php
      $categories = get_categories();
      $separator = "";
      $output = "";
      if($categories){
        foreach($categories as $category) {
          $output .= '<li class="p-side__listItem"><a class="p-side__listLink" href="'. get_category_link( $category->term_id ) .'">'.$category->cat_name.' ('.$category->count.')'.'</a>'.$separator.'</li>';
        }
        echo trim($output, $separator);
      }
      ?>
    </ul>
  </div>
  <div class="l-aside__module">
    <h2 class="c-title">タグ</h2>
    <ul class="p-side__list">
      <?php
      $term_list = get_terms('post_tag', Array('number' => 20)); //ここの20を変更する
      $result_list = [];
      foreach ($term_list as $term) {
        $u = (get_term_link( $term, 'post_tag' ));
        echo '<li class="p-side__listItem"><a class="p-side__listLink" href="'.$u.'">'.$term->name.'（'.$term->count.'）</a></li>';
      }
      ?>
    </ul>
  </div>
  <div class="l-aside__module">
    <h2 class="c-title">月別アーカイブ</h2>
    <ul class="p-monthlyArchive js-monthlyArchive">
      <?php
      $y_flg = true; //年の切替フラグ
      $f_flg = true; //初回フラグ
      $year = idate('Y'); //本日の年
      $month = idate('m'); //本日の月
      $oldest_year = get_oldest_year(); //一番古い投稿日の年
      while ( $year >= $oldest_year ) { //一番古い投稿年を指定年が下回るまでループ
        //年見出し出力
        if ( $y_flg == true ){ //年切替フラグが立っていたら
          $year_archives_num = get_year_archives_num( $year ); //指定年の投稿数を取得
          if ( $year_archives_num > 0 ){ //指定年の投稿があったら閉じた年見出しを出力
            if ( $f_flg == true ){ //初回は閉じタグ不要&開いておく
              ?>
              <li class="p-monthlyArchive__year">
                <div class="p-monthlyArchive__yearHeading js-yearHeading">
                  <span class="p-monthlyArchive__toggleIcon js-toggleIcon open"></span><?php echo $year; ?>年 (<?php echo $year_archives_num; ?>)
                </div>
                <ul class="p-monthlyArchive__months js-months">
                  <?php
                  $f_flg = false; //1度通ったらフラグを倒しておく
                } else { //2回目以降は閉じタグ必要&閉めておく
                  ?>
                </ul>
              </li>
              <li class="p-monthlyArchive__year">
                <div class="p-monthlyArchive__yearHeading js-yearHeading">
                  <span class="p-monthlyArchive__toggleIcon js-toggleIcon"></span><?php echo $year; ?>年 (<?php echo $year_archives_num; ?>)
                </div>
                <ul class="p-monthlyArchive__months js-months hide">
                  <?php
                }
                $y_flg = false; //年見出しが出力されたら年切替フラグを倒しておく
              } else { //該当の年に投稿がなかった場合
                $year--; //1年前へ
                $month = 12; //12月へ
              }
            }
            //月アーカイブ出力
            if ( $y_flg == false ){ //年切替フラグが倒れていたら
              $month_archives_num = get_month_archives_num($year, $month); //指定年月の投稿数を取得
              if ( $month_archives_num > 0 ) { //指定年月の投稿があったらアーカイブリンクを出力
                ?>
                <li class="p-monthlyArchive__month"><a class="p-monthlyArchive__monthLink" href="<?php echo home_url('/').$year."/".str_pad($month, 2, 0, STR_PAD_LEFT); ?>"><?php echo $year."年".$month."月"; ?></a> (<?php echo $month_archives_num; ?>)</li>
                <?php
              }
              $month--; //1月前へ
              if ( $month < 1 ){ //0月になってしまったら
                $year--; //1年前へ
                $month = 12; //12月へ
                $y_flg = true; //年切替フラグを立てる
              }
            }
          }
          ?>
        </ul>
      </li>


    </ul>

  </div>
</aside>
