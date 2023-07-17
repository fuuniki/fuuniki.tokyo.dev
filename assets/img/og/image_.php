<?php

  $fontSize = 56; // 文字サイズ
  $fontFamily = 'set-font.otf'; // TrueTypeフォントを指定する
  $MarginX=50;//横方向マージン
  $MarginY=50;//縦方向マージン
  $angle=0;//文字を回転させる場合用
  $txtX = $fontSize+$MarginX; // 文字の横位置(文字の左が基準)
  $txtY = $fontSize * 2+$MarginY; // 文字の縦位置(文字のベースラインが基準)
  $txt = $_GET['text']; // テキスト拾う用

  $Nx=1200; //元画像の横ピクセル数
  $Ny=630; //元画像の縦ピクセル数
  $ENx=$Nx-$txtX*2;//有効横ピクセル数
  $ENy=$Ny-$txtY*2;//有効縦ピクセル数
  $newtxt=imageWordwrap($fontSize, $angle, $fontFamily, $txt, $ENx);
  $initpos=imagettfbbox($fontSize, $angle,$fontFamily,$newtxt);
  $BoxHight=$initpos[1]-$initpos[7];
  $txtln=round($BoxHight/$fontSize);
  $step=$fontSize/2;
  $centY=$Ny/2+$MarginY;
  $initcol=$centY+$fontSize*2;

  $img = imagecreatefrompng('og_base.png'); // テキストを載せる画像
  $color = imagecolorallocate($img, 0, 0, 0); // テキストの色指定(RGB)

  imagettftext($img, $fontSize, $angle, $txtX,$initcol-$txtln*$step, $color, $fontFamily, $newtxt);//初期位置から行分だけシフト
  //imagestring($img, 5, $txtX , $txtY, $txt, $white);

  header('Content-Type: image/png');
  imagepng($img);
  imagedestroy($img);
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
  ?>
