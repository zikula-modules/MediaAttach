<?php
/**
 * MediaAttach
 *
 * @version      $Id: countuploads.php 22 2008-02-23 21:30:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * get the amount of all uploaded files
 *
 * @param    fileFilter      string    optional filter by file id
 * @param    formatFilter    string    optional filter by file format
 * @param    catFilter       string    optional filter by category
 * @param    userFilter      int       optional filter by given user id
 * @param    moduleFilter    string    optional filter by module name
 * @param    objectidFilter  string    optional filter by object id
 * @param    searchfor       string    optional search term string
 * @param    bool            string    optional string 'AND' or 'OR'
 * @return   int             upload count
 */
function MediaAttach_userapi_countuploads($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }

    $fileFilter     = (isset($args['fileFilter'])   && is_array($args['fileFilter']))   ? $args['fileFilter']   : '';
    $formatFilter   = (isset($args['formatFilter']) && is_array($args['formatFilter'])) ? $args['formatFilter'] : '';
    $catFilter      = (isset($args['catFilter'])    && is_array($args['catFilter']))    ? $args['catFilter']    : array();
    $userFilter     = (isset($args['userFilter'])   && is_numeric($args['userFilter'])) ? $args['userFilter']   : '';
    $moduleFilter   = (isset($args['moduleFilter']))                                    ? $args['moduleFilter'] : '';
    $objectidFilter = (isset($args['objectidFilter']))                                  ? $args['objectidFilter'] : '';
    $searchfor      = (isset($args['searchfor'])    && !empty($searchfor))              ? $args['searchfor']    : '';
    $bool           = (isset($args['bool'])         && !empty($args['bool']))           ? $args['bool']         : 'AND';

    $where = _maIntBuildWhereString(array('fileFilter'     => $fileFilter,
                                          'formatFilter'   => $formatFilter,
                                          'userFilter'     => $userFilter,
                                          'moduleFilter'   => $moduleFilter,
                                          'objectidFilter' => $objectidFilter,
                                          'searchfor'      => $searchfor,
                                          'bool'           => $bool,
                                          'noexpand'       => true));

    $numitems = DBUtil::selectObjectCount('ma_files', $where, 'fileid', false, $catFilter);

    return $numitems;
}
