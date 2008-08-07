<?php
/**
 * MediaAttach
 *
 * @version      $Id: newestfiles.php 220 2007-08-11 15:23:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * initialise block
 *
 */
function MediaAttach_newestfilesblock_init()
{
    pnSecAddSchema('MediaAttach:Newestfilesblock:', 'Block title::');
}

/**
 * get information on block
 *
 * @return       array       The block information
 */
function MediaAttach_newestfilesblock_info()
{
    return array('module'         => 'MediaAttach',
                 'text_type'      => 'Newestfiles',
                 'text_type_long' => 'Show newest MediaAttach files',
                 'allow_multiple' => true,
                 'form_content'   => false,
                 'form_refresh'   => false,
                 'show_preview'   => false,
                 'admin_tableless' => true);
}

/**
 * display block
 *
 * @param        blockinfo   array a blockinfo structure
 * @return       output      the rendered bock
 */
function MediaAttach_newestfilesblock_display($blockinfo)
{
    if (!SecurityUtil::checkPermission('MediaAttach:Newestfilesblock:', "$blockinfo[title]::", ACCESS_READ)) {
        return false;
    }

    if (!pnModAvailable('MediaAttach')) {
        return false;
    }

    $vars = pnBlockVarsFromContent($blockinfo['content']);

    if (empty($vars['numitems'])) {
        $vars['numitems'] = 5;
    }

    $formatFilter = '';
    if (!empty($vars['formats'])) {
        $formatFilter = explode(':', $vars['formats']);
    }


    $uploads = pnModAPIFunc('MediaAttach', 'user', 'getalluploads', array('startnum'     => 1,
                                                                      'numitems'     => $vars['numitems'],
                                                                      'sortby'       => 'date',
                                                                      'sortdir'      => 'desc',
                                                                      'formatFilter' => $formatFilter));
    if (!$uploads) {
        return false;
    }

    $countFiles = pnModAPIFunc('MediaAttach', 'user', 'countuploads', array('formatFilter' => $formatFilter));
    if ($countFiles <= $vars['numitems']) {
        $vars['numitems'] = $countFiles;
    }

    $numUploads = count($uploads);
    $currentUser = pnUserGetVar('uid');
    $ownHandling = pnModGetVar('MediaAttach', 'ownhandling');
    for ($i = 0; $i < $numUploads; $i++) {
        $uploads[$i] = _maIntPrepFileForTemplate($uploads[$i], $currentUser, $ownHandling);
    }

    $shown_results = 0;
    $newestfiles = array();
    foreach ($uploads as $file) {
        if (SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$file[fileid]", ACCESS_OVERVIEW)) {
            $shown_results++;
            if ($shown_results <= $vars['numitems']) {
                   if (SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$file[fileid]", ACCESS_READ)) {
                       $newestfiles[] = array('url'       => pnModURL('MediaAttach', 'user', 'displayfile', array('fileid' => $file['fileid'])),
                                              'title'     => $file['title'],
                                              'filesize'  => $file['filesize'],
                                              'extension' => $file['extension'],
                                              'format'    => $file['format']);
                   }
                   else {
                       $newestfiles[] = array('title'     => $file['title'],
                                              'filesize'  => $file['filesize'],
                                              'extension' => $file['extension'],
                                              'format'    => $file['format']);
                   }
            }
        }
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('files', $newestfiles);

    $blockinfo['content'] = $render->fetch('MediaAttach_block_newestfiles.htm');
    return pnBlockThemeBlock($blockinfo);
}


/**
 * modify block settings
 *
 * @param        blockinfo   array a blockinfo structure
 * @return       output      the bock form
 */
function MediaAttach_newestfilesblock_modify($blockinfo)
{
    $vars = pnBlockVarsFromContent($blockinfo['content']);

    if (empty($vars['numitems'])) {
        $vars['numitems'] = 5;
    }

    if (!empty($vars['formats'])) {
        $vars['formats'] = explode(':', $vars['formats']);
    }


    if (!($allformats = pnModAPIFunc('MediaAttach', 'filetypes', 'getallformats'))) {
        return false;
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('numitems', $vars['numitems']);
    $render->assign('formats', $vars['formats']);
    $render->assign('allformats', $allformats);
    return $render->fetch('MediaAttach_block_newestfiles_modify.htm');
}


/**
 * update block settings
 *
 * @param        blockinfo   array a blockinfo structure
 * @return       $blockinfo  the modified blockinfo structure
 */
function MediaAttach_newestfilesblock_update($blockinfo)
{
    $vars = pnBlockVarsFromContent($blockinfo['content']);
    $vars['numitems'] = (int) FormUtil::getPassedValue('numitems', 5, 'POST');
    $vars['formats'] = FormUtil::getPassedValue('formats', array(), 'POST');
    $vars['formats'] = implode(':', $vars['formats']);

    $blockinfo['content'] = pnBlockVarsToContent($vars);

    $render = pnRender::getInstance('MediaAttach', false);
    $render->clear_cache('MediaAttach_block_newestfiles.htm');
    return $blockinfo;
}
