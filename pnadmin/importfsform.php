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
 * form for import from a server directory
 *
 * @param    curd        string   current directory
 * @return   output      form template output
 */
function MediaAttach_admin_importfsform($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'uploaddir')))
      || !pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'cachedir')))) {
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'modifyconfig'));
    }

    $currentDir = FormUtil::getPassedValue('curd', isset($args['curd']) ? $args['curd'] : getenv('DOCUMENT_ROOT'), 'GET');
    unset($args);

    list($dirs, $files) = pnModAPIFunc('MediaAttach', 'filesystem', 'readdirectory', array('directory' => $currentDir));

    $render = & pnRender::getInstance('MediaAttach', false);
    $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));
    $render->assign('currentdir', $currentDir);
    $render->assign('dirs', $dirs);
    $render->assign('files', $files);

    $render->assign('categories', pnModAPIFunc('MediaAttach', 'cat', 'getCategoryTree'));

    return $render->fetch('MediaAttach_import_fs.htm');
}
