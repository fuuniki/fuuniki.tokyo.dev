<html lang="ja">
<head prefix="og:http://ogp.me/ns#">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php if ( is_home() || is_front_page() ) : ?>fuuniki.tokyo | Travel and Photo Blog<?php else : ?><?php wp_title('', true, 'right'); ?><?php endif; ?></title>
<meta name="description" content="旅で訪れた場所を写真とともに紹介します。">
<meta name="keywords" content="旅行,旅,写真,ブログ">
<meta name="robots" content="index, follow">
<meta name="viewport" content="width=device-width, initial-scale=1.0" >
<meta name="format-detection" content="telephone=no">

<!-- ogp -->
<meta property="og:title" content="<?php if ( is_home() || is_front_page() ) : ?>fuuniki.tokyo | Travel and Photo Blog<?php else : ?><?php wp_title('', true, 'right'); ?><?php endif; ?>">
<meta property="og:description" content="旅で訪れた場所を写真とともに紹介します。">
<?php if ( is_home() || is_front_page() ) : ?>
<meta property="og:url" content="https://www.fuuniki.tokyo">
<?php else : ?>
<meta property="og:url" content="<?php echo get_current_link();?>">
<?php endif; ?>

<?php if ( is_single() && has_post_thumbnail() ) : ?>
<!-- 記事に設定されているアイキャッチ画像のOGP -->
<meta property="og:image" content="<?php the_post_thumbnail_url() ?>">
<?php elseif ( is_single() ) : ?>
<!-- 生成されたOGP -->
<meta property="og:image" content="<?php echo get_template_directory_uri() ?>/assets/img/og/image.php?text=<?php the_title(); ?>">
<?php else : ?>
<!-- デフォルトOGP -->
<meta property="og:image" content="<?php echo get_template_directory_uri() ?>/assets/img/og/og_base.png">
<?php endif; ?>

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?php echo get_bloginfo('name');?>">

<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@fuuniki">

<!--ファビコンやブックマークアイコンの指定-->
<link rel="SHORTCUT ICON" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png" />
<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/android-chrome-192x192.png">

<?php if ( is_home() || is_front_page() ) : ?>
<meta name="thumbnail" content="<?php echo get_template_directory_uri() ?>/assets/img/mainvisual/mv_01.jpg" />
<?php elseif ( is_single() && has_post_thumbnail() ) : ?>
<!-- 記事に設定されているサムネイル -->
<meta name="thumbnail" content="<?php the_post_thumbnail_url() ?>" />
<?php elseif ( is_single() ) : ?>
<!-- 生成されたサムネイル -->
<meta name="thumbnail" content="<?php echo get_template_directory_uri() ?>/assets/img/og/image.php?text=<?php the_title(); ?>" />
<?php else : ?>
<meta name="thumbnail" content="" />
<?php endif; ?>



<!-- css -->
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/assets/css/destyle.css">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/assets/css/base.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">

<!-- js library -->
<!--
<script src="//code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/2.1.1/TweenMax.min.js"></script>
<script src="bodyScrollLock.min.js" type="text/javascript"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
-->
<link href="//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" rel="stylesheet" >

<?php wp_head(); ?>
</head>

<body>

<div class="l-wrapper">

<header class="l-header">
        <div class="l-inner">
          <div class="l-header__content">
            <a class="l-header__logo" href="<?php echo get_home_url();?>">
              <div class="l-header__site-title"><?php echo get_bloginfo('name');?></div>
              <p class="l-header__site-description">Travel and Photo Blog</p>
            </a>
            <div class="l-nav__hamburger">
              <span class="l-nav__hamburgerLine"></span>
              <span class="l-nav__hamburgerLine"></span>
              <span class="l-nav__hamburgerLine"></span>
            </div>
          </div>

          <nav class="l-nav" id="js-global-nav">
            <ul class="l-nav__list">
              <li class="l-nav__item"><a href="<?php echo get_home_url();?>">HOME</a></li>
              <li class="l-nav__item"><a href="<?php echo get_home_url();?>/profile/">Profile</a></li>
              <li class="l-nav__item"><a href="<?php echo get_home_url();?>/article-list/">Article List</a></li>
              <li class="l-nav__item"><a href="<?php echo get_home_url();?>/privacy-policy/">Privacy Policy</a></li>
            </ul>
            <div class="l-nav__bg"></div>
          </nav>

        </div>
      </header>
