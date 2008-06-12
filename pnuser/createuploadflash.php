<?php
/**
 * MediaAttach
 *
 * @version      $Id: createuploadflash.php 59 2008-03-02 09:57:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * Create an upload for a specific item (uploaded by flash / swf widget)
 */
function MediaAttach_user_createuploadflash()
{
    if (pnSessionGetVar('MediaAttachCreateLock') == '1') {
        header("HTTP/1.0 500 Server Error");
        echo 'Already in action';
        exit(0);
    }

    $modname  = FormUtil::getPassedValue('parentmodule',  '', 'GET');
    if (empty($modname)) {
        header("HTTP/1.0 500 Server Error");
        echo 'Invalid module';
        exit(0);
    }

    if (!SecurityUtil::checkPermission('MediaAttach::', "$modname:: ", ACCESS_COMMENT)) {
        header("HTTP/1.0 403 Forbidden");
        echo 'You have no permissions';
        exit(0);
    }

    $definition = pnModAPIFunc('MediaAttach', 'definitions', 'getmoduledefinition', array('modname' => $modname));

    $objectid = FormUtil::getPassedValue('objectid', null, 'GET');
    $redirect = FormUtil::getPassedValue('redirect', null, 'GET');
    $redirect = str_replace('&amp;', '&', base64_decode($redirect)) . '#files';

    $msglog = MediaAttach_user_performsingleupload(1, $_FILES['Filedata'], _MEDIAATTACH_NOTITLE, '', array(0), $modname, $objectid, $redirect, $definition, '');

    header("HTTP/1.0 200 OK");
    return true;
}
