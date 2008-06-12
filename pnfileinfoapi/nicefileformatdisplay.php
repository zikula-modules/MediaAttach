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
 * return string with enhanced file format string
 *
 * @param    array    $args['fileinfo']     the file information array
 * @return   string                         beauty format
 */
function MediaAttach_fileinfoapi_nicefileformatdisplay($args) {
    if (!isset($args['fileinfo']) || !is_array($args['fileinfo'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $fileinfo =  $args['fileinfo'];
    unset($args);

    if (empty($fileinfo['fileformat'])) {
        return '';
    }

    $output = $fileinfo['fileformat'];
    if (empty($fileinfo['video']['dataformat']) && empty($fileinfo['audio']['dataformat'])) {
        return $output;  // 'gif'
    }
    if (empty($fileinfo['video']['dataformat']) && !empty($fileinfo['audio']['dataformat'])) {
        if ($fileinfo['fileformat'] == $fileinfo['audio']['dataformat']) {
            return $output; // 'mp3'
        }
        $output .= '.' . $fileinfo['audio']['dataformat']; // 'ogg.flac'
        return $output;
    }
    if (!empty($fileinfo['video']['dataformat']) && empty($fileinfo['audio']['dataformat'])) {
        if ($fileinfo['fileformat'] == $fileinfo['video']['dataformat']) {
            return $output; // 'mpeg'
        }
        $output .= '.' . $fileinfo['video']['dataformat']; // 'riff.avi'
        return $output;
    }
    if ($fileinfo['video']['dataformat'] == $fileinfo['audio']['dataformat']) {
        if ($fileinfo['fileformat'] == $fileinfo['video']['dataformat']) {
            return $output; // 'real'
        }
        $output .= '.' . $fileinfo['video']['dataformat']; // any examples?
        return $output;
    }
    $output .= '.' . $fileinfo['video']['dataformat'];
    $output .= '.' . $fileinfo['audio']['dataformat']; // asf.wmv.wma

    return $output;
}
