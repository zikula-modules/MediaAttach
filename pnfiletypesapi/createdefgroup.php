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
 * @param    did    int    definition id
 * @param    gid    int    group id
 * @return   int    true on success, false on failure
 */
function MediaAttach_filetypesapi_createdefgroup($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['did']) || !isset($args['gid']) || !is_numeric($args['did']) || !is_numeric($args['gid'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $did = $args['did'];
    $gid = $args['gid'];
    unset($args);

    $defgroup = array('did' => $did,
                      'gid' => $gid);

    $result = DBUtil::insertObject($defgroup, 'ma_defgroups', 'did', true);
    if (!$result) {
        return LogUtil::registerError(__('Error! Creation attempt failed.', $dom));
    }

    return true;
}

