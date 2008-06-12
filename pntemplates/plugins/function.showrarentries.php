<?php
/**
 * MediaAttach
 *
 * @version      $Id: function.showrarentries.php 210 2007-08-08 12:58:50Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        string      filename     name of file to examine
 * @return       mixed       analyzation results
 */
function smarty_function_showrarentries($params, &$smarty) 
{
    if (!isset($params['filename'])) {
        $smarty->trigger_error("smarty_function_showrarentries: missing parameter 'filename'");
        return false;
    }

    $res = '';
    if (function_exists('rar_open')) {
        $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');
        $rar_file = rar_open($uploaddir . '/' . $params['filename']) or $smarty->trigger_error("smarty_function_showrarentries: Can't open Rar archive");

        $entries = rar_list($rar_file);

        $cachedir = pnModGetVar('MediaAttach', 'cachedir');
        $cachedir = realpath($cachedir);
        $cachedir .= '/';
        $res .= 'rar support is experimental, please give feedback if it works<br />';
        foreach ($entries as $entry) {
           $res .= $entry->getName() . ' (packed size: ' . $entry->getPackedSize() . ', unpacked size: ' . $entry->getUnpackedSize() . ')<br />' . "\n";
//           $entry->extract($cachedir);
        }

        rar_close($rar_file);
    }
    else {
//        $res = 'Extracting rar files not possible due to php settings.';
    }

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $res);
    }
    else {
        return $res;
    }
}
