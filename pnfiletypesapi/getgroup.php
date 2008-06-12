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
 * get a specific group
 *
 * @param    int     $args['gid']  id of group to get
 * @return   array                 group array
 */
function MediaAttach_filetypesapi_getgroup($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['gid']) || !is_numeric($args['gid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $gid = $args['gid'];
    unset($args);

    $group = DataUtil::formatForDisplay(DBUtil::selectObjectByID('ma_groups', $gid, 'gid'));

    return $group;
}

