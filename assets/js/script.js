/* slick animation */
jQuery('.slider').slick({
  fade: true,
  centerMode: true,
  centerPadding: '0px',
  dots: true,
  arrows: false,
  infinite: true,
  autoplay: true,
  adaptiveHeight: true,
  autoplaySpeed: 2500,
  speed: 1000,
  pauseOnHover: false,
  // pauseOnDotsHover: false,
  // pauseOnFocus: false,
  slidesToShow: 1,
  slidesToScroll: 1,
  accessibility: true,
});

/* smooth scroll */
jQuery('a[href^="#"]').click(function () {
  // 移動先を0px調整する。0を30にすると30px下にずらすことができる。
  var adjust = 0;
  // スクロールの速度（ミリ秒）
  var speed = 100;
  // アンカーの値取得 リンク先（href）を取得して、hrefという変数に代入
  var href = jQuery(this).attr("href");
  // 移動先を取得 リンク先(href）のidがある要素を探して、targetに代入
  var target = jQuery(href == "#" || href == "" ? 'html' : href);
  // 移動先を調整 idの要素の位置をoffset()で取得して、positionに代入
  var position = target.offset().top + adjust;
  // スムーススクロール linear（等速） or swing（変速）
  jQuery('body,html').animate({ scrollTop: position }, speed, 'swing');
  return false;
});
jQuery(window).on('scroll', function () {
  if (jQuery(window).scrollTop() > 300) {
    jQuery('#js-pagetop').fadeIn(400);
  } else {
    jQuery('#js-pagetop').fadeOut(400);
  }
});

/* accodion */
// 初期設定: 最初のアーカイブを開いた状態にし、それ以外は閉じる
//jQuery('.js-months').hide(); // すべて閉じる
jQuery('.js-monthlyArchive__year').first().find('.js-months').show(); // 最初の要素だけ開く
jQuery('.js-monthlyArchive__year').first().find('.js-toggleIcon').addClass('open'); // アイコンも開いた状態に

jQuery('.js-yearHeading').click(function () {
  const $clickedMonths = jQuery(this).next('.js-months'); // クリックされた年の月リスト

  if ($clickedMonths.is(':visible')) {
    // 既に開いている場合は閉じる
    $clickedMonths.stop(true, true).slideUp(300);
    jQuery(this).find('.js-toggleIcon').removeClass('open');
  } else {
    // 他の開いている部分を閉じる
    jQuery('.js-months:visible').stop(true, true).slideUp(300);
    jQuery('.js-toggleIcon').removeClass('open');

    // クリックした部分を開く
    $clickedMonths.stop(true, true).slideDown(300);
    jQuery(this).find('.js-toggleIcon').addClass('open');
  }
});


/* grobal-nav */
jQuery(".l-nav__hamburger").click(function () {//ボタンがクリックされたら
  jQuery(this).toggleClass('active');//ボタン自身に activeクラスを付与し
  jQuery("#js-global-nav").toggleClass('js-panelActive');//ナビゲーションにpanelactiveクラスを付与
  jQuery(".l-nav__bg").toggleClass('js-circleActive');//丸背景にcircleactiveクラスを付与
  if (jQuery(this).hasClass('active')) {
    jQuery("body").css({ 'height': '100%', 'overflow': 'hidden' });
  } else {
    jQuery("body").css({ 'height': '', 'overflow': '' });
  }
});

jQuery("#js-global-nav a").click(function () {//ナビゲーションのリンクがクリックされたら
  jQuery(".openbtn").removeClass('active');//ボタンの activeクラスを除去し
  jQuery("#js-global-nav").removeClass('js-panelActive');//ナビゲーションのpanelactiveクラスを除去
  jQuery(".l-nav__bg").removeClass('js-circleActive');//丸背景のcircleactiveクラスを除去
});


/* footer-wave */
var unit = 100,
  canvasList, // キャンバスの配列
  info = {}, // 全キャンバス共通の描画情報
  colorList; // 各キャンバスの色情報

/**
 * Init function.
 *
 * Initialize variables and begin the animation.
 */
function init() {
  info.seconds = 0;
  info.t = 0;
  canvasList = [];
  colorList = [];
  // canvas1個めの色指定
  canvasList.push(document.getElementById("waveCanvas"));
  colorList.push(['#ccc', '#efefef', '#efefef']);//重ねる波の色設定 #333', '#666', '#111
  // 各キャンバスの初期化
  for (var canvasIndex in canvasList) {
    var canvas = canvasList[canvasIndex];
    canvas.width = document.documentElement.clientWidth; //Canvasのwidthをウィンドウの幅に合わせる
    canvas.height = 200;//波の高さ
    canvas.contextCache = canvas.getContext("2d");
  }
  // 共通の更新処理呼び出し
  update();
}

function update() {
  for (var canvasIndex in canvasList) {
    var canvas = canvasList[canvasIndex];
    // 各キャンバスの描画
    draw(canvas, colorList[canvasIndex]);
  }
  // 共通の描画情報の更新
  info.seconds = info.seconds + .014;
  info.t = info.seconds * Math.PI;
  // 自身の再起呼び出し
  setTimeout(update, 35);
}

/**
 * Draw animation function.
 *
 * This function draws one frame of the animation, waits 20ms, and then calls
 * itself again.
 */
function draw(canvas, color) {
  // 対象のcanvasのコンテキストを取得
  var context = canvas.contextCache;
  // キャンバスの描画をクリア
  context.clearRect(0, 0, canvas.width, canvas.height);

  //波の重なりを描画 drawWave(canvas, color[数字（波の数を0から数えて指定）], 透過, 波の幅のzoom,波の開始位置の遅れ )
  drawWave(canvas, color[0], 0.5, 3, 0);//0.5⇒透過具合50%、3⇒数字が大きいほど波がなだらか
  drawWave(canvas, color[1], 0.4, 2, 250);
  drawWave(canvas, color[2], 0.2, 1.6, 100);
}

/**
* 波を描画
* drawWave(色, 不透明度, 波の幅のzoom, 波の開始位置の遅れ)
*/
function drawWave(canvas, color, alpha, zoom, delay) {
  var context = canvas.contextCache;
  context.fillStyle = color;//塗りの色
  context.globalAlpha = alpha;
  context.beginPath(); //パスの開始
  drawSine(canvas, info.t / 0.5, zoom, delay);
  context.lineTo(canvas.width + 10, canvas.height); //パスをCanvasの右下へ
  context.lineTo(0, canvas.height); //パスをCanvasの左下へ
  context.closePath() //パスを閉じる
  context.fill(); //波を塗りつぶす
}

/**
 * Function to draw sine
 *
 * The sine curve is drawn in 10px segments starting at the origin.
 * drawSine(時間, 波の幅のzoom, 波の開始位置の遅れ)
 */
function drawSine(canvas, t, zoom, delay) {
  var xAxis = Math.floor(canvas.height / 2);
  var yAxis = 0;
  var context = canvas.contextCache;
  // Set the initial x and y, starting at 0,0 and translating to the origin on
  // the canvas.
  var x = t; //時間を横の位置とする
  var y = Math.sin(x) / zoom;
  context.moveTo(yAxis, unit * y + xAxis); //スタート位置にパスを置く

  // Loop to draw segments (横幅の分、波を描画)
  for (i = yAxis; i <= canvas.width + 10; i += 10) {
    x = t + (-yAxis + i) / unit / zoom;
    y = Math.sin(x - delay) / 3;
    context.lineTo(i, unit * y + xAxis);
  }
}

init();
