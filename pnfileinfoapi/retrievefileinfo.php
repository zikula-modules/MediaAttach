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

@ini_set('memory_limit', '512M');

/**
 * retrieve file information
 *
 * @param    file     array    the file array
 * @return   array    file information array
 */
function MediaAttach_fileinfoapi_retrievefileinfo($args)
{
    if (!isset($args['file']) || !is_array($args['file'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $file = $args['file'];
    $filename = pnModGetVar('MediaAttach', 'uploaddir') . '/' . $file['filename'];
    unset($args);

    $filenameOS = DataUtil::formatForOS($filename, true);
    if (!is_file($filenameOS) || !file_exists($filenameOS)) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $fileInfo = pnModAPIFunc('MediaAttach', 'fileinfo', 'getcachedinfo', array('fileid' => $file['fileid']));

    if ($fileInfo != false) {
        return $fileInfo;
    }

    Loader::requireOnce('modules/MediaAttach/pnincludes/getid3/getid3/getid3.php');

    $getID3 = new getID3;
//    $getID3->encoding = 'UTF-8';
//    set_time_limit(30);

    $threshold = 52428800;

    // auto-get md5_data, md5_file, sha1_data, sha1_file if filesize < 50MB
    $hashesBool = (bool) (filesize($filenameOS) < $threshold);
    $getID3->option_md5_data  = $hashesBool;
    $getID3->option_sha1_data = $hashesBool;

    $analyzeBool = (bool) (filesize($filenameOS) < $threshold);
//TODO: threshold size
$analyzeBool = true;

    if ($analyzeBool) {
        $fileInfo = $getID3->analyze($filenameOS);
    }

    if ($hashesBool) {
        $fileInfo['md5_file']  = getid3_lib::md5_file($filenameOS);
        $fileInfo['sha1_file'] = getid3_lib::sha1_file($filenameOS);
    }

    // copy data from all subarrays of [tags] into [comments] so
    // metadata is all available in one location for all tag formats
    getid3_lib::CopyTagsToComments($fileInfo);

    //strip off unneeded fields
    unset($fileInfo['GETID3_VERSION']);
    unset($fileInfo['filename']);
    unset($fileInfo['filepath']);
    unset($fileInfo['filenamepath']);

    $fileInfo['fileformat'] = pnModAPIFunc('MediaAttach', 'fileinfo', 'nicefileformatdisplay', array('fileinfo' => $fileInfo));

    // we need only 'comments_html' for now
    if (isset($fileInfo['tags'])) unset($fileInfo['tags']);
    if (isset($fileInfo['tags_html'])) unset($fileInfo['tags_html']);
    if (isset($fileInfo['comments'])) unset($fileInfo['comments']);

    //make sure some specific fields exist
    if (!isset($fileInfo['fileformat'])) $fileInfo['fileformat'] = '';
    if (!isset($fileInfo['filesize'])) $fileInfo['filesize'] = '';
    if (!isset($fileInfo['mime_type'])) $fileInfo['mime_type'] = '';
    if (!isset($fileInfo['encoding'])) $fileInfo['encoding'] = '';

    if (!isset($fileInfo['bitrate'])) $fileInfo['bitrate'] = '';
    if (!isset($fileInfo['playtime_seconds'])) $fileInfo['playtime_seconds'] = '';
    if (!isset($fileInfo['playtime_string'])) $fileInfo['playtime_string'] = '';

    if (!isset($fileInfo['md5_file'])) $fileInfo['md5_file'] = '';
    if (!isset($fileInfo['md5_data_source'])) $fileInfo['md5_data_source'] = '';
    if (!isset($fileInfo['md5_data'])) $fileInfo['md5_data'] = '';
    if (!isset($fileInfo['sha1_file'])) $fileInfo['sha1_file'] = '';
    if (!isset($fileInfo['sha1_data'])) $fileInfo['sha1_data'] = '';

    if (!isset($fileInfo['audio'])) $fileInfo['audio'] = array();
    if (!isset($fileInfo['audio']['bitrate'])) $fileInfo['audio']['bitrate'] = '';
    if (!isset($fileInfo['audio']['bitrate_mode'])) $fileInfo['audio']['bitrate_mode'] = '';
    if (!isset($fileInfo['audio']['sample_rate'])) $fileInfo['audio']['sample_rate'] = '';
    if (!isset($fileInfo['audio']['bits_per_sample'])) $fileInfo['audio']['bits_per_sample'] = '';
    if (!isset($fileInfo['audio']['channelmode'])) $fileInfo['audio']['channelmode'] = '';
    if (!isset($fileInfo['audio']['channels'])) $fileInfo['audio']['channels'] = '';
    if (!isset($fileInfo['audio']['codec'])) $fileInfo['audio']['codec'] = '';
    if (!isset($fileInfo['audio']['encoder'])) $fileInfo['audio']['encoder'] = '';
    if (!isset($fileInfo['audio']['compression_ratio'])) $fileInfo['audio']['compression_ratio'] = '';
    if (!isset($fileInfo['audio']['lossless'])) $fileInfo['audio']['lossless'] = '';

    if (!isset($fileInfo['video'])) $fileInfo['video'] = array();
    if (!isset($fileInfo['video']['bitrate'])) $fileInfo['video']['bitrate'] = '';
    if (!isset($fileInfo['video']['bitrate_mode'])) $fileInfo['video']['bitrate_mode'] = '';
    if (!isset($fileInfo['video']['bits_per_sample'])) $fileInfo['video']['bits_per_sample'] = '';
    if (!isset($fileInfo['video']['frame_rate'])) $fileInfo['video']['frame_rate'] = '';
    if (!isset($fileInfo['video']['pixel_aspect_ratio'])) $fileInfo['video']['pixel_aspect_ratio'] = '';
    if (!isset($fileInfo['video']['codec'])) $fileInfo['video']['codec'] = '';
    if (!isset($fileInfo['video']['encoder'])) $fileInfo['video']['encoder'] = '';
    if (!isset($fileInfo['video']['compression_ratio'])) $fileInfo['video']['compression_ratio'] = '';
    if (!isset($fileInfo['video']['lossless'])) $fileInfo['video']['lossless'] = '';

    if (!isset($fileInfo['video']['resolution_x'])) $fileInfo['video']['resolution_x'] = '';
    if (!isset($fileInfo['video']['resolution_y'])) $fileInfo['video']['resolution_y'] = '';

    if (!isset($fileInfo['swf'])) $fileInfo['swf'] = array();
    if (!isset($fileInfo['swf']['bgcolor'])) $fileInfo['swf']['bgcolor'] = '';

    if (!isset($fileInfo['comments_html'])) $fileInfo['comments_html'] = array();

    if (!pnModAPIFunc('MediaAttach', 'fileinfo', 'cacheinfo', array('fileid' => $file['fileid'], 'data' => $fileInfo))) {
        LogUtil::registerStatus('Notice: file information could not be cached.');
    }

    return $fileInfo;
}

