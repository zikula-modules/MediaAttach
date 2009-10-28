<?php
/**
 * MediaAttach
 *
 * @version      $Id: display.php 22 2008-02-23 09:57:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * display one file in a separate template
 *
 * @param    fileid        int     upload id to show
 * @return   output        the data
 */
function MediaAttach_user_display($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $fileid = (int) FormUtil::getPassedValue('fileid', (isset($args['fileid'])) ? $args['fileid'] : null, 'GET');
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

    $currentUser = pnUserGetVar('uid');
    $ownHandling = pnModGetVar('MediaAttach', 'ownhandling');
    $file = _maIntPrepFileForTemplate($file, $currentUser, $ownHandling);

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('currentuser', $currentUser);
    $render->assign('file', $file);

    return $render->fetch(_maIntChooseTemplate($render, 'user', 'display', $file['modname']));
}
