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


/**
 * create a new definition
 *
 * @param    string    $args['modname']         module name of the definition
 * @param    array     $args['groups']          file group of the definition
 * @param    int       $args['displayfiles']    display files 0/1
 * @param    int       $args['sendmails']       send mails 0/1
 * @param    string    $args['recipient']       mail address
 * @param    int       $args['maxsize']         maximum file size in bytes
 * @param    int       $args['downloadmode']    0/1 physical/inline
 * @param    int       $args['naming']          0/1/2
 * @param    string    $args['namingprefix']    prefix
 * @param    int       $args['numfiles']        number of files during an upload
 * @return   int                                File type ID on success, false on failure
 */
function MediaAttach_definitionsapi_createdefinition($args)
{
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
        return LogUtil::registerError(_MODARGSERROR);
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
        return LogUtil::registerError(_CREATEFAILED);
    }


    foreach ($groups as $currentgroup) {
        if (!pnModAPIFunc('MediaAttach', 'filetypes', 'createdefgroup',
                            array('did' => $def['did'], 'gid' => $currentgroup))) {
            return LogUtil::registerError(_CREATEFAILED);
        }
    }

    return $def['did'];
}

