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
 * get all PN groups with their quota values
 *
 * @return   array             group array or false on failure
 */
function MediaAttach_quotaapi_getallgroupquotas()
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    pnModDBInfoLoad('Groups');

    $pntables = pnDBGetTables();

    $gtable  = $pntables['groups'];
    $gcolumn = $pntables['groups_column'];
    $qtable  = $pntables['ma_quotas'];
    $qcolumn = $pntables['ma_quotas_column'];

    $sql = "SELECT   $gcolumn[name],
                     $gcolumn[gid],
                     $qcolumn[qamount]
            FROM     $gtable
            LEFT JOIN $qtable ON $gcolumn[gid] = $qcolumn[qguid]
            AND $qcolumn[qtype] = 0
            ORDER BY $gcolumn[name]";

    $result = DBUtil::executeSQL($sql);

    if($result === false)
        return false;

    if ($result->EOF)
        return false;

    $groupquotas = array();
    while(!$result->EOF)
    {
        if (!empty($result->fields[0]))
        $groupquotas[] = array('name'   => DataUtil::formatForDisplay($result->fields[0]),
                               'gid'    => DataUtil::formatForDisplay($result->fields[1]),
                               'amount' => DataUtil::formatForDisplay($result->fields[2] / (1024 * 1024))); //get amount in MB
        $result->MoveNext();
    }
    $result->Close();
//die(print_r($groupquotas));
    return $groupquotas;
}

