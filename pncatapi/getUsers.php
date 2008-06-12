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
 * retrieves all users having files in MediaAttach
 *
 * @return mixed    user array on success, false on failure
 */
function MediaAttach_catapi_getUsers()
{
    $pntables = pnDBGetTables();
    $fcolumn  = $pntables['ma_files_column'];

    $allFiles = DBUtil::selectObjectArray('ma_files');
    $users = array();
    $allUIDs = array();
    foreach($allFiles as $file) {
        if (!in_array($file['uid'], $allUIDs)) {
            $newUID = $file['uid'];
            $allUIDs[] = $newUID;

            $newUname = pnUserGetVar('uname', $newUID);

            $where = $fcolumn['uid'] . " = '" . $newUID . "'";
            $filecount = DBUtil::selectObjectCount('ma_files', $where);

            $users[] = array('id' => $newUID,
                             'name' => $newUname,
                             'filecount' => $filecount);
        }
    }

    return $users;
}
