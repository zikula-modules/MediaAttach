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
 * get all file groups
 *
 * @return   array   array of groups, or false on failure
 */
function MediaAttach_filetypesapi_getallgroups()
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $pntables = pnDBGetTables();
    $gcolumn = $pntables['ma_groups_column'];
    $where = "";
    $orderBy = "ORDER BY $gcolumn[groupname]";
    $dbgroups = DBUtil::selectObjectArray('ma_groups', $where, $orderBy);

    if (!$dbgroups) {
        return LogUtil::registerError(_GETFAILED);
    }

    $groups = array();

    foreach($dbgroups as $currentGroup) {
        if (!$currentGroup['image']) $currentGroup['image'] = 'folder.gif';
        $formats = pnModAPIFunc('MediaAttach', 'filetypes', 'getgroupformats',
                            array('gid' => $currentGroup['gid']));
        $groups[] = array('gid' => $currentGroup['gid'],
                              'groupname' => DataUtil::formatForDisplay($currentGroup['groupname']),
                              'directory' => DataUtil::formatForDisplay($currentGroup['directory']),
                              'image'     => DataUtil::formatForDisplay($currentGroup['image']),
                              'formats'   => $formats);
    }

    return $groups;
}

