<?php
/**
 * MediaAttach
 *
 * @version      $Id: editthumb.php 96 2008-03-09 22:49:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * edit an upload
 *
 * @param    int      fileid     the id of the upload file to be modified
 * @param    int      objectid   generic object id mapped onto fileid if present
 * @param    int      thumbnr    thumbnail number: 1..x (optional, default to modvar setting)
 * @param    string   backurl    url to return to
 * @return   output              the modification page
 */
function MediaAttach_user_editthumb($args)
{
    $fileid   = (int) FormUtil::getPassedValue('fileid',   (isset($args['fileid']))   ? $args['fileid']   : null, 'GET');
    $objectid = (int) FormUtil::getPassedValue('objectid', (isset($args['objectid'])) ? $args['objectid'] : null, 'GET');
    $backurl  =       FormUtil::getPassedValue('backurl',  (isset($args['backurl']))  ? $args['backurl']  : null, 'GET');
    $thumbnr  = (int) FormUtil::getPassedValue('thumbnr',  (isset($args['thumbnr']) && is_numeric($args['thumbnr'])) ? $args['thumbnr'] : 0, 'GET');
    if ($thumbnr == 0) {
        $thumbnr = pnModGetVar('MediaAttach', 'defaultthumb');
    }
    unset($args);

    if (!empty($objectid)) {
        $fileid = $objectid;
    }

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $usethumbcropper = pnModGetVar('MediaAttach', 'usethumbcropper');
    if ($usethumbcropper == 0) {
        $backurl = str_replace('&amp;', '&', base64_decode($backurl)) . '#file' . $fileid;
        LogUtil::registerError(_MEDIAATTACH_CROPTHUMBDEACTIVATED);
        return pnRedirect($backurl);
    }

    $isOwner = (pnModGetVar('MediaAttach', 'ownhandling') && (pnUserGetVar('uid') == $file['uid']));
    if (!$isOwner && !SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$objectid:$fileid", ACCESS_EDIT)) {
        return LogUtil::registerPermissionError();
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));
    $render->assign('file', $file);
    $render->assign('backurl', $backurl);
    $render->assign('thumbnr', $thumbnr);
    $render->assign('cropsizemode', pnModGetVar('MediaAttach', 'cropsizemode'));

    return $render->fetch(_maIntChooseTemplate($render, 'user', 'editthumb', $file['modname']));
}

