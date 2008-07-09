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
function MediaAttach_catapi_orderCategories($args)
{
    if (!isset($args['categories']) || empty($args['categories'])) {
        return;
    }

    if (!isset($args['sort_id']) || empty($args['sort_id'])) {
        $args['sort_id'] = 'sort_value';
    }

    if (!isset($args['sort_ascending']) || empty($args['sort_ascending'])) {
        $args['sort_ascending'] = true;
    }

    $array          = $args['categories'];
    $id             = $args['sort_id'];
    $sort_ascending = $args['sort_ascending'];
    unset($args);

    $temp_array = array();
    while (count($array) > 0) {
        $top_id = 0;
        $bottom_id = 0;
        $index = 0;
        $property = '';

        // Check the top level categories
        $ak = array_keys($array);
        foreach ($ak as $k) {
            $depth = StringUtil::countInstances($array[$k]['ipath_relative'], '/');

            if ($depth == 0 && (empty($property) || $array[$k]['catprop'] == $property)) {
                $property = $array[$k]['catprop'];
                if ($array[$k][$id] < $array[$top_id][$id]) {
                    $top_id = $index;
                }
            }
            $index++;
        }
        $temp_array[] = $array[$top_id];
        
        // Add the childs to the parent
        $bottom_id = $top_id+1;
        while ($bottom_id <= $index) {
            $depth = StringUtil::countInstances($array[$bottom_id]['ipath_relative'], '/');
            if ($depth == 0) {
                // Another top level category reached
                break;
            }
            $temp_array[] = $array[$bottom_id];
            $bottom_id++;
        }
        $array = array_merge(array_slice($array, 0, $top_id), array_slice($array, $bottom_id));
    }

    if ($sort_ascending) {
        return $temp_array;
    } else {
        return array_reverse($temp_array);
    }
}
