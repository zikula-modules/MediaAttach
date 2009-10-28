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
 * @param    gid    int    id of group to get
 * @return   array  group array
 */
function MediaAttach_filetypesapi_getgroup($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['gid']) || !is_numeric($args['gid'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $gid = $args['gid'];
    unset($args);

    $group = DataUtil::formatForDisplay(DBUtil::selectObjectByID('ma_groups', $gid, 'gid'));

    return $group;
}

