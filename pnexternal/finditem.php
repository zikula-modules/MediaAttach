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


/*
 * ---------------------------------------------------------------------------------------------------------
 * Popup selector for scribite plugin
 * based on mediashare implementation
 * ---------------------------------------------------------------------------------------------------------
 */

Loader::requireOnce('modules/MediaAttach/common.php');


/**
 * find files / items
 *
 * @param        did     int     definition id for selected module
 * @return       output  The external item finder page
 */
function MediaAttach_external_finditem($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $formatfilter = '';
    $definitionid = (int) FormUtil::getPassedValue('did', 0, 'GET');

    $fromGuppy = (int) FormUtil::getPassedValue('guppy', 0, 'GET');

    PageUtil::AddVar('stylesheet', ThemeUtil::getModuleStylesheet('MediaAttach'));

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('definitionid', $definitionid);
    $render->assign('mainCategory', pnModAPIFunc('MediaAttach', 'cat', 'getMainCat'));
    $render->assign('fromGuppy', $fromGuppy);

    $definitions = pnModAPIFunc('MediaAttach', 'definitions', 'getalldefinitions');

    if (!$definitions) {
        $render->assign('modules', 0);
        echo $render->fetch('MediaAttach_external_finditem.html');
        return true;
    }

    $render->assign('modules', 1);
    $render->assign('definitions', $definitions);

    if ($definitionid == 0) {
        $definitionid = $definitions[0]['did'];
    }

    $modname = '';
    foreach($definitions as $currentDef) {
        if ($currentDef['did'] == $definitionid) {
            $modname = $currentDef['modname'];
            break;
        }
    }

    if (empty($modname)) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }
    else if (!SecurityUtil::checkPermission('MediaAttach::', "$modname:: ", ACCESS_COMMENT)) {
        return LogUtil::registerPermissionError();
    }

    $fetchArgs = array();
    $fetchArgs['moduleFilter'] = $modname;

    $cat_prop = FormUtil::getPassedValue('catprop', 'Main', 'GET');
    $cat_id   = (int) FormUtil::getPassedValue('catid', 0, 'GET');
    $render->assign('catPROP', $cat_prop);
    $render->assign('catID', $cat_id);
    if ($cat_prop != '' && $cat_id != 0) {
        $fetchArgs['catFilter'] = array($cat_prop => $cat_id);
        $fetchArgs['catFilter']['__META__'] = array('module' => 'MediaAttach');
    }

    _maIntProcessFileList($render, 50, $fetchArgs);

    echo $render->fetch('MediaAttach_external_finditem.html');
    return true;
}

