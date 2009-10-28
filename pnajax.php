<?php
/**
 * MediaAttach
 *
 * @version      $Id: pnajax.php 96 2008-03-09 10:49:43Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');
Loader::requireOnce('modules/MediaAttach/common_imgthumb.php');

/**
 * perform upload
 * performs an upload process in the background
 */
function MediaAttach_ajax_performupload()
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $result = array();
    if (!isset($_POST['MediaAttach_modname'])) {
        //upload is still running
        $result['message'] = '...';
        AjaxUtil::output($result, true); //2nd param = send authid
    }

    if ($_POST['MediaAttach_modname'] == 'MediaAttach') {
        $MediaAttach_modname = 'MediaAttach';
        $MediaAttach_objectid = 99999999;
        $MediaAttach_redirect = base64_encode(pnModURL('MediaAttach', 'admin', 'view'));
    } else {
        $MediaAttach_modname  = FormUtil::getPassedValue('MediaAttach_modname',  null, 'POST');
        $MediaAttach_objectid = FormUtil::getPassedValue('MediaAttach_objectid', null, 'POST');
        $MediaAttach_redirect = FormUtil::getPassedValue('MediaAttach_redirect', null, 'POST');
    }

    if (!SecurityUtil::checkPermission('MediaAttach::', "$MediaAttach_modname:: ", ACCESS_COMMENT)) {
        AjaxUtil::error(__('Sorry! No authorization to access this module.', $dom));
    }

    $MediaAttach_redirect = str_replace('&amp;', '&', base64_decode($MediaAttach_redirect)) . '#files';

    if (!SecurityUtil::confirmAuthKey()) {
        AjaxUtil::error(__("Invalid 'authkey':  this probably means that you pressed the 'Back' button, or that the page 'authkey' expired. Please refresh the page and try again.", $dom));
    }

    $definition = pnModAPIFunc('MediaAttach', 'definitions', 'getmoduledefinition', array('modname' => $MediaAttach_modname));

    $jsfield_files  = FormUtil::getPassedValue('MediaAttach_uploadfiles',  null, 'FILES');
    $jsfield_titles = FormUtil::getPassedValue('MediaAttach_titles',       null, 'POST');
    $jsfield_descs  = FormUtil::getPassedValue('MediaAttach_descriptions', null, 'POST');
    $jsfield_cats   = FormUtil::getPassedValue('MediaAttach_categories',   array(), 'POST');
    if (!is_array($jsfield_files) || !is_array($jsfield_titles) || !is_array($jsfield_descs) || !is_array($jsfield_cats)) {
        AjaxUtil::error(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $numfiles = count($jsfield_files['name']);
    if (($numfiles != count($jsfield_titles)) || ($numfiles != count($jsfield_descs))) {
        AjaxUtil::error(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    if ($numfiles > $definition['numfiles']) {
        $numfiles = $definition['numfiles'];
    }
    $numfiles--;

    $upload = array();
    $result['messages'] = array();
    $result['listentries'] = array();
    Loader::requireOnce('modules/MediaAttach/pnuser/createupload.php');
    for ($i = 0; $i <= $numfiles; $i++) {
        $title = $jsfield_titles[$i];
        $desc = $jsfield_descs[$i];

        $cats = array();
        if ($jsfield_cats[$i]) {
            $rawCats = explode(',', $jsfield_cats[$i]);
            foreach($rawCats as $rawCat) {
                $catParts = explode(':', $rawCat);
                $cats[$catParts[0]] = $catParts[1];
            }
        }

        $upload['name'] = $jsfield_files['name'][$i];
        $upload['type'] = $jsfield_files['type'][$i];
        $upload['tmp_name'] = $jsfield_files['tmp_name'][$i];
        $upload['error'] = $jsfield_files['error'][$i];
        $upload['size'] = $jsfield_files['size'][$i];

        $result['messages'][$i] = MediaAttach_user_performsingleupload($i+1, $upload, $title, $desc, $cats, $MediaAttach_modname, $MediaAttach_objectid, $MediaAttach_redirect, $definition);
        $result['messages'][$i] = strip_tags($result['messages'][$i]);

        //retrieve entry in used filelist/inlinelist
        $render = pnRender::getInstance('MediaAttach', false);
        $render->assign('definition', $definition);
        $render->assign('currentuser', pnUserGetVar('uid'));
        $newfile = pnModAPIFunc('MediaAttach', 'user', 'getlastuploadbymodnameandobjectid', array('modname' => $MediaAttach_modname, 'objectid' => $MediaAttach_objectid));
        $render->assign('file', $newfile);

        if ($_POST['MediaAttach_modname'] == 'MediaAttach') {
            $templateset = ($definition['downloadmode'] == 1) ? 'inline' : 'filelist';
            $result['listentries'][$i] = base64_encode($render->fetch('MediaAttach_admin_upload_' . $templateset . '_single.htm'));
        } else {
            $templateset = ($definition['downloadmode'] == 1) ? 'inlinelist' : 'filelist';
            $result['listentries'][$i] = base64_encode($render->fetch(_maIntChooseTemplate($render, 'user', $templateset . '_single', $MediaAttach_modname)));
        }
    }

    $result['message'] = 'Done';

    AjaxUtil::output($result, true, true);
}

/*
 * retrieve item list for selection in pnForm and in the content plugin
 */
function MediaAttach_ajax_getfilelist($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $sortby       =       FormUtil::getPassedValue('sortby',       'date');
    $sortdir      =       FormUtil::getPassedValue('sortdir',  ($sortby == 'date') ? 'desc' : 'asc');
    $searchfor    =       FormUtil::getPassedValue('searchfor',   '');
    $definitionid = (int) FormUtil::getPassedValue('did', 0, 'POST');

    $definitions = pnModAPIFunc('MediaAttach', 'definitions', 'getalldefinitions');
    if (!$definitions) {
        return false;
    }

    $thumbnr  = (int) FormUtil::getPassedValue('thumbnr',  0, 'POST');
    if ($thumbnr == 0) {
        $thumbnr = pnModGetVar('MediaAttach', 'defaultthumb');
    }

    $fetchArgs = array('sortby'       => $sortby,
                       'sortdir'      => $sortdir,
                       'searchfor'    => $searchfor);

    if ($definitionid != 0) {
        $modname = '';
        foreach($definitions as $currentDef) {
            if ($currentDef['did'] == $definitionid) {
                $modname = $currentDef['modname'];
                break;
            }
        }

        if (empty($modname)) {
            return false;
        } else if (!SecurityUtil::checkPermission('MediaAttach::', $modname.'::', ACCESS_READ)) {
            AjaxUtil::error(__('Sorry! No authorization to access this module.', $dom));
        }

        $fetchArgs['moduleFilter'] = $modname;

    } else if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_COMMENT)) {
        AjaxUtil::error(__('Sorry! No authorization to access this module.', $dom));
    }

    $cat_prop = FormUtil::getPassedValue('catprop', 'Main');
    $cat_id   = (int) FormUtil::getPassedValue('catid', 0);
    if ($cat_prop != '' && $cat_id != 0) {
        $fetchArgs['catFilter'] = array($cat_prop => $cat_id);
        $fetchArgs['catFilter']['__META__'] = array('module' => 'MediaAttach');
    }

    $files = pnModAPIFunc('MediaAttach', 'user', 'getalluploads', $fetchArgs);
    if ($files === false) {
        AjaxUtil::error(__('Error! Could not load items.', $dom));
    }

    $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');
    $imageFormats = array('gif', 'jpg', 'jpeg', 'png');

    $slimFiles = array();
    foreach ($files as $file) {
        $render = pnRender::getInstance('MediaAttach', false);
        $render->assign('file', $file);
        $render->assign('thumbnr', $thumbnr);

        $previewInfo = base64_encode($render->fetch(_maIntChooseTemplate($render, 'external', 'fileinfo', 'MediaAttach')));

        $slimFiles[] = array('fileid'       => $file['fileid'],
                             'title'        => str_replace('&amp;', '&', $file['title']),
                             'extension'    => $file['extension'],
                             'previewInfo'  => $previewInfo);
    }

    return array('files' => $slimFiles);
}
