<?php
/* ---------------------------------------
テーマ内でよく使う処理
--------------------------------------- */
//wp_head()で出力される内容にCSS読み込み設定を記述します。複数のスタイルシートを設定したい場合など、都度HTMLの<head>〜</head>に記述しなくてよく管理上便利です。
function register_stylesheet() {
 wp_register_style('style', get_stylesheet_directory_uri().'/style.css');
}
function add_stylesheet() {
 register_stylesheet();
 wp_enqueue_style('style', '', array(), '1.0', false);
}
add_action('wp_enqueue_scripts', 'add_stylesheet');


function change_wp_title_of_date_archive( $title )
{
    if ( is_date() ) {
        if (is_year()) {
            $title = the_time("Y年");
        } elseif (is_month()) {
            $title = the_time("Y年n月");
        } else {
            $title = the_time("Y年n月j日");
        }

        $title .= ' | ';
    }

    return $title;
}
add_filter('wp_title', 'change_wp_title_of_date_archive', 1);


/* ---------------------------------------
ウィジェットの有効化・設定
--------------------------------------- */
//ウィジェットを作成し、管理画面で設定できるようにします。
//また、各ウィジェットをくくるHTMLタグなども指定できます。
//表示にはテーマテンプレート内でdynamic_sidebar()に設定したidを指定します。
function theme_slug_widgets_init() {
register_sidebar(array(
	 'name' => 'サイドナビ',
	 'id' => 'sidenavi' ,
	 'before_widget' => '<div class="side_widget">',
	 'after_widget' => '</div>',
	 'before_title' => '<h2 class="side_widget_title">',
	 'after_title' => '</h2>'
));
register_sidebar(array(
	 'name' => 'フッター',
	 'id' => 'footerwidget' ,
	 'before_widget' => '<div class="footer_widget">',
	 'after_widget' => '</div>',
	 'before_title' => '<h2 class="footer_widget_title">',
	 'after_title' => '</h2>'
));
}
add_action( 'widgets_init', 'theme_slug_widgets_init' );

/* ---------------------------------------
メニューの設定
--------------------------------------- */
//'ロケーションID名' => '管理画面での表示名' となっています。
//ヘッダー用・フッター用の2箇所に設定するメニュー例です。管理画面＞外観＞メニューでメニューを作成後、メニューの位置で下記の設定が選択できるようになっています。
//表示にはテーマテンプレート内でwp_nav_menu()に設定したロケーションIDを指定します。
function menu_setup() {
  register_nav_menus( array(
    'global' => 'グローバルメニュー',
    'footer' => 'フッターメニュー'
  ) );
}
add_action( 'after_setup_theme', 'menu_setup' );

/* ---------------------------------------
ショートコードの設定
--------------------------------------- */
//サイトアドレスURLを取得
//テスト環境と本番環境が異なる場合など画像URLをこちらで設定しておくと後で書き換え不要で便利
function shortcode_url() {
    return get_home_url();
}
add_shortcode('url', 'shortcode_url');

//wordpressアドレスURLを取得
//サイトアドレスと別の場合、こちらも設定しておくと便利
function shortcode_siteurl() {
    return site_url();
}
add_shortcode('site_url', 'shortcode_siteurl');

//テーマのURLを取得
//テーマ内にある画像の出力等したい場合、都度フルパスを書く必要がなくなるため便利
function shortcode_templateurl() {
    return get_stylesheet_directory_uri();
}
add_shortcode('thema_url', 'shortcode_templateurl');

// アイキャッチ有効
add_theme_support('post-thumbnails');

//アイキャッチをトリミング
//サイドバー
add_image_size('side-thumb', 750, 225,true);
//トップ, アーカイブ
add_image_size('top-thumb', 600, 320,true);
add_image_size('square', 500, 500,true);

//jQuery有効化
function my_scripts(){
  wp_enqueue_script( 'jquery' );
  if(is_single()){
    wp_enqueue_style( 'flexslider-css', get_template_directory_uri() . '/assets/css/flexslider.css');
    wp_enqueue_script( 'flexslider-js', get_template_directory_uri() . '/assets/js/jquery.flexslider-min.js', array(), '2.2.2', true);
  }
}
add_action( 'wp_enqueue_scripts', 'my_scripts');


/* ---------------------------------------
アーカイブ（サイドバー）
--------------------------------------- */
// 指定年の投稿数を取得
function get_year_archives_num( $year ) {
  global $wpdb;
  $cnt = $wpdb->get_var(
    "SELECT count(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND DATE_FORMAT(post_date, '%Y') = '".$year."';"
  );
  return $cnt;
}
// 指定年月の投稿数を取得
function get_month_archives_num( $year, $month ) {
  global $wpdb;
  $cnt = $wpdb->get_var(
    "SELECT count(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND DATE_FORMAT(post_date, '%Y%m') = '".$year.str_pad($month, 2, 0, STR_PAD_LEFT)."';"
  );
  return $cnt;
}
// 一番古い記事の年を取得
function get_oldest_year() {
  global $wpdb;
  $oldest_date = $wpdb->get_var(
    "SELECT post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date ASC LIMIT 1;"
  );
  return idate('Y', strtotime($oldest_date) ); //投稿日の年だけ数値で取得
}
//文字数を限定する
function twpp_adjacent_post_link( $previous = true, $max_length = 10, $trim_marker = '...' ) {
  $html = '';
  $post = get_adjacent_post( false, '', $previous );

  if( !empty( $post ) ) {
    $title = apply_filters( 'the_title', $post->post_title );

    if( mb_strlen( $title ) > $max_length ) {
      $title = mb_substr( $title, 0, $max_length ) . $trim_marker;
    }

    $html .= sprintf(
      '<a href="%s">%s</a>',
      esc_url( get_permalink( $post->ID ) ),
      $title
    );

    echo $html;
  }
}

/* ---------------------------------------
現在のURLを取得
--------------------------------------- */
function get_current_link() {
  return (is_ssl() ? 'https' : 'http') . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
}

/* ---------------------------------------
JSON-LDによる構造化データの追加
--------------------------------------- */
//TOPページ
function add_json_ld_for_home_page() {
    if (is_front_page() || is_home()) {  // トップページまたはブログ一覧ページの場合
        $json_ld = array(
            "@context" => "https://schema.org",
            "@type" => "WebSite",
            "name" => get_bloginfo('name'),
            "url" => home_url(),
            "logo" => get_site_icon_url(),
            "publisher" => array(
                "@type" => "Organization",
                "name" => get_bloginfo('name'),
                "logo" => get_site_icon_url()
            )
        );

        // JSON-LDをページに埋め込む
        echo '<script type="application/ld+json">' . json_encode($json_ld) . '</script>';
    }
}
add_action('wp_head', 'add_json_ld_for_home_page');

//カテゴリ
function add_json_ld_for_category_archive() {
    if (is_category()) {  // カテゴリアーカイブの場合
        $category = get_queried_object();  // 現在のカテゴリーを取得
        $posts = get_posts(array(
            'category' => $category->term_id,
            'posts_per_page' => 5  // 上位5件の記事を取得
        ));
        
        $items = array();
        foreach ($posts as $post) {
            $items[] = array(
                "@type" => "ListItem",
                "position" => count($items) + 1,
                "url" => get_permalink($post->ID),
                "name" => get_the_title($post->ID)
            );
        }

        $json_ld = array(
            "@context" => "https://schema.org",
            "@type" => "ItemList",
            "name" => 'Category Archive: ' . single_cat_title('', false),
            "url" => get_category_link($category->term_id),
            "itemListElement" => $items
        );

        // JSON-LDをページに埋め込む
        echo '<script type="application/ld+json">' . json_encode($json_ld) . '</script>';
    }
}
add_action('wp_head', 'add_json_ld_for_category_archive');

//タグ
function add_json_ld_for_tag_archive() {
    if (is_tag()) {  // タグアーカイブの場合
        $tag = get_queried_object();  // 現在のタグを取得
        $posts = get_posts(array(
            'tag' => $tag->slug,
            'posts_per_page' => 5  // 上位5件の記事を取得
        ));
        
        $items = array();
        foreach ($posts as $post) {
            $items[] = array(
                "@type" => "ListItem",
                "position" => count($items) + 1,
                "url" => get_permalink($post->ID),
                "name" => get_the_title($post->ID)
            );
        }

        $json_ld = array(
            "@context" => "https://schema.org",
            "@type" => "ItemList",
            "name" => 'Tag Archive: ' . single_tag_title('', false),
            "url" => get_tag_link($tag->term_id),
            "itemListElement" => $items
        );

        // JSON-LDをページに埋め込む
        echo '<script type="application/ld+json">' . json_encode($json_ld) . '</script>';
    }
}
add_action('wp_head', 'add_json_ld_for_tag_archive');

function custom_yoast_seo_category_schema( $data ) {
    // カテゴリーページの場合
    if (is_category()) {
        $data['name'] = single_cat_title('', false) . ' の投稿';
    }

    return $data;
}
add_filter( 'wpseo_json_ld_output', 'custom_yoast_seo_category_schema' );

// パンくずリストの日付形式をカスタマイズ
function custom_yoast_breadcrumb_date_format($crumbs) {
    // アーカイブページの日付取得
    if (is_archive() && (is_month() || is_day())) {
        $year = get_query_var('year');
        $month = get_query_var('monthnum');
        
        // 月を2桁形式に変換
        $month_num = str_pad((int)$month, 2, '0', STR_PAD_LEFT);
        
        // 新しい形式： 2025年02月
        $formatted_date = $year . '年' . $month_num . '月';

        // パンくずリストの年月部分を変更
        foreach ($crumbs as $key => $crumb) {
            if (isset($crumb['text']) && preg_match('/\d{1,2}月 \d{4}/', $crumb['text'])) {
                $crumbs[$key]['text'] = $formatted_date;
            }
        }
    }
    return $crumbs;
}
add_filter('wpseo_breadcrumb_links', 'custom_yoast_breadcrumb_date_format');



/* ***************************************
* 投稿画面
*************************************** */

/* ---------------------------------------
クイックタグを追加する
--------------------------------------- */
function appthemes_add_quicktags() {
  if (wp_script_is('quicktags')){
    wp_enqueue_script( 'my-quicktags', get_template_directory_uri(). '/assets/js/my-quicktags.js', array(), 'v1.0.0', true );
  }
}
add_action( 'admin_print_footer_scripts', 'appthemes_add_quicktags' );

/* ---------------------------------------
ブログカード
--------------------------------------- */
/* リンクをカード形式で表示するための関数 */
function show_Linkcard($atts) {
  extract(shortcode_atts(array(
    'url'=>"",
    'title'=>"",
    'excerpt'=>""
  ),$atts));

  //OGP情報を取得
  require_once 'OpenGraph.php';
  $graph = OpenGraph::fetch($url);

  //OGPタグからタイトルを取得
  $Link_title = $graph->title;
  $src        = $graph->image;

  //OGPタグからdescriptionを取得
  $Link_description = wp_trim_words($graph->description, 40, '…' );
  if(!empty($excerpt)){
    $Link_description = $excerpt;//値を取得できない時場合は直にexcerpt=""を入力
  }

  $xLink_img = '<img src="'. $src .'" />';

  //文字化け回避
  $detects = array(
   'ASCII','EUC-JP','SJIS', 'JIS', 'CP51932','UTF-16', 'ISO-8859-1'
  );

  // タイトルの文字化け回避
  $title_check = utf8_decode($Link_title);
  if(mb_detect_encoding($title_check) == 'UTF-8'){
      $Link_title = $title_check;
  }
  if(mb_detect_encoding($Link_title) != 'UTF-8'){
      $Link_title = mb_convert_encoding($Link_title, 'UTF-8', mb_detect_encoding($Link_title, $detects, true));
  }

  // descriptionの文字化け回避
 $description_check = utf8_decode($Link_description);
 if(mb_detect_encoding($description_check) == 'UTF-8'){
     $Link_description = $description_check;
 }
 if(mb_detect_encoding($Link_description) != 'UTF-8'){
     $Link_description = mb_convert_encoding($Link_description, 'UTF-8', mb_detect_encoding($Link_description, $detects, true));
 }

  //HTML出力
  $sc_Linkcard ='';
  $sc_Linkcard .='
  <div class="EmbedBaseLinkCard">
    <a href="'. $url .'" class="EmbedBaseLinkCard__link">
      <div class="EmbedBaseLinkCard__main">
        <div class="EmbedBaseLinkCard__title">'. $Link_title .'</div>
        <div class="EmbedBaseLinkCard__description">'. $Link_description .'</div>
        <div class="EmbedBaseLinkCard__meta">'. $url .'</div>
      </div>
      <div class="EmbedBaseLinkCard__thumbnail">'. $xLink_img .'</div>
    </a>
  </div>
  ';

  return $sc_Linkcard;
}
//関数利用時のフォーマット
add_shortcode("sc_Linkcard", "show_Linkcard");

/* リンクをカード形式で表示するための関数2 */
function show_LinkcardEx($atts) {
  extract(shortcode_atts(array(
    'url'=>"",
    'title'=>"",
    'excerpt'=>""
  ),$atts));

  //OGP情報を取得
  require_once 'OpenGraph.php';
  $graph = OpenGraph::fetch($url);

  //OGPタグからタイトルを取得
  $Link_title = $graph->title;
  $src        = $graph->image;

  //OGPタグからdescriptionを取得
  $Link_description = wp_trim_words($graph->description, 40, '…' );
  if(!empty($excerpt)){
    $Link_description = $excerpt;//値を取得できない時場合は直にexcerpt=""を入力
  }

  $xLink_img = '<img src="'. $src .'" />';

  //文字化け回避
  $detects = array(
   'ASCII','EUC-JP','SJIS', 'JIS', 'CP51932','UTF-16', 'ISO-8859-1'
  );

  // タイトルの文字化け回避
  $title_check = utf8_decode($Link_title);
  if(mb_detect_encoding($title_check) == 'UTF-8'){
      $Link_title = $title_check;
  }
  if(mb_detect_encoding($Link_title) != 'UTF-8'){
      $Link_title = mb_convert_encoding($Link_title, 'UTF-8', mb_detect_encoding($Link_title, $detects, true));
  }

  // descriptionの文字化け回避
 $description_check = utf8_decode($Link_description);
 if(mb_detect_encoding($description_check) == 'UTF-8'){
     $Link_description = $description_check;
 }
 if(mb_detect_encoding($Link_description) != 'UTF-8'){
     $Link_description = mb_convert_encoding($Link_description, 'UTF-8', mb_detect_encoding($Link_description, $detects, true));
 }

  //HTML出力
  $sc_Linkcard ='';
  $sc_Linkcard .='
  <div class="EmbedBaseLinkCard">
    <a href="'. $url .'" class="EmbedBaseLinkCard__link" target="_blank">
      <div class="EmbedBaseLinkCard__main">
        <div class="EmbedBaseLinkCard__title">'. $Link_title .'</div>
        <div class="EmbedBaseLinkCard__description">'. $Link_description .'</div>
        <div class="EmbedBaseLinkCard__meta">'. $url .'</div>
      </div>
      <div class="EmbedBaseLinkCard__thumbnail">'. $xLink_img .'</div>
    </a>
  </div>
  ';

  return $sc_Linkcard;
}
//関数利用時のフォーマット
add_shortcode("sc_LinkcardEx", "show_LinkcardEx");

/* ---------------------------------------
目次を追加する
--------------------------------------- */
function add_index( $content ) {
	if ( is_single() ) {
		$pattern = '/<h[1-3]>(.+?)<\/h[1-3]>/s';
		preg_match_all( $pattern, $content, $elements, PREG_SET_ORDER );

		if ( count( $elements ) >= 1 ) {
			$toc          = '';
			$i            = 0;
			$currentlevel = 0;
			$id           = 'chapter-';

			foreach ( $elements as $element ) {
				$id           .= $i + 1;
				$regex         = '/' . preg_quote( $element[0], '/' ) . '/su';
				$replace_title = preg_replace( '/<(h[1-3])>(.+?)<\/(h[1-3])>/s', '<$1 id="' . $id . '">$2</$3>', $element[0], 1 );
				$content       = preg_replace( $regex, $replace_title, $content, 1 );

				if ( strpos( $element[0], '<h2' ) !== false ) {
					$level = 1;
				} elseif ( strpos( $element[0], '<h3' ) !== false ) {
					$level = 2;
				} elseif ( strpos( $element[0], '<h4' ) !== false ) {
					$level = 3;
				} elseif ( strpos( $element[0], '<h5' ) !== false ) {
					$level = 4;
				} elseif ( strpos( $element[0], '<h6' ) !== false ) {
					$level = 5;
				}

				while ( $currentlevel < $level ) {
					if ( 0 === $currentlevel ) {
						$toc .= '<ol class="p-article__indexList">';
					} else {
						$toc .= '<ol class="p-article__indexList--child">';
					}
					$currentlevel++;
				}

				while ( $currentlevel > $level ) {
					$toc .= '</li></ol>';
					$currentlevel--;
				}

				// 目次の項目で使用する要素を指定
				$toc .= '<li class="p-article__indexItem"><a href="#' . $id . '" class="p-article__indexLink">' . $element[1] . '</a>';
				$i++;
				$id = 'chapter-';
			} // foreach

			// 目次の最後の項目をどの要素から作成したかによりタグの閉じ方を変更
			while ( $currentlevel > 0 ) {
				$toc .= '</li></ol>';
				$currentlevel--;
			}

			$index = '<div class="p-article__index" id="toc"><div class="p-article__indexTitle">目次</div>' . $toc . '</div>';
			$h2    = '/<h2.*?>/i';

			if ( preg_match( $h2, $content, $h2s ) ) {
				$content = preg_replace( $h2, $index . $h2s[0], $content, 1 );
			}
		}
	}
	return $content;
}
add_filter( 'the_content', 'add_index' );

/* ***************************************
* 管理画面上の機能 
*************************************** */

/* ---------------------------------------
管理画面内の設定
--------------------------------------- */
//プロフィール欄HTMLタグ有効
remove_filter('pre_user_description', 'wp_filter_kses');

// カテゴリ説明文HTML有効
remove_filter( 'pre_term_description', 'wp_filter_kses' );

//カテゴリ説明欄HTMLタグ有効
remove_filter( 'pre_term_name', 'wp_filter_kses' );

//faviconの設定
function admin_favicon() {
 echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_template_directory_uri().'/favicon.ico" />';
}
add_action('admin_head', 'admin_favicon');

/* ---------------------------------------
WordPressの投稿一覧にアクセス数を表示
--------------------------------------- */
// ページビュー数のカウンターのセット
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
// ページビュー数を取得する
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
// 管理画面に閲覧数項目を追加する
add_filter( 'manage_pages_columns', 'count_add_column' );
add_filter( 'manage_posts_columns', 'count_add_column' );
function count_add_column( $columns ) {
    $columns['views'] = '閲覧数';
    return $columns;
}

// 管理画面にページビュー数を表示する
add_action( 'manage_pages_custom_column' , 'count_add_column_data', 10, 2 );
add_action( 'manage_posts_custom_column' , 'count_add_column_data', 10, 2 );
function count_add_column_data( $column, $post_id ) {
    switch ( $column ) {
        case 'views' :
                        echo getPostViews($post_id);
            break;
    }
}

// 閲覧数項目を並び替えれる要素にする
add_filter( 'manage_edit-page_sortable_columns', 'column_views_sortable' );
add_filter( 'manage_edit-post_sortable_columns', 'column_views_sortable' );
function column_views_sortable( $newcolumn ) {
    $columns['views'] = 'views';
    return $columns;
}

// ページビュー数で並び替えるようにリクエストを送る
add_filter( 'request', 'sort_views_column' );
function sort_views_column( $vars )
{
    if ( isset( $vars['orderby'] ) && 'views' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'post_views_count', //Custom field key
            'orderby' => 'meta_value_num') //Custom field value (number)
        );
    }
    return $vars;
}

// 記事のPVをカウントする
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/* ---------------------------------------
記事のアクセス数（ページビュー数）を計測（WordPress Popular Posts）
--------------------------------------- */
/* 管理画面にPV数を表示 */
if(function_exists('wpp_get_views')){

    add_filter('manage_posts_columns', function($columns){
            $columns['view'] = "View";
            return $columns;
    });

    add_action('manage_posts_custom_column',function($column_name, $post_id){
        if($column_name == 'view'){
        echo '日：', wpp_get_views ( get_the_ID(), 'daily' );
        echo "<br />";
        echo '週：', wpp_get_views ( get_the_ID(), 'weekly' );
        echo "<br />";
        echo '月：', wpp_get_views ( get_the_ID(), 'monthly' );
        echo "<br />";
        echo '全：', wpp_get_views ( get_the_ID(), 'all' );
        }
    },10,2);

}

/* ---------------------------------------
投稿画面に「撮影日」フィールドを追加
--------------------------------------- */
// 撮影日メタボックスを追加
function add_photo_date_meta_box() {
    add_meta_box(
        'photo_date_meta_box',       // メタボックスID
        '撮影日',                    // メタボックスのタイトル
        'display_photo_date_meta_box', // コールバック関数
        'post',                      // 投稿タイプ（投稿に追加）
        'side',                      // 表示場所（サイドメニュー）
        'default'                    // 優先度
    );
}
add_action('add_meta_boxes', 'add_photo_date_meta_box');

// 撮影日メタボックスの表示内容
function display_photo_date_meta_box($post) {
    $photo_date = get_post_meta($post->ID, '_photo_date', true);
    wp_nonce_field(basename(__FILE__), 'photo_date_nonce'); // セキュリティのためのノンスフィールド
    ?>
    <label for="photo_date">撮影日を選択:</label>
    <input type="date" id="photo_date" name="photo_date" value="<?php echo esc_attr($photo_date); ?>" style="width: 100%;">
    <?php
}

// 撮影日データを保存
function save_photo_date_meta($post_id) {
    // セキュリティチェック
    if (!isset($_POST['photo_date_nonce']) || !wp_verify_nonce($_POST['photo_date_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // 自動保存時は処理を中断
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // 権限チェック
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // 撮影日を保存
    $new_photo_date = (isset($_POST['photo_date']) ? sanitize_text_field($_POST['photo_date']) : '');
    update_post_meta($post_id, '_photo_date', $new_photo_date);
}
add_action('save_post', 'save_photo_date_meta');

//撮影日のカスタムクエリを追加
function filter_posts_by_photo_date($query) {
    if (!is_admin() && $query->is_main_query() && get_query_var('photo_date')) {
        $photo_date = sanitize_text_field(get_query_var('photo_date'));
        $query->set('meta_key', '_photo_date');
        $query->set('meta_value', $photo_date);
        $query->set('meta_compare', 'LIKE');  // 撮影日の部分一致で検索
    }
}
add_action('pre_get_posts', 'filter_posts_by_photo_date');

function add_photo_date_query_var($vars) {
    $vars[] = 'photo_date';  // クエリ変数を追加
    return $vars;
}
add_filter('query_vars', 'add_photo_date_query_var');

function add_photo_date_rewrite_rule() {
    add_rewrite_rule(
        '^photo/([0-9]{4})/([0-9]{2})/?$', // URL構造 /photo/2025/02/
        'index.php?photo_date=$1-$2',      // 内部的には ?photo_date=2025-02 と同じ扱いに
        'top'
    );
}
add_action('init', 'add_photo_date_rewrite_rule');

function load_archive_template_for_photo_date($template) {
    if (get_query_var('photo_date')) {
        // 撮影日クエリがある場合、archive.php を使用
        return locate_template('archive.php');
    }
    return $template;
}
add_filter('template_include', 'load_archive_template_for_photo_date');