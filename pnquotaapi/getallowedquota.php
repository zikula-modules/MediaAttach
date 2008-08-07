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
 * get allowed quota for a user
 *
 * @param    uid      int   id of user
 * @return   array    amount of quota
 */
function MediaAttach_quotaapi_getallowedquota($args)
{
    if (!isset($args['uid']) || !is_numeric($args['uid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $uid = $args['uid'];
    unset($args);

    $amount = 0;


    $quotaJoin = array();
    $quotaJoin[] = array('join_table'          =>  'group_membership', // table to join with
                         'join_field'          =>  'gid',              // field selected through LEFT JOIN
                         'object_field_name'   =>  'qguid2',           // fieldname in the resulting object
                         'compare_field_table' =>  'qguid',            // field to join on from main table
                         'compare_field_join'  =>  'gid');             // field to join on from the join table

    $pntables = pnDBGetTables();
    $gmcolumn  = $pntables['group_membership_column'];
    $qcolumn = $pntables['ma_quotas_column'];

    $where = "WHERE $qcolumn[qtype] = '0'
              AND $gmcolumn[uid] = '" . DataUtil::formatForStore($uid) . "'";
    $orderBy = "ORDER BY $qcolumn[qamount] DESC LIMIT 1";
    $dbquotas = DBUtil::selectExpandedObjectArray('ma_quotas', $quotaJoin, $where, $orderBy);

    if ($dbquotas === false) {
        return false;
    }

    if (isset($dbquotas[0]['qamount'])) {
        $amount = $dbquotas[0]['qamount'];
    }



    $pntables = pnDBGetTables();
    $qcolumn = $pntables['ma_quotas_column'];

    $where = "WHERE $qcolumn[qtype] = '1'
              AND $qcolumn[qguid] = '" . DataUtil::formatForStore($uid) . "'";
    $dbquotas = DBUtil::selectObjectArray('ma_quotas', $where);

    if ($dbquotas === false) {
        return false;
    }

    if (isset($dbquotas[0]['qamount'])) {
        $amount = $dbquotas[0]['qamount'];
    }

    return DataUtil::formatForDisplay($amount);
}

