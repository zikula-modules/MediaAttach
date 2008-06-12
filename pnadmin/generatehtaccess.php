<?php
/**
 * MediaAttach
 *
 * @version      $Id: $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * Create a .htaccess file for denying direct access in case $uploaddir is being placed within the webroot
 */
function MediaAttach_admin_generatehtaccess()
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');
    if (!file_exists($uploaddir . '/.htaccess')) {
        $htHandle = fopen($uploaddir . '/.htaccess', 'w');
        fwrite($htHandle, "# Purpose of file: block any direct web access to MediaAttach files\n");
        fwrite($htHandle, "# -------------------------------------------------------------\n");
        fwrite($htHandle, "Order deny,allow\n");
        fwrite($htHandle, "Deny from all\n");
        fclose($htHandle);
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'modifyconfig'));
}

