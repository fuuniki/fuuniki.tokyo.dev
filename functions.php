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
クイックタグを追加する
--------------------------------------- */
function appthemes_add_quicktags() {
  if (wp_script_is('quicktags')){
    wp_enqueue_script( 'my-quicktags', get_template_directory_uri(). '/assets/js/my-quicktags.js', array(), 'v1.0.0', true );
  }
}
add_action( 'admin_print_footer_scripts', 'appthemes_add_quicktags' );
