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
 * edit a group
 *
 * @param     gid          int     the id of the group to be modified
 * @param     objectid     int     generic object id mapped onto gid if present
 * @return    output       the modification page
 */
function MediaAttach_admin_editgroup($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $gid      = (int) FormUtil::getPassedValue('gid',      isset($args['gid'])      ? $args['gid']      : null, 'POST');
    $objectid = (int) FormUtil::getPassedValue('objectid', isset($args['objectid']) ? $args['objectid'] : null, 'POST');
    unset($args);

    if (!empty($objectid)) {
        $gid = $objectid;
    }

    if (!($allformats = pnModAPIFunc('MediaAttach', 'filetypes', 'getallformats'))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $formats = pnModAPIFunc('MediaAttach', 'filetypes', 'getgroupformats', array('gid' => $gid));

    if (!($group = pnModAPIFunc('MediaAttach', 'filetypes', 'getgroup', array('gid' => $gid)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));
    $render->assign('group', $group);
    $render->assign('formats', $formats);
    $render->assign('allformats', $allformats);
    return $render->fetch('MediaAttach_admin_group_edit.htm');
}

