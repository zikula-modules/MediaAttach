<?php
/**
 * MediaAttach
 *
 * @version      $Id: common_imgthumb.php 96 2008-03-09 22:49:43Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/*
 * This function is based on the "Thumb" plugin:
 *
 *     Purpose: creates cached thumbnails
 *     Home: http://www.cerdmann.com/thumb/
 *     Copyright (C) 2005 Christoph Erdmann
 *
 *     Changelog:
 *     2005-10-31 Fixed some small bugs (CE)
 *     2005-10-09 Rewrote crop-function (CE)
 *     2005-10-08 Decreased processing time by prescaling linear and cleaned code (CE)
 *     2005-07-13 Set crop=true as standard (CE)
 *     ... (cutted old entries)
 */

/**
 * Parameters:
 *     file        string           path to original image (required)
 *     thumbnr     int              number of thumbnail to create (1..x) (optional, default = modvar setting)
 *     type        int              destination image type 1=GIF, 2=JPG, 3=PNG, SWF=4 (optional, default = source image type)
 *     extrapolate boolean          extrapolate image (optional, default = true)
 *     crop        boolean          crop thumbnail (optional, default = true)
 *     width       int              thumbnail width (optional, default = modvar setting)
 *     height      int              thumbnail width (optional, default = modvar setting)
 *     longside    boolean
 *     shortside   boolean
 *     offset_w    int              horizontal offset of thumbnail (optional, default = 0)
 *     offset_h    int              vertical offset of thumbnail (optional, default = 0)
 *     sharpen     boolean          perform unsharp mask algorithm (optional, default = false)
 *     quality     int              quality for jpegs: 0..100 (optional, default = 100)
 *     assign
 */
function _maIntImageThumb($params, &$smarty)
{
    // unsharp function
    if (!function_exists('UnsharpMask'))
    {
        // Unsharp mask algorithm by Torstein Hnsi 2003 (thoensi_at_netcom_dot_no)
        // Christoph Erdmann: changed it a little, cause i could not reproduce the darker blurred image, now it is up to 15% faster with same results
        function UnsharpMask($img, $amount, $radius, $threshold)
        {
            // Attempt to calibrate the parameters to Photoshop:
            if ($amount > 500) $amount = 500;
            $amount = $amount * 0.016;
            if ($radius > 50) $radius = 50;
            $radius = $radius * 2;
            if ($threshold > 255) $threshold = 255;

            $radius = abs(round($radius));     // Only integers make sense.
            if ($radius == 0) {
                return $img;
                imagedestroy($img);
                break;
            }
            $w = imagesx($img);
            $h = imagesy($img);
            $imgCanvas = $img;
            $imgCanvas2 = $img;
            $imgBlur = imagecreatetruecolor($w, $h);

            // Gaussian blur matrix:
            //    1    2    1
            //    2    4    2
            //    1    2    1

            // Move copies of the image around one pixel at the time and merge them with weight
            // according to the matrix. The same matrix is simply repeated for higher radii.
            for ($i = 0; $i < $radius; $i++)
            {
                imagecopy      ($imgBlur, $imgCanvas, 0, 0, 1, 1, $w - 1, $h - 1); // up left
                imagecopymerge ($imgBlur, $imgCanvas, 1, 1, 0, 0, $w, $h, 50); // down right
                imagecopymerge ($imgBlur, $imgCanvas, 0, 1, 1, 0, $w - 1, $h, 33.33333); // down left
                imagecopymerge ($imgBlur, $imgCanvas, 1, 0, 0, 1, $w, $h - 1, 25); // up right
                imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 1, 0, $w - 1, $h, 33.33333); // left
                imagecopymerge ($imgBlur, $imgCanvas, 1, 0, 0, 0, $w, $h, 25); // right
                imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 0, 1, $w, $h - 1, 20 ); // up
                imagecopymerge ($imgBlur, $imgCanvas, 0, 1, 0, 0, $w, $h, 16.666667); // down
                imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 0, 0, $w, $h, 50); // center
            }
            $imgCanvas = $imgBlur;

            // Calculate the difference between the blurred pixels and the original and set the pixels
            for ($x = 0; $x < $w; $x++)
            { // each row
                for ($y = 0; $y < $h; $y++)
                { // each pixel
                    $rgbOrig = ImageColorAt($imgCanvas2, $x, $y);
                    $rOrig = (($rgbOrig >> 16) & 0xFF);
                    $gOrig = (($rgbOrig >> 8) & 0xFF);
                    $bOrig = ($rgbOrig & 0xFF);
                    $rgbBlur = ImageColorAt($imgCanvas, $x, $y);
                    $rBlur = (($rgbBlur >> 16) & 0xFF);
                    $gBlur = (($rgbBlur >> 8) & 0xFF);
                    $bBlur = ($rgbBlur & 0xFF);

                    // When the masked pixels differ less from the original
                    // than the threshold specifies, they are set to their original value.
                    $rNew = (abs($rOrig - $rBlur) >= $threshold) ? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig)) : $rOrig;
                    $gNew = (abs($gOrig - $gBlur) >= $threshold) ? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig)) : $gOrig;
                    $bNew = (abs($bOrig - $bBlur) >= $threshold) ? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig)) : $bOrig;

                    if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew))
                    {
                        $pixCol = ImageColorAllocate($img, $rNew, $gNew, $bNew);
                        ImageSetPixel($img, $x, $y, $pixCol);
                    }
                }
            }
            return $img;
        }
    }

    @ini_set('memory_limit', '64M');


    ### validate given parameters
    if (empty($params['file']) || !file_exists($params['file'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }
    $srcFile = $params['file'];

    if (isset($params['thumbnr']) && is_numeric($params['thumbnr'])) {
        $thumbNumber = (int) $params['thumbnr'];
    } else {
        $thumbNumber = pnModGetVar('MediaAttach', 'defaultthumb');
    }

    $thumbHash = md5($srcFile . filemtime($srcFile) . $thumbNumber);

    // determine thumbnail filetype
    $_CONFIG['types'] = array('','.gif','.jpg','.png');
    if (!empty($params['type'])) $_DST['type'] = $params['type'];
    else $_DST['type'] = 3; // default to png

    $destFilePath = $thumbHash . $_CONFIG['types'][$_DST['type']];

    $cachedir = pnModGetVar('MediaAttach', 'cachedir');
    $cachedir = str_replace(getenv('DOCUMENT_ROOT'), '', $cachedir);
    if (substr($cachedir, 0, 1) == '/') {
        $cachedir = substr($cachedir, 1, strlen($cachedir) - 1);
    }

    $destFilePath = $cachedir . '/' . $destFilePath;

    // catch cached file if existing
    if (file_exists($destFilePath)) {
        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $destFilePath);
            return;
        } else {
            return $destFilePath;
        }
    }

    // otherwise go on

    // get info about source image
    $temp = getimagesize($srcFile);
    $_SRC['file']       = $srcFile;
    $_SRC['filename']   = basename($srcFile);
    $_SRC['width']      = $temp[0];
    $_SRC['height']     = $temp[1];
    $_SRC['type']       = $temp[2]; // 1=GIF, 2=JPG, 3=PNG, SWF=4
    $_SRC['string']     = $temp[3];



    if (!isset($params['extrapolate']) || empty($params['extrapolate']))
        $params['extrapolate'] = true;
    if (!isset($params['crop']) || empty($params['crop']))
        $params['crop'] = true;

    if (empty($params['width']) && empty($params['height']) && empty($params['longside']) && empty($params['shortside'])) {
        $thumbsizes = pnModGetVar('MediaAttach', 'thumbsizes');

        $params['width'] = $thumbsizes[$thumbNumber-1][0];
        $params['height'] = $thumbsizes[$thumbNumber-1][1];
    }

    $_DST['width'] = $params['width'];
    $_DST['height']= $params['height'];

    $_SRC['offset_w'] = $_SRC['offset_h'] = 0;

    $isUserDefinedCrop = (isset($params['offset_w']) && isset($params['offset_h']));

    if (!$isUserDefinedCrop) {
        // the size relation should stay unchanged independent of the image format
        if (isset($params['longside']) && is_numeric($params['longside'])) {
            if ($_SRC['width'] < $_SRC['height']) {
                $_DST['height']   = $params['longside'];
                $_DST['width']    = round($params['longside'] / ($_SRC['height'] / $_SRC['width']));
            } else {
                $_DST['width']    = $params['longside'];
                $_DST['height']   = round($params['longside'] / ($_SRC['width'] / $_SRC['height']));
            }
        } elseif (isset($params['shortside']) && is_numeric($params['shortside'])) {
            if ($_SRC['width'] < $_SRC['height']) {
                $_DST['width']    = $params['shortside'];
                $_DST['height']   = round($params['shortside'] / ($_SRC['width'] / $_SRC['height']));
            } else {
                $_DST['height']   = $params['shortside'];
                $_DST['width']    = round($params['shortside'] / ($_SRC['height'] / $_SRC['width']));
            }
        }

        // shall we crop? (default)
        if ($params['crop']) {
            $width_ratio = $_SRC['width'] / $_DST['width'];
            $height_ratio = $_SRC['height'] / $_DST['height'];

            // cut at width
            if ($width_ratio > $height_ratio) {
                $_SRC['offset_w'] = round(($_SRC['width'] - $_DST['width'] * $height_ratio) / 2);
                $_SRC['width'] = round($_DST['width'] * $height_ratio);

            // cut at height
            } elseif ($width_ratio < $height_ratio) {
                $_SRC['offset_h'] = round(($_SRC['height'] - $_DST['height'] * $width_ratio) / 2);
                $_SRC['height'] = round($_DST['height'] * $width_ratio);
            }
        }

        if ($params['extrapolate'] == 'false' && $_DST['height'] > $_SRC['height'] && $_DST['width'] > $_SRC['width']) {
            $_DST['width'] = $_SRC['width'];
            $_DST['height'] = $_SRC['height'];
        }
    }

    // read in SRC
    if ($_SRC['type'] == 1) $_SRC['image'] = imagecreatefromgif($_SRC['file']);
    if ($_SRC['type'] == 2) $_SRC['image'] = imagecreatefromjpeg($_SRC['file']);
    if ($_SRC['type'] == 3) $_SRC['image'] = imagecreatefrompng($_SRC['file']);

    if (!$isUserDefinedCrop) {
        // if the image is very big, scale down
        if ($_DST['width'] * 4 < $_SRC['width'] && $_DST['height'] * 4 < $_SRC['height'])
        {
            // multiplikator for destination size
            $_TMP['width'] = round($_DST['width'] * 4);
            $_TMP['height'] = round($_DST['height'] * 4);

            $_TMP['image'] = imagecreatetruecolor($_TMP['width'], $_TMP['height']);
            imagecopyresized($_TMP['image'], $_SRC['image'], 0, 0, $_SRC['offset_w'], $_SRC['offset_h'], $_TMP['width'], $_TMP['height'], $_SRC['width'], $_SRC['height']);
            $_SRC['image'] = $_TMP['image'];
            $_SRC['width'] = $_TMP['width'];
            $_SRC['height'] = $_TMP['height'];

            // if scaled down, we may not cut out an area again
            $_SRC['offset_w'] = 0;
            $_SRC['offset_h'] = 0;
            unset($_TMP['image']);
        }
        $_DST['image'] = imagecreatetruecolor($_DST['width'], $_DST['height']);
        imagecopyresampled($_DST['image'], $_SRC['image'], 0, 0, $_SRC['offset_w'], $_SRC['offset_h'], $_DST['width'], $_DST['height'], $_SRC['width'], $_SRC['height']);
    } else {
        $_SRC['offset_w'] = $params['offset_w'];
        $_SRC['offset_h'] = $params['offset_h'];

        $_DST['image'] = imagecreatetruecolor($_DST['width'], $_DST['height']);
        imagecopy($_DST['image'], $_SRC['image'], 0, 0, $_SRC['offset_w'], $_SRC['offset_h'], $_DST['width'], $_DST['height']);
    }

    if (isset($params['sharpen']) && $params['sharpen'] != false) {
        $_DST['image'] = UnsharpMask($_DST['image'], 80, .5, 3);
    }

    // store thumbnail
    if ($_DST['type'] == 1) {
        imagetruecolortopalette($_DST['image'], false, 256);
        imagegif($_DST['image'], $destFilePath);
    }
    if ($_DST['type'] == 2) {
        if (empty($params['quality'])) $params['quality'] = 100; //80;
        imagejpeg($_DST['image'], $destFilePath, $params['quality']);
    }
    if ($_DST['type'] == 3) {
        imagepng($_DST['image'], $destFilePath);
    }

    imagedestroy($_DST['image']);
    imagedestroy($_SRC['image']);

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $destFilePath);
    } else {
        return $destFilePath;
    }
}
