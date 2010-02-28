<?php
function barcode($digits)
{
    if (strlen($digits) != 12) {
        echo "Invalid code length";
        exit;
    }
    // 0 = left
    $conversion["0"]["0"] = "0001101";
    $conversion["0"]["1"] = "0011001";
    $conversion["0"]["2"] = "0010011";
    $conversion["0"]["3"] = "0111101";
    $conversion["0"]["4"] = "0100011";
    $conversion["0"]["5"] = "0110001";
    $conversion["0"]["6"] = "0101111";
    $conversion["0"]["7"] = "0111011";
    $conversion["0"]["8"] = "0110111";
    $conversion["0"]["9"] = "0001011";
    // 1 = right
    $conversion["1"]["0"] = "1110010";
    $conversion["1"]["1"] = "1100110";
    $conversion["1"]["2"] = "1101100";
    $conversion["1"]["3"] = "1000010";
    $conversion["1"]["4"] = "1011100";
    $conversion["1"]["5"] = "1001110";
    $conversion["1"]["6"] = "1010000";
    $conversion["1"]["7"] = "1000100";
    $conversion["1"]["8"] = "1001000";
    $conversion["1"]["9"] = "1110100";
    // convert code to binary
    $bin = array();
    // start, 3 bits
    $bin[] = 1;
    $bin[] = 0;
    $bin[] = 1;
    // loop 2 times, once for left, once for right
    for ($side = 0; $side <= 1; $side ++) {
        // 6 = number of numbers on one side
        for ($number = 0 + (6 * $side); $number < 6 + (6 * $side); $number ++) {
            // 7 = number if bits in a number
            for ($bit = 0; $bit < 7; $bit ++) {
                $bin[] = $conversion["" . $side]["" . $digits {
                    $number}
                ] {
                    $bit} ;
                // echo $conversion["".$side]["".$number]{$bit};
            }
        }
        // guard bars (middle)
        $bin[] = 0;
        $bin[] = 1;
        $bin[] = 0;
        $bin[] = 1;
        $bin[] = 0;
    }
    // end
    $bin[] = 1;
    $bin[] = 0;
    $bin[] = 1;

    $height = 150;
    $width = 600;
    $barcode = imagecreatetruecolor($width, $height);
    $white = imagecolorallocate($barcode, 255, 255, 255);
    $black = imagecolorallocate($barcode, 0, 0, 0);

    $bar_width = $width / 95;

    for ($i = 1; $i <= 95; $i ++) {
        imageline($barcode, $bar_width * $i, 0, $bar_width * $i, $height, $white);
        if ($bin[$i]) {
            imagefill($barcode, ($bar_width * $i) - 1, 1, $white);
        }
    }
    // now let's create the numbers
    imagefilledrectangle($barcode, $bar_width * 3, $height * 0.8, $bar_width * 45, $height, $white);
    imagefilledrectangle($barcode, $bar_width * 50, $height * 0.8, $bar_width * 91, $height, $white);
    // this code is a bit fuzzy i know.
    for ($number = 0; $number < 12; $number ++) {
        if ($number == 6) {
            $middlegap = 5;
        }
        imagefttext($barcode, 35 / (200 / $height), 0, $bar_width * (4 + 7 * $number + $middlegap), $height,
            $black, "data/arial.ttf", $digits {
                $number}
            );
    }
    return $barcode;
}


$note = $recursion->database->note->select("barcode='".$_GET["barcode"]."'");
if ($note) {
	$date = explode(" ", $note["creation"]);
	$date = $date[0];
	$amount = $note["money"];
	$barcode = $note["barcode"];
}
else
{
	$date = "2010-01-01";
	$amount = 0;
	$barcode = "000000000000";
}
$size = 1200;

$image = imagecreatetruecolor($size, $size / 2);

$white = imagecolorallocate($image, 255, 255, 255);
$background = imagecolorallocate($image, 220, 220, 220);
$black = imagecolorallocate($image, 50, 50, 50);
imagefill($image, 1, 1, $background);

$fontsize = 300;
// amount shadow
$amount = $amount;
$string = $date." ".$barcode;
imagefttext($image, $fontsize, 0, $size / 2 - ($fontsize / 2) * strlen($amount), $size / 4 + $fontsize / 2, $black,
	"page/shownote/arial.ttf", $amount);
// amount
imagefttext($image, $fontsize, 0, ($size / 2 - ($fontsize / 2) * strlen($amount)) - 20, $size / 4 + $fontsize / 2 - 20, $white,
	"page/shownote/arial.ttf", $amount);
// date
imagefttext($image, 50, 0, 100, 580, $black,
	"page/shownote/arial.ttf", $string);



$barcode = barcode($barcode);

$barcode = imagerotate($barcode, 90, 0);

imagecopyresized($image, $barcode, $size - 150, 0,
    0, 0, $size, $size / 2,
    $size, $size / 2);
header("Content-type: IMAGE/PNG");
imagepng($image);
exit;

?>