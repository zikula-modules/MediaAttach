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
 * Modify the user quotas
 *
 * @param    numusers     int    the number of users
 * @param    amountx      int    the amount of the quota of user x (x = 1 to numusers)
 */
function MediaAttach_admin_updateuserquotas($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $numusers = (int) FormUtil::getPassedValue('numusers', isset($args['numusers']) ? $args['numusers'] : null, 'POST');
    unset($args);

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewquotas'));
    }


    if (!pnModAPIFunc('MediaAttach', 'quota', 'deleteallquotas', array('qtype' => 1))) {
        LogUtil::registerError(_UPDATEFAILED);
    }

    for ($i = 1; $i <= $numusers; $i++){
        $uid    = (int) FormUtil::getPassedValue('uid' . $i,     isset($args['uid'])          ? $args['uid']          : null, 'POST');
        $amount = (int) FormUtil::getPassedValue('amountu' . $i, isset($args['amountu' . $i]) ? $args['amountu' . $i] : null, 'POST');

        if (!empty($amount)) {
            if (!pnModAPIFunc('MediaAttach', 'quota', 'createquota',
                            array('qtype' => 1,
                                  'qguid' => $uid,
                                  'qamount' => _maIntMBToByte($amount)))) {
                LogUtil::registerError(_UPDATEFAILED);
            }
        }
    }

    LogUtil::registerStatus(_UPDATESUCCEDED);
    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewquotas'));
}

