<?php
/**
 * MediaAttach
 *
 * @version      $Id: shrinkimage.php 22 2008-02-23 21:30:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * this method creates a shrinked copy of a given image file
 * based on implementation of the Avatar module
 *
 * @param    imagefile    string    filepath to input image
 */
function MediaAttach_userapi_shrinkimage($imagefile)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!isset($imagefile) || !file_exists($imagefile)) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    // get image information
    $imageinfo = getimagesize($imagefile);

    $maxwidth  = pnModGetVar('MediaAttach', 'shrinkwidth');
    $maxheight = pnModGetVar('MediaAttach', 'shrinkheight');

    // check for image dimensions limit
    if ($imageinfo[0] > $maxwidth || $imageinfo[1] > $maxheight) {
        // resize the image

        // get current dimensions
        $width  = $imageinfo[0];
        $height = $imageinfo[1];

        if ($width > $maxwidth) {
            $height = ($maxwidth / $width) * $height;
            $width  = $maxwidth;
        }

        if ($height > $maxheight) {
            $width  = ($maxheight / $height) * $width;
            $height = $maxheight;
        }

        // get the correct functions based on the image type
        switch ($imageinfo[2]) {
            case 1: $createfunc = 'imagecreatefromgif';
                    $savefunc   = 'imagegif';
                    break;
            case 2: $createfunc = 'imagecreatefromjpeg';
                    $savefunc   = 'imagejpeg';
                    break;
            case 3: $createfunc = 'imagecreatefrompng';
                    $savefunc   = 'imagepng';
                    break;
            case 4: $createfunc = 'imagecreatefromwbmp';
                    $savefunc   = 'imagewbmp';
                    break;
        }
        $srcImage  = $createfunc($imagefile);
        $destImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($destImage, $srcImage, 0, 0, 0, 0, $width, $height, $imageinfo[0], $imageinfo[1]);
        $savefunc($destImage, $imagefile);

        // free the memory
        imagedestroy($srcImage);
        imagedestroy($destImage);
    }
}
