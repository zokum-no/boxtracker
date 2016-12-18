<?php

header("Content-type: image/png");

include("../../db.php");
include("getvask.php");

$xdim = 365;
$ydim = 75;

$im = imagecreatetruecolor($xdim, $ydim);

$black = imagecolorallocate($im, 0,0,0);
$nede = imagecolorallocate($im, 192,0,0);
$oppe = imagecolorallocate($im, 0,64,0);

$nedegraf = getvask("nede");

$uke = imagecolorallocate($im, 39,39,39);
$ukenummer = imagecolorallocate($im, 139,139,139);
$pseudomnd = imagecolorallocate($im, 59,59,59);

for ($i = 0; $i != 365; $i++) {
	if ($i % 7 == 0) {
	                imageline($im, $i, 15, $i, 150, $uke);
			        }


	if ($i % 28 == 0) {
		imageline($im, $i, 0, $i, 150, $pseudomnd);
		imagestring($im, 1, $i, 8, $i/7,   $ukenummer);
	}

	if (strstr($nedegraf, "," . $i . ",")) {
		imageline($im, $i, 50, $i, 150, $nede);
	} else {
		//		imageline($im, 365 - $i, 60, 365 - $i, 150, $oppe);
	}


}

imagepng($im);
imagedestroy($im);

?>
