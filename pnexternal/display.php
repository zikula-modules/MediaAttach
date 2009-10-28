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
 * display one file in a separate template
 *
 * @param    fileid        int     file id to show
 * @param    displaymode   string  link or embed
 * @param    floatmode     string  none, left or right
 * @param    thumbnr       int     thumbnail number: 1..x (optional, default = modvar setting)
 * @return   output        the data
 */
function MediaAttach_external_display($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $fileid      = (int) FormUtil::getPassedValue('fileid', (isset($args['fileid'])) ? $args['fileid'] : null, 'GET');
    $displaymode = FormUtil::getPassedValue('displaymode', (isset($args['displaymode'])) ? $args['displaymode'] : 'embed', 'GET');
    if ($displaymode != 'link' && $displaymode != 'embed') $displaymode = 'embed';
    $floatmode = FormUtil::getPassedValue('floatmode', (isset($args['floatmode'])) ? $args['floatmode'] : 'none', 'GET');
    if ($floatmode != 'none' && $floatmode != 'left' && $floatmode != 'right') $floatmode = 'none';
    $thumbnr = FormUtil::getPassedValue('thumbnr', (isset($args['thumbnr'])) ? $args['thumbnr'] : 0, 'GET');
    if ($thumbnr != 'original') $thumbnr = (int) $thumbnr;
    if ($thumbnr != 'original' && !is_numeric($thumbnr)) {
        $thumbnr = pnModGetVar('MediaAttach', 'defaultthumb');
    }
    unset($args);

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    if (!SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$fileid", ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }

    $currentUser = pnUserGetVar('uid');
    $ownHandling = pnModGetVar('MediaAttach', 'ownhandling');
    $file = _maIntPrepFileForTemplate($file, $currentUser, $ownHandling);

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('currentuser', $currentUser);
    $render->assign('file', $file);
    $render->assign('displaymode', $displaymode);
    $render->assign('floatmode', $floatmode);
    $render->assign('thumbnr', $thumbnr);

    return $render->fetch(_maIntChooseTemplate($render, 'external', 'display', 'MediaAttach'));
}

