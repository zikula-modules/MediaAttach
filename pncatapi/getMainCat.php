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
 * retrieves the main/default category of MediaAttach
 *
 * @return mixed    category array on success, false on failure
 */
function MediaAttach_catapi_getMainCat()
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!($class = Loader::loadClass('CategoryRegistryUtil'))) {
        pn_exit (__('Error! Unable to load class CategoryRegistryUtil', $dom));
    }

    return CategoryRegistryUtil::getRegisteredModuleCategory('MediaAttach', 'ma_files', 'Main', 30); // 30 == /__System/Modules/Global
}

