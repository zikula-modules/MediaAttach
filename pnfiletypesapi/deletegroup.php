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


/**
 * delete a group
 *
 * @param    int      $args['gid']   ID of the group
 * @return   bool                    true on success, false on failure
 */
function MediaAttach_filetypesapi_deletegroup($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($gid) || !is_numeric($gid)) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $gid = $args['gid'];
    unset($args);

    if (!($group = pnModAPIFunc('MediaAttach', 'filetypes', 'getgroup', array('gid' => $gid)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $result = DBUtil::deleteObjectByID('ma_groups', $gid, 'gid');

    if (!$result) {
        return LogUtil::registerError(_DELETEFAILED);
    }

    if (!pnModAPIFunc('MediaAttach', 'filetypes', 'deleteformatgroups',
                        array('gid' => $gid))) {
        return LogUtil::registerError(_DELETEFAILED);
    }

    $render = pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $gid);

    return true;
}

