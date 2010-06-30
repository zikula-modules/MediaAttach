<?php
/**
 * MediaAttach
 *
 * @version      $Id: download.php 96 2008-03-09 22:49:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');
Loader::requireOnce('modules/MediaAttach/common_imgthumb.php');

/**
 * display data of an upload
 *
 * @param    fileid        int     upload id to display data for (mandatory)
 * @param    inline        int     if set to 1 then inline else physical
 * @param    thumb         int     if set to 1 then the thumbnail image is being returned
 * @param    thumbraw      int     if set to 1 then the thumbnail filepath is being returned
 * @param    thumbnr       int     thumbnail number: 1..x (optional, default to modvar setting)
 * @return   output        the data
 */
function MediaAttach_user_download($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $fileid      = (int) FormUtil::getPassedValue('fileid', (isset($args['fileid'])) ? $args['fileid'] : 0, 'GET');
    $inline      = (int) FormUtil::getPassedValue('inline', (isset($args['inline'])) ? $args['inline'] : 0, 'GET');
    $thumb       =  (int) FormUtil::getPassedValue('thumb', (isset($args['thumb'])) ? $args['thumb'] : 0, 'GET');
    $thumbraw    =  (int) FormUtil::getPassedValue('thumbraw', (isset($args['thumbraw'])) ? $args['thumbraw'] : 0, 'GET');
    $thumbNumber = (int) FormUtil::getPassedValue('thumbnr', (isset($args['thumbnr'])) ? $args['thumbnr'] : 0, 'GET');
    unset($args);

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    if (!SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$fileid", ACCESS_READ)) {
        return LogUtil::registerPermissionError();
    }

    //special check for Dizkus: has current user access to topic the upload belongs to?
    if ($file['modname'] == 'Dizkus') {
        if (!pnModAPIFunc('Dizkus', 'user', 'gettopicreadpermission', array('topic_id' => $file['objectid']))) {
            return LogUtil::registerPermissionError();
        }
    }

    if ($file['extension'] == 'extvid') {
        pnRedirect(pnModURL('MediaAttach', 'user', 'display', array('fileid' => $fileid)));
    }

    $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');
    if ($thumb == 1) {
        if ($thumbNumber == 0) {
            $thumbNumber = pnModGetVar('MediaAttach', 'defaultthumb');
        }

        $thumbFilePath = _maIntImageThumb(array('file' => $uploaddir . '/' . $file['filename'],
                                                'thumbnr' => $thumbNumber));
        if ($thumbraw == 1) {
            echo $thumbFilePath;
            return true;
        } else {
            return $thumbFilePath;
        }
    }

    pnModAPIFunc('MediaAttach', 'user', 'incdlcounter', array('fileid' => $fileid));

    $useCompression = pnConfigGetVar('UseCompression');
    if ($useCompression == 1) {
        // erase output buffer because the gzip destroys binary data
        ob_end_clean();
        header("Content-Encoding: identity");
    }

    //header("Pragma: public");
    //header("Expires: 0");
    //header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //header("Cache-Control: public");

    $expireSeconds = 10800;
    header("Expires: " . gmdate("D, d M Y H:i:s", strtotime("+$expireSeconds seconds")) . " GMT");
    header("Cache-Control: public, max-age=$expireSeconds, pre-check=$expireSeconds");
    header("Pragma: cache", true);

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        // use cached version in the browser if available - and sent corresponding 304 code
        header('Last-Modified: ' . $_SERVER['HTTP_IF_MODIFIED_SINCE'], true, 304);
        exit;
    }
    else {
        header("Last-Modified: " . gmdate('D, d M Y H:i:s', filemtime($file['filename'])) . ' GMT');
    }

    header("Content-Length: " . $file['filesize']);

    if ($inline == 1) {
        header("Content-Description: MediaAttach inline file");
        header("Content-Disposition: inline; filename=" . $file['filename'] . "; filesize=" . $file['filesize'] . ";");
    } else {
        header("Content-Description: MediaAttach file download");
        header("Content-Disposition: attachment; filename=" . $file['filename'] . "; filesize=" . $file['filesize'] . ";");
    }
    header("Content-type: " . $file['mimetype']);
    header("Content-Transfer-Encoding: binary");

    if ($useCompression != 1) {
         header("Content-Length: " . $file['filesize']);
        // TODO: work out better solution (like getting rid of gzip with the above output buffer cleaning)
    }


   // TODO: FileUtil needs a function for reading files in chunks
   // Loader::loadClass('FileUtil');
   // echo FileUtil::readFile($uploaddir . '/' . $file['filename'], true);
    
    $fileloc = $uploaddir . '/' . $file['filename'];
    $chunk = 1048576; //1M
    $buffer = '';
    $handle = fopen($fileloc, 'rb');
    if ($handle === false) {
        return false;
    }
    while (!feof($handle)) {
        $buffer = fread($handle, $chunk);
        print $buffer;
        ob_flush();
        flush();
    }
    fclose($handle);
    return true;
}
