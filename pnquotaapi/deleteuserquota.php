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
 * delete one user quota
 *
 * @param    uid     int     uid of user
 * @return   int     true on success, false on failure
 */
function MediaAttach_quotaapi_deleteuserquota($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['uid']) || !is_numeric($args['uid'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $uid = $args['uid'];
    unset($args);

    $pntables = pnDBGetTables();
    $qcolumn  = $pntables['ma_quotas_column'];
    $where    = "WHERE $qcolumn[qtype] = '1'
                 AND $qcolumn[qguid] = '" . (int) DataUtil::formatForStore($uid) . "'";

    $resultwhere = DBUtil::deleteObject(array(), 'ma_quotas', $where);

    if (!$resultwhere) {
        return LogUtil::registerError(__('Error! Sorry! Deletion attempt failed.', $dom));
    }

    return true;
}
