<?php
/**
 * MediaAttach
 *
 * @version      $Id: common.php 110 2008-04-19 9:17:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/* categorization modes */
define('MEDIAATTACH_CATMODE_NONE',       0);
define('MEDIAATTACH_CATMODE_CATEGORIES', 1);
define('MEDIAATTACH_CATMODE_MODULES',    2);
define('MEDIAATTACH_CATMODE_USERS',      4);

/**
 * utility function for getting file names
 *
 * @return   array  file name depending on naming and full file path
 */
function _maIntGetFilenameForDefinition($filename, $extension, $naming, $namingprefix)
{
    $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');
    $backupFilename = $filename;

    $iterIndex = -1;
    do {
        if ($naming == 0) {
            // original file name
            $filenameCharCount = strlen($filename);
            for ($y = 0; $y < $filenameCharCount; $y++){
                if(!ereg("([0-9A-Za-z_\.])", $filename[$y]))
                    $filename[$y] = '_';
            }
            // append incremented number
            if ($iterIndex > 0) {
                // strip off extension
                $filename = str_replace('.' . $extension, '', $backupFilename);
                // add iterated number
                $filename .= (string) ++$iterIndex;
                // readd extension
                $filename .= '.' . $extension;
            }
            else $iterIndex++;

        } else if ($naming == 1) {
            // md5 name
            $filename = md5(uniqid(mt_rand(),TRUE)) . '.' . $extension;

        } else if ($naming == 2) {
            // prefix with random number
            $filename = $namingprefix . mt_rand(1, 999999) . '.' . $extension;
        }

        if (substr($filename, 0, 1) == '/' || substr($filename, 0, 1) == '\\') {
            $filename = substr($filename, 1, strlen($filename)-1);
        }
    }
    while (file_exists($uploaddir . '/' . $filename)); // repeat until we have a new name

    // return file name as well as it's path
    return array($filename, $uploaddir . '/' . $filename);
}


/**
 * display a given file size in a readable format
 *
 * @param        string      size         file size in bytes
 * @param        boolean     nodesc       if set to true the description will not be appended
 * @param        boolean     onlydesc     if set to true only the description will be returned
 * @return       string      file size in a readable form
 */
function _maIntCalcReadableFilesize($size, $nodesc = false, $onlydesc = false)
{
    $sizeDesc = _MEDIAATTACH_BYTES;              // we have bytes as default
    if ($size >= 1024) {
        $size /= 1024;
        $sizeDesc = _MEDIAATTACH_KB;             // kilobytes
    }
    if ($size >= 1024) {
        $size /= 1024;
        $sizeDesc = _MEDIAATTACH_MB;             // megabytes
    }
    if ($size >= 1024) {
        $size /= 1024;
        $sizeDesc = _MEDIAATTACH_GB;             // gigabytes
    }
    $sizeDesc = '&nbsp;' . $sizeDesc;

    // format number
    $dec_point = ',';
    $thousands_separator = '.';
    if ($size - number_format($size, 0) >= 0.005) {
        $size = number_format($size, 2, $dec_point, $thousands_separator);
    } else {
        $size = number_format($size, 0, '', $thousands_separator);
    }

    // append size descriptor if desired
    if (!$nodesc) {
        $size .= $sizeDesc;
    }

    // return either only the description or the complete string
    $result = ($onlydesc) ? $sizeDesc : $size;
    return $result;
}

/**
 * perform some checks and modifications on a given file object
 *
 * @param      array    file           input object
 * @param      string   currentuser      current username
 * @param      bool     ownHandling      shall users modify their own files
 * @return     array    modified object
 */
function _maIntPrepFileForTemplate($file, $currentUser, $ownHandling)
{
    // append default title if necessary
    if ($file['title'] == '') {
        $file['title'] = _MEDIAATTACH_NOTITLE;
    }

    // call transform hooks
    list($file['title'], $file['desc']) = pnModCallHooks('item', 'transform', '', array($file['title'], $file['desc']));

    // determine if current user may modify this file in terms of config
    $isOwner = ($ownHandling && ($currentUser == $file['uid']));

    $currentmodname = $file['modname'];
    $currentobjectid = $file['objectid'];
    $currentfileid = $file['fileid'];
    // determine if current user may modify this file in terms in general (config + permissions)
    $file['allowedit'] = ($isOwner || SecurityUtil::checkPermission('MediaAttach::', "$currentmodname:$currentobjectid:$currentfileid", ACCESS_EDIT));
    $file['allowdelete'] = ($isOwner || SecurityUtil::checkPermission('MediaAttach::', "$currentmodname:$currentobjectid:$currentfileid", ACCESS_DELETE));

    // return our modified file instance
    return $file;
}

/**
 * utility function for determine bytes from megabytes
 *
 * @return   int  calculated file size
 */
function _maIntMBToByte($amount) {
    $amount = str_replace('.', '', $amount);
    $amount = str_replace(',', '', $amount);
    $amount = $amount * 1024 * 1024;
    return $amount;
}

/**
 * create appropriate WHERE string
 *
 * @param    string $args['filefilter']     optional filter by file id
 * @param    string $args['formatfilter']   optional filter by file format
 * @param    int    $args['userfilter']     optional filter by given user id
 * @param    string $args['modulefilter']   optional filter by module name
 * @param    string $args['objectidfilter'] optional filter by object id
 * @param    string $args['searchfor']      optional search term string
 * @param    string $args['bool']           optional string 'AND' or 'OR'
 * @param    bool   $args['noexpand']       not used within selectExpanded* (default: false)
 * @return   string                         built string for $where
 */
function _maIntBuildWhereString($args)
{
    $where = '';

    // no further $args checking here --> has been done before

    $pntables = pnDBGetTables();
    $filescolumn = $pntables['ma_files_column'];
    $formatscolumn = $pntables['ma_formats_column'];

    if (isset($args['noexpand']) && $args['noexpand'] == true) {
        $prefix = '';
    } else {
        $prefix = 'tbl.';
    }

    if ($args['fileFilter'] != '') {
        if (!empty($where)) $where .= ' AND ';
        $where .= $prefix . $filescolumn['fileid'] . ' IN (';
        $firstone = 1;
        foreach($args['fileFilter'] as $currentFilter) {
            if ($firstone) $firstone = 0;
            else $where .= ',';
            $where .= "'" . $currentFilter . "'";
        }
        $where .= ')';
    }

    if ($args['formatFilter'] != '') {
        if (!empty($where)) $where .= ' AND ';
        $where .= $prefix . $filescolumn['extension'] . ' IN (';
        $firstone = 1;
        foreach($args['formatFilter'] as $currentFilter) {
            if ($firstone) $firstone = 0;
            else $where .= ',';
            $where .= "'" . $currentFilter . "'";
        }
        $where .= ')';
    }

    if ($args['userFilter'] != '') {
        if (!empty($where)) $where .= ' AND ';
        $where .= $prefix . $filescolumn['uid'] . ' = ' . (int) DataUtil::formatForStore($args['userFilter']);
    }

    if ($args['moduleFilter'] != '') {
        if (!empty($where)) $where .= ' AND ';
        $where .= $prefix . $filescolumn['modname'] . " = '" . DataUtil::formatForStore($args['moduleFilter']) . "'";
    } else {
        $currentType = FormUtil::getPassedValue('type', '', 'GETPOST');
        $currentFunc = FormUtil::getPassedValue('func', '', 'GETPOST');
        $currentMod = pnModGetName();

        if ($currentMod != 'MediaAttach' && $currentMod != 'Profile' && $currentMod != 'content'
            || ($currentMod == 'MediaAttach' && $currentType != 'account' && $currentType != 'ajax' && $currentType != 'external'
            && ($currentFunc != 'view' && $currentFunc != 'main' && $currentFunc != '' && $currentFunc != 'getfilelist'))) {
                if (!empty($where)) $where .= ' AND ';
                $where .= $prefix . $filescolumn['modname'] . " != 'MediaAttach'";
        }
    }

    if ($args['objectidFilter'] != '') {
        if (!empty($where)) $where .= ' AND ';
        $where .= $prefix . $filescolumn['objectid'] . " = '" . DataUtil::formatForStore($args['objectidFilter']) . "'";
    }

    if ($args['searchfor'] != '') {
        $args['searchfor'] = DataUtil::formatForStore(trim($args['searchfor']));

        if (!empty($where)) $where .= ' AND ';
        $flag = false;
        $words = explode(' ', $args['searchfor']);

        $where .= '(';
        foreach ($words as $word) {
            if ($flag) {
                if ($bool != 'AND' && $bool != 'OR') $bool = 'OR';
                $where .= ' ' . $bool . ' ';
            }
            $where .= '(' . $prefix . $filescolumn['title'] . " LIKE '%$word%' OR " . $prefix . $filescolumn['desc'] . " LIKE '%$word%') \n";
            $flag = true;
        }
        $where .= ')';
    }

    return $where;
}

/**
 * utility function to select a template for the current use case
 */
function _maIntChooseTemplate(&$render, $type, $func, $modname) {
    if ($render->template_exists('MediaAttach_' . $type . '_' . $func . '_' . DataUtil::formatForOS($modname) . '.htm')) {
        return 'MediaAttach_' . $type . '_' . $func . '_' . DataUtil::formatForOS($modname) . '.htm';
    } else {
        return 'MediaAttach_' . $type . '_' . $func . '.htm';
    }
}

/**
 * helper method treating outsourced file list handling
 */
function _maIntProcessFileList(&$render, $itemsperpage, $customFilter, $dataSource = 'GET') {
    $itemsperpage = (int) FormUtil::getPassedValue('itemsperpage', $itemsperpage, $dataSource);
    $startnum     = (int) FormUtil::getPassedValue('startnum',     0,        $dataSource);
    $sortby       =       FormUtil::getPassedValue('sortby',       'date',   $dataSource);
    $sortdir      =       FormUtil::getPassedValue('sortdir',      ($sortby == 'date') ? 'desc' : 'asc', $dataSource);
    $preview      = (int) FormUtil::getPassedValue('preview',      0,        $dataSource);
    $onlyimages   = (int) FormUtil::getPassedValue('onlyimages',   0,        $dataSource);
    $searchfor    =       FormUtil::getPassedValue('searchfor',    '',       $dataSource);
    $thumbnr      = (int) FormUtil::getPassedValue('thumbnr',      0,        $dataSource);
    if ($thumbnr == 0) {
        $thumbnr = pnModGetVar('MediaAttach', 'defaultthumb');
    }

    $formatFilter = ($onlyimages == 1) ? array('gif', 'jpg', 'jpeg', 'png') : '';

    $fetchArgs = array('startnum'     => $startnum,
                       'numitems'     => $itemsperpage,
                       'sortby'       => $sortby,
                       'sortdir'      => $sortdir,
                       'formatFilter' => $formatFilter,
                       'searchfor'    => $searchfor);

    if (!empty($customFilter) && is_array($customFilter)) {
        foreach ($customFilter as $filterName => $filterValue) {
            $fetchArgs[$filterName] = $filterValue;
        }
    }

    $files = pnModAPIFunc('MediaAttach', 'user', 'getalluploads', $fetchArgs);

    if ($files === false) {
        return LogUtil::registerError(_GETFAILED);
    }

    $render->assign('sortby',         DataUtil::formatForDisplay($sortby));
    $render->assign('sortdir',        DataUtil::formatForDisplay($sortdir));
    $render->assign('itemsperpage',   $itemsperpage);
    $render->assign('preview',        $preview);
    $render->assign('onlyimages',     $onlyimages);
    $render->assign('thumbnr',        $thumbnr);

    if (empty($files)) {
        $render->assign('filesthere', 0);
    } else {
        $numFiles = count($files);
        $currentUser = pnUserGetVar('uid');
        $ownHandling = pnModGetVar('MediaAttach', 'ownhandling');
        for ($i = 0; $i < $numFiles; $i++) {
            $files[$i] = _maIntPrepFileForTemplate($files[$i], $currentUser, $ownHandling);
        }

        $render->assign('filesthere', 1);
        $render->assign('files', $files);

        $render->assign('pager', array('numitems'     => pnModAPIFunc('MediaAttach', 'user', 'countuploads', $fetchArgs),
                                       'itemsperpage' => $itemsperpage));
    }
    return;
}

/**
 * utility function to get all modules from which files can be imported
 */
function _maGetImportModules() {
    $supportedModules = Array(
        'Downloads',
        'mediashare',
        'PhotoGallery',
        'PNphpBB2',
        'pnUpper'
    );

    $availableModules = Array();
    foreach($supportedModules as $modName) {
        if (pnModAvailable($modName) && !file_exists('pnTemp/convertLog_MediaAttach_import_from_' . DataUtil::formatForOS($modName) . '.txt')) {
            $availableModules[] = $modName;
        }
    }

    return $availableModules;
}
