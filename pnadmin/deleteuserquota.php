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
 * delete user quota
 *
 * @param    int    uid            the id of the user
 */
function MediaAttach_admin_deleteuserquota($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $uid      = (int) FormUtil::getPassedValue('uid',      isset($args['uid'])      ? $args['uid']      : null, 'REQUEST');
    $objectid = (int) FormUtil::getPassedValue('objectid', isset($args['objectid']) ? $args['objectid'] : null, 'REQUEST');
    unset($args);

    if (!empty($objectid)) {
        $uid = $objectid;
    }

    if (pnModAPIFunc('MediaAttach', 'quota', 'deleteuserquota', array('uid' => $uid))) {
        LogUtil::registerStatus(_DELETESUCCEDED);
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewquotas'));
}
