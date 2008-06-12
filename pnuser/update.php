<?php
/**
 * MediaAttach
 *
 * @version      $Id: update.php 59 2008-03-02 09:57:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * Modify a file
 *
 * @param    int      fileid     the id of the file to be modified
 * @param    int      objectid   generic object id mapped onto fileid if present
 * @param    string   title      the title of the file
 * @param    string   desc       the description of the file
 * @param    array    cats       category array
 * @param    string   backurl    url to return to
 */
function MediaAttach_user_update($args)
{
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
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect($backurl);
    }

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        LogUtil::registerError(_GETFAILED);
        return pnRedirect($backurl);
    }

    $file['objectid']       = $objectid;
    $file['title']          = $title;
    $file['desc']           = str_replace("\n", "<br />", $desc);
    $file['__CATEGORIES__'] = $cats;

    if (pnModAPIFunc('MediaAttach', 'user', 'update', $file)) {
        LogUtil::registerStatus(_UPDATESUCCEDED);
    }

    return pnRedirect($backurl);
}
