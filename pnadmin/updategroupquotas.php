<?php
/**
 * MediaAttach
 *
 * @version      $Id: $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * Modify the group quotas
 *
 * @param    int     anzgroups    the number of groups
 * @param    int     amountx      the amount of the quota of group x (x = 1 to anzgroups)
 */
function MediaAttach_admin_updategroupquotas($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $anzgroups = (int) FormUtil::getPassedValue('anzgroups', isset($args['anzgroups']) ? $args['anzgroups'] : null, 'POST');
    unset($args);

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewquotas'));
    }


    if (!pnModAPIFunc('MediaAttach', 'quota', 'deleteallquotas', array('qtype' => 0))) {
        LogUtil::registerError(_UPDATEFAILED);
    }

    for ($i = 1; $i <= $anzgroups; $i++){
        $gid    = (int) FormUtil::getPassedValue('gid' . $i,     isset($args['gid'])          ? $args['gid']          : null, 'POST');
        $amount = (int) FormUtil::getPassedValue('amountg' . $i, isset($args['amountg' . $i]) ? $args['amountg' . $i] : null, 'POST');

        if (!empty($amount)) {
            if (!pnModAPIFunc('MediaAttach', 'quota', 'createquota',
                            array('qtype' => 0,
                                  'qguid' => $gid,
                                  'qamount' => _maIntMBToByte($amount)))) {
                LogUtil::registerError(_UPDATEFAILED);
            }
        }
    }

    LogUtil::registerStatus(_DELETESUCCEDED);
    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewquotas'));
}

