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
 * get all groups of a format
 *
 * @param    int    $args['fid']  id of file type
 * @return   array                group array, or false on failure
 */
function MediaAttach_filetypesapi_getformatgroups($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['fid']) || !is_numeric($args['fid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $fid = $args['fid'];
    unset($args);

    $groupJoin = array();
    $groupJoin[] = array('join_table'          =>  'ma_formatgroups',  // table to join with
                          'join_field'          =>  'gid',              // field selected through LEFT JOIN
                          'object_field_name'   =>  'gidtwo',           // fieldname in the resulting object
                          'compare_field_table' =>  'gid',              // field to join on from main table
                          'compare_field_join'  =>  'gid');             // field to join on from the join table

    $pntables = pnDBGetTables();
    $gcolumn  = $pntables['ma_groups_column'];
    $fgcolumn = $pntables['ma_formatgroups_column'];

    $where = "WHERE $fgcolumn[fid] = '" . (int) DataUtil::formatForStore($fid) . "'";
    $orderBy = "ORDER BY $gcolumn[groupname] ASC";
    $dbgroups = DBUtil::selectExpandedObjectArray('ma_groups', $groupJoin, $where, $orderBy);

    if ($dbgroups === false || !$dbgroups) {
        return false;
    }

    return $dbgroups;
}

