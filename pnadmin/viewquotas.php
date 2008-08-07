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
 * view quotas
 *
 * @return       output       The quota page
 */
function MediaAttach_admin_viewquotas()
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'uploaddir')))
      || !pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'cachedir')))) {
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'modifyconfig'));
    }

    if (!($groupquotas = pnModAPIFunc('MediaAttach', 'quota', 'getallgroupquotas'))) {
        $groupquotas = 0;
    }

    if (!($userquotas = pnModAPIFunc('MediaAttach', 'quota', 'getalluserquotas'))) {
        $userquotas = 0;
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));
    $render->assign('groupquotas', $groupquotas);
    $render->assign('userquotas', $userquotas);

    return $render->fetch('MediaAttach_admin_quotas.htm');
}

