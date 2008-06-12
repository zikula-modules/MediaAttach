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
 * Modify the file type
 *
 * @param     int     fid          the id of the format to be modified
 * @param     int     objectid     generic object id mapped onto fid if present
 * @param     string  extension    the extension of the format to be updated
 * @param     string  image        the image of the format to be updated
 * @param     array   groups       the groups of the format
 */
function MediaAttach_admin_updateformat($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $fid       = (int) FormUtil::getPassedValue('fid',       isset($args['fid'])       ? $args['fid']       : null, 'POST');
    $objectid  = (int) FormUtil::getPassedValue('objectid',  isset($args['objectid'])  ? $args['objectid']  : null, 'POST');
    $extension =       FormUtil::getPassedValue('extension', isset($args['extension']) ? $args['extension'] : null, 'POST');
    $image     =       FormUtil::getPassedValue('image',     isset($args['image'])     ? $args['image']     : null, 'POST');
    $groups    =       FormUtil::getPassedValue('groups',    isset($args['groups'])    ? $args['groups']    : null, 'POST');
    unset($args);

    if (!empty($objectid)) {
        $fid = $objectid;
    }

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewformats'));
    }

    if(pnModAPIFunc('MediaAttach', 'filetypes', 'updateformat',
                    array('fid'         => $fid,
                          'extension'   => $extension,
                          'image'       => $image,
                          'groups'      => $groups))) {
        LogUtil::registerStatus(_UPDATESUCCEDED);
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewformats'));
}

