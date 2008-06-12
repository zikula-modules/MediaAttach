<?php
/**
 * MediaAttach
 *
 * @version      $Id: function.maimageselect.php 210 2007-08-08 12:58:50Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        string      selected    (optional) image to select
 * @param        string      type        'formats' or 'groups'
 * @return       string      the results of the module function
 */
function smarty_function_maimageselect($params, &$smarty)
{
    if (!isset($params['type'])) {
        $smarty->trigger_error("smarty_function_maimageselect: missing parameter 'type'");
        return false;
    }

    if ($params['type'] == 'formats') {
        $imgdir = 'modules/MediaAttach/pnimages/formats';
    }
    elseif ($params['type'] == 'groups') {
        $imgdir = 'modules/MediaAttach/pnimages/folder';
    }

    $res = '<select id="MediaAttach_image" name="image" size="1" onchange="document.getElementById(\'currentformat\').src = \'' . $imgdir . '/\' + document.getElementById(\'MediaAttach_image\').options[document.getElementById(\'MediaAttach_image\').selectedIndex].value;" onkeyup="document.getElementById(\'currentformat\').src = \'' . $imgdir . '/\' + document.getElementById(\'MediaAttach_image\').options[document.getElementById(\'MediaAttach_image\').selectedIndex].value;">' . "\n";

    $handle = opendir($imgdir);
    while ($file = readdir($handle)) {
        $images[] = $file;
    }
    asort($images);

    foreach ($images as $currentimg) {
        if ($currentimg != '.' && $currentimg != '..' && $currentimg != 'index.htm' && $currentimg != 'index.html' && $currentimg != '.cvs' && $currentimg != '.svn') {
            $res .= '<option value="' . $currentimg . '"';
            if ($params['selected'] == $currentimg) $res .= ' selected="selected"';
            $res .= '>' . $currentimg . '</option>' . "\n";
        }
    }

    $res .= '</select>&nbsp;&nbsp;<img src="' . $imgdir . '/' . $params['selected'] . '" id="currentformat" width="22" height="22" alt="" />' . "\n";

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $res);
    }
    else {
        return $res;
    }
}
