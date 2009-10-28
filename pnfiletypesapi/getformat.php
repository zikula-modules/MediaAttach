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
 * @param    fid    int    id of file type to get
 * @return   array  format array
 */
function MediaAttach_filetypesapi_getformat($args)
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

    $format = DataUtil::formatForDisplay(DBUtil::selectObjectByID('ma_formats', $fid, 'fid'));

    return $format;
}

