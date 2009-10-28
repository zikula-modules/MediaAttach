<?php
/**
 * MediaAttach
 *
 * @version      $Id: $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

/**
 * cache given array
 *
 * @param        fileid     int     fileid of examined upload
 * @param        data       array   data to cache
 * @return       true
 */
function MediaAttach_fileinfoapi_cacheinfo(&$args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!isset($args['fileid']) || !is_numeric($args['fileid']) || !isset($args['data']) || !is_array($args['data'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $cacheDir = pnConfigGetVar('temp') . '/pnRender_cache';
    $cacheId = 'fileinfo_' . $args['fileid'];
    $cacheFile = $cacheDir . '/' . md5($cacheId) . '.ma';
    $cacheFileOS = DataUtil::formatForOS($cacheFile, true);

    $cacheNeeded = false;

    if (file_exists($cacheFileOS)) {
        $cacheLength = 14 * 24 * 60 * 60; // 14 days
        if (time() - filemtime($cacheFileOS) > $cacheLength) {
            unlink($cacheFileOS);
            $cacheNeeded = true;
        }
    } else {
        $cacheNeeded = true;
    }

    if ($cacheNeeded) {
        array_walk($args['data'], 'base64_encoder_multi');
        Loader::loadClass('FileUtil');
        return FileUtil::writeSerializedFile($cacheFile, $args['data'], true);
    }

    return true;
}

function base64_encoder_multi(&$val, $key)
{
    if (is_array($val))
        array_walk($val, 'base64_encoder_multi');
    else
        $val = base64_encode($val);
}
