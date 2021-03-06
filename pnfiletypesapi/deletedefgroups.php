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
 * delete relations of either a definition or a group
 *
 * @param    did    int    (optional) definition
 * @param    gid    int    (optional) group
 * @return   int    true on success, false on failure
 */
function MediaAttach_filetypesapi_deletedefgroups($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if ((!isset($args['did']) || !is_numeric($args['did'])) && (!isset($args['gid']) || !is_numeric($args['gid']))) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    if (isset($args['did'])) {
        $did = $args['did'];
    }
    if (isset($args['gid'])) {
        $gid = $args['gid'];
    }
    unset($args);

    $pntables = pnDBGetTables();
    $column   = $pntables['ma_defgroups_column'];

    if (isset($did)) {
        $where    = "WHERE $column[did] = '" . (int) DataUtil::formatForStore($did) . "'";
    }
    elseif (isset($gid)) {
        $where    = "WHERE $column[gid] = '" . (int) DataUtil::formatForStore($gid) . "'";
    }

    $resultwhere = DBUtil::deleteObject(array(), 'ma_defgroups', $where);

    if (!$resultwhere) {
        return LogUtil::registerError(__('Error! Sorry! Deletion attempt failed.', $dom));
    }

    return true;
}
