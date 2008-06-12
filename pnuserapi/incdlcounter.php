<?php
/**
 * MediaAttach
 *
 * @version      $Id: incdlcounter.php 22 2008-02-23 21:30:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * increase the download count of an upload
 *
 * @param    int    $args['fileid']       the ID of the file
 * @return   bool                         true on success, false on failure
 */
function MediaAttach_userapi_incdlcounter($args)
{
    if (!isset($args['fileid']) || !is_numeric($args['fileid'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $fileid = $args['fileid'];
    unset($args);

    $pntables = pnDBGetTables();
    $column   = $pntables['ma_files_column'];

    $sql = "UPDATE " . $pntables['ma_files'] . "
            SET $column[dlcount] = $column[dlcount] + 1
            WHERE $column[fileid] = '" . (int) DataUtil::formatForStore($fileid) . "'";

    $result = DBUtil::executeSQL($sql);

    if (!$result) {
        return false;
    }

    $render = pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $fileid);

    return true;
}
