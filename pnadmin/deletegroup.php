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


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * delete a group
 *
 * @param     gid            int     the id of the group to be modified
 * @param     objectid       int     generic object id mapped onto gid if present
 * @param     confirmation   bool    confirmation that this group can be deleted
 */
function MediaAttach_admin_deletegroup($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $gid          = (int)  FormUtil::getPassedValue('gid',          isset($args['gid'])          ? $args['gid']          : null, 'POST');
    $objectid     = (int)  FormUtil::getPassedValue('objectid',     isset($args['objectid'])     ? $args['objectid']     : null, 'POST');
    $confirmation = (bool) FormUtil::getPassedValue('confirmation', isset($args['confirmation']) ? $args['confirmation'] : null, 'POST');
    unset($args);

    if (!empty($objectid)) {
        $gid = $objectid;
    }

    if (!($group = pnModAPIFunc('MediaAttach', 'filetypes', 'getgroup', array('gid' => $gid)))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    if (empty($confirmation)) {
        $render = pnRender::getInstance('MediaAttach', false);
        $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));
        $render->assign('group', $group);
        return $render->fetch('MediaAttach_admin_group_delete.htm');
    }

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(__("Invalid 'authkey':  this probably means that you pressed the 'Back' button, or that the page 'authkey' expired. Please refresh the page and try again.", $dom));
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewgroups'));
    }

    if (pnModAPIFunc('MediaAttach', 'filetypes', 'deletegroup', array('gid' => $gid))) {
        LogUtil::registerStatus(__('Done! Item deleted.', $dom));
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewgroups'));
}

