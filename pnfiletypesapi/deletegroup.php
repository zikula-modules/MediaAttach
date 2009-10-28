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


/**
 * delete a group
 *
 * @param    gid   int    ID of the group
 * @return   bool  true on success, false on failure
 */
function MediaAttach_filetypesapi_deletegroup($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($gid) || !is_numeric($gid)) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $gid = $args['gid'];
    unset($args);

    if (!($group = pnModAPIFunc('MediaAttach', 'filetypes', 'getgroup', array('gid' => $gid)))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    $result = DBUtil::deleteObjectByID('ma_groups', $gid, 'gid');

    if (!$result) {
        return LogUtil::registerError(__('Error! Sorry! Deletion attempt failed.', $dom));
    }

    if (!pnModAPIFunc('MediaAttach', 'filetypes', 'deleteformatgroups',
                        array('gid' => $gid))) {
        return LogUtil::registerError(__('Error! Sorry! Deletion attempt failed.', $dom));
    }

    $render = pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $gid);

    return true;
}

