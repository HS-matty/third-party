<?php
session_start();
putenv('GDFONTPATH=' . realpath('.'));
unset($_SESSION['rnd']);

$str=rand(10000,99999);	


$_SESSION['rnd'] = $str;
$im=imagecreatefromjpeg('image.jpg');

imagettftext ($im, 15, 5, 15, 25, -10, "arial.ttf", $str);
imagejpeg($im);
imagedestroy ($im);

?>