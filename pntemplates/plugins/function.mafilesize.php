<?php
/**
 * MediaAttach
 *
 * @version      $Id: function.mafilesize.php 210 2007-08-08 12:58:50Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        string      size         file size in bytes
 * @param        boolean     nodesc       if set to true the description will not be appended
 * @param        boolean     onlydesc     if set to true only the description will be returned
 * @return       string      file size in a readable form
 */
function smarty_function_mafilesize($params, &$smarty) 
{
    if (!isset($params['size'])) {
        $smarty->trigger_error("smarty_function_mafilesize: missing parameter 'size'");
        return false;
    }

    $nodesc = (isset($params['nodesc'])) ? $params['nodesc'] : false;
    $onlydesc = (isset($params['onlydesc'])) ? $params['onlydesc'] : false;

    if (!is_numeric($params['size'])) {
        $params['size'] = (int) $params['size'];
    }

    Loader::requireOnce('modules/MediaAttach/common.php');
    $result = _maIntCalcReadableFilesize($params['size'], $nodesc, $onlydesc);

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $result);
    }
    else {
        return $result;
    }
}
