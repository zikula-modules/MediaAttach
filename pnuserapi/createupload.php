<?php
/**
 * MediaAttach
 *
 * @version      $Id: createupload.php 42 2008-03-01 14:59:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * create a new upload
 *
 * This function creates a new upload and returns its ID.
 * Access checking is done.
 *
 * @param    modname         string  Name of the module to create upload for
 * @param    objectid        int     ID of the item to create upload for
 * @param    definition      int     The definition id of the upload
 * @param    uid             int     The uploader's user id
 * @param    title           string  The title of the upload
 * @param    desc            string  The description of the upload
 * @param    extension       string  The extension of the upload file
 * @param    mimetype        string  The mimetype of the upload
 * @param    filename        string  The original file name of the upload file
 * @param    filesize        int     The file size of the upload file
 * @param    url             string  The url to redirect to
 * @param    __CATEGORIES__  array   categories array
 * @return   integer         ID of new upload file on success, false on failure
 */
function MediaAttach_userapi_createupload($args)
{
    if (!isset($args['modname'])
             || !isset($args['objectid'])
             || !isset($args['definition'])
             || !isset($args['uid'])
             || !isset($args['extension'])
             || !isset($args['mimetype'])
             || !isset($args['filename'])
             || !isset($args['filesize'])
             || !isset($args['url'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $modname    = $args['modname'];
    $objectid   = $args['objectid'];
    $definition = $args['definition'];
    $uid        = $args['uid'];
    $title      = (isset($args['title'])) ? $args['title'] : '';
    $desc       = (isset($args['desc'])) ? $args['desc'] : '';
    $extension  = strtolower($args['extension']);
    $mimetype   = $args['mimetype'];
    $filename   = $args['filename'];
    $filesize   = $args['filesize'];
    $url        = $args['url'];
    $cats       = isset($args['__CATEGORIES__']) ? $args['__CATEGORIES__'] : Array();
    unset($args);

    if (!SecurityUtil::checkPermission('MediaAttach::', "$modname:$objectid:", ACCESS_COMMENT)) {
        return LogUtil::registerPermissionError();
    }

    $file = array('definition'     => $definition,
                  'modname'        => $modname,
                  'objectid'       => $objectid,
                  'uid'            => $uid,
                  'date'           => date("Y-m-d H:i:s"),
                  'title'          => $title,
                  'desc'           => $desc,
                  'extension'      => $extension,
                  'mimetype'       => $mimetype,
                  'filename'       => $filename,
                  'filesize'       => $filesize,
                  'dlcount'        => '0',
                  'url'            => $url);
    $file['__CATEGORIES__'] = $cats;

    $result = DBUtil::insertObject($file, 'ma_files', 'fileid');

    if (!$result) {
        return LogUtil::registerError(_CREATEFAILED);
    }

    // call create hooks for this item
    pnSessionSetVar('MediaAttachCreateLock', '1'); // prevent recursive call
    pnModCallHooks('item', 'create', $file['fileid'], array('module' => 'MediaAttach'));
    pnSessionSetVar('MediaAttachCreateLock', '0');

    return $file['fileid'];
}
