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
 * retrieves all modules covered by MediaAttach
 *
 * @return mixed    module array on success, false on failure
 */
function MediaAttach_catapi_getModules()
{
    $pntables = pnDBGetTables();
    $fcolumn  = $pntables['ma_files_column'];

    $definitions = pnModAPIFunc('MediaAttach', 'definitions', 'getalldefinitions');
    $modules = array();

    $currentLang = pnUserGetLang();
    foreach($definitions as $def) {
        $modInfo = pnModGetInfo(pnModGetIDFromName($def['modname']));
        // transformation for unified handling with Categories
        $modInfo['display_name'] = array($currentLang => $modInfo['displayname']);

        $where = $fcolumn['modname'].' = \''.$def['modname'].'\'';
        $filecount = DBUtil::selectObjectCount('ma_files', $where);
        $modInfo['filecount'] = $filecount;

        $modules[] = $modInfo;
    }

    return $modules;
}
