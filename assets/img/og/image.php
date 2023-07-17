<?php

/** GET パラメータから値を得ます。undefined やキーだけ渡された時の対策を関数化しています */
function setGetDef(string $key, string $def)
{
   if (isset($_GET[$key]) && $_GET[$key] !== '') {
       return $_GET[$key];
   }

   return $def;
}

// 書き込むテキストをGETパラメータから得ます
$text        = setGetDef('text', 'テスト文字列');
$imageWidth  = 1200;
$imageHeight = 640;
// 画像を生成します
//$image = imagecreate($imageWidth, $imageHeight);
$image = imagecreatefrompng('og_base.png');

// 背景色セット（最初の imagecolorallocate は背景色セットになります）
// @see https://www.php.net/manual/ja/function.imagecolorallocate.php
imagecolorallocate($image, 255, 255, 255);
// テキスト色セット（2 回目以降の imagecolorallocate は独立した色情報になります）
// @see https://www.php.net/manual/ja/function.imagecolorallocate.php
$textColor = imagecolorallocate($image, 0, 0, 0);

$size   = 60; // 文字サイズ
$angle  = 0; // 文字回転角度。斜めに文字を置くときに 0 以外にします
$font   = 'set-font.otf'; // フォントファイルへのパス
$MarginX=50;//横方向マージン
$MarginY=50;//縦方向マージン
$text   = imageWordwrap($size, $angle, $font, $text, $imageWidth - ($size + $MarginX)*2);
$textWH = getTextSize($size, $angle, $font, $text);
// 一行目の高さ
$firstLineHeight = getTextSize($size, $angle, $font, explode("\n", $text)[0])['height'];

// 上下左右中央に文字列を描画します
// @see https://www.php.net/manual/ja/function.imagettftext.php
imagettftext(
   $image, // 画像リソース
   $size, // 文字サイズ
   $angle, // 文字回転角度。斜めに文字を置くときに 0 以外にします
   ($imageWidth - $textWH['width']) / 2, // 画像左端を 0 とした文字列左端の X 座標
    ($imageHeight - $textWH['height']) / 2 + $firstLineHeight, // 画像上端を 0 とした文字列一行目下端の Y 座標
   $textColor, // テキスト色
   $font,// フォントファイルへのパス
   $text
);

// 画像を出力します
// @see https://www.php.net/manual/ja/function.header.php
header('Content-type: image/png');
// @see https://www.php.net/manual/ja/function.imagepng.php
imagepng($image);

/**
* @param  int    $size  文字サイズ
* @param  int    $angle 角度
* @param  string $font  フォントファイルへのパス
* @param  string $text  高さと幅を知りたい文字列
* @return array  高さと幅を格納した連想配列
*/
function getTextSize(int $size, int $angle, string $font, string $text): array
{
   // @see https://www.php.net/manual/ja/function.imagettfbbox.php
   $boundingBox = imagettfbbox($size, $angle, $font, $text);

   return [
       'width'  => $boundingBox[2] - $boundingBox[0],
       'height' => $boundingBox[1] - $boundingBox[7],
   ];
}

/**
 * 画像の幅で折り返し
 * @param  int    $size       文字サイズ
 * @param  int    $angle      角度
 * @param  string $font       フォントファイルへのパス
 * @param  string $text       高さと幅を知りたい文字列
 * @param  int    $imageWidth 画像の幅
 * @param  string $break      改行文字
 * @return string
 */
function imageWordwrap(
    int $size,
    int $angle,
    string $font,
    string $text,
    int $imageWidth,
    string $break = "\r\n"
): string {
    /** @var string[] $cahrs 1文字ずつに分解。絵文字非対応。対応するライブラリとフォントを見つける必要あり */
    $chars       = mb_str_split($text);
    $lines       = [];
    $currentLine = '';
    foreach ($chars as $ch) {
        $wh = getTextSize($size, $angle, $font, $currentLine.$ch);
        if ($wh['width'] > $imageWidth) {
            $lines[]     = $currentLine;
            $currentLine = $ch;
        } else {
            $currentLine .= $ch;
        }
    }
    $lines[] = $currentLine;

    return implode($break, $lines);
}
?>
