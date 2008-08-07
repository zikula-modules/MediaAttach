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
 * update a filetype
 *
 * @param    fid          int    the ID of the format
 * @param    image        int    image of the format
 * @param    groups       array  groups of the format
 * @return   bool         true on success, false on failure
 */
function MediaAttach_filetypesapi_updateformat($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['fid']) || !is_numeric($args['fid']) || !isset($args['image']) || !isset($args['groups'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $fid = $args['fid'];
    $image = $args['image'];
    $groups = $args['groups'];
    unset($args);

    if (!($format = pnModAPIFunc('MediaAttach', 'filetypes', 'getformat', array('fid' => $fid)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $format['image'] = $image;

    $result = DBUtil::updateObject($format, 'ma_formats', '', 'fid');

    if (!$result) {
        return LogUtil::registerError(_UPDATEFAILED);
    }

    if (!pnModAPIFunc('MediaAttach', 'filetypes', 'deleteformatgroups',
                        array('fid' => $fid))) {
        return LogUtil::registerError(_UPDATEFAILED);
    }
    foreach ($groups as $currentgroup) {
        if (!pnModAPIFunc('MediaAttach', 'filetypes', 'createformatgroup',
                            array('fid' => $fid, 'gid' => $currentgroup))) {
            return LogUtil::registerError(_UPDATEFAILED);
        }
    }

    $render = pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $fid);

    return true;
}

