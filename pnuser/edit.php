<?php
/**
 * MediaAttach
 *
 * @version      $Id: edit.php 59 2008-03-02 09:57:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * edit an upload
 *
 * @param    fileid     int      the id of the upload file to be modified
 * @param    objectid   int      generic object id mapped onto fileid if present
 * @param    backurl    string   url to return to
 * @return   output     the modification page
 */
function MediaAttach_user_edit($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $fileid   = (int) FormUtil::getPassedValue('fileid',   (isset($args['fileid']))   ? $args['fileid']   : null, 'GET');
    $objectid = (int) FormUtil::getPassedValue('objectid', (isset($args['objectid'])) ? $args['objectid'] : null, 'GET');
    $backurl  =       FormUtil::getPassedValue('backurl',  (isset($args['backurl']))  ? $args['backurl']  : null, 'GET');
    unset($args);

    if (!empty($objectid)) {
        $fileid = $objectid;
    }

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    $file['desc'] = str_replace("<br />", "\n", $file['desc']);

    $isOwner = (pnModGetVar('MediaAttach', 'ownhandling') && (pnUserGetVar('uid') == $file['uid']));
    if (!$isOwner && !SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$objectid:$fileid", ACCESS_EDIT)) {
        return LogUtil::registerPermissionError();
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));
    $render->assign('file', $file);
    $render->assign('backurl', $backurl);

    $render->assign('categories', pnModAPIFunc('MediaAttach', 'cat', 'getCategoryTree'));
    return $render->fetch(_maIntChooseTemplate($render, 'user', 'edit', $file['modname']));
}
