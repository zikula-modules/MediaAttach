<?php
/**
 * MediaAttach
 *
 * @version      $Id: getalluploads.php 114 2008-05-05 6:42:14Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * get all uploaded files
 *
 * @param    startnum             int     offset of first file to fetch
 * @param    numitems             int     number of files to fetch
 * @param    sortby               string  sorting field
 * @param    sortdir              string  sorting direction
 * @param    assocKey             string  key field to use to build the associative index (optional) (default='')
 * @param    fileFilter           array   optional filter by file ids
 * @param    formatFilter         array   optional filter by file formats
 * @param    catFilter            array   optional filter by category ids
 * @param    userFilter           int     optional filter by given user id
 * @param    moduleFilter         string  optional filter by module name
 * @param    objectidFilter       string  optional filter by object id
 * @param    searchfor            string  optional search term string
 * @param    bool                 string  optional string 'AND' or 'OR'
 * @return                        array of uploads, or false on failure
 */
function MediaAttach_userapi_getalluploads($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $uploads = array();

    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_READ)) {
        return $uploads;
    }

    $startnum       = (isset($args['startnum'])     && is_numeric($args['startnum']))   ? $args['startnum']     : 0;
    $numitems       = (isset($args['numitems'])     && is_numeric($args['numitems']))   ? $args['numitems']     : '';

    $sortby         = (isset($args['sortby'])       && !empty($args['sortby']))         ? $args['sortby']       : 'date';
    $sortdir        = (isset($args['sortdir'])      && !empty($args['sortdir']))        ? $args['sortdir']      : 'asc';

    $assocKey       = (isset($args['assocKey'])     && !empty($args['assocKey']))       ? $args['assocKey']     : '';

    $fileFilter     = (isset($args['fileFilter'])   && is_array($args['fileFilter']))   ? $args['fileFilter']   : '';
    $formatFilter   = (isset($args['formatFilter']) && is_array($args['formatFilter'])) ? $args['formatFilter'] : '';
    $catFilter      = (isset($args['catFilter'])    && is_array($args['catFilter']))    ? $args['catFilter']    : null;
    $userFilter     = (isset($args['userFilter'])   && is_numeric($args['userFilter'])) ? $args['userFilter']   : '';
    $moduleFilter   = (isset($args['moduleFilter']))                                    ? $args['moduleFilter'] : '';
    $objectidFilter = (isset($args['objectidFilter']))                                  ? $args['objectidFilter'] : '';
    $searchfor      = (isset($args['searchfor'])    && !empty($args['searchfor']))      ? $args['searchfor']    : '';
    $bool           = (isset($args['bool'])         && !empty($args['bool']))           ? $args['bool']         : 'AND';
    unset($args);

    $allowedSortings = array('date', 'title', 'module', 'filename', 'username', 'filetype', 'filesize');
    if (!in_array($sortby, $allowedSortings)) $sortby = 'date';
    $allowedSortdir = array('asc', 'desc');
    if (!in_array($sortdir, $allowedSortdir)) $sortdir = 'asc';

    if ($catFilter != null) {
        $catFilter['__META__'] = array('module' => 'MediaAttach');
    }

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

    $joinArray[] = array('join_table'           =>  'users',
                         'join_field'           =>  'uname',
                         'object_field_name'    =>  'username',
                         'compare_field_table'  =>  'uid',
                         'compare_field_join'   =>  'uid');

    $permFilter = array();
    $permFilter[] = array('component_left'   => 'MediaAttach',
                          'component_middle' => '',
                          'component_right'  => '',
                          'instance_left'    => 'modname',
                          'instance_middle'  => 'objectid',
                          'instance_right'   => 'fileid',
                          'level'            => ACCESS_READ);

    $pntables = pnDBGetTables();
    $filescolumn = $pntables['ma_files_column'];
    $userscolumn = $pntables['users_column'];

    $where = _maIntBuildWhereString(array('fileFilter'     => $fileFilter,
                                          'formatFilter'   => $formatFilter,
                                          'userFilter'     => $userFilter,
                                          'moduleFilter'   => $moduleFilter,
                                          'objectidFilter' => $objectidFilter,
                                          'searchfor'      => $searchfor,
                                          'bool'           => $bool));

    if ($sortby == 'module') $sortby = 'modname';
    elseif ($sortby == 'filetype') $sortby = 'extension';

    $orderBy = 'ORDER BY ';
    if ($sortby == 'username') $orderBy .= 'c.' . $userscolumn['uname'];
    elseif ($sortby == 'RAND()') $orderBy .= 'RAND()';
    else $orderBy .= 'tbl.' . $filescolumn[$sortby];

    $orderBy .= ' ' . strtoupper($sortdir);

    if (!empty($assocKey) && !isset($filescolumn[$assocKey])) $assocKey = '';

    $files = DBUtil::selectExpandedObjectArray('ma_files', $joinArray, $where, $orderBy, $startnum-1, $numitems, $assocKey, $permFilter, $catFilter);

    if ($files === false || !$files) {
        return $files;
    }

    if (!($class = Loader::loadClass('ObjectUtil'))) {
        pn_exit (__f('Error! Unable to load class ObjectUtil'));
    }

    // need to do this here as the category expansion code can't know the
    // root category which we need to build the relative path component
    $categories = pnModAPIFunc('MediaAttach', 'cat', 'getCategoryTree');
    ObjectUtil::postProcessExpandedObjectArrayCategories($files, $categories);

    $ak = array_keys($files);
    foreach ($ak as $k) {
        $files[$k]['url'] = str_replace('&amp;', '&', urldecode($files[$k]['url']));
        if ($files[$k]['extension'] != 'extvid') {
            $files[$k]['fileInfo'] = pnModAPIFunc('MediaAttach', 'fileinfo', 'retrievefileinfo', array('file' => $files[$k]));
        }
    }

    return $files;
}
