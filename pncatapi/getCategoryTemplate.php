<?php
/**
 * MediaAttach
 *
 * @version      $Id: getCategoryTemplate.php 127 2008-06-10 09:03:14Z mateo $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
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
    if (empty($args['property']) || !is_string($args['property'])
      || empty($args['category']) || !is_array($args['category']) ) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $property = $args['property'];
    $category = $args['category'];
    unset($args);

    $template = '';

    // Check for an specific category template
    if (isset($category['__ATTRIBUTES__']['ma_filetemplate']) && !empty($category['__ATTRIBUTES__']['ma_filetemplate'])) {
        $template = 'MediaAttach_user_list'.$category['__ATTRIBUTES__']['ma_filetemplate'].'.htm';
    } else {
        // Check parent categories to inherit a template if exists
        if (!($class = Loader::loadClass('CategoryUtil'))) {
            pn_exit (pnML('_UNABLETOLOADCLASS', array('s' => 'CategoryUtil')));
        }

        // get the ipath of the category root of the registry
        $rootCat   = '/'.$catRegistry[$property].'/';

        // clean the path to get the parent categories IDs only
        $upperpath = substr($category['ipath'], strpos($category['ipath'], $rootCat) + 1);
        $upperpath = substr($upperpath, 0, strlen($upperpath) - strlen('/'.$category['id']));

        // extract the parent categories IDs
        $parentIDs = explode('/', $upperpath);

        $where = array();
        foreach ($parentIDs as $catID) {
            $where[] = "cat_id='".DataUtil::formatForStore($catID)."'";
        }
        $where = implode(' OR ', $where);
        $parentCats = CategoryUtil::getCategories($where, '', 'id');

        // Check the parent categories and inherit the first template found
        for ($i = count($parentIDs)-1; $i >= 0; $i--) {
            if (isset($parentCats[$parentIDs[$i]]['__ATTRIBUTES__']['ma_filetemplate']) && !empty($parentCats[$parentIDs[$i]]['__ATTRIBUTES__']['ma_filetemplate'])) {
                $template = 'MediaAttach_user_list'.$parentCats[$parentIDs[$i]]['__ATTRIBUTES__']['ma_filetemplate'].'.htm';
                break;
            }
        }
    }

    return $template;
}
