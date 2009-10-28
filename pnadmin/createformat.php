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
 * Create a file type
 *
 * @param   extension    string    the extension of the format to be created
 * @param   image        string    the image of the format to be created
 * @param   groups       array     the groups of the format
 */
function MediaAttach_admin_createformat($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $extension = FormUtil::getPassedValue('extension', isset($args['extension']) ? $args['extension'] : null, 'POST');
    $image     = FormUtil::getPassedValue('image',     isset($args['image'])     ? $args['image']     : null, 'POST');
    $groups    = FormUtil::getPassedValue('groups',    isset($args['groups'])    ? $args['groups']    : null, 'POST');
    unset($args);

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(__("Invalid 'authkey':  this probably means that you pressed the 'Back' button, or that the page 'authkey' expired. Please refresh the page and try again.", $dom));
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewformats'));
    }

    $fid = pnModAPIFunc('MediaAttach', 'filetypes', 'createformat',
                                array('extension' => $extension,
                                      'image'     => $image,
                                      'groups'    => $groups));

    if ($fid) {
        LogUtil::registerStatus(__('Done! Item created.', $dom));
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewformats'));
}

