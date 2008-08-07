<?php
/**
 * MediaAttach
 *
 * @version      $Id: edit.php 45 2008-03-01 04:40:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * display a list of files
 *
 * @param    objectid     string   object id of current page item
 * @return   output       the data
 */
function MediaAttach_user_showfilelist($args)
{
    $modname = pnModGetName();
    if ($modname == 'MediaAttach' && FormUtil::getPassedValue('type', '', 'GET') == 'external') {
        return false;   // we want only the upload form in the scribite/guppy popup
    }

    if (!isset($args['objectid']) || empty($args['objectid'])) {
        return false;
    }
    $objectid = $args['objectid'];
    unset($args);

    if (!SecurityUtil::checkPermission('MediaAttach::', "$modname:$objectid: ", ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }

    pnModAPIFunc('MediaAttach', 'user', 'add_stylesheet_header');

    $files = pnModAPIFunc('MediaAttach', 'user', 'getalluploads', array('moduleFilter'   => $modname,
                                                                        'objectidFilter' => $objectid));
    $definition  = pnModAPIFunc('MediaAttach', 'definitions', 'getmoduledefinition', array('modname' => $modname));

    $numFiles    = count($files);
    $currentUser = pnUserGetVar('uid');
    $ownHandling = pnModGetVar('MediaAttach', 'ownhandling');
    for ($i = 0; $i < $numFiles; $i++) {
        $files[$i] = _maIntPrepFileForTemplate($files[$i], $currentUser, $ownHandling);
    }

    $render = pnRender::getInstance('MediaAttach', false);

    $render->assign('definition', $definition);
    $render->assign('files', $files);
    $render->assign('modname', DataUtil::formatForDisplay($modname));

    $templateset = ($definition['downloadmode'] == 1) ? 'inlinelist' : 'filelist';
    return $render->fetch(_maIntChooseTemplate($render, 'user', $templateset, $modname));
}
