<?php
/**
 * MediaAttach
 *
 * @version      $Id: function.showtarentries.php 210 2007-08-08 12:58:50Z weckamc $
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
function smarty_function_showtarentries($params, &$smarty) 
{
    if (!isset($params['filename'])) {
        $smarty->trigger_error("smarty_function_showtarentries: missing parameter 'filename'");
        return false;
    }

    Loader::requireOnce('modules/MediaAttach/pnincludes/tarmanager/tar.class.php');

    $tarHandler = new tar();
    $tarFile = realpath(pnModGetVar('MediaAttach', 'uploaddir')) . '/' . $params['filename'];

    if (!file_exists($tarFile) || !$tarHandler->openTar($tarFile)) {
        return 'Sorry, could not open archive.';
    }

    $res = '';
    if($tarHandler->numDirectories > 0) {
        $res .= 'Directories:<br />';
        foreach($tarHandler->directories as $id => $information) {
            $res .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$information[directory]/$information[name]<br />\n";
        }
        $res .= "<br />\n";
    }

    if($tarHandler->numFiles > 0) {
        $res .= 'Files:<br />';
        foreach($tarHandler->files as $id => $information) {
            $res .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$information[directory]/$information[name]<br />\n";
        }
        $res .= "<br />\n";
    }

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $res);
    }
    else {
        return $res;
    }
}
