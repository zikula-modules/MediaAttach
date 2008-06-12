<?php
/**
 * MediaAttach: Profile integration logic
 *
 * @version      $Id: pnaccount.php 22 2008-02-23 09:30:43Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * Retrieve list of files owned by current user
 *
 * @return   array   pnRender output
 */
function MediaAttach_account_viewuploads()
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }

    if (!pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'uploaddir')))
      || !pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'cachedir')))) {
        return false;
    }

    $render = pnRender::getInstance('MediaAttach', false);

    _maIntProcessFileList($render, 5, array('userFilter' => pnUserGetVar('uid')));

    $render->assign('definition', array('displayfiles' => 1));

    return $render->fetch('MediaAttach_profile_myuploads.htm');
}
