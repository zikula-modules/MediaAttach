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
 * edit a definition
 *
 * @param     did          int     the id of the definition to be modified
 * @param     objectid     int     generic object id mapped onto did if present
 * @return    output       the modification page
 */
function MediaAttach_admin_editdefinition($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $did      = (int) FormUtil::getPassedValue('did',      isset($args['did'])      ? $args['did']      : null, 'GET');
    $objectid = (int) FormUtil::getPassedValue('objectid', isset($args['objectid']) ? $args['objectid'] : null, 'GET');
    unset($args);

    if (!empty($objectid)) {
        $did = $objectid;
    }

    if (!($allgroups = pnModAPIFunc('MediaAttach', 'filetypes', 'getallgroups'))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    $groups = pnModAPIFunc('MediaAttach', 'filetypes', 'getdefgroups', array('did' => $did));

    if (($definition = pnModAPIFunc('MediaAttach', 'definitions', 'getdefinition', array('did' => $did))) === false) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    $render = & pnRender::getInstance('MediaAttach', false);
    $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));
    $render->assign('did', DataUtil::formatForDisplay($did));
    $render->assign('groups', $groups);
    $render->assign('allgroups', $allgroups);
    $render->assign('definition', $definition);

    return $render->fetch('MediaAttach_admin_def_edit.htm');
}

