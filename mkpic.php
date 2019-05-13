<?php
session_start();
header('Content-type: image/png');
$im = @imagecreatetruecolor(28, 18) || die('無法建立圖片！');
$text_color = imagecolorallocate($im, 255, 255, 255);
$num1 = mt_rand(0, 9);
$num2 = mt_rand(0, 9);
$num3 = mt_rand(0, 9);
$num = $num1 . $num2 . $num3;
imagestring($im, 2, 5, 2, $num, $text_color);
imagepng($im);
imagedestroy($im);

$_SESSION['chknum'] = $num;
