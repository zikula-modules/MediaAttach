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
 * edit a file type
 *
 * @param     fid          int     the id of the format to be modified
 * @param     objectid     int     generic object id mapped onto fid if present
 * @return    output       the modification page
 */
function MediaAttach_admin_editformat($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $fid      = (int) FormUtil::getPassedValue('fid',      isset($args['fid'])      ? $args['fid']      : null, 'POST');
    $objectid = (int) FormUtil::getPassedValue('objectid', isset($args['objectid']) ? $args['objectid'] : null, 'POST');
    unset($args);

    if (!empty($objectid)) {
        $fid = $objectid;
    }

    if (!($allgroups = pnModAPIFunc('MediaAttach', 'filetypes', 'getallgroups'))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $groups = pnModAPIFunc('MediaAttach', 'filetypes', 'getformatgroups', array('fid' => $fid));

    if (!($format = pnModAPIFunc('MediaAttach', 'filetypes', 'getformat', array('fid' => $fid)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));
    $render->assign('format', $format);
    $render->assign('groups', $groups);
    $render->assign('allgroups', $allgroups);
    return $render->fetch('MediaAttach_admin_format_edit.htm');
}
