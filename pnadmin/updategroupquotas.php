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


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * Modify the group quotas
 *
 * @param    numgroups    int     the number of groups
 * @param    amountx      int     the amount of the quota of group x (x = 1 to numgroups)
 */
function MediaAttach_admin_updategroupquotas($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $numgroups = (int) FormUtil::getPassedValue('numgroups', isset($args['numgroups']) ? $args['numgroups'] : null, 'POST');
    unset($args);

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(__("Invalid 'authkey':  this probably means that you pressed the 'Back' button, or that the page 'authkey' expired. Please refresh the page and try again.", $dom));
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewquotas'));
    }


    if (!pnModAPIFunc('MediaAttach', 'quota', 'deleteallquotas', array('qtype' => 0))) {
        LogUtil::registerError(__('Error! Update attempt failed.', $dom));
    }

    for ($i = 1; $i <= $numgroups; $i++){
        $gid    = (int) FormUtil::getPassedValue('gid' . $i,     isset($args['gid'])          ? $args['gid']          : null, 'POST');
        $amount = (int) FormUtil::getPassedValue('amountg' . $i, isset($args['amountg' . $i]) ? $args['amountg' . $i] : null, 'POST');

        if (!empty($amount)) {
            if (!pnModAPIFunc('MediaAttach', 'quota', 'createquota',
                            array('qtype' => 0,
                                  'qguid' => $gid,
                                  'qamount' => _maIntMBToByte($amount)))) {
                LogUtil::registerError(__('Error! Update attempt failed.', $dom));
            }
        }
    }

    LogUtil::registerStatus(__('Done! Item deleted.', $dom));
    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewquotas'));
}

