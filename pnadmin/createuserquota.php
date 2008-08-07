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
 * Create an user quota
 *
 * @param    uid          int       (optional) the user id
 * @param    uname        string    (optional) the user name
 * @param    amount       int       the amount of the user quota
 */
function MediaAttach_admin_createuserquota($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $uid    = (int) FormUtil::getPassedValue('uid',    isset($args['uid'])    ? $args['uid']    : null, 'POST');
    $uname  =       FormUtil::getPassedValue('uname',  isset($args['uname'])  ? $args['uname']  : null, 'POST');
    $amount = (int) FormUtil::getPassedValue('amount', isset($args['amount']) ? $args['amount'] : null, 'POST');
    unset($args);

    if ((empty($uid) && empty($uname)) || empty($amount)) {
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewquotas'));
    }

    if (empty($uid) || !is_numeric($uid)) {
        $uid = pnUserGetIDFromName($uname);
        if (!$uid) {
            LogUtil::registerError('errormsg', 'Error: User ' . DataUtil::formatForDisplay($uname) . ' does not exist');
            return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewquotas'));
        }
    }

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewquotas'));
    }

    if (!pnModAPIFunc('MediaAttach', 'quota', 'createquota',
                        array('qtype' => 1,
                              'qguid' => $uid,
                              'qamount' => _maIntMBToByte($amount)))) {
        LogUtil::registerError(_UPDATEFAILED);
    }

    LogUtil::registerStatus(_UPDATESUCCEDED);
    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewquotas'));
}

