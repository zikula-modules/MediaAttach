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
 * update a definition
 *
 * @param    int       $args['did']             the ID of the definition
 * @param    array     $args['groups']          file group of the definition
 * @param    int       $args['displayfiles']    display files 0/1
 * @param    int       $args['sendmails']       send mails 0/1
 * @param    string    $args['recipient']       mail address
 * @param    int       $args['maxsize']         maximum file size in bytes
 * @param    int       $args['downloadmode']    0/1 physical/inline
 * @param    int       $args['naming']          0/1/2
 * @param    string    $args['namingprefix']    prefix
 * @param    int       $args['numfiles']        number of files during an upload
 * @return   bool                               true on success, false on failure
 */
function MediaAttach_definitionsapi_updatedefinition($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!isset($args['did']) || !is_numeric($args['did']) || !isset($args['groups'])
         || !isset($args['displayfiles']) || !is_numeric($args['displayfiles'])
         || !isset($args['sendmails']) || !is_numeric($args['sendmails'])
         || !isset($args['recipient']) || !isset($args['maxsize'])
         || !isset($args['downloadmode']) || !is_numeric($args['downloadmode'])
         || !isset($args['naming']) || !is_numeric($args['naming'])
         || !isset($args['namingprefix'])
         || !isset($args['numfiles']) || !is_numeric($args['numfiles'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $did = $args['did'];
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

    if (!($definition = pnModAPIFunc('MediaAttach', 'definitions', 'getdefinition', array('did' => $did)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    $definition['displayfiles'] = $displayfiles;
    $definition['sendmails'] = $sendmails;
    $definition['recipient'] = $recipient;
    $definition['maxsize'] = $maxsize;
    $definition['downloadmode'] = $downloadmode;
    $definition['naming'] = $naming;
    $definition['namingprefix'] = $namingprefix;
    $definition['numfiles'] = $numfiles;

    $result = DBUtil::updateObject($definition, 'ma_defs', '', 'did');

    if (!$result) {
        return LogUtil::registerError(_UPDATEFAILED);
    }

    if (!pnModAPIFunc('MediaAttach', 'filetypes', 'deletedefgroups', array('did' => $did))) {
        return LogUtil::registerError(_UPDATEFAILED);
    }
    foreach ($groups as $currentgroup) {
        if (!pnModAPIFunc('MediaAttach', 'filetypes', 'createdefgroup',
                                            array('did' => $did, 'gid' => $currentgroup))) {
            return LogUtil::registerError(_UPDATEFAILED);
        }
    }

    $render = pnRender::getInstance('MediaAttach');
    $render->clear_cache(null, $did);

    return true;
}
