<?php
/* ---------------------------------------
サムネイル生成
--------------------------------------- */
// 文字列をパラメータから取得
$txt = $_GET['text'];

// 文字サイズ
$fontSize = 60;

// テキストを載せる画像
$image = imagecreatefrompng('og_base.png');

// 字体
$fontFamily = 'set-font.otf';

$txtX = $fontSize; // 文字の横位置(文字の左が基準)
$txtY = $fontSize * 2; // 文字の縦位置(文字のベースラインが基準)

$color = imagecolorallocate($image, 0, 0, 0); // テキストの色指定(RGB)

// テキストを描写
// 改行で文字列を切って行ごとに描画
//$txt = mb_wordwrap($txt,20);
$txt = mb_wordwrap2($txt,24);
$lines = explode('\n', $txt);
foreach ($lines as $n => $line) {
  $length = mb_strlen($line);
  $xpos = (1200 - ($length * $fontSize)) / 2;
  $ypos = (640 + $fontSize) / 2 - ((count($lines) - 1) * $fontSize / 2) + ($n * $fontSize);
  // 文字列ここで書く
  // リソース, フォントサイズ, 角度, x, y, 色, 文字
  imagettftext($image, $fontSize, 0, $xpos, $ypos, $color, $fontFamily, $line);
}

//imagettftext($image, $fontSize, 0, $txtX, $txtY, $color, $fontFamily, $txt);

// PNG画像として出力
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);


function mb_wordwrap( $str, $width=35, $break=PHP_EOL, $encode="UTF-8" )
{
  $c = mb_strlen($str, $encode);
  $arr = [];
  for ($i=0; $i<=$c; $i+=$width) {
    $arr[] = mb_substr($str, $i, $width, $encode);
  }
  return implode($break, $arr);
}


function mb_wordwrap2 ( $string, $width = 35, $break = PHP_EOL ) {
	$one_char_array   = mb_str_split( $string );
	$char_point_array = array_map(
		function( $char ) {
			$point = 1; // 全角
			if ( strlen( $char ) === mb_strlen( $char ) ) { // 半角
				if ( ctype_upper( $char ) ) { // アルファベット大文字
					$point = 0.7; // 全角を基準とした大きさ
				} else { // アルファベット小文字 or 記号
					$point = 0.5; // 全角を基準とした大きさ
				}
			}

			return $point;
		},
		$one_char_array
	);

	$words_array = array();
	$point_sum   = 0;
	$start       = 0;
	foreach ( $char_point_array as $index => $point ) {
		$point_sum += $point;
		if ( $point_sum >= $width ) {
			$words_array[] = mb_substr( $string, $start, $index - $start );
			$start         = $index;
			$point_sum     = 0;
		}

		if ( $index === array_key_last( $char_point_array ) ) {
			$words_array[] = mb_substr( $string, $start, count( $one_char_array ) - $start );
		}
	}

	return implode( $break, $words_array );
}
?>
