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
 * create a new definition - group relation
 *
 * @param    int    $args['did']    definition
 * @param    int    $args['gid']    group
 * @return   int                    true on success, false on failure
 */
function MediaAttach_filetypesapi_createdefgroup($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['did']) || !isset($args['gid']) || !is_numeric($args['did']) || !is_numeric($args['gid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $did = $args['did'];
    $gid = $args['gid'];
    unset($args);

    $defgroup = array('did' => $did,
                      'gid' => $gid);

    $result = DBUtil::insertObject($defgroup, 'ma_defgroups', 'did', true);
    if (!$result) {
        return LogUtil::registerError(_CREATEFAILED);
    }

    return true;
}

