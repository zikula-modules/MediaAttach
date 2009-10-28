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
 * delete file type
 *
 * @param     fid            int     the id of the file format to be deleted
 * @param     objectid       int     generic object id mapped onto fid if present
 * @param     confirmation   bool    confirmation that this file type can be deleted
 */
function MediaAttach_admin_deleteformat($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $fid          = (int)  FormUtil::getPassedValue('fid',          isset($args['fid'])          ? $args['fid']          : null, 'POST');
    $objectid     = (int)  FormUtil::getPassedValue('objectid',     isset($args['objectid'])     ? $args['objectid']     : null, 'POST');
    $confirmation = (bool) FormUtil::getPassedValue('confirmation', isset($args['confirmation']) ? $args['confirmation'] : null, 'POST');
    unset($args);

    if (!empty($objectid)) {
        $fid = $objectid;
    }

    if (!($format = pnModAPIFunc('MediaAttach', 'filetypes', 'getformat', array('fid' => $fid)))) {
        return LogUtil::registerError(__('Error! Could not load items.', $dom));
    }

    if (empty($confirmation)) {
        $render = pnRender::getInstance('MediaAttach', false);
        $render->assign('authid', SecurityUtil::generateAuthKey('MediaAttach'));
        $render->assign('format', $format);
        return $render->fetch('MediaAttach_admin_format_delete.htm');
    }

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(__("Invalid 'authkey':  this probably means that you pressed the 'Back' button, or that the page 'authkey' expired. Please refresh the page and try again.", $dom));
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewformats'));
    }

    if (pnModAPIFunc('MediaAttach', 'filetypes', 'deleteformat', array('fid' => $fid))) {
        LogUtil::registerStatus(__('Done! Item deleted.', $dom));
    }

    return pnRedirect(pnModURL('MediaAttach', 'admin', 'viewformats'));
}

