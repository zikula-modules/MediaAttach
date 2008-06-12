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
 * Create a file type
 *
 * @param   string    extension    the extension of the format to be created
 * @param   string    image        the image of the format to be created
 * @param   array     groups       the groups of the format
 */
function MediaAttach_admin_createformat($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $extension = FormUtil::getPassedValue('extension', isset($args['extension']) ? $args['extension'] : null, 'POST');
    $image     = FormUtil::getPassedValue('image',     isset($args['image'])     ? $args['image']     : null, 'POST');
    $groups    = FormUtil::getPassedValue('groups',    isset($args['groups'])    ? $args['groups']    : null, 'POST');
    unset($args);

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewformats'));
    }

    $fid = pnModAPIFunc('MediaAttach', 'filetypes', 'createformat',
                                array('extension' => $extension,
                                      'image'     => $image,
                                      'groups'    => $groups));

    if ($fid) {
        LogUtil::registerStatus(_CREATESUCCEDED);
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewformats'));
}

