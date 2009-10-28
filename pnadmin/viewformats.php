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
 * view file formats
 *
 * @return       output       The format page
 */
function MediaAttach_admin_viewformats()
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'uploaddir')))
      || !pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'cachedir')))) {
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'modifyconfig'));
    }

    if (!($groups = pnModAPIFunc('MediaAttach', 'filetypes', 'getallgroups')) || !($formats = pnModAPIFunc('MediaAttach', 'filetypes', 'getallformats'))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));
    $render->assign('groups', $groups);
    $render->assign('formats', $formats);
    $dangerformats = array('cgi', 'pl', 'asp', 'phtml', 'php', 'php3', 'php4', 'php5', 'exe', 'com', 'bat', 'jsp', 'cfm', 'shtml');
    $render->assign('danger', $dangerformats);

    return $render->fetch('MediaAttach_admin_format_view.htm');
}

