<?php
/**
 * MediaAttach
 *
 * @version      $Id: $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * Modify configuration
 *
 * @return       output       The configuration page
 */
function MediaAttach_admin_modifyconfig()
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    Loader::requireOnce('modules/MediaAttach/pnincludes/MediaAttach_admin_modifyconfighandler.class.php');

    $render = FormUtil::newForm('MediaAttach');

    return $render->execute('MediaAttach_admin_modifyconfig.htm', new MediaAttach_admin_modifyconfighandler());
}
