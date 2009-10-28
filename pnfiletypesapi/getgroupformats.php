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
 * get all formats of a group
 *
 * @param    gid    int    id of group
 * @return   array  format array, or false on failure
 */
function MediaAttach_filetypesapi_getgroupformats($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!isset($args['gid']) || !is_numeric($args['gid'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $gid = $args['gid'];
    unset($args);

    $formatJoin = array();
    $formatJoin[] = array('join_table'          =>  'ma_formatgroups',  // table to join with
                          'join_field'          =>  'fid',              // field selected through LEFT JOIN
                          'object_field_name'   =>  'fidtwo',           // fieldname in the resulting object
                          'compare_field_table' =>  'fid',              // field to join on from main table
                          'compare_field_join'  =>  'fid');             // field to join on from the join table

    $pntables = pnDBGetTables();
    $fcolumn  = $pntables['ma_formats_column'];
    $fgcolumn = $pntables['ma_formatgroups_column'];

    $where = "WHERE $fgcolumn[gid] = '" . (int) DataUtil::formatForStore($gid) . "'";
    $orderBy = "ORDER BY $fcolumn[extension] ASC";
    $dbformats = DBUtil::selectExpandedObjectArray('ma_formats', $formatJoin, $where, $orderBy);

    if ($dbformats === false || !$dbformats) {
        return false;
    }

    return $dbformats;
}

