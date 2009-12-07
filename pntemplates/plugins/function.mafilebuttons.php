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
function smarty_function_mafilebuttons($params, &$smarty) 
{
    if (!isset($params['file'])) {
        $smarty->trigger_error("smarty_function_mafilebuttons: missing parameter 'file'");
        return false;
    }

    if (!is_array($params['file'])) {
        $smarty->trigger_error("smarty_function_mafilebuttons: wrong parameter 'file'");
        return false;
    }

    $res = '';

    $render = & pnRender::getInstance('MediaAttach', false);
    $render->assign('file', $params['file']);
    $render->assign('view', (isset($params['view'])) ? (int) $params['view'] : 0);
    $render->assign('edit', (isset($params['edit'])) ? (int) $params['edit'] : 0);
    $render->assign('delete', (isset($params['delete'])) ? (int) $params['delete'] : 0);

    if ($params['file']['extension'] != 'extvid') {
        $render->assign('info', (isset($params['info'])) ? (int) $params['info'] : 0);
        $render->assign('dl', (isset($params['dl'])) ? (int) $params['dl'] : 0);

        $uid = pnSessionGetVar('uid');
        $mail = (isset($params['mail'])) ? (int) $params['mail'] : 0;
        $mailfiles = pnModGetVar('MediaAttach', 'mailfiles');
        $maxmailsize = pnModGetVar('MediaAttach', 'maxmailsize') * 1024;
        $render->assign('mail', $mail && $uid != '' && $mailfiles == 1 && $params['file']['filesize'] < $maxmailsize);
    }
    else {
        $render->assign('info', 0);
        $render->assign('dl', 0);
        $render->assign('mail', 0);
    }

    $thumbnr = (isset($params['thumbnr'])) ? $params['thumbnr'] : FormUtil::getPassedValue('thumbnr', 0, 'GETPOST');
    if ($thumbnr != 'original') $thumbnr = (int) $thumbnr;
    if ($thumbnr != 'original' && !is_numeric($thumbnr)) {
        $thumbnr = pnModGetVar('MediaAttach', 'defaultthumb');
    }
    $render->assign('thumbnr', $thumbnr);

    $render->assign('usethumbcropper', pnModGetVar('MediaAttach', 'usethumbcropper'));

    $res = $render->fetch('MediaAttach_file_buttons.htm');

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $res);
    }
    else {
        return $res;
    }
}
