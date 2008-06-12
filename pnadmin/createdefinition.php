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
 * Create a definition
 *
 * @param    string   modname             module name of the definition
 * @param    array    groups              file groups of the definition
 * @param    int      displayfiles        display files 0/1/2
 * @param    int      sendmails           send mails 0/1
 * @param    string   recipient           mail address
 * @param    int      maxsize             maximum file size
 * @param    int      downloadmode        0/1 physical/inline
 * @param    int      naming              0/1/2
 * @param    string   namingprefix        counter prefix
 * @param    int      numfiles            number of files during an upload
 */
function MediaAttach_admin_createdefinition($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $modname       =       FormUtil::getPassedValue('modname',       isset($args['modname'])       ? $args['modname']       : null, 'POST');
    $groups        =       FormUtil::getPassedValue('groups',        isset($args['groups'])        ? $args['groups']        : null, 'POST');
    $displayfiles  = (int) FormUtil::getPassedValue('displayfiles',  isset($args['displayfiles'])  ? $args['displayfiles']  : null, 'POST');
    $sendmails     = (int) FormUtil::getPassedValue('sendmails',     isset($args['sendmails'])     ? $args['sendmails']     : null, 'POST');
    $recipient     =       FormUtil::getPassedValue('recipient',     isset($args['recipient'])     ? $args['recipient']     : null, 'POST');
    $maxsize       = (int) FormUtil::getPassedValue('maxsize',       isset($args['maxsize'])       ? $args['maxsize']       : null, 'POST');
    $downloadmode  = (int) FormUtil::getPassedValue('downloadmode',  isset($args['downloadmode'])  ? $args['downloadmode']  : null, 'POST');
    $naming        = (int) FormUtil::getPassedValue('naming',        isset($args['naming'])        ? $args['naming']        : null, 'POST');
    $namingprefix  =       FormUtil::getPassedValue('namingprefix',  isset($args['namingprefix'])  ? $args['namingprefix']  : null, 'POST');
    $numfiles      = (int) FormUtil::getPassedValue('numfiles',      isset($args['numfiles'])      ? $args['numfiles']      : null, 'POST');
    unset($args);

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewdefinitions'));
    }

    //get bytes from KBytes
    $maxsize *= 1024;

    $did = pnModAPIFunc('MediaAttach', 'definitions', 'createdefinition',
                        array('modname'       => $modname,
                              'groups'        => $groups,
                              'displayfiles'  => $displayfiles,
                              'sendmails'     => $sendmails,
                              'recipient'     => $recipient,
                              'maxsize'       => $maxsize,
                              'downloadmode'  => $downloadmode,
                              'naming'        => $naming,
                              'namingprefix'  => $namingprefix,
                              'numfiles'      => $numfiles));

    if ($did) {
        LogUtil::registerStatus(_CREATESUCCEDED);
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewdefinitions'));
}

