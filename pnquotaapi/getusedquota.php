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
 * get used quota for a user
 *
 * @param    uid      int   id of user
 * @return   array    amount of quota
 */
function MediaAttach_quotaapi_getusedquota($args)
{
    if (!isset($args['uid']) || !is_numeric($args['uid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $uid = $args['uid'];
    unset($args);

    $pntables = pnDBGetTables();
    $fcolumn = $pntables['ma_files_column'];
    $where = "WHERE $fcolumn[uid] = '" . (int) DataUtil::formatForStore($uid) . "'";
    $dbamounts = DBUtil::selectObjectArray ('ma_files', $where);

    if ($dbamounts === false) {
        return false;
    }

    $amount = 0;

    foreach($dbamounts as $currentAmount)
    {
        $amount += $currentAmount['filesize'];
    }

    return $amount;
}

