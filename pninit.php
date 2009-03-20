<?php
/**
 * MediaAttach
 *
 * @version      $Id: pninit.php 96 2008-03-09 10:49:43Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2007 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * initialise MediaAttach
 *
 * @return       bool       true on success, false otherwise
 */
function MediaAttach_init()
{
    $tableNames = array('formats', 'groups', 'formatgroups', 'defs', 'defgroups', 'files', 'quotas');

    foreach ($tableNames as $currentTableName) {
        if (!DBUtil::createTable('ma_' . $currentTableName)) {
            return false;
        }
    }

    if (!pnModRegisterHook('item', 'display', 'GUI', 'MediaAttach', 'user', 'viewupload')) {
        return LogUtil::registerError(_REGISTERFAILED . ', Nr. 1');
    }
    if (!pnModRegisterHook('item', 'create', 'GUI', 'MediaAttach', 'user', 'createupload')) {
        return LogUtil::registerError(_REGISTERFAILED . ', Nr. 2');
    }
    if (!pnModRegisterHook('item', 'update', 'GUI', 'MediaAttach', 'user', 'createupload')) {
        return LogUtil::registerError(_REGISTERFAILED . ', Nr. 3');
    }
    if (!pnModRegisterHook('item', 'delete', 'API', 'MediaAttach', 'user', 'delete')) {
        return LogUtil::registerError(_REGISTERFAILED . ', Nr. 4');
    }
    if (!pnModRegisterHook('module', 'remove', 'API', 'MediaAttach', 'admin', 'removehook')) {
        return LogUtil::registerError(_REGISTERFAILED . ', Nr. 5');
    }

    pnModSetVar('MediaAttach', 'uploaddir',      '/absolute/path/to/upload/dir');
    pnModSetVar('MediaAttach', 'cachedir',       'relative/path/to/cache/dir');
    pnModSetVar('MediaAttach', 'mailfiles',      '0');
    pnModSetVar('MediaAttach', 'usequota',       '0');
    pnModSetVar('MediaAttach', 'ownhandling',    '0');
    pnModSetVar('MediaAttach', 'usefrontpage',   '0');
    pnModSetVar('MediaAttach', 'useaccountpage', '1');
    pnModSetVar('MediaAttach', 'thumbsizes',     array(array(100, 64), array(150, 113)));
    pnModSetVar('MediaAttach', 'defaultthumb',   '2');
    pnModSetVar('MediaAttach', 'shrinkimages',   '0');
    pnModSetVar('MediaAttach', 'shrinkwidth',    '680');
    pnModSetVar('MediaAttach', 'shrinkheight',   '510');
    pnModSetVar('MediaAttach', 'usethumbcropper', '0');
    pnModSetVar('MediaAttach', 'cropsizemode',    '0');
    pnModSetVar('MediaAttach', 'usedcatmodes',   '7');
    pnModSetVar('MediaAttach', 'defaultcatmode', '2');

    // create the default data for MediaAttach
    MediaAttach_defaultdata();

    // create the category registries for MediaAttach
    if (!MediaAttach_create_categoryregistries()) {
        return LogUtil::registerError(_CATREGCREATEFAILED);
    }

    if (!pnModAPIFunc('Modules', 'admin', 'enablehooks', array('callermodname' => 'MediaAttach',
                                                               'hookmodname' => 'MediaAttach'))) {
        return LogUtil::registerError(_REGISTERSELFFAILED);
    }

    return true;
}

/**
 * upgrade MediaAttach from an old version
 *
 * @author       Axel Guckelsberger
 * @return       bool       true on success, false otherwise
 */
function MediaAttach_upgrade($oldversion)
{
    return true;
}

/**
 * delete MediaAttach
 *
 * @author       Axel Guckelsberger
 * @return       bool       true on success, false otherwise
 */
function MediaAttach_delete()
{
    if (!pnModUnregisterHook('item', 'display', 'GUI', 'MediaAttach', 'user', 'viewupload')) {
        return LogUtil::registerError(_UNREGISTERFAILED . ', Nr. 1');
    }
    if (!pnModUnregisterHook('item', 'create', 'GUI', 'MediaAttach', 'user', 'createupload')) {
        return LogUtil::registerError(_UNREGISTERFAILED . ', Nr. 2');
    }
    if (!pnModUnregisterHook('item', 'update', 'GUI', 'MediaAttach', 'user', 'createupload')) {
        return LogUtil::registerError(_UNREGISTERFAILED . ', Nr. 3');
    }
    if (!pnModUnregisterHook('item', 'delete', 'API', 'MediaAttach', 'user', 'delete')) {
        return LogUtil::registerError(_UNREGISTERFAILED . ', Nr. 4');
    }
    if (!pnModUnregisterHook('module', 'remove', 'API', 'MediaAttach', 'admin', 'removehook')) {
        return LogUtil::registerError(_UNREGISTERFAILED . ', Nr. 5');
    }

    $tableNames = array('formats', 'groups', 'formatgroups', 'defs', 'defgroups', 'files', 'quotas');

    foreach ($tableNames as $currentTableName) {
        if (!DBUtil::dropTable('ma_' . $currentTableName)) {
            return false;
        }
    }

    // remove module vars
    pnModDelVar('MediaAttach');

    // remove the category data of MediaAttach
    if (!MediaAttach_delete_categorydata()) {
        return LogUtil::registerError(_CATREGDELETEFAILED);
    }

    // deletion successful
    return true;
}

/**
 * create the default data for MediaAttach
 *
 * @author       Axel Guckelsberger
 * @return       bool       false
 */
function MediaAttach_defaultdata()
{
    if (!DBUtil::deleteWhere('ma_groups', "1=1")
      || !DBUtil::deleteWhere('ma_formats', "1=1")
      || !DBUtil::deleteWhere('ma_formatgroups', "1=1")) {
        return false;
    }

    // insert default groups
    $groups = Array(
            array('groupname' => 'Images',        'directory' => 'images',         'image' => 'folder.gif'),
            array('groupname' => 'Compression',   'directory' => 'compression',    'image' => 'folder.gif'),
            array('groupname' => 'Plain text',    'directory' => 'plaintext',      'image' => 'folder.gif'),
            array('groupname' => 'Documents',     'directory' => 'documents',      'image' => 'folder.gif'),
            array('groupname' => 'Media',         'directory' => 'media',          'image' => 'folder.gif'),
            array('groupname' => 'Flash',         'directory' => 'flash',          'image' => 'folder.gif'),
            array('groupname' => 'User defined',  'directory' => 'userdefined',    'image' => 'folder.gif'),
            array('groupname' => 'PDF only',      'directory' => 'pdfonly',        'image' => 'folder.gif')
    );

    DBUtil::insertObjectArray($groups, 'ma_groups', 'gid');

    // insert file formats
    $filetypes = Array(
            array('extension' => 'bmp',  'image' => 'image.gif'),
            array('extension' => 'gif',  'image' => 'image.gif'),
            array('extension' => 'jpeg', 'image' => 'image.gif'),
            array('extension' => 'jpg',  'image' => 'image.gif'),
            array('extension' => 'pcx',  'image' => 'image.gif'),
            array('extension' => 'png',  'image' => 'image.gif'),
            array('extension' => 'tga',  'image' => 'image.gif'),
            array('extension' => 'tif',  'image' => 'image.gif'),

            array('extension' => 'ace',  'image' => 'bin.gif'),
            array('extension' => 'cab',  'image' => 'bin.gif'),
            array('extension' => 'iso',  'image' => 'bin.gif'),
            array('extension' => 'jar',  'image' => 'bin.gif'),
            array('extension' => 'lha',  'image' => 'bin.gif'),
            array('extension' => 'lzh',  'image' => 'bin.gif'),
            array('extension' => 'tar',  'image' => 'bin.gif'),
            array('extension' => 'rar',  'image' => 'bin.gif'),
            array('extension' => 'zip',  'image' => 'zip.gif'),

            array('extension' => 'c',    'image' => 'plain.gif'),
            array('extension' => 'cpp',  'image' => 'plain.gif'),
            array('extension' => 'css',  'image' => 'plain.gif'),
            array('extension' => 'csv',  'image' => 'plain.gif'),
            array('extension' => 'h',    'image' => 'plain.gif'),
            array('extension' => 'htm',  'image' => 'html.gif'),
            array('extension' => 'html', 'image' => 'html.gif'),
            array('extension' => 'java', 'image' => 'plain.gif'),
            array('extension' => 'pas',  'image' => 'plain.gif'),
            array('extension' => 'reg',  'image' => 'plain.gif'),
            array('extension' => 'txt',  'image' => 'plain.gif'),
            array('extension' => 'xml',  'image' => 'xml.gif'),
            array('extension' => 'xul',  'image' => 'xul.gif'),

            array('extension' => 'ai',   'image' => 'documents.gif'),
            array('extension' => 'pdf',  'image' => 'pdf.gif'),
            array('extension' => 'ps',   'image' => 'ps.gif'),
            array('extension' => 'doc',  'image' => 'word.gif'),
            array('extension' => 'xls',  'image' => 'spreadsheet.gif'),
            array('extension' => 'ppt',  'image' => 'documents.gif'),
            array('extension' => 'odt',  'image' => 'word.gif'),
            array('extension' => 'ods',  'image' => 'spreadsheet.gif'),
            array('extension' => 'odp',  'image' => 'documents.gif'),

            array('extension' => 'asf',  'image' => 'video.gif'),
            array('extension' => 'avi',  'image' => 'video.gif'),
            array('extension' => 'mid',  'image' => 'sound.gif'),
            array('extension' => 'mov',  'image' => 'quicktime.gif'),
            array('extension' => 'mp3',  'image' => 'mpsound.gif'),
            array('extension' => 'mp4',  'image' => 'video.gif'),
            array('extension' => 'mpe',  'image' => 'video.gif'),
            array('extension' => 'mpeg', 'image' => 'video.gif'),
            array('extension' => 'mpg',  'image' => 'video.gif'),
            array('extension' => 'ra',   'image' => 'real.gif'),
            array('extension' => 'wav',  'image' => 'sound.gif'),
            array('extension' => 'wma',  'image' => 'sound.gif'),
            array('extension' => 'wmv',  'image' => 'video.gif'),

            array('extension' => 'swf',  'image' => 'flash.gif'),
            array('extension' => 'flv',  'image' => 'flash.gif'),
            array('extension' => 'extvid',  'image' => 'flash.gif')
    );

    DBUtil::insertObjectArray($filetypes, 'ma_formats', 'fid');

    $formatgroups = Array(
            'Images'       => array('bmp', 'gif', 'jpeg', 'jpg', 'pcx', 'png', 'tga', 'tif'),
            'Compression'  => array('ace', 'arj', 'cab', 'gz', 'iso', 'jar', 'lha', 'lzh', 'rar', 'tar', 'zip'),
            'Plain text'   => array('c', 'cpp', 'css', 'csv', 'h', 'htm', 'html', 'java', 'pas', 'txt', 'xml', 'xul'),
            'Documents'    => array('ai', 'pdf', 'ps', 'doc', 'xls', 'ppt', 'odt', 'ods', 'odp'),
            'Media'        => array('asf', 'avi', 'mid', 'mov', 'mp3', 'mp4', 'mpe', 'mpeg', 'mpg', 'ra', 'wav', 'wma', 'wmv', 'extvid'),
            'Flash'        => array('swf', 'flv', 'extvid'),
            'User defined' => array('jpg', 'gif', 'zip', 'pdf', 'doc', 'xls', 'html', 'htm', 'mp3', 'reg'),
            'PDF only'     => array('pdf')
    );

    foreach($groups as $currentgroup) {
        foreach ($formatgroups[$currentgroup['groupname']] as $currentfg) {
            foreach ($filetypes as $currentformat) {
                if ($currentformat['extension'] == $currentfg) {
                    $insertfg = array('fid' => $currentformat['fid'], 'gid' => $currentgroup['gid']);
                    DBUtil::insertObject($insertfg, 'ma_formatgroups', 'fid', true);
                }
            }
        }
    }
}

/**
 * create the category registries for MediaAttach
 *
 * @author       Axel Guckelsberger
 * @return       bool       true if successful or false if something went wrong
 */
function MediaAttach_create_categoryregistries()
{
    // load necessary classes
    Loader::loadClass('CategoryUtil');
    Loader::loadClassFromModule('Categories', 'CategoryRegistry');

    // get the language file
    $lang = pnUserGetLang();

    $rootCatPath = '/__SYSTEM__/Modules/Global';
    $rootCat = CategoryUtil::getCategoryByPath($rootCatPath);

    // get the category path for which we're going to insert our upgraded categories
    if ($rootCat) {
        $registry = new PNCategoryRegistry();
        $registry->setDataField('modname', 'MediaAttach');
        $registry->setDataField('table', 'ma_files');
        $registry->setDataField('property', 'Main');
        $registry->setDataField('category_id', $rootCat['id']);
        $registry->insert();

        $registry = new PNCategoryRegistry();
        $registry->setDataField('modname', 'MediaAttach');
        $registry->setDataField('table', 'ma_files');
        $registry->setDataField('property', 'Second');
        $registry->setDataField('category_id', $rootCat['id']);
        $registry->insert();

        $registry = new PNCategoryRegistry();
        $registry->setDataField('modname', 'MediaAttach');
        $registry->setDataField('table', 'ma_files');
        $registry->setDataField('property', 'Third');
        $registry->setDataField('category_id', $rootCat['id']);
        $registry->insert();
    }

    // store our module-specific category path
    pnModSetVar('MediaAttach', 'baseCat', $rootCatPath);

    return true;
}

/**
 * remove the category data of MediaAttach
 *
 * @author       Axel Guckelsberger
 * @return       bool       true if successful or false if something went wrong
 */
function MediaAttach_delete_categorydata()
{
    if (!pnModDBInfoLoad('Categories')) {
        return false;
    }

    DBUtil::deleteWhere('categories_mapobj', "cmo_modname='MediaAttach'");
    DBUtil::deleteWhere('categories_registry', "crg_modname='MediaAttach'");

    return true;
}
