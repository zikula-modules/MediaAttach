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
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['fid']) || !is_numeric($args['fid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $fid = $args['fid'];
    unset($args);

    if (!($format = pnModAPIFunc('MediaAttach', 'filetypes', 'getformat', array('fid' => $fid)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $result = DBUtil::deleteObjectByID('ma_formats', $fid, 'fid');

    if (!$result) {
        return LogUtil::registerError(_DELETEFAILED);
    }

    if (!pnModAPIFunc('MediaAttach', 'filetypes', 'deleteformatgroups',
                        array('fid' => $fid))) {
        return LogUtil::registerError(_DELETEFAILED);
    }

    $render = pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $fid);

    return true;
}

