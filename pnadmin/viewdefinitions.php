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
 * view definitions
 *
 * @return       output       The definition page
 */
function MediaAttach_admin_viewdefinitions()
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'uploaddir')))
      || !pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'cachedir')))) {
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'modifyconfig'));
    }

    if (!($groups = pnModAPIFunc('MediaAttach', 'filetypes', 'getallgroups'))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    $definitions = pnModAPIFunc('MediaAttach', 'definitions', 'getalldefinitions');

    $render = & pnRender::getInstance('MediaAttach', false);
    $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));

    if (!$definitions) {
        $render->assign('modules', 0);
    }
    else {
        $render->assign('modules', 1);
        $render->assign('groups', $groups);
        $render->assign('definitions', $definitions);
    }

    return $render->fetch('MediaAttach_admin_def_view.htm');
}
