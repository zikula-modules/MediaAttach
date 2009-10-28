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
 * create a new quota item
 *
 * @param    qtype     int     0/1 (group/user)
 * @param    qguid     int     gid/uid
 * @param    qamount   int     amount in bytes
 * @return   int       quota id on success, false on failure
 */
function MediaAttach_quotaapi_createquota($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['qtype']) || !is_numeric($args['qtype'])
        || !isset($args['qguid']) || !is_numeric($args['qguid'])
        || !isset($args['qamount']) || !is_numeric($args['qamount'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $qtype = $args['qtype'];
    $qguid = $args['qguid'];
    $qamount = $args['qamount'];
    unset($args);

    $quota = array('qtype'        => $qtype,
                   'qguid'        => $qguid,
                   'qamount'      => $qamount);

    $result = DBUtil::insertObject($quota, 'ma_quotas', 'qid');

    if (!$result) {
        return LogUtil::registerError(__('Error! Creation attempt failed.', $dom));
    }

    return $quota['qid'];
}

