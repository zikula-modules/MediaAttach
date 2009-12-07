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
 * delete a file type
 *
 * @param    fid   int    ID of the format
 * @return   bool  true on success, false on failure
 */
function MediaAttach_filetypesapi_deleteformat($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['fid']) || !is_numeric($args['fid'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $fid = $args['fid'];
    unset($args);

    if (!($format = pnModAPIFunc('MediaAttach', 'filetypes', 'getformat', array('fid' => $fid)))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    $result = DBUtil::deleteObjectByID('ma_formats', $fid, 'fid');

    if (!$result) {
        return LogUtil::registerError(__('Error! Sorry! Deletion attempt failed.', $dom));
    }

    if (!pnModAPIFunc('MediaAttach', 'filetypes', 'deleteformatgroups',
                        array('fid' => $fid))) {
        return LogUtil::registerError(__('Error! Sorry! Deletion attempt failed.', $dom));
    }

    $render = & pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $fid);

    return true;
}

