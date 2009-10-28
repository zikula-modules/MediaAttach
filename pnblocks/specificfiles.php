<?php
/**
 * MediaAttach
 *
 * @version      $Id: specificfiles.php 217 2007-08-09 20:28:42Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * initialise block
 *
 */
function MediaAttach_specificfilesblock_init()
{
    pnSecAddSchema('MediaAttach:Specificfilesblock:', 'Block title::');
}

/**
 * get information on block
 *
 * @return       array       The block information
 */
function MediaAttach_specificfilesblock_info()
{
    return array('module'         => 'MediaAttach',
                 'text_type'      => 'Specificfiles',
                 'text_type_long' => 'Show specific MediaAttach files',
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
function MediaAttach_specificfilesblock_display($blockinfo)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!SecurityUtil::checkPermission('MediaAttach:Specificfilesblock:', "$blockinfo[title]::", ACCESS_READ)) {
        return false;
    }

    if (!pnModAvailable('MediaAttach')) {
        return false;
    }

    $vars = pnBlockVarsFromContent($blockinfo['content']);

    $fileFilter = '';
    if (!empty($vars['files'])) {
        $fileFilter = explode(':', $vars['files']);
    }


    list($files, $total_hits) = pnModAPIFunc('MediaAttach', 'user', 'getalluploads',
                      array('startnum'     => 1,
                            'sortby'       => 'title',
                            'sortdir'      => 'asc',
                            'fileFilter'   => $fileFilter));

    if (!$files) {
        return false;
    }

    $numFiles = count($files);
    for ($i = 0; $i < $numFiles; $i++) {
        if ($files[$i]['title'] == '') {
            $files[$i]['title'] = __('No title', $dom);
        }
        list($files[$i]['title'], $files[$i]['desc']) = pnModCallHooks('item', 'transform', 'x', array($files[$i]['title'], $files[$i]['desc']));
    }

    $shown_results = 0;
    $specificfiles = array();
    foreach ($files as $file) {
        if (SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$file[fileid]", ACCESS_OVERVIEW)) {
            if (SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$file[fileid]", ACCESS_READ)) {
                $specificfiles[] = array('url'       => pnModURL('MediaAttach', 'user', 'displayfile', array('fileid' => $file['fileid'])),
                                         'title'     => $file['title'],
                                         'filesize'  => $file['filesize'],
                                         'extension' => $file['extension'],
                                         'format'    => $file['format']);
            }
            else {
                $specificfiles[] = array('title'     => $file['title'],
                                         'filesize'  => $file['filesize'],
                                         'extension' => $file['extension'],
                                         'format'    => $file['format']);
            }
        }
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('files', $specificfiles);

    $blockinfo['content'] = $render->fetch('MediaAttach_block_specificfiles.htm');
    return pnBlockThemeBlock($blockinfo);
}


/**
 * modify block settings
 *
 * @param        blockinfo   array a blockinfo structure
 * @return       output      the bock form
 */
function MediaAttach_specificfilesblock_modify($blockinfo)
{
    $vars = pnBlockVarsFromContent($blockinfo['content']);

    if (!empty($vars['files'])) {
        $vars['files'] = explode(':', $vars['files']);
    }


    list($allfiles, $total_hits) = pnModAPIFunc('MediaAttach', 'user', 'getalluploads',
                                      array('startnum'     => 1,
                                            'numitems'     => null,
                                            'sortby'       => 'title',
                                            'sortdir'      => 'asc',
                                            'filefilter'   => '',
                                            'formatfilter' => ''));

    if (!$allfiles) {
        return false;
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('files', $vars['files']);
    $render->assign('allfiles', $allfiles);
    return $render->fetch('MediaAttach_block_specificfiles_modify.htm');
}


/**
 * update block settings
 *
 * @param        blockinfo   array a blockinfo structure
 * @return       $blockinfo  the modified blockinfo structure
 */
function MediaAttach_specificfilesblock_update($blockinfo)
{
    $vars = pnBlockVarsFromContent($blockinfo['content']);
    $vars['files'] = FormUtil::getPassedValue('files', array(), 'POST');
    $vars['files'] = implode(':', $vars['files']);

    $blockinfo['content'] = pnBlockVarsToContent($vars);

    $render = pnRender::getInstance('MediaAttach', false);
    $render->clear_cache('MediaAttach_block_specificfiles.htm');
    return $blockinfo;
}
