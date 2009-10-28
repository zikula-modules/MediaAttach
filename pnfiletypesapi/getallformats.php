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
 * get all file formats
 *
 * @return   array   array of formats, or false on failure
 */
function MediaAttach_filetypesapi_getallformats()
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $pntables = pnDBGetTables();
    $fcolumn = $pntables['ma_formats_column'];
    $where = "";
    $orderBy = "ORDER BY $fcolumn[extension]";
    $dbformats = DBUtil::selectObjectArray('ma_formats', $where, $orderBy);

    if (!$dbformats) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    $formats = array();

    foreach($dbformats as $currentFormat) {
        if (!$currentFormat['image']) $currentFormat['image'] = 'unknown.gif';
        $groups = pnModAPIFunc('MediaAttach', 'filetypes', 'getformatgroups',
                                    array('fid' => $currentFormat['fid']));
        $formats[] = array('fid' => $currentFormat['fid'],
                           'extension' => DataUtil::formatForDisplay($currentFormat['extension']),
                           'image' => DataUtil::formatForDisplay($currentFormat['image']),
                           'groups' => $groups);
    }

    return $formats;
}
