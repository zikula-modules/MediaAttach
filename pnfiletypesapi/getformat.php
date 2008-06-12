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
 * get a specific format
 *
 * @param    int     $args['fid']  id of file type to get
 * @return   array                 format array
 */
function MediaAttach_filetypesapi_getformat($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['fid']) || !is_numeric($args['fid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $fid = $args['fid'];
    unset($args);

    $format = DataUtil::formatForDisplay(DBUtil::selectObjectByID('ma_formats', $fid, 'fid'));

    return $format;
}

