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


/**
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        imgref      image        file path of image to examine
 * @return       array       return array of getimgsize
 */
function smarty_function_maimagesize($params, &$smarty)
{
    if (!isset($params['imgref'])) {
        $smarty->trigger_error("smarty_function_maimagesize: missing parameter 'ref'");
        return false;
    }

    $result = getimagesize($params['imgref']);

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $result);
    }
    else {
        return $result;
    }
}
