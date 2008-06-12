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
 * edit a definition
 *
 * @param     int     did          the id of the definition to be modified
 * @param     int     objectid     generic object id mapped onto did if present
 * @return    output               the modification page
 */
function MediaAttach_admin_editdefinition($args)
{
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
        return LogUtil::registerError(_GETFAILED);
    }

    $groups = pnModAPIFunc('MediaAttach', 'filetypes', 'getdefgroups', array('did' => $did));

    if (($definition = pnModAPIFunc('MediaAttach', 'definitions', 'getdefinition', array('did' => $did))) === false) {
        return LogUtil::registerError(_GETFAILED);
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));
    $render->assign('did', DataUtil::formatForDisplay($did));
    $render->assign('groups', $groups);
    $render->assign('allgroups', $allgroups);
    $render->assign('definition', $definition);

    return $render->fetch('MediaAttach_admin_def_edit.htm');
}

