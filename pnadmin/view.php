<?php
/**
 * MediaAttach
 *
 * @version      $Id: $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * the main administration function
 *
 * @return       output       The main module admin page.
 */
function MediaAttach_admin_view()
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'uploaddir')))
      || !pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'cachedir')))) {
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'modifyconfig'));
    }

    $modname = 'MediaAttach';
    $objectid = 99999999;

    if (!SecurityUtil::checkPermission('MediaAttach::', "$modname:$objectid: ", ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }

    $render = pnRender::getInstance('MediaAttach', false);
    _maIntProcessFileList($render, 20, array('moduleFilter' => $modname));

    $definition = pnModAPIFunc('MediaAttach', 'definitions', 'getmoduledefinition', array('modname' => $modname));
    $definition['displayfiles'] = 2; // show all files

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

    $preview      = (int) FormUtil::getPassedValue('preview',      0,        'GET');
    $definition['downloadmode'] = $preview;

    $render->assign('authid',     SecurityUtil::generateAuthKey('MediaAttach'));
    $render->assign('modname',    DataUtil::formatForDisplay($modname));
    $render->assign('objectid',   99999999);
    $render->assign('definition', $definition);

    $render->assign('redirect',   base64_encode(pnGetCurrentURL()));

    if (pnModGetVar('MediaAttach', 'usequota') == 1) {
        $render->assign('usequota', 1);
        $isLogged = pnUserLoggedIn();
        $render->assign('allowedquota', $isLogged ? pnModAPIFunc('MediaAttach', 'quota', 'getallowedquota', array('uid' => pnUserGetVar('uid'))) : 0);
        $render->assign('usedquota', $isLogged ? pnModAPIFunc('MediaAttach', 'quota', 'getusedquota', array('uid' => pnUserGetVar('uid'))) : 0);
    }
    else {
        $render->assign('usequota', 0);
    }

    $numArr = array();
    for ($i = 1; $i <= $definition['numfiles']; $i++) {
        $numArr[] = $i;
    }
    $render->assign('numArr', $numArr);

    $render->assign('mainCategory', pnModAPIFunc('MediaAttach', 'cat', 'getMainCat'));
    $render->assign('categories', pnModAPIFunc('MediaAttach', 'cat', 'getCategoryTree'));
    $render->assign('activateExternalVideos', $activateExternalVideos);
    if ($activateExternalVideos) {
        $render->assign('supportedProviders', pnModAPIFunc('MediaAttach', 'extvideo', 'getproviders'));
    }

    $render->assign('importModules', _maGetImportModules());

    return $render->fetch('MediaAttach_admin_view.htm');
}
