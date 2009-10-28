<?php
/**
 * MediaAttach
 *
 * @version      $Id: update.php 59 2008-03-02 09:57:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * Modify a file
 *
 * @param    fileid     int      the id of the file to be modified
 * @param    objectid   int      generic object id mapped onto fileid if present
 * @param    title      string   the title of the file
 * @param    desc       string   the description of the file
 * @param    cats       array    category array
 * @param    backurl    string   url to return to
 */
function MediaAttach_user_update($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $fileid   = (int) FormUtil::getPassedValue('fileid',                  (isset($args['fileid']) && is_numeric($args['fileid'])) ? $args['fileid'] : null, 'POST');
    $objectid = (int) FormUtil::getPassedValue('objectid',                (isset($args['objectid'])) ? $args['objectid'] : null, 'POST');
    $title    =       FormUtil::getPassedValue('MediaAttach_title',       (isset($args['title']))    ? $args['title']    : null, 'POST');
    $desc     =       FormUtil::getPassedValue('MediaAttach_description', (isset($args['desc']))     ? $args['desc']     : null, 'POST');
    $backurl  =       FormUtil::getPassedValue('backurl',                 (isset($args['backurl']))  ? $args['backurl']  : null, 'POST');

    $cats     =       FormUtil::getPassedValue('mafilecats', (isset($args['cats']) && is_array($args['cats'])) ? $args['cats'] : null, 'POST');
    unset($args);

    if (!empty($objectid)) {
        $fileid = $objectid;
    }

    $backurl = str_replace('&amp;', '&', base64_decode($backurl)) . '#file' . $fileid;

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(__("Invalid 'authkey':  this probably means that you pressed the 'Back' button, or that the page 'authkey' expired. Please refresh the page and try again.", $dom));
        return pnRedirect($backurl);
    }

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        LogUtil::registerError(__('Error! Could not load items.', $dom));
        return pnRedirect($backurl);
    }

    $file['objectid']       = $objectid;
    $file['title']          = $title;
    $file['desc']           = str_replace("\n", "<br />", $desc);
    $file['__CATEGORIES__'] = $cats;

    if (pnModAPIFunc('MediaAttach', 'user', 'update', $file)) {
        LogUtil::registerStatus(__('Done! Item updated.', $dom));
    }

    return pnRedirect($backurl);
}
