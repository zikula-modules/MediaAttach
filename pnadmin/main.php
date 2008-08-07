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
 * the main administration function
 *
 * @return       output       The main module admin page.
 */
function MediaAttach_admin_main()
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');

    if (!pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => $uploaddir))
      || !pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'cachedir')))) {
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'modifyconfig'));
    }

    list($dirs, $files) = pnModAPIFunc('MediaAttach', 'filesystem', 'readdirectory', array('directory' => $uploaddir));

    $numUploads = 0;
    $sizeUploads = 0;

    $numUploads = count($files);

    for ($i = 0; $i < $numUploads; $i++) {
        if ($files[$i]['filename'] == '.htaccess') {
            $numUploads--;
        }
        else {
            $sizeUploads += $files[$i]['filesize'];
        }
    }

    $sizeUploads = _maIntCalcReadableFilesize($sizeUploads);

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('numUploads', $numUploads);
    $render->assign('sizeUploads', $sizeUploads);

    return $render->fetch('MediaAttach_admin_main.htm');
}
