<?php
/**
 * MediaAttach
 *
 * @version      $Id: function.maprofileinfo.php 210 2007-08-08 12:58:50Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        int         uid          id of user who's file information is being requested
 * @return       string      output
 */
function smarty_function_maprofileinfo($params, &$smarty)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!isset($params['uid'])) {
        $smarty->trigger_error("smarty_function_maprofileinfo: missing parameter 'uid'");
        return false;
    }

    if (!is_numeric($params['uid'])) {
        $smarty->trigger_error("smarty_function_maprofileinfo: parameter 'uid' must be numeric");
        return false;
    }

    //this plugin is being executed from the Profile menu - we have to ensure lang files are loaded
    pnModLangLoad('MediaAttach');

    $files = pnModAPIFunc('MediaAttach', 'user', 'getalluploads',
                                         array('startnum'     => 1,
                                               'userFilter'   => $params['uid']));

    $numFiles = 0;
    $sizeFiles = 0;

    $res = '<tr>' . "\n";
    $res .= '<td>' . _MEDIAATTACH_PROFILEUPLOADS . '</td>' . "\n";

    if (!$files) {
        $res .= '<td>' . __f('%s files uploaded', $numFiles) . '</td>' . "\n";
    }
    else {
        $numFiles = count($files);

        for ($i = 0; $i < $numFiles; $i++) {
            $sizeFiles += $files[$i]['filesize'];
        }

        Loader::requireOnce('modules/MediaAttach/common.php');
        $sizeFiles = _maIntCalcReadableFilesize($sizeFiles);

        $res .= '<td>' . __f('%s files uploaded', $numFiles) . ' (' . $sizeFiles . ' ' . _MEDIAATTACH_PROFILETOTAL . ')' . '</td>' . "\n";
    }

    $res .= '</tr>' . "\n";

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $res);
    }
    else {
        return $res;
    }
}
