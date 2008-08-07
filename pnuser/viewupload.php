<?php
/**
 * MediaAttach
 *
 * @version      $Id: viewupload.php 114 2008-05-05 06:24:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * display the upload formular
 *
 * @param    objectid     int      ID of the item to refer to
 * @return   output       upload form
 */
function MediaAttach_user_viewupload($args)
{
    $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');
    if (!pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => $uploaddir))) {
        return LogUtil::registerError(_MEDIAATTACH_DIRERR);
    }

    $modname   = pnModGetName();
    $objectid  = (isset($args['objectid'])) ? $args['objectid'] : 99999999;
    $extrainfo = $args['extrainfo'];
    unset($args);

    pnModAPIFunc('MediaAttach', 'user', 'add_stylesheet_header');

    $definition = pnModAPIFunc('MediaAttach', 'definitions', 'getmoduledefinition', array('modname' => $modname));

    // remove external videos from allowed file types
    $activateExternalVideos = false;
    $numFormats = count($definition['formats']);
    for($i = 0; $i < $numFormats; $i++) {
        if ($definition['formats'][$i]['extension'] == 'extvid') {
            $activateExternalVideos = 1;
            unset($definition['formats'][$i]);
            break;
        }
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('authid',     SecurityUtil::generateAuthKey('MediaAttach'));
    $render->assign('modname',    DataUtil::formatForDisplay($modname));
    $render->assign('objectid',   DataUtil::formatForDisplay($objectid));
    $render->assign('definition', $definition);

    $render->assign('allowadd',   SecurityUtil::checkPermission('MediaAttach::', "$modname:$objectid: ", ACCESS_COMMENT));

    $redirectURL = pnGetCurrentURL();
    if (is_array($extrainfo)) {
        $redirectURL = $extrainfo['returnurl'];

    } elseif (!empty($extrainfo)) {
        $redirectURL = $extrainfo;
    }
    $render->assign('redirect',   base64_encode($redirectURL));

    if (pnModGetVar('MediaAttach', 'usequota') == 1) {
        $render->assign('usequota', 1);
        $isLogged = pnUserLoggedIn();
        $render->assign('allowedquota', $isLogged ? pnModAPIFunc('MediaAttach', 'quota', 'getallowedquota', array('uid' => pnUserGetVar('uid'))) : 0);
        $render->assign('usedquota', $isLogged ? pnModAPIFunc('MediaAttach', 'quota', 'getusedquota', array('uid' => pnUserGetVar('uid'))) : 0);
    } else {
        $render->assign('usequota', 0);
    }

    $numArr = array();
    for ($i = 1; $i <= $definition['numfiles']; $i++) {
        $numArr[] = $i;
    }
    $render->assign('numArr', $numArr);

    $render->assign('categories', pnModAPIFunc('MediaAttach', 'cat', 'getCategoryTree'));
    $render->assign('activateExternalVideos', $activateExternalVideos);
    if ($activateExternalVideos) {
        $render->assign('supportedProviders', pnModAPIFunc('MediaAttach', 'extvideo', 'getproviders'));
    }

    return $render->fetch(_maIntChooseTemplate($render, 'user', 'uploadform', $modname));
}
