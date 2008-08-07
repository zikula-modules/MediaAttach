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
Loader::requireOnce('modules/MediaAttach/common_mimetypes.php');


/**
 * starts import from another module
 *
 * @param  importmod     string      name of module to import from
 */
function MediaAttach_admin_importmodprocess($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'importmodform'));
    }

    $availableImportMods = _maGetImportModules();

    $importMod = FormUtil::getPassedValue('importmod', isset($args['importmod']) ? $args['importmod'] : null, 'POST');
    if ($importMod == null || !in_array($importMod, $availableImportMods) || !pnModAvailable($importMod)) {
        LogUtil::registerError(_MODARGSERROR);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'importmodform'));
    }
    unset($args);

    if ($importMod == 'PNphpBB2') {
        LogUtil::registerError('Sorry, this import is not finished yet.');
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'importmodform'));
    }

    ini_set('max_execution_time' , 86400);
    ini_set('memory_limit', '64M');

    $loggedData = array();
    $loggedData['categories'] = array();
    $loggedData['files'] = array();

    $modError = 'Could not load database information of ' . $importMod; // todo: put in lang file

    if (!pnModDBInfoLoad($importMod)) {
        LogUtil::registerError($modError);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'importmodform'));
    }

    if ($importMod == 'PhotoGallery') {
        // load lang file with part of physical filenames
        pnModLangLoad('PhotoGallery', 'photogallery', false);
    }

    $definition = pnModAPIFunc('MediaAttach', 'definitions', 'getmoduledefinition', array('modname' => 'MediaAttach'));
    $pntable = pnDBGetTables();

    if ($importMod != 'pnUpper') {
        // step one - convert albums/categories
        pnModDBInfoLoad('Categories');
        Loader::loadClassFromModule('Categories', 'category');
        Loader::loadClass('LanguageUtil');
        $allLanguages = LanguageUtil::getLanguages();
        $collectedCategoryInfo = array();

        switch($importMod) {
            case 'Downloads':
                    $columns = $pntable['downloads_categories_column'];
                    $sql = "SELECT " . $columns['cid'] . " AS catOldID,
                                " . $columns['title'] . " AS title,
                                " . $columns['description'] . " AS description,
                                " . $columns['pid'] . " AS catOldParentID
                            FROM " . $pntable['downloads_categories'];
                    break;
            case 'mediashare':
                    $columns = $pntable['mediashare_albums_column'];
                    $sql = "SELECT " . $columns['id'] . " AS catOldID,
                                " . $columns['title'] . " AS title,
                                " . $columns['description'] . " AS description,
                                " . $columns['parentAlbumId'] . " AS catOldParentID
                            FROM " . $pntable['mediashare_albums'] . "
                            WHERE " . $columns['id'] . " > 1";
                    break;
            case 'PhotoGallery':
                    $columns = $pntable['photogallery_galleries_column'];
                    $sql = "SELECT " . $columns['gid'] . " AS catOldID,
                                " . $columns['name'] . " AS title,
                                " . $columns['desc'] . " AS description,
                                '0' AS catOldParentID
                            FROM " . $pntable['photogallery_galleries'];
                    break;
        }

        $result = DBUtil::executeSQL($sql);
        if (!$result) {
            LogUtil::registerError($modError);
            return pnRedirect(pnModURL('MediaAttach', 'admin', 'importmodform'));
        }

        for (; !$result->EOF; $result->MoveNext()) {
            list($catOldID, $catTitle, $catDescription, $catOldParentID) = $result->fields;

            $isInterestingRow = ($importMod != 'mediashare' || ($importMod == 'mediashare' && $catOldID != 1));        // exclude main album

            if ($isInterestingRow) {
                // determine new parent category ID, default to main category
                $catNewParentID = 30;
                if (($importMod == 'Downloads' && $catOldParentID > 0)
                 || ($importMod == 'mediashare' && $catOldParentID > 1)) {
                    $catNewParentID = $loggedData['categories'][$catOldParentID]['newCatID'];
                }

                // create new subcategory
                $newCat = new PNCategory();
                $newCat->setDataField('parent_id', $catNewParentID);
                $newCat->setDataField('name', $catTitle);
                $catDisplayName = Array();
                $catDisplayDesc = Array();

                foreach ($allLanguages as $currentLang) {
                    $catDisplayName[$currentLang] = $catTitle;
                    $catDisplayDesc[$currentLang] = $catDescription;
                }

                $newCat->setDataField('display_name', $catDisplayName);
                $newCat->setDataField('display_desc', $catDisplayDesc);

                $newCat->insert();
                $newCat->update();    // since the original insert can't construct the ipath (since the insert id is not known yet) we update the object here.

                $catNewID = $newCat->getDataField('id');

                $loggedData['categories'][$catOldID] = array(
                                                        'oldCatID'      => $catOldID,
                                                        'newCatID'      => $catNewID,
                                                        'oldParentID'   => $catOldParentID,
                                                        'newParentID'   => $catNewParentID,
                                                        'title'         => $catTitle,
                                                        'description'   => $catDescription);
            }
        }
    }

    // step two - convert files
    switch($importMod) {
        case 'Downloads':
                $columns = $pntable['downloads_downloads_column'];
                $sql = "SELECT " . $columns['lid'] . " AS fileOldID,
                            " . $columns['title'] . " AS title,
                            " . $columns['description'] . " AS description,
                            " . $columns['cid'] . " AS catOldID,
                            'unknown' AS mimetype,
                            " . $columns['url'] . " AS filepath,
                            " . $columns['filesize'] . " AS filesize
                        FROM " . $pntable['downloads_downloads'];

                $sourcePath = pnModGetVar('downloads','upload_folder');
                break;
        case 'mediashare':
                $mcolumns = $pntable['mediashare_media_column'];
                $scolumns = $pntable['mediashare_mediastore_column'];
                $sql = "SELECT a." . $mcolumns['id'] . " AS fileOldID,
                               a." . $mcolumns['title'] . " AS title,
                               a." . $mcolumns['description'] . " AS description,
                               a." . $mcolumns['parentAlbumId'] . " AS catOldID,
                               b." . $scolumns['mimeType'] . " AS mimetype,
                               b." . $scolumns['fileRef'] . " AS filepath,
                               b." . $scolumns['bytes'] . " AS filesize
                        FROM " . $pntable['mediashare_media'] . " a,
                             " . $pntable['mediashare_mediastore'] . " b
                        WHERE a." . $mcolumns['originalId'] . " = b." . $scolumns['id'];

                $sourcePath = pnModGetVar('mediashare', 'mediaDirName') . '/';
                break;
        case 'PhotoGallery':
                $columns = $pntable['photogallery_photos_column'];
                $sql = "SELECT " . $columns['pid'] . " AS fileOldID,
                            " . $columns['name'] . " AS title,
                            " . $columns['desc'] . " AS description,
                            " . $columns['gid'] . " AS catOldID,
                            'unknown' AS mimetype,
                            " . $columns['image'] . " AS filepath,
                            '0' AS filesize
                        FROM " . $pntable['photogallery_photos'];

                $sourcePath = pnModGetVar('PhotoGallery', 'imagepath');
                break;
        case 'pnUpper':
                $columns = $pntable['up_files_column'];

                $sql = "SELECT " . $columns['fileid'] . " AS fileOldID,
                               " . $columns['title'] . " AS title,
                               " . $columns['desc'] . " AS description,
                               '0' AS catOldID,
                               " . $columns['mimetype'] . " AS mimetype,
                               " . $columns['filename'] . " AS filepath,
                               " . $columns['filesize'] . " AS filesize
                        FROM " . $pntable['up_files'];

                $sourcePath = pnModGetVar('pnUpper', 'uploaddir') . '/';
                break;
    }

    $result = DBUtil::executeSQL($sql);
    if (!$result) {
        LogUtil::registerError($modError);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'importmodform'));
    }

    $msglog = '';

    for (; !$result->EOF; $result->MoveNext()) {
        list($fileOldID, $fileTitle, $fileDescription, $fileOldCatID, $fileMimetype, $fileOldPath, $fileSize) = $result->fields;

        if ($importMod == 'Downloads') {
            // determine mimetype
            $extensionarr = split("\.", $fileOldPath);
            $extension = $extensionarr[count($extensionarr) - 1];
            $fileMimetype = _maGuessMimetypeFromExtension($extension);
        }
        elseif ($importMod == 'PhotoGallery') {
            $fileMimetype = _maGuessMimetypeFromExtension($fileOldPath);
            $fileOldPath = _PHOTO_IMAGEPREFIX . $fileOldID . _PHOTO_LARGEIMAGESUFFIX . '.' . $fileOldPath;
            $fileSize = filesize($sourcePath . $fileOldPath);
        }

        $newCatID = 0;
        if (isset($loggedData['categories'][$fileOldCatID])) {
            $newCatID = $loggedData['categories'][$fileOldCatID]['newCatID'];
        }

        $cats = array();
        if ($newCatID) $cats['Main'] = $newCatID;

        $file = array('filename' => $fileOldPath,
                      'filepath' => $sourcePath . $fileOldPath,
                      'filesize' => $fileSize,
                      'mimetype' => $fileMimetype
                );

        list($fileNewID, $singlelog) = MediaAttach_import_performsinglemoduleimport($file, $fileTitle, $fileDescription, $cats, $definition);
        $msglog .= $singlelog;

        if ($fileNewID) {
            $loggedData['files'][$fileOldID] = array(
                                                    'oldFileID'     => $fileOldID,
                                                    'oldFilePath'   => $fileOldPath,
                                                    'newID'         => $fileNewID,
                                                    'oldCatID'      => $fileOldCatID,
                                                    'newCatID'      => $newCatID,
                                                    'title'         => $fileTitle,
                                                    'description'   => $fileDescription);
        }
    }

    if (!empty($msglog)) $msglog = '<ul>' . $msglog . '</ul>';

    Loader::loadClass('FileUtil');
    $res = FileUtil::writeSerializedFile('pnTemp/convertLog_MediaAttach_import_from_' . DataUtil::formatForOS($importMod) . '.txt', $loggedData);
    if ($res === false) LogUtil::registerError('Writing the protocol file failed unfortunately.');

    LogUtil::registerStatus($msglog);
    return pnRedirect(pnModURL('MediaAttach', 'admin', 'view'));
}





/**
 * outsourced part of the create function - the real upload functionality
 *
 * @param    array    file              the file array
 * @param    string   title             title field
 * @param    string   description       description field
 * @param    array    categories        category array
 * @param    array    definition        definition for the current module
 */
function MediaAttach_import_performsinglemoduleimport($file, $title, $description, $categories, $definition) {
    $msglog = '';

    $filename = $file['filename'];
    $extensionarr = split("\.", $filename);
    $extension = $extensionarr[count($extensionarr) - 1];

    $msgpref = '<li><strong>' . $filename . '</strong>:<br /><div style="padding-left: 30px">';

    list($filename, $destFilePath) = _maIntGetFilenameForDefinition($filename, $extension, $definition['naming'], $definition['namingprefix']);

    // Extension check
    $extension_okay = 0;
    $lowerExtension = strtolower($extension);
    foreach ($definition['formats'] as $currentFileType) {
        if (strtolower($currentFileType['extension']) == $lowerExtension) {
            $extension_okay = 1;
            break;
        }
    }
    if (!$extension_okay) {
        $msglog .= $msgpref . _MEDIAATTACH_ERRFORMAT . '</div></li>';
        return $msglog;
    }

    $copiedProperly = 1;
    if (!copy($file['filepath'], $destFilePath)) {
        $copiedProperly = 0;
        $msglog .= $msgpref . _MEDIAATTACH_ERRINSERTFILE.' ('._FROM." $file[filepath] "._TO." $destFilePath)";
    }

    if ($copiedProperly == 1) {
        $upload = array('modname'    => 'MediaAttach',
                        'objectid'   => 99999999,
                        'definition' => $definition['did'],
                        'uid'        => pnUserGetVar('uid'),
                        'title'      => $title,
                        'desc'       => str_replace("\n", "<br />", $description),
                        'extension'  => $extension,
                        'mimetype'   => $file['mimetype'],
                        'filename'   => $filename,
                        'filesize'   => $file['filesize'],
                        'url'        => pnModUrl('MediaAttach', 'admin', 'view'));
        $upload['__CATEGORIES__'] = $categories;

        $fileid = pnModAPIFunc('MediaAttach', 'user', 'createupload', $upload);

        if ($fileid == false) {
            $msglog .= $msgpref . _MEDIAATTACH_ERRINSERTFILE;
        }
        else {
            $upload['fileid'] = $fileid;
            $msglog .= $msgpref . _MEDIAATTACH_IMPORTCREATED;
        }
    }
    $msglog .= '</div></li>';

    return array($fileid, $msglog);
}


