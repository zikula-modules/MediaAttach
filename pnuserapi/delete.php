<?php
/**
 * MediaAttach
 *
 * @version      $Id: delete.php 22 2008-02-23 21:30:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * delete a file
 *
 * @param    fileid     int      the ID of the file
 * @param    objectid   int      the ID of the file (hook call)
 * @param    extrainfo  array    hook info (hook call)
 * @return   bool       true on success, false on failure
 */
function MediaAttach_userapi_delete($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $fileid    = (isset($args['fileid']) && is_numeric($args['fileid'])) ? $args['fileid'] : 0;
    $objectid  = (isset($args['objectid']) && $args['objectid']) ? $args['objectid'] : 0;
    $extrainfo = (isset($args['extrainfo'])) ? $args['extrainfo'] : 0;
    unset($args);

    if (pnSessionGetVar('MediaAttachDeleteLock') == '1') {
        return true;
    }

    $hookcall = 0;
    if (!empty($objectid)) {
        $hookcall = 1;
    }

    if ($hookcall == 1) {
        if (!is_array($extrainfo)) {
            return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
        }

        $modname = (!empty($extrainfo['module'])) ? $extrainfo['module'] : pnModGetName();

        if (!empty($extrainfo['itemid'])) {
            $objectid = $extrainfo['itemid'];
        }

        pnModDBInfoLoad('MediaAttach');
        $pntables    = pnDBGetTables();
        $filescolumn = $pntables['ma_files_column'];

        // retrieve every $fileid covered by given combination of module name and deleted objectid
        $where = $filescolumn['modname'] . " = '" . DataUtil::formatForStore($modname) . "' AND " . $filescolumn['objectid'] . " = '" . DataUtil::formatForStore($objectid) . "'";

        $files = DBUtil::selectObjectArray('ma_files', $where);
        if ($files === false) {
            return LogUtil::registerError(__('Error! Could not load items.', $dom));
        }

        // delete all affected files
        foreach($files as $file) {
            if (!_MediaAttachDeleteFileInternal($file['fileid'])) {
                return false;
            }
        }

    } else {
        // normal deletion - only one file at once
        if (!$fileid) {
            return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
        }

        return _MediaAttachDeleteFileInternal($fileid);
    }

    return true;
}

/**
 * delete a file
 *
 * @param    int      $args['fileid']       the ID of the file
 * @return   bool                           true on success, false on failure
 */
function _MediaAttachDeleteFileInternal($fileid)
{
    if (!($file = DBUtil::selectObjectByID('ma_files', $fileid, 'fileid'))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    $result = DBUtil::deleteObjectByID('ma_files', $fileid, 'fileid');
    if (!$result) {
        return LogUtil::registerError(__('Error! Sorry! Deletion attempt failed.', $dom));
    }

    if (!($class = Loader::loadClass('ObjectUtil'))) {
        pn_exit (__f('Error! Unable to load class ObjectUtil'));
    }

    // delete any object category mappings for this item
    ObjectUtil::deleteObjectCategories($file, 'ma_files', 'fileid');

    // call delete hooks for this item
    pnSessionSetVar('MediaAttachDeleteLock', '1'); // prevent recursive call
    pnModCallHooks('item', 'delete', $file['fileid'], array('module' => 'MediaAttach'));
    pnSessionSetVar('MediaAttachDeleteLock', '0');

    $render = pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $fileid);

    return true;
}
