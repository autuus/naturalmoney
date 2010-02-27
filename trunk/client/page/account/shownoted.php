<?php
$golden_ratio = 1.618;


$degrees = 90;
$size = 600;

$image = imagecreatetruecolor($size, $size/$golden_ratio);
$wallpaper = imagecreatefromjpeg("shownote/Expanding.jpg");
imagecopyresized($image, $wallpaper, 0, 0,
	0, 0, imagesx($image), imagesy($image),
	imagesx($wallpaper),imagesy($wallpaper));

	$new_image = imagecreatetruecolor(imagesx($image)/2, imagesy($image)/2);
	// rotate 90 and -90 in turns
	$degrees *= -1;




imagecopyresized($new_image, $image, imagesx($new_image)/2, 0,
	0, 0, imagesx($new_image), imagesy($new_image),
	imagesx($image)*2,imagesy($image));

$degrees *= -1;

$image = imagerotate($image, $degrees, 0);


imagecopyresized($new_image, $image, 0, imagesy($new_image)/2,
	0, 0, imagesx($new_image)/2, imagesy($new_image)/2,
	imagesx($image),imagesy($image));


$image = imagerotate($image, -90, 0);


imagecopyresized($new_image, $image, imagesx($new_image)/4, 0,
	0, 0, imagesx($new_image)/4, imagesy($new_image)/2,
	imagesx($image),imagesy($image));


$image = imagerotate($image, 90, 0);


imagecopyresized($new_image, $image, 0, imagesx($new_image)/6.5,
	0, 0, imagesx($new_image)/4, imagesy($new_image)/4,
	imagesx($image),imagesy($image));

header("Content-type: IMAGE/PNG");
imagepng($new_image);


?>