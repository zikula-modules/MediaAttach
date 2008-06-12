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


/*
 * ---------------------------------------------------------------------------------------------------------
 * File information logic
 * ---------------------------------------------------------------------------------------------------------
 */


/**
 * display file information for an upload
 *
 * @param    int     fileid        upload id to display information for
 * @return   output                the data
 */
function MediaAttach_fileinfo_showfileinfo($args)
{
    $fileid = (int) FormUtil::getPassedValue('fileid', (isset($args['fileid'])) ? $args['fileid'] : null, 'GET');
    unset($args);

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    if (!SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$fileid", ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('file', $file);

    return $render->fetch('MediaAttach_file_information.htm');
}
