<?php
/**
 * MediaAttach
 *
 * @version      $Id: function.showzipentries.php 210 2007-08-08 12:58:50Z weckamc $
 * @author       Axel Guckelsberger & Nicolas Berens
 * @link         http://guite.de
 * @copyright    Copyright (C) 2009 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        int         fileid       id of file for unique ids within html
 * @param        array       dirarray     array of directory to parse
 * @return       mixed       analyzation results
 */
function smarty_function_showzipentries($params, &$smarty) 
{
    if (!isset($params['fileid'])) {
        $smarty->trigger_error("smarty_function_showzipentries: missing parameter 'fileid'");
        return false;
    }

    if (!is_numeric($params['fileid'])) {
        $params['fileid'] = (int) $params['fileid'];
    }

    if (!isset($params['dirarray'])) {
        $smarty->trigger_error("smarty_function_showzipentries: missing parameter 'dirarray'");
        return false;
    }

    if (!is_array($params['dirarray'])) {
        $smarty->trigger_error("smarty_function_showzipentries: wrong parameter 'dirarray'");
        return false;
    }

    $dirul = '';

    $dirul .= '<ul id="tree" class="matree">';
    $dirul .= createULconstructFromDirArray($params['dirarray'], menuname);
    $dirul .= '</ul>';

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $dirul);
    }
    else {
        return $dirul;
    }
}

function createULconstructFromDirArray($dirarray, $menuname, $level=1)  {
    $dirul = "";
    foreach($dirarray as $currentKey => $currentValue) {
        if (is_array($currentValue)) {
            $dirul .= '<li><a href="#">' . $currentKey . '</a>' . "\n" . '<ul>' . "\n";
            $dirul .= createULconstructFromDirArray($currentValue, $menuname, $level+1);
            $dirul .= '</ul></li>';
        }
        else {
            $dirul .= '<li><a href="">' . $currentKey . '&nbsp;(' . $currentValue . ' bytes)</a></li>' . "\n";
        }
    }
    return $dirul;
}
