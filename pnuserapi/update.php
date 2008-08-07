<?php
/**
 * MediaAttach
 *
 * @version      $Id: update.php 22 2008-02-23 21:30:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * update a file
 *
 * @param    fileid             int     the ID of the file
 * @param    title              string  the file title
 * @param    desc               string  the file description
 * @param    __CATEGORIES__     array   categories array
 * @return   bool               true on success, false on failure
 */
function MediaAttach_userapi_update($args)
{
    if (!isset($args['fileid']) || !is_numeric($args['fileid'])
         || !isset($args['title'])
         || !isset($args['desc'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $fileid = $args['fileid'];
    $title  = $args['title'];
    $desc   = $args['desc'];
    $cats   = isset($args['__CATEGORIES__']) ? $args['__CATEGORIES__'] : Array();
    unset($args);

    if (!($file = DBUtil::selectObjectByID('ma_files', $fileid, 'fileid'))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $file['title'] = $title;
    $file['desc']  = $desc;
    $file['__CATEGORIES__'] = $cats;

    $result = DBUtil::updateObject($file, 'ma_files', '', 'fileid');

    if (!$result) {
        return LogUtil::registerError(_UPDATEFAILED);
    }

    // call update hooks for this item
    pnModCallHooks('item', 'update', $file['fileid'], array('module' => 'MediaAttach'));

    $render = pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $fileid);

    return true;
}
