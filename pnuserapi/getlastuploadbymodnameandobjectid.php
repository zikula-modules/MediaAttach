<?php
/**
 * MediaAttach
 *
 * @version      $Id: getlastuploadbymodnameandobjectid.php 39 2008-03-01 02:32:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * get the last upload for a given modname / objectid pair
 *
 * @param    modname   string   name of current module
 * @param    objectid  int      current objectid
 * @return   array     file array, or false on failure
 */
function MediaAttach_userapi_getlastuploadbymodnameandobjectid($args)
{
    if (!isset($args['modname']) || empty($args['modname']) || !isset($args['objectid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $modname  = $args['modname'];
    $objectid = $args['objectid'];
    unset($args);

    $formatJoin = array();
    $formatJoin[] = array('join_table'          =>  'ma_formats',     // table to join with
                          'join_field'          =>  'image',          // field selected through LEFT JOIN
                          'object_field_name'   =>  'format',         // fieldname in the resulting object
                          'compare_field_table' =>  'extension',      // field to join on from main table
                          'compare_field_join'  =>  'extension');     // field to join on from the join table

    $pntables = pnDBGetTables();
    $fcolumn  = $pntables['ma_files_column'];

    $where = "WHERE $fcolumn[modname] = '" . DataUtil::formatForStore($modname) . "'"
           . " AND $fcolumn[objectid] = '" . DataUtil::formatForStore($objectid) . "'";

    $orderBy = " $fcolumn[fileid] DESC";

    $file = DBUtil::selectExpandedObjectArray('ma_files', $formatJoin, $where, $orderBy, 0, 1); //LIMIT 0, 1

    if ($file === false || !$file) {
        return LogUtil::registerError(_GETFAILED);
    }

    //we have only one item
    $file = $file[0];

    if (!SecurityUtil::checkPermission('MediaAttach::', $file['modname'] . ":" . $file['objectid'] . ":$fileid", ACCESS_READ)) {
       return false;
    }

    if (!($definition = pnModAPIFunc('MediaAttach', 'definitions', 'getdefinition', array('did' => $file['definition'])))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $file['url'] = str_replace('&amp;', '&', urldecode($file['url']));
    $file['definition'] = $definition;
    if ($file['extension'] != 'extvid') {
        $file['fileInfo'] = pnModAPIFunc('MediaAttach', 'fileinfo', 'retrievefileinfo', array('file' => $file));
    }

    return $file;
}
