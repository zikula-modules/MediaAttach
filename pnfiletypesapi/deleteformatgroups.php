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
 * delete relations of either a format or a group
 *
 * @param    fid    int    (optional) format
 * @param    gid    int    (optional) group
 * @return   int    true on success, false on failure
 */
function MediaAttach_filetypesapi_deleteformatgroups($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if ((!isset($args['fid']) || !is_numeric($args['fid'])) && (!isset($args['gid']) || !is_numeric($args['gid']))) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $fid = $args['fid'];
    $gid = $args['gid'];
    unset($args);

    $pntables = pnDBGetTables();
    $column   = $pntables['ma_formatgroups_column'];

    if (isset($fid)) {
        $where    = "WHERE $column[fid] = '" . (int) DataUtil::formatForStore($fid) . "'";
    }
    elseif (isset($gid)) {
        $where    = "WHERE $column[gid] = '" . (int) DataUtil::formatForStore($gid) . "'";
    }

    $resultwhere = DBUtil::deleteObject(array(), 'ma_formatgroups', $where);

    if (!$resultwhere) {
        return LogUtil::registerError(__('Error! Sorry! Deletion attempt failed.', $dom));
    }

    return true;
}

