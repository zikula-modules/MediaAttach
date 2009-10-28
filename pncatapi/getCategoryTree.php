<?php
/**
 * MediaAttach
 *
 * @version      $Id: getCategoryTree.php 114 2008-05-05 06:42:14Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * retrieves the categories of MediaAttach
 *
 * @return mixed    category array on success, false on failure
 */
function MediaAttach_catapi_getCategoryTree()
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!($class = Loader::loadClass('CategoryRegistryUtil'))) {
        pn_exit (__('Error! Unable to load class CategoryRegistryUtil', $dom));
    }

    return CategoryRegistryUtil::getRegisteredModuleCategories('MediaAttach', 'ma_files');
}
