<?php
/**
 * MediaAttach
 *
 * @version      $Id: display.php 22 2008-02-23 09:57:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * send upload in a mail to a user
 *
 * @param    fileid    int   id of file to send
 * @return   output    the confirmation
 */
function MediaAttach_user_sendfile($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!pnUserLoggedIn()) {
        return LogUtil::registerPermissionError();
    }

    $fileid = (int) FormUtil::getPassedValue('fileid', (isset($args['fileid'])) ? $args['fileid'] : null, 'GET');
    unset($args);

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    if (!SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$fileid", ACCESS_READ)) {
        return LogUtil::registerPermissionError();
    }

    $fullfilename = pnModGetVar('MediaAttach', 'uploaddir') . '/' . $file['filename'];

    if (pnModAPIFunc('Mailer', 'user', 'sendmessage',
                     array('fromname'    => pnConfigGetVar('sitename'),
                           'fromaddress' => pnConfigGetVar('adminmail'),
                           'toname'      => pnUserGetVar('uname'),
                           'toaddress'   => pnUserGetVar('email'),
                           'subject'     => _MEDIAATTACH_DLMAILSUBJECT . ': ' . $file['filename'],
                           'body'        => __('Hi! Here is the file which you sent yourself on our site', $dom),
                           'html'        => 0,
                           'attachments' => array($fullfilename)))) {
        pnModAPIFunc('MediaAttach', 'user', 'incdlcounter', array('fileid' => $fileid));
        pnSessionSetVar('statusmsg', __('The mail has been sent to you successfully', $dom));
    } else {
        LogUtil::registerError(__('Sorry, the mail could not be sent to you', $dom));
    }

    $file['url'] = str_replace('&amp;', '&', urldecode($file['url']));

    return pnRedirect($file['url'] . '#file' . $fileid);
}
