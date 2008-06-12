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
 * Create a group
 *
 * @param    string    groupname    the name of the group to be created
 * @param    string    directory    the directory of the group to be created
 * @param    string    image        the image of the group to be created
 * @param    array     formats      the formats of the group
 */
function MediaAttach_admin_creategroup($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $groupname = FormUtil::getPassedValue('groupname', isset($args['groupname']) ? $args['groupname'] : null, 'POST');
    $directory = FormUtil::getPassedValue('directory', isset($args['directory']) ? $args['directory'] : null, 'POST');
    $image     = FormUtil::getPassedValue('image',     isset($args['image'])     ? $args['image']     : null, 'POST');
    $formats   = FormUtil::getPassedValue('formats',   isset($args['formats'])   ? $args['formats']   : null, 'POST');
    unset($args);

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewgroups'));
    }

    // Directory name cleaning
    for ($i = 0; $i < strlen($directory); $i++){
        if (!ereg("([0-9A-Za-z_\.])", $directory[$i]))
            $directory[$i] = '_';
    }

    $gid = pnModAPIFunc('MediaAttach', 'filetypes', 'creategroup',
                                 array('groupname'   => $groupname,
                                       'directory'   => $directory,
                                       'image'       => $image,
                                       'formats'     => $formats));

    if ($gid) {
        LogUtil::registerStatus(_CREATESUCCEDED);
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewgroups'));
}
