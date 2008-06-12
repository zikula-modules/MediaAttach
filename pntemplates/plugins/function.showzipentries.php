<?php
/**
 * MediaAttach
 *
 * @version      $Id: function.showzipentries.php 210 2007-08-08 12:58:50Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
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

    $menuname = 'treemenu' . $params['fileid'];
    $treeimagepath = 'modules/MediaAttach/pnincludes/treemenu/';
    $res = '<script type="text/javascript" language="javascript">' . "\n";
    $res .= '    var ' . $menuname . ' = new TREEMENU();' . "\n";
    $res .= '    ' . $menuname . '.entry(1, "Root folder");' . "\n";
    $res .= getRecursiveDirString($params['dirarray'], $menuname);
    $res .= '    ' . $menuname . '.width = 200;' . "\n";
    $res .= '    ' . $menuname . '.bgColor = "transparent";' . "\n";
    $res .= '    ' . $menuname . '.itemBGColor = "transparent";' . "\n";
    $res .= '    ' . $menuname . '.itemBGColor1 = "transparent";' . "\n";
    $res .= '    ' . $menuname . '.autoClose = true;' . "\n";
    $res .= '    ' . $menuname . '.itemWrap = false;' . "\n";
    $res .= '    ' . $menuname . '.itemBold = true;' . "\n";
    $res .= '    ' . $menuname . '.iconClosed = "' . $treeimagepath . 'closed.gif";' . "\n";
    $res .= '    ' . $menuname . '.iconClosedHilight = "' . $treeimagepath . 'closed_hilight.gif";' . "\n";
    $res .= '    ' . $menuname . '.iconOpen = "' . $treeimagepath . 'open.gif";' . "\n";
    $res .= '    ' . $menuname . '.iconOpenHilight = "' . $treeimagepath . 'open_hilight.gif";' . "\n";
    $res .= '    ' . $menuname . '.iconPoint = "' . $treeimagepath . 'point.gif";' . "\n";
    $res .= '    ' . $menuname . '.iconPointHilight = "' . $treeimagepath . 'point_hilight.gif";' . "\n";
    $res .= '    ' . $menuname . '.imgBlank = "' . $treeimagepath . 'blank.gif";' . "\n";
    $res .= '    ' . $menuname . '.create();' . "\n";
    $res .= '</script>' . "\n";

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $res);
    }
    else {
        return $res;
    }
}


function getRecursiveDirString($dirarray, $menuname, $level=1) {
    $res = '';
    foreach($dirarray as $currentKey => $currentValue) {
        if (is_array($currentValue)) {

            $res .= '    ' . $menuname . '.entry(' . ($level+1) . ', "' . $currentKey . '");' . "\n";
            $res .= getRecursiveDirString($currentValue, $menuname, $level+1);
        }
        else {
            $res .= '    ' . $menuname . '.entry(' . ($level+1) . ', "' . $currentKey . ' (' . $currentValue . ' bytes)");' . "\n";
        }
    }
    return $res;
}
