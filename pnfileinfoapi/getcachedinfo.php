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
 * get cached content
 *
 * @param   fileid       int   fileid of examined upload
 * @return               data array or false on failure
 */
function MediaAttach_fileinfoapi_getcachedinfo($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!isset($args['fileid']) || !is_numeric($args['fileid'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $cacheDir = pnConfigGetVar('temp') . '/view_cache';
    $cacheId = 'fileinfo_' . $args['fileid'];
    $cacheFile = $cacheDir . '/' . md5($cacheId) . '.ma';
    $cacheFileOS = DataUtil::formatForOS($cacheFile, true);

    if (file_exists($cacheFileOS)) {
        Loader::loadClass('FileUtil');
        $data = FileUtil::readSerializedFile($cacheFile, true);
        array_walk($data, 'base64_cleaner_multi');
        return $data;
    }

    return false;
}


function base64_cleaner_multi(&$val, $key) {
   if (is_array($val)) array_walk($val, 'base64_cleaner_multi');
   else $val = base64_decode($val);
}

