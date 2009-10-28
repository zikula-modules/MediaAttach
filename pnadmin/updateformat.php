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
 * Modify the file type
 *
 * @param     fid          int     the id of the format to be modified
 * @param     objectid     int     generic object id mapped onto fid if present
 * @param     extension    string  the extension of the format to be updated
 * @param     image        string  the image of the format to be updated
 * @param     groups       array   the groups of the format
 */
function MediaAttach_admin_updateformat($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
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
        LogUtil::registerError(__("Invalid 'authkey':  this probably means that you pressed the 'Back' button, or that the page 'authkey' expired. Please refresh the page and try again.", $dom));
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewformats'));
    }

    if(pnModAPIFunc('MediaAttach', 'filetypes', 'updateformat',
                    array('fid'         => $fid,
                          'extension'   => $extension,
                          'image'       => $image,
                          'groups'      => $groups))) {
        LogUtil::registerStatus(__('Done! Item updated.', $dom));
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewformats'));
}

