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


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * Create a definition
 *
 * @param    modname             string   module name of the definition
 * @param    groups              array    file groups of the definition
 * @param    displayfiles        int      display files 0/1/2
 * @param    sendmails           int      send mails 0/1
 * @param    recipient           string   mail address
 * @param    maxsize             int      maximum file size
 * @param    downloadmode        int      0/1 physical/inline
 * @param    naming              int      0/1/2
 * @param    namingprefix        string   counter prefix
 * @param    numfiles            int      number of files during an upload
 */
function MediaAttach_admin_createdefinition($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
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
        LogUtil::registerError(__("Invalid 'authkey':  this probably means that you pressed the 'Back' button, or that the page 'authkey' expired. Please refresh the page and try again.", $dom));
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
        LogUtil::registerStatus(__('Done! Item created.', $dom));
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewdefinitions'));
}

