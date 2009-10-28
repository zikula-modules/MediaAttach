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
 * delete all quotas
 *
 * @param    qtype      int     0 = groups, 1 = user
 * @return   int        true on success, false on failure
 */
function MediaAttach_quotaapi_deleteallquotas($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['qtype']) || !is_numeric($args['qtype'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $qtype = $args['qtype'];
    unset($args);

    $pntables = pnDBGetTables();
    $qcolumn  = $pntables['ma_quotas_column'];
    $where    = "WHERE $qcolumn[qtype] = '" . (int) DataUtil::formatForStore($qtype) . "'";

    $resultwhere = DBUtil::deleteObject(array(), 'ma_quotas', $where);

    if (!$resultwhere) {
        return LogUtil::registerError(__('Error! Sorry! Deletion attempt failed.', $dom));
    }

    return true;
}

