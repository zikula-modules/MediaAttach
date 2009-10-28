<?php
/**
 * MediaAttach
 *
 * @version      $Id: getCategoryTemplate.php 127 2008-06-10 09:03:14Z mateo $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * retrieves the category MediaAttach template if exists
 *
 * @return string    template name, empty string if not exits
 */
function MediaAttach_catapi_getCategoryTemplate($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (empty($args['property']) || !is_string($args['property'])
      || empty($args['category']) || !is_array($args['category']) ) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $property = $args['property'];
    $category = $args['category'];
    unset($args);

    // check for an specific category template
    if (isset($category['__ATTRIBUTES__']['ma_filetemplate']) && !empty($category['__ATTRIBUTES__']['ma_filetemplate'])) {
        $template = 'MediaAttach_user_list' . $category['__ATTRIBUTES__']['ma_filetemplate'] . '.htm';
        return $template;
    }

    // else...

    // check parent categories to inherit a template if exists
    if (!($class = Loader::loadClass('CategoryUtil'))) {
        pn_exit (__('Error! Unable to load class CategoryUtil', $dom));
    }

    // get the ipath of the category root of the registry
    $rootCat   = '/' . $catRegistry[$property] . '/';

    // clean the path to get the parent categories IDs only
    $upperpath = substr($category['ipath'], strpos($category['ipath'], $rootCat) + 1);
    $upperpath = StringUtil::left($upperpath, strlen($upperpath) - strlen('/'.$category['id']));

    // extract the parent categories IDs
    $parentIDs = explode('/', $upperpath);

    $where = array();
    foreach ($parentIDs as $catID) {
        $where[] = "cat_id='".DataUtil::formatForStore($catID)."'";
    }
    $where = implode(' OR ', $where);
    $parentCats = CategoryUtil::getCategories($where, '', 'id');

    $template = '';
    // Check the parent categories and inherit the first template found
    for ($i = count($parentIDs)-1; $i >= 0; $i--) {
        if (isset($parentCats[$parentIDs[$i]]['__ATTRIBUTES__']['ma_filetemplate']) && !empty($parentCats[$parentIDs[$i]]['__ATTRIBUTES__']['ma_filetemplate'])) {
            $template = 'MediaAttach_user_list'.$parentCats[$parentIDs[$i]]['__ATTRIBUTES__']['ma_filetemplate'].'.htm';
            break;
        }
    }

    return $template;
}
