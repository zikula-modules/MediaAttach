<?php
/**
 * MediaAttach
 *
 * @version      $Id: updatethumb.php 97 2008-03-10 15:02:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');
Loader::requireOnce('modules/MediaAttach/common_imgthumb.php');

/**
 * Recreate a thumbnail following specific parameters
 *
 * @param    fileid     int      the id of the file to be modified
 * @param    objectid   int      generic object id mapped onto fileid if present
 * @param    thumbnr    int      thumbnail number: 1..x (optional, default to modvar setting)
 * @param    x1         int      x1 coordinate
 * @param    y1         int      y1 coordinate
 * @param    x2         int      x2 coordinate
 * @param    y2         int      y2 coordinate
 * @param    width      int      dimension width
 * @param    height     int      dimension height
 * @param    backurl    string   url to return to
 */
function MediaAttach_user_updatethumb($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $fileid   = (int) FormUtil::getPassedValue('fileid',    (isset($args['fileid']) && is_numeric($args['fileid'])) ? $args['fileid'] : null, 'POST');
    $objectid = (int) FormUtil::getPassedValue('objectid',  (isset($args['objectid'])) ? $args['objectid'] : null,  'POST');
    $thumbnr  = (int) FormUtil::getPassedValue('thumbnr',  (isset($args['thumbnr']) && is_numeric($args['thumbnr'])) ? $args['thumbnr'] : 0, 'GET');
    if ($thumbnr == 0) {
        $thumbnr = pnModGetVar('MediaAttach', 'defaultthumb');
    }

    $thumbsizes = pnModGetVar('MediaAttach', 'thumbsizes');
    $thumbwidth = $thumbsizes[$thumbnr-1][0];
    $thumbheight = $thumbsizes[$thumbnr-1][1];

    $coords = array();
    $coords['x1']       = (int) FormUtil::getPassedValue('x1',        (isset($args['x1']))       ? $args['x1']       : 0,     'POST');
    $coords['y1']       = (int) FormUtil::getPassedValue('y1',        (isset($args['y1']))       ? $args['y1']       : 0,     'POST');
    $coords['x2']       = (int) FormUtil::getPassedValue('x2',        (isset($args['x2']))       ? $args['x2']       : $thumbwidth,   'POST');
    $coords['y2']       = (int) FormUtil::getPassedValue('y2',        (isset($args['y2']))       ? $args['y2']       : $thumbheight,  'POST');
    $coords['width']    = (int) FormUtil::getPassedValue('width',     (isset($args['width']))    ? $args['width']    : $thumbwidth,   'POST');
    $coords['height']   = (int) FormUtil::getPassedValue('height',    (isset($args['height']))   ? $args['height']   : $thumbheight,  'POST');
    $backurl            =       FormUtil::getPassedValue('backurl',   (isset($args['backurl']))  ? $args['backurl']  : null, 'POST');
    unset($args);

    if (!empty($objectid)) {
        $fileid = $objectid;
    }

    $backurl = str_replace('&amp;', '&', base64_decode($backurl)) . '#file' . $fileid;

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(__("Invalid 'authkey':  this probably means that you pressed the 'Back' button, or that the page 'authkey' expired. Please refresh the page and try again.", $dom));
        return pnRedirect($backurl);
    }

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        LogUtil::registerError(__('Error! Could not load items.', $dom));
        return pnRedirect($backurl);
    }

    $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');
    $fullFilename = $uploaddir . '/' . $file['filename'];

    // delete old thumbnail image
    $thumbFilePath = _maIntImageThumb(array('file' => $fullFilename,
                                            'thumbnr' => $thumbnr));
    pnModAPIFunc('MediaAttach', 'filesystem', 'deletefile', array('file' => $thumbFilePath));

    // create new one
    $thumbFilePath = _maIntImageThumb(array('file' => $fullFilename,
                                            'thumbnr' => $thumbnr,
                                            'offset_w' => $coords['x1'],
                                            'offset_h' => $coords['y1'],
                                            'width' => $coords['width'],
                                            'height' => $coords['height']));

    LogUtil::registerStatus(__('Done! Item updated.', $dom));

    return pnRedirect($backurl);
}
