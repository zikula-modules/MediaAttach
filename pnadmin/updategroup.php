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
 * Modify the group
 *
 * @param    int       gid          the id of the group to be modified
 * @param    int       objectid     generic object id mapped onto gid if present
 * @param    string    groupname    the name of the group to be created
 * @param    string    directory    the directory of the group to be created
 * @param    string    image        the image of the group to be created
 * @param    array     formats      the formats of the group
 */
function MediaAttach_admin_updategroup($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $gid       = (int) FormUtil::getPassedValue('gid',       isset($args['gid'])       ? $args['gid']       : null, 'POST');
    $objectid  = (int) FormUtil::getPassedValue('objectid',  isset($args['objectid'])  ? $args['objectid']  : null, 'POST');
    $groupname =       FormUtil::getPassedValue('groupname', isset($args['groupname']) ? $args['groupname'] : null, 'POST');
    $directory =       FormUtil::getPassedValue('directory', isset($args['directory']) ? $args['directory'] : null, 'POST');
    $image     =       FormUtil::getPassedValue('image',     isset($args['image'])     ? $args['image']     : null, 'POST');
    $formats   =       FormUtil::getPassedValue('formats',   isset($args['formats'])   ? $args['formats']   : null, 'POST');
    unset($args);

    if (!empty($objectid)) {
        $gid = $objectid;
    }

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewgroups'));
    }

    if (!($group = pnModAPIFunc('MediaAttach', 'filetypes', 'getgroup', array('gid' => $gid)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    // Directory name cleaning
    for ($i = 0; $i < strlen($directory); $i++){
        if (!ereg("([0-9A-Za-z_\.])", $directory[$i]))
            $directory[$i] = '_';
    }

    if (pnModAPIFunc('MediaAttach', 'filetypes', 'updategroup',
                    array('gid'    => $gid,
                          'groupname'   => $groupname,
                          'directory' => $directory,
                          'image'  => $image,
                          'formats' => $formats))) {
        LogUtil::registerStatus(_UPDATESUCCEDED);
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewgroups'));
}
