<?php
/**
 * MediaAttach
 *
 * @version      $Id: download.php 96 2008-03-09 22:49:48Z weckamc $
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');
Loader::requireOnce('modules/MediaAttach/common_imgthumb.php');

/**
 * display data of an upload
 *
 * @param    int     fileid        upload id to display data for (mandatory)
 * @param    int     inline        if set to 1 then inline else physical
 * @param    int     thumb         if set to 1 then the thumbnail image is being returned
 * @param    int     thumbraw      if set to 1 then the thumbnail filepath is being returned
 * @param    int     thumbnr       thumbnail number: 1..x (optional, default to modvar setting)
 * @return   output                the data
 */
function MediaAttach_user_download($args)
{
    $fileid      = (int) FormUtil::getPassedValue('fileid', (isset($args['fileid'])) ? $args['fileid'] : 0, 'GET');
    $inline      = (int) FormUtil::getPassedValue('inline', (isset($args['inline'])) ? $args['inline'] : 0, 'GET');
    $thumb       =  (int) FormUtil::getPassedValue('thumb', (isset($args['thumb'])) ? $args['thumb'] : 0, 'GET');
    $thumbraw    =  (int) FormUtil::getPassedValue('thumbraw', (isset($args['thumbraw'])) ? $args['thumbraw'] : 0, 'GET');
    $thumbNumber = (int) FormUtil::getPassedValue('thumbnr', (isset($args['thumbnr'])) ? $args['thumbnr'] : 0, 'GET');
    unset($args);

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    if (!SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$fileid", ACCESS_READ)) {
        return LogUtil::registerPermissionError();
    }

    //special check for pnForum: has current user access to topic the upload belongs to?
    if ($file['modname'] == 'pnForum') {
        if (!pnModAPIFunc('pnForum', 'user', 'gettopicreadpermission', array('topic_id' => $file['objectid']))) {
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

    Loader::loadClass('FileUtil');
    $data = FileUtil::readFile($uploaddir . '/' . $file['filename'], true);

    $useCompression = pnConfigGetVar('UseCompression');
    if ($useCompression == 1) {
        // erase output buffer because the gzip destroys binary data
        ob_end_clean();
    }

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");

    if ($inline == 1) {
        header("Content-Description: MediaAttach inline file");
        header("Content-Disposition: inline; filename=" . $file['filename'] . ";");
    } else {
        header("Content-Description: MediaAttach file download");
        header("Content-Disposition: attachment; filename=" . $file['filename'] . ";");
    }
    header("Content-type: " . $file['mimetype']);
    header("Content-Transfer-Encoding: binary");

    if ($useCompression != 1) {
        // header("Content-Length: " . $file['filesize']);
        // TODO: work out better solution (like getting rid of gzip with the above output buffer cleaning)
    }

    echo $data;
    return true;
}
