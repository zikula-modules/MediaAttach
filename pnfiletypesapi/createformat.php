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
 * create a new file type
 *
 * @param    extension    string  extension of the format
 * @param    image        int     image of the format
 * @param    groups       array   groups of the format
 * @return   int          File type ID on success, false on failure
 */
function MediaAttach_filetypesapi_createformat($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return false;
    }

    if (!isset($args['extension']) || !isset($args['image']) || !isset($args['groups'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $extension = $args['extension'];
    $image = $args['image'];
    $groups = $args['groups'];
    unset($args);

    $format = array('extension' => $extension,
                    'image' => $image);

    $result = DBUtil::insertObject($format, 'ma_formats', 'fid');
    if (!$result) {
        return LogUtil::registerError(_CREATEFAILED);
    }

    foreach ($groups as $currentgroup) {
        if (!pnModAPIFunc('MediaAttach', 'filetypes', 'createformatgroup',
                            array('fid' => $format['fid'], 'gid' => $currentgroup))) {
            return LogUtil::registerError(_CREATEFAILED);
        }
    }

    return $format['fid'];
}

