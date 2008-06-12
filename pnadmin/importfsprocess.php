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


Loader::requireOnce('modules/MediaAttach/common.php');
Loader::requireOnce('modules/MediaAttach/common_mimetypes.php');


/**
 * starts import from a server directory
 *
 * @param    string   curd                current directory
 * @param    array    fileX               file x selected? (X = 1,2,3,...n)
 * @param    string   titleX              title (if any) (X = 1,2,3,...n)
 * @param    string   descriptionX        description (if any) (X = 1,2,3,...n)
 * @param    int      numfiles            number of files available ( = n)
 */
function MediaAttach_admin_importfsprocess($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'importfsform'));
    }

    $currentDir = FormUtil::getPassedValue('curd', isset($args['curd']) ? $args['curd'] : getenv('DOCUMENT_ROOT'), 'POST');
    $currentDir = realpath($currentDir);
    $numFiles = (int) FormUtil::getPassedValue('numfiles', isset($args['numfiles']) ? $args['numfiles'] : 0, 'POST');
    if ($numFiles == 0) {
        LogUtil::registerError(_MODARGSERROR);
        return pnRedirect(pnModURL('MediaAttach', 'admin', 'importfsform'));
    }

    unset($args);

    $definition = pnModAPIFunc('MediaAttach', 'definitions', 'getmoduledefinition', array('modname' => 'MediaAttach'));
    list($dirs, $files) = pnModAPIFunc('MediaAttach', 'filesystem', 'readdirectory', array('directory' => $currentDir));

    $msglog = '';
    $filenr = 0;
    for ($i = 0; $i < $numFiles; $i++) {
        $isFileSelected = (int) FormUtil::getPassedValue('file' . $i, 0, 'POST');
        if ($isFileSelected == 1) {
            $filenr++;
            $title = FormUtil::getPassedValue('title' . $i,       _MEDIAATTACH_NOTITLE, 'POST');
            $desc  = FormUtil::getPassedValue('description' . $i, '',              'POST');

            $cats = FormUtil::getPassedValue('mafilecats_' . $i,      null, 'POST');

            $msglog .= MediaAttach_import_performsingleimport($filenr, $files[$i], $title, $desc, $cats, $definition);
        }
    }

    if (!empty($msglog)) $msglog = '<ul>' . $msglog . '</ul>';

    LogUtil::registerStatus($msglog);
    return pnRedirect(pnModURL('MediaAttach', 'admin', 'view'));
}



/**
 * outsourced part of the create function - the real upload functionality
 *
 * @param    int      nr                file index (for multiple files)
 * @param    array    file              the file array
 * @param    string   title             title field
 * @param    string   description       description field
 * @param    array    categories        category array
 * @param    array    definition        definition for the current module
 */
function MediaAttach_import_performsingleimport($nr, $file, $title, $description, $categories, $definition) {
    $msglog = '';

    $filename = $file['filename'];
    $extensionarr = split("\.", $filename);
    $extension = $extensionarr[count($extensionarr) - 1];

    $msgpref = '<li><strong>' . _MEDIAATTACH_UPLOADFILE . ' ' . $nr . '</strong> (' . $filename . '):<br /><div style="padding-left: 30px">';

    list($filename, $destFilePath) = _maIntGetFilenameForDefinition($filename, $extension, $definition['naming'], $definition['namingprefix']);

    // Extension check
    $extension_okay = 0;

    foreach ($definition['formats'] as $currentformat) {
        if (strtolower($currentformat['extension']) == strtolower($extension)) {
            $extension_okay = 1;
        }
    }

    if (!$extension_okay) {
        $msglog .= $msgpref . _MEDIAATTACH_ERRFORMAT . '</div></li>';
        return $msglog;
    }

    $copiedProperly = 1;
    if (!copy($file['filepath'], $destFilePath)) {
        $copiedProperly = 0;
    }

    if ($copiedProperly == 1) {
        $upload = array('modname'    => 'MediaAttach',
                        'objectid'   => 99999999,
                        'definition' => $definition['did'],
                        'uid'        => pnUserGetVar('uid'),
                        'title'      => $title,
                        'desc'       => str_replace("\n", "<br />", $description),
                        'extension'  => $extension,
                        'mimetype'   => _maGuessMimetypeFromExtension($extension),
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

    return $msglog;
}
