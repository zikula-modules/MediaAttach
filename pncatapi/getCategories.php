<?php
/**
 * MediaAttach
 *
 * @version      $Id: getCategories.php 114 2008-05-05 06:42:14Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * retrieves all MediaAttach categories
 *
 * @return mixed    category array on success, false on failure
 */
function MediaAttach_catapi_getCategories()
{
    if (!($class = Loader::loadClass('CategoryUtil'))) {
        pn_exit (pnML('_UNABLETOLOADCLASS', array('s' => 'CategoryUtil')));
    }

    $categories  = array();
    $catRegistry = pnModAPIFunc('MediaAttach', 'cat', 'getCategoryTree');

    // Different registered categories will be retrieved
    // TODO: config var to choose the property to list by default
    $alreadyIncluded = array(); 
    foreach ($catRegistry as $prop => $rootCat) {
        // check if the category is already listed
        if (isset($alreadyIncluded[$rootCat])) {
            continue; 
        }
        $alreadyIncluded[$rootCat] = 1;

        // Get the subcategories
        $allCats = CategoryUtil::getSubCategories($rootCat);

        // Get the number of files for each category
        foreach ($allCats as $category) {
            $filecount = DBUtil::selectObjectCount('ma_files', '', '1', false, array($prop => $category['id']));
            $category['filecount'] = $filecount;
            $category['catprop'] = $prop;
            $categories[] = $category;
        }
    }

    return $categories;
}
