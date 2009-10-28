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
 * create a new definition
 *
 * @param    modname         string    module name of the definition
 * @param    groups          array     file group of the definition
 * @param    displayfiles    int       display files 0/1
 * @param    sendmails       int       send mails 0/1
 * @param    recipient       string    mail address
 * @param    maxsize         int       maximum file size in bytes
 * @param    downloadmode    int       0/1 physical/inline
 * @param    naming          int       0/1/2
 * @param    namingprefix    string    prefix
 * @param    numfiles        int       number of files during an upload
 * @return   int             definition ID on success, false on failure
 */
function MediaAttach_definitionsapi_createdefinition($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['modname']) || !isset($args['groups'])
         || !isset($args['displayfiles']) || !is_numeric($args['displayfiles'])
         || !isset($args['sendmails']) || !is_numeric($args['sendmails'])
         || !isset($args['recipient']) || !isset($args['maxsize'])
         || !isset($args['downloadmode']) || !is_numeric($args['downloadmode'])
         || !isset($args['naming']) || !is_numeric($args['naming'])
         || !isset($args['namingprefix'])
         || !isset($args['numfiles']) || !is_numeric($args['numfiles'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $modname = $args['modname'];
    $groups = $args['groups'];
    $displayfiles = $args['displayfiles'];
    $sendmails = $args['sendmails'];
    $recipient = $args['recipient'];
    $maxsize = $args['maxsize'];
    $downloadmode = $args['downloadmode'];
    $naming = $args['naming'];
    $namingprefix = $args['namingprefix'];
    $numfiles = $args['numfiles'];
    unset($args);

    $def = array('modname'        => $modname,
                 'displayfiles'   => $displayfiles,
                 'sendmails'      => $sendmails,
                 'recipient'      => $recipient,
                 'maxsize'        => $maxsize,
                 'downloadmode'   => $downloadmode,
                 'naming'         => $naming,
                 'namingprefix'   => $namingprefix,
                 'numfiles'       => $numfiles);

    $result = DBUtil::insertObject($def, 'ma_defs', 'did');

    if (!$result) {
        return LogUtil::registerError(__('Error! Creation attempt failed.', $dom));
    }


    foreach ($groups as $currentgroup) {
        if (!pnModAPIFunc('MediaAttach', 'filetypes', 'createdefgroup',
                            array('did' => $def['did'], 'gid' => $currentgroup))) {
            return LogUtil::registerError(__('Error! Creation attempt failed.', $dom));
        }
    }

    return $def['did'];
}

