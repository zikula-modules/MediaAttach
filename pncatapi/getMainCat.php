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
 * retrieves the main/default category of MediaAttach
 *
 * @return mixed    category array on success, false on failure
 */
function MediaAttach_catapi_getMainCat()
{
    if (!($class = Loader::loadClass('CategoryRegistryUtil'))) {
        pn_exit (pnML('_UNABLETOLOADCLASS', array('s' => 'CategoryRegistryUtil')));
    }

    return CategoryRegistryUtil::getRegisteredModuleCategory('MediaAttach', 'ma_files', 'Main', 30); // 30 == /__System/Modules/Global
}

