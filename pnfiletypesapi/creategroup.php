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
 * create a new group
 *
 * @param    string    $args['groupname']    name of the group
 * @param    string    $args['directory']    directory of the group
 * @param    int       $args['image']        image of the group
 * @param    array     $args['formats']      formats of the group
 * @return   int                             File type ID on success, false on failure
 */
function MediaAttach_filetypesapi_creategroup($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['groupname']) || !isset($args['directory']) || !isset($args['image']) || !isset($args['formats'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $groupname = $args['groupname'];
    $directory = $args['directory'];
    $image = $args['image'];
    $formats = $args['formats'];
    unset($args);

    $group = array('groupname' => $groupname,
                   'directory' => $directory,
                   'image' => $image);

    $result = DBUtil::insertObject($group, 'ma_groups', 'gid');
    if (!$result) {
        return LogUtil::registerError(_CREATEFAILED);
    }

    foreach ($formats as $currentformat) {
        if (!pnModAPIFunc('MediaAttach', 'filetypes', 'createformatgroup',
                            array('fid' => $currentformat, 'gid' => $group['gid']))) {
            return LogUtil::registerError(_CREATEFAILED);
        }
    }

    return $group['gid'];
}

