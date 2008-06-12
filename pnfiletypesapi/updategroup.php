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
 * @param    int       $args['gid']          the ID of the group
 * @param    string    $args['groupname']    name of the group
 * @param    string    $args['directory']    directory of the group
 * @param    int       $args['image']        image of the group
 * @param    array     $args['formats']      formats of the group
 * @return   bool                            true on success, false on failure
 */
function MediaAttach_filetypesapi_updategroup($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['gid']) || !is_numeric($args['gid']) || !isset($args['groupname']) || !isset($args['directory']) || !isset($args['image']) || !isset($args['formats'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $gid = $args['gid'];
    $groupname = $args['groupname'];
    $directory = $args['directory'];
    $image = $args['image'];
    $formats = $args['formats'];
    unset($args);

    if (!($group = pnModAPIFunc('MediaAttach', 'filetypes', 'getgroup', array('gid' => $gid)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $group['groupname'] = $groupname;
    $group['directory'] = $directory;
    $group['image'] = $image;

    $result = DBUtil::updateObject($group, 'ma_groups', '', 'gid');

    if (!$result) {
        return LogUtil::registerError(_UPDATEFAILED);
    }

    if (!pnModAPIFunc('MediaAttach', 'filetypes', 'deleteformatgroups',
                        array('gid' => $gid))) {
        return LogUtil::registerError(_UPDATEFAILED);
    }
    foreach ($formats as $currentformat) {
        if (!pnModAPIFunc('MediaAttach', 'filetypes', 'createformatgroup',
                            array('fid' => $currentformat, 'gid' => $gid))) {
            return LogUtil::registerError(_UPDATEFAILED);
        }
    }

    $render = pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $gid);

    return true;
}

