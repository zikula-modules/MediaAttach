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
 * create a new format - group relation
 *
 * @param    fid    int    format id
 * @param    gid    int    group id
 * @return   int    true on success, false on failure
 */
function MediaAttach_filetypesapi_createformatgroup($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['fid']) || !isset($args['gid']) || !is_numeric($args['fid']) || !is_numeric($args['gid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $fid = $args['fid'];
    $gid = $args['gid'];
    unset($args);

    $fgroup = array('fid' => $fid,
                    'gid' => $gid);

    $result = DBUtil::insertObject($fgroup, 'ma_formatgroups', 'fid', true);
    if (!$result) {
        return LogUtil::registerError(_CREATEFAILED);
    }

    return true;
}

