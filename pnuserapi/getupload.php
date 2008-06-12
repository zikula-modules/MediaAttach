<?php
/**
 * MediaAttach
 *
 * @version      $Id: getupload.php 39 2008-03-01 02:32:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * get a specific upload
 *
 * @param    int   $args['fileid']  id of file to get
 * @return   array                  file array, or false on failure
 */
function MediaAttach_userapi_getupload($args)
{
    if (!isset($args['fileid']) || !is_numeric($args['fileid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $fileid = $args['fileid'];
    unset($args);

    $joinArray = array();
    $joinArray[] = array('join_table'           => 'ma_defs',
                         'join_field'           => array('displayfiles', 'sendmails', 'recipient', 'maxsize', 'downloadmode', 'naming', 'namingprefix', 'numfiles'),
                         'object_field_name'    => array('defdisplayfiles', 'defsendmails', 'defrecipient', 'defmaxsize', 'defdownloadmode', 'defnaming', 'defnamingprefix', 'defnumfiles'),
                         'compare_field_table'  => 'definition',
                         'compare_field_join'   => 'did');

    $joinArray[] = array('join_table'           =>  'ma_formats',     // table to join with
                         'join_field'           =>  'image',          // field selected through LEFT JOIN
                         'object_field_name'    =>  'format',         // fieldname in the resulting object
                         'compare_field_table'  =>  'extension',      // field to join on from main table
                         'compare_field_join'   =>  'extension');     // field to join on from the join table

    $permFilter = array();
    $permFilter[] = array('component_left'   => 'MediaAttach',
                          'component_middle' => '',
                          'component_right'  => '',
                          'instance_left'    => 'modname',
                          'instance_middle'  => 'objectid',
                          'instance_right'   => 'fileid',
                          'level'            => ACCESS_READ);

    $file = DBUtil::selectExpandedObjectByID('ma_files', $joinArray, $fileid, 'fileid', null, $permFilter);

    if ($file === false || !$file) {
        return false;
    }

    if (!($class = Loader::loadClass('ObjectUtil'))) {
        pn_exit (pnML('_UNABLETOLOADCLASS', array('s' => 'ObjectUtil')));
    }

    // need to do this here as the category expansion code can't know the
    // root category which we need to build the relative path component
    $mainCat = pnModAPIFunc('MediaAttach', 'cat', 'getMainCat');
    ObjectUtil::postProcessExpandedObjectCategories($file, $mainCat);

    $file['url'] = str_replace('&amp;', '&', urldecode($file['url']));
    $file['username'] = pnUserGetVar('uname', $file['uid']);
    if ($file['extension'] != 'extvid') {
        $file['fileInfo'] = pnModAPIFunc('MediaAttach', 'fileinfo', 'retrievefileinfo', array('file' => $file));
    }

    return $file;
}
