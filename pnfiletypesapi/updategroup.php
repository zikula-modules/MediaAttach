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
 * update a group
 *
 * @param    gid          int     the ID of the group
 * @param    groupname    string  name of the group
 * @param    directory    string  directory of the group
 * @param    image        int     image of the group
 * @param    formats      array   formats of the group
 * @return   bool         true on success, false on failure
 */
function MediaAttach_filetypesapi_updategroup($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['gid']) || !is_numeric($args['gid']) || !isset($args['groupname']) || !isset($args['directory']) || !isset($args['image']) || !isset($args['formats'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $gid = $args['gid'];
    $groupname = $args['groupname'];
    $directory = $args['directory'];
    $image = $args['image'];
    $formats = $args['formats'];
    unset($args);

    if (!($group = pnModAPIFunc('MediaAttach', 'filetypes', 'getgroup', array('gid' => $gid)))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    $group['groupname'] = $groupname;
    $group['directory'] = $directory;
    $group['image'] = $image;

    $result = DBUtil::updateObject($group, 'ma_groups', '', 'gid');

    if (!$result) {
        return LogUtil::registerError(__('Error! Update attempt failed.', $dom));
    }

    if (!pnModAPIFunc('MediaAttach', 'filetypes', 'deleteformatgroups',
                        array('gid' => $gid))) {
        return LogUtil::registerError(__('Error! Update attempt failed.', $dom));
    }
    foreach ($formats as $currentformat) {
        if (!pnModAPIFunc('MediaAttach', 'filetypes', 'createformatgroup',
                            array('fid' => $currentformat, 'gid' => $gid))) {
            return LogUtil::registerError(__('Error! Update attempt failed.', $dom));
        }
    }

    $render = pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $gid);

    return true;
}

