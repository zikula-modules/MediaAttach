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
 * @param        array       file         given upload array
 * @return       string      according template
 */
function smarty_function_mareturnurl($params, &$smarty) 
{
    $entrypoint = pnConfigGetVar('entrypoint', 'index.php');

    $backurl = pnGetCurrentURI();
    // cut off prepending folders in case PN has been installed in a subdirectory
    $backurl = substr($backurl, strpos($backurl, $entrypoint));
    if ($backurl{0} == '/') {
        $backurl = substr($backurl, 1);
    }

    $backurl = base64_encode($backurl);

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $backurl);
    }
    else {
        return $backurl;
    }
}
