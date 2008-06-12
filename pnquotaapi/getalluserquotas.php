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
 * get all PN users
 *
 * @return   array             user array or false on failure
 */
function MediaAttach_quotaapi_getalluserquotas()
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    pnModDBInfoLoad('Users');

    $pntables = pnDBGetTables();

    $utable   = $pntables['users'];
    $ucolumn  = $pntables['users_column'];
    $qtable   = $pntables['ma_quotas'];
    $qcolumn  = $pntables['ma_quotas_column'];

    $sql = "SELECT   $ucolumn[uname],
                     $ucolumn[uid],
                     q.$qcolumn[qamount]
            FROM     $utable, $qtable q
            WHERE    $ucolumn[uid] = q.$qcolumn[qguid] 
            AND      q.$qcolumn[qtype] = 1
            ORDER BY $ucolumn[uname] ASC";

    $result = DBUtil::executeSQL($sql);

    if ($result === false)
        return false;

    $userquotas = array();
    while(!$result->EOF)
    {
        $userquotas[] = array('name'   => DataUtil::formatForDisplay($result->fields[0]),
                              'uid'    => DataUtil::formatForDisplay($result->fields[1]),
                              'amount' => DataUtil::formatForDisplay($result->fields[2] / (1024 * 1024))); //get amount in MB
        $result->MoveNext();
    }
    $result->Close();

    return $userquotas;
}

