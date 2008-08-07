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
 * get all groups of a definition
 *
 * @param    did     int    id of definition
 * @return   array   group array, or false on failure
 */
function MediaAttach_filetypesapi_getdefgroups($args)
{
    if (!isset($args['did']) || !is_numeric($args['did'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $did = $args['did'];
    unset($args);

    $groupJoin = array();
    $groupJoin[] = array('join_table'           =>  'ma_defgroups',  // table to join with
                          'join_field'          =>  'gid',              // field selected through LEFT JOIN
                          'object_field_name'   =>  'gidtwo',           // fieldname in the resulting object
                          'compare_field_table' =>  'gid',              // field to join on from main table
                          'compare_field_join'  =>  'gid');             // field to join on from the join table

    $pntables = pnDBGetTables();
    $gcolumn  = $pntables['ma_groups_column'];
    $dgcolumn = $pntables['ma_defgroups_column'];

    $where = "WHERE $dgcolumn[did] = '" . (int) DataUtil::formatForStore($did) . "'";
    $orderBy = "ORDER BY $gcolumn[groupname] ASC";
    $dbgroups = DBUtil::selectExpandedObjectArray('ma_groups', $groupJoin, $where, $orderBy);

    if ($dbgroups === false || !$dbgroups) {
        return false;
    }

    return $dbgroups;
}
