<?php
/**
 * MediaAttach
 *
 * @version      $Id: delete.php 59 2008-03-02 09:57:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

Loader::requireOnce('modules/MediaAttach/common.php');
Loader::requireOnce('modules/MediaAttach/common_imgthumb.php');

/**
 * delete a file
 *
 * @param     fileid         int     the id of the file to be deleted
 * @param     objectid       int     generic object id mapped onto fileid if present
 * @param     confirmation   bool    confirmation that this file can be deleted
 * @param     backurl        string  url to return after process
 */
function MediaAttach_user_delete($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $fileid       = (int)  FormUtil::getPassedValue('fileid',       (isset($args['fileid']))       ? $args['fileid']       : null, 'GETPOST');
    $objectid     = (int)  FormUtil::getPassedValue('objectid',     (isset($args['objectid']))     ? $args['objectid']     : null, 'GETPOST');
    $confirmation = (bool) FormUtil::getPassedValue('confirmation', (isset($args['confirmation'])) ? $args['confirmation'] : null, 'POST');
    $backurl      =        FormUtil::getPassedValue('backurl',      (isset($args['backurl']))      ? $args['backurl']      : null, 'GETPOST');
    unset($args);

    if (!empty($objectid)) {
        $fileid = $objectid;
    }

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    $isOwner = (pnModGetVar('MediaAttach', 'ownhandling') && (pnUserGetVar('uid') == $file['uid']));
    if (!$isOwner && !SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$objectid:$fileid", ACCESS_DELETE)) {
        return LogUtil::registerPermissionError();
    }

    if ($confirmation != true) {
        $render = pnRender::getInstance('MediaAttach', false);
        $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));

        list($file['title'], $file['desc']) = pnModCallHooks('item', 'transform', '', array($file['title'], $file['desc']));
        $render->assign('file', $file);
        $render->assign('backurl', $backurl);

        return $render->fetch(_maIntChooseTemplate($render, 'user', 'delete', $file['modname']));
    }

    $backurl = str_replace('&amp;', '&', base64_decode($backurl)) . '#files';

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(__("Invalid 'authkey':  this probably means that you pressed the 'Back' button, or that the page 'authkey' expired. Please refresh the page and try again.", $dom));
        return pnRedirect($backurl);
    }

    if (pnModAPIFunc('MediaAttach', 'user', 'delete', array('fileid' => $fileid))) {
        if ($file['extension'] == 'extvid') {
            LogUtil::registerStatus(__('Done! Item deleted.', $dom));
        } else {
            // delete file physically
            $fullFileName = pnModGetVar('MediaAttach', 'uploaddir') . '/' . $file['filename'];

            // start with thumbnails
            $thumbSizes = pnModGetVar('MediaAttach', 'thumbsizes');
            $numThumbSizes = count($thumbSizes);
            for($thumbNumber = 1; $thumbNumber <= $numThumbSizes; $thumbNumber++) {
                $thumbFilePath = _maIntImageThumb(array('file' => $fullFileName,
                                                        'thumbnr' => $thumbNumber));
                pnModAPIFunc('MediaAttach', 'filesystem', 'deletefile', array('file' => $thumbFilePath));
            }

            // now delete original file
            if (pnModAPIFunc('MediaAttach', 'filesystem', 'deletefile', array('file' => $fullFileName))) {
                LogUtil::registerStatus(__('Done! Item deleted.', $dom));
            } else {
                LogUtil::registerError(__('Error! Sorry! Deletion attempt failed.', $dom));
            }
        }
    }

    $maInfo = pnModGetInfo(pnModGetIDFromName('MediaAttach'));
    // change redirect url in case the user comes from the file display page
    if (strpos($backurl, $maInfo['displayname']) !== false && strpos($backurl, 'display') !== false) {
        if (strpos($backurl, 'admin') !== false) {
            $backurl = pnModURL('MediaAttach', 'admin', 'view');
        } else {
            if (pnModGetVar('MediaAttach', 'usefrontpage') != 0) {
                $backurl = pnModURL('MediaAttach', 'user', 'main');
            } else {
                $backurl = pnConfigGetVar('entrypoint');
            }
        }
    }

    return pnRedirect($backurl);
}
