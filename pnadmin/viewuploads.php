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
 * view user files
 *
 * @return       output       The list page
 */
function MediaAttach_admin_viewuploads()
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'uploaddir')))
      || !pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'cachedir')))) {
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'modifyconfig'));
    }

    $render = pnRender::getInstance('MediaAttach', false);
    _maIntProcessFileList($render, 20, '');

    $definition = array();
    $definition['displayfiles'] = 2; // show all files
    $definition['sendmails'] = 0;
    $definition['downloadmode'] = $preview;

    $render->assign('definition', $definition);

    return $render->fetch('MediaAttach_admin_upload_view.htm');
}

