
<div class="wave">
<canvas id="waveCanvas"></canvas>
</div>

<footer class="l-footer">

        <div class="l-inner">
          <?php if ( is_home() || is_front_page() || is_page('profile')) : ?>
            <div class="p-banner">
              <div class="l-inner">
                <ul class="p-banner__list">
                  <li class="p-banner__item">
                    <a href="https://www.instagram.com/fuuniki/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/banner/insta.jpg" alt=""></a>
                  </li>
                  <li class="p-banner__item">
                    <a href="https://www.amazon.co.jp/hz/wishlist/ls/KZ645U1XPMRY?ref_=list_d_wl_lfu_nav_1&viewType=grid" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/banner/amazon.jpg" alt=""></a>
                  </li>
                  <li class="p-banner__item">
                    <a href="https://www.twitch.tv/fuuniki" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/banner/twitch.jpg" alt=""></a>
                  </li>
                </ul>
              </div>
            </div>
          <?php endif; ?>

          <div class="l-footer__content">
            <ul class="l-footer__nav">
              <li class="l-footer__navItem"><a href="<?php echo get_home_url();?>/profile/">プロフィール</a></li>
              <li class="l-footer__navItem"><a href="<?php echo get_home_url();?>/privacy-policy/">プライバシーポリシー</a></li>
            </ul>
            <small class="l-footer__copylight">© <?php echo get_bloginfo('name');?></small>
          </div>
        </div>
      </footer>

      <div class="c-pagetop" id="js-pagetop">
        <a class="c-pagetop__button" href="#"></a>
      </div>

      </div>

      <!-- js -->
      <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/2.1.1/TweenMax.min.js"></script>
      <script src="bodyScrollLock.min.js" type="text/javascript"></script>
      <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri();?>/assets/js/script.js" charset="UTF-8" async defer></script>

    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/assets/css/custom.css">


<?php wp_footer(); ?>
</body>
</html>
