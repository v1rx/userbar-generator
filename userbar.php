<?php
header('Content-Type: image/png');

function addText($im, $text, $font, $fontSize, $x, $y, $textColor, $strokeColor, $strokeWidth)
{
    $color = imagecolorallocate($im, $textColor[0], $textColor[1], $textColor[2]);
    $color2 = imagecolorallocate($im, $strokeColor[0], $strokeColor[1], $strokeColor[2]);

    for ($offsetX = -$strokeWidth; $offsetX <= $strokeWidth; $offsetX++)
    {
        for ($offsetY = -$strokeWidth; $offsetY <= $strokeWidth; $offsetY++)
        {
            if ($offsetX === 0 && $offsetY === 0)
            {
                continue;
            }

            imagettftext($im, $fontSize, 0, $x + $offsetX, $y + $offsetY, $color2 * -1, $font, $text);
        }
    }

    imagettftext($im, $fontSize, 0, $x, $y, $color * -1, $font, $text);
}

function getFiles($directory, $extensions)
{
    $files = [];

    $dir = opendir('./' . $directory);

    if ($dir !== false)
    {
        while (($file = readdir($dir)) !== false)
        {
            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

            if(in_array($fileExtension, $extensions))
            {
                $files[] = $file;
            }
        }

        closedir($dir);
    }

    return $files;
}

$backgrounds = getFiles('backgrounds', ['png']);
$props = getFiles('props', ['png']);

/** Set current background, random if no `bg` is passed */
$currentBackground = isset($_GET['bg']) && in_array($_GET['bg'], $backgrounds)
    ? $_GET['bg']
    : $backgrounds[array_rand($backgrounds)];

/** Set current prop*/
$currentProp = isset($_GET['prop']) && in_array($_GET['prop'], $props)
    ? $_GET['prop']
    : NULL;

/** Set current text */
$currentText = isset($_GET['text'])
    ? $_GET['text']
    : 'five.sh';

/** Set current font */
$currentFont = __DIR__ . '/visitor2.ttf';

/** Make sure font exists */
if (!file_exists($currentFont))
{
    die('Font file not found: ' . $currentFont);
}

/** Create base image from background */
$image = imagecreatefrompng(sprintf('./backgrounds/%s', $currentBackground));

/** Set alpha blending on */
imagealphablending($image, true);
imagesavealpha($image, true);

/** Initial font x/y */
$textX = 6; $textY = 12;

/** Font values */
$fontSize = 10;
$fontColor = [255, 255, 255];

/** Stroke */
$strokeColor = [0, 0, 0];
$strokeWidth = 1;

/** Calculate text width */
$bbox = imagettfbbox($fontSize, 0, $currentFont, $currentText);
$textWidth = $bbox[2] - $bbox[0];

/** Right-align the text */
$textX = (imagesx($image) - $textWidth) - $textX;

/** Read prop used */
if($currentProp)
{
    $propX = isset($_GET['x']) && is_numeric($_GET['x'])
        ? intval($_GET['x'])
        : 0;
    
    $propY = isset($_GET['y']) && is_numeric($_GET['y'])
        ? intval($_GET['y'])
        : 0;

    $propImage = imagecreatefrompng(sprintf('./props/%s', $currentProp));

    $propWidth = imagesx($propImage);
    $propHeight = imagesy($propImage);

    imagecopy(
        $image, $propImage, $propX, $propY, 0, 0, $propWidth, $propHeight
    );
}

addText(
    $image,
    $currentText,
    $currentFont,
    $fontSize,
    $textX,
    $textY,
    $fontColor,
    $strokeColor,
    $strokeWidth
);

imagepng($image);

imagedestroy($image);
?>
