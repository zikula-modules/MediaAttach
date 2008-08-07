<?php
/**
 * MediaAttach
 *
 * @version      $Id: incdlcounter.php 22 2008-02-23 21:30:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * increase the download count of an upload
 *
 * @param    fileid     int    the ID of the file
 * @return   bool       true on success, false on failure
 */
function MediaAttach_userapi_incdlcounter($args)
{
    if (!isset($args['fileid']) || !is_numeric($args['fileid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $result = DBUtil::incrementObjectFieldByID('ma_files', 'dlcount', $args['fileid'], 'fileid', 1);

    if ($result === false) {
        return false;
    }

    $render = pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $fileid);

    return true;
}
