<?php
/**
 * MediaAttach
 *
 * @version      $Id: inline.php 220 2007-08-11 15:23:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * initialise block
 *
 */
function MediaAttach_inlineblock_init()
{
    pnSecAddSchema('MediaAttach:Inlineblock:', 'Block title::');
}

/**
 * get information on block
 *
 * @return       array       The block information
 */
function MediaAttach_inlineblock_info()
{
    return array('module'         => 'MediaAttach',
                 'text_type'      => 'Inline',
                 'text_type_long' => 'Inline display of files',
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
function MediaAttach_inlineblock_display($blockinfo)
{
    if (!SecurityUtil::checkPermission('MediaAttach:Inlineblock:', "$blockinfo[title]::", ACCESS_READ)) {
        return false;
    }

    if (!pnModAvailable('MediaAttach')) {
        return false;
    }

    $vars = pnBlockVarsFromContent($blockinfo['content']);

    if (empty($vars['numitems'])) {
        $vars['numitems'] = 5;
    }

    if (empty($vars['displaytype'])) {
        $vars['displaytype'] = 0;
    }

    $formatFilter = '';
    if (!empty($vars['formats'])) {
        $formatFilter = explode(':', $vars['formats']);
    }

    if ($vars['displaytype'] == 0) {
        $uploads = pnModAPIFunc('MediaAttach', 'user', 'getalluploads', array('startnum'     => 1,
                                                                          'numitems'     => $vars['numitems'],
                                                                          'sortby'       => 'date',
                                                                          'sortdir'      => 'desc',
                                                                          'formatFilter' => $formatFilter));
    }
    elseif ($vars['displaytype'] == 1) {
        $uploads = pnModAPIFunc('MediaAttach', 'user', 'getalluploads', array('startnum'     => 1,
                                                                          'numitems'     => $vars['numitems'],
                                                                          'sortby'       => 'RAND()',
                                                                          'formatFilter' => $formatFilter));
    }

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
    $files = array();
    foreach ($uploads as $file) {
        if (SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$file[fileid]", ACCESS_OVERVIEW)) {
            $shown_results++;
            if ($shown_results <= $vars['numitems']) {
                if (SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$file[fileid]", ACCESS_READ)) {
                    $file['url'] = pnModURL('MediaAttach', 'user', 'displayfile', array('fileid' => $file['fileid']));
                }
                else {
                    $file['url'] = '';
                }
                array_push($files, $file);
            }
        }
    }

    $render = & pnRender::getInstance('MediaAttach', false);
    $render->assign('files', $files);

    $blockinfo['content'] = $render->fetch('MediaAttach_block_inline.htm');
    return pnBlockThemeBlock($blockinfo);
}


/**
 * modify block settings
 *
 * @param        blockinfo   array a blockinfo structure
 * @return       output      the bock form
 */
function MediaAttach_inlineblock_modify($blockinfo)
{
    $vars = pnBlockVarsFromContent($blockinfo['content']);

    if (empty($vars['numitems'])) {
        $vars['numitems'] = 5;
    }

    if (empty($vars['displaytype'])) {
        $vars['displaytype'] = 0;
    }

    if (!empty($vars['formats'])) {
        $vars['formats'] = explode(':', $vars['formats']);
    }


    if (!($allformats = pnModAPIFunc('MediaAttach', 'filetypes', 'getallformats'))) {
        return false;
    }

    $render = & pnRender::getInstance('MediaAttach', false);
    $render->assign('numitems', $vars['numitems']);
    $render->assign('displaytype', $vars['displaytype']);
    $render->assign('formats', $vars['formats']);
    $render->assign('allformats', $allformats);
    return $render->fetch('MediaAttach_block_inline_modify.htm');
}


/**
 * update block settings
 *
 * @param        blockinfo   array a blockinfo structure
 * @return       $blockinfo  the modified blockinfo structure
 */
function MediaAttach_inlineblock_update($blockinfo)
{
    $vars = pnBlockVarsFromContent($blockinfo['content']);
    $vars['numitems'] = (int) FormUtil::getPassedValue('numitems', 5, 'POST');
    $vars['displaytype'] = FormUtil::getPassedValue('displaytype', 0, 'POST');
    $vars['formats'] = FormUtil::getPassedValue('formats', array(), 'POST');
    $vars['formats'] = implode(':', $vars['formats']);

    $blockinfo['content'] = pnBlockVarsToContent($vars);

    $render = & pnRender::getInstance('MediaAttach', false);
    $render->clear_cache('MediaAttach_block_inline.htm');
    return $blockinfo;
}
