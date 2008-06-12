<?php
/**
 * MediaAttach
 *
 * @version      $Id: function.madownloadtime.php 210 2007-08-08 12:58:50Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        string      size    	file size (in bytes)
 * @param        string      speed    	connection speed (speed in kb/s)
 * @return       string      the results of the module function
 */
function smarty_function_madownloadtime($params, &$smarty) 
{
    if (!isset($params['speed'])) {
        $smarty->trigger_error("smarty_function_madownloadtime: missing parameter 'speed'");
        return false;
    }

    if (!isset($params['size'])) {
        $smarty->trigger_error("smarty_function_madownloadtime: missing parameter 'size'");
        return false;
    }

    if (!is_numeric($params['size'])) {
        $smarty->trigger_error("smarty_function_madownloadtime: parameter 'size' must be an integer");
        return false;
    }

    $s = $params['size'] / ($params['speed'] * 128);
    $t = sprintf('%02d:%02d', $s / 60, $s % 60);
    if ($t == '00:00') {
        $t = '00:01';
    }

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $t);
    }
    else {
        return $t;
    }
}
