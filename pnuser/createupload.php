<?php
/**
 * MediaAttach
 *
 * @version      $Id: createupload.php 59 2008-03-02 09:57:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * Create an upload for a specific item
 *
 * This function is called with the results of the form
 * supplied by MediaAttach_user_viewupload to create a new upload
 * This function is also a create hook.
 * It can be called by other modules like pnForum if they
 * want to integrate upload functionality during a create process.
 *
 * @param   string   MediaAttach_modname        the name of the module the upload is for (taken from HTTP put)
 * @param   string   MediaAttach_objectid       ID of the item the upload is for (taken from HTTP put)
 * @param   string   MediaAttach_redirect       URL to return to (taken from HTTP put)
 * @param   array    MediaAttach_uploadfileX    the upload (taken from HTTP put) (X = 1,2,3,...n)
 * @param   string   MediaAttach_titleX         The title of the upload (if any) (taken from HTTP put) (X = 1,2,3,...n)
 * @param   string   MediaAttach_descriptionX   The description of the upload (if any) (taken from HTTP put) (X = 1,2,3,...n)
 */
function MediaAttach_user_createupload($args)
{
    if (isset($args) && is_array($args)) {
        extract($args);
        unset($args);
    }

    $hookcall = 0;
    if (isset($objectid) && !empty($objectid)) {
        $hookcall = 1;

        //return if ajax process is running (pnForum)
        if (pnSessionGetVar('pn_ajax_call') == 'ajax') {
            return;
        }
    }

    if ($hookcall == 1) {
        if (!isset($extrainfo) || !is_array($extrainfo)) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        $MediaAttach_modname  = (!empty($extrainfo['module'])) ? $extrainfo['module'] : pnModGetName();
        $MediaAttach_objectid = (!empty($extrainfo['itemid'])) ? $extrainfo['itemid'] : $objectid;

        if (empty($MediaAttach_objectid)) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        $urlfunc = $urlparams = '';
        if ($MediaAttach_modname == 'pnForum') {
            $urlfunc = 'viewtopic';
            $urlparams = array('topic' => $MediaAttach_objectid);
        }
        $MediaAttach_redirect = pnModURL($MediaAttach_modname, 'user', $urlfunc, $urlparams);

    } else {
        $extrainfo = '';

        $MediaAttach_modname  = FormUtil::getPassedValue('MediaAttach_modname',  null, 'POST');
        $MediaAttach_objectid = FormUtil::getPassedValue('MediaAttach_objectid', null, 'POST');
        $MediaAttach_redirect = FormUtil::getPassedValue('MediaAttach_redirect', null, 'POST');
    }

    $MediaAttach_redirect = str_replace('&amp;', '&', base64_decode($MediaAttach_redirect)) . '#files';

    if (!SecurityUtil::checkPermission('MediaAttach::', "$MediaAttach_modname:: ", ACCESS_COMMENT)) {
        return LogUtil::registerPermissionError($MediaAttach_redirect);
    }

    if (pnSessionGetVar('MediaAttachCreateLock') == '1') {
        return MediaAttach_user_returnFromCreate($hookcall, $MediaAttach_redirect, $extrainfo, '');
    }

    if ($hookcall == 0 && !SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect($MediaAttach_redirect);
    }

    $definition = pnModAPIFunc('MediaAttach', 'definitions', 'getmoduledefinition', array('modname' => $MediaAttach_modname));
    // remove external videos from allowed file types
    $numFormats = count($definition['formats']);
    for($i = 0; $i < $numFormats; $i++) {
        if ($definition['formats'][$i]['extension'] == 'extvid') {
            unset($definition['formats'][$i]);
            break;
        }
    }

    $msglog = '';

    $jsfield_files  = FormUtil::getPassedValue('MediaAttach_uploadfiles',  null, 'FILES');
    $jsfield_titles = FormUtil::getPassedValue('MediaAttach_titles',       null, 'POST');
    $jsfield_descs  = FormUtil::getPassedValue('MediaAttach_descriptions', null, 'POST');
    $jsfield_cats   = FormUtil::getPassedValue('MediaAttach_categories',   null, 'POST');
    if (is_array($jsfield_files) && is_array($jsfield_titles) && is_array($jsfield_descs) && is_array($jsfield_cats)) {
        //process fields from JS upload form

        $numfiles = count($jsfield_files['name']);
        if (($numfiles != count($jsfield_titles)) || ($numfiles != count($jsfield_descs)) || ($numfiles != count($jsfield_cats))) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        if ($numfiles > $definition['numfiles']) {
            $numfiles = $definition['numfiles'];
        }
        $numfiles--;

        $upload = array();
        for ($i = 0; $i <= $numfiles; $i++) {
            $title = $jsfield_titles[$i];
            $description = $jsfield_descs[$i];
            $cats = explode(',', $jsfield_cats[$i]);

            $upload['name']     = $jsfield_files['name'][$i];
            $upload['type']     = $jsfield_files['type'][$i];
            $upload['tmp_name'] = $jsfield_files['tmp_name'][$i];
            $upload['error']    = $jsfield_files['error'][$i];
            $upload['size']     = $jsfield_files['size'][$i];

            $msglog .= MediaAttach_user_performsingleupload($i+1, $upload, $title, $description, $cats, $MediaAttach_modname, $MediaAttach_objectid, $MediaAttach_redirect, $definition, $hookcall);
        }

    } else {
        //process fields from non-JS upload form

        for ($i = 1; $i <= $definition['numfiles']; $i++) {
            $title = FormUtil::getPassedValue('MediaAttach_title' . $i, _MEDIAATTACH_NOTITLE, 'POST');
            $desc  = FormUtil::getPassedValue('MediaAttach_description' . $i, '', 'POST');
            $cats  = FormUtil::getPassedValue('mafilecats_' . $i,      null, 'POST');

            $msglog .= MediaAttach_user_performsingleupload($i, $_FILES['MediaAttach_uploadfile' . $i], $title, $desc, $cats, $MediaAttach_modname, $MediaAttach_objectid, $MediaAttach_redirect, $definition, $hookcall);
        }
    }

    if (!empty($msglog)) $msglog = '<ul>' . $msglog . '</ul>';

    return MediaAttach_user_returnFromCreate($hookcall, $MediaAttach_redirect, $extrainfo, $msglog);
}

/**
 * returns dependant from if it was called by create hook or normal create form
 *
 * @param    int      hookcall            called  by hook (0 or 1)
 * @param    string   redirect            url for redirect (normal call)
 * @param    array    extrainfo           extrainfo to return (hook call)
 * @param    string   error               error message to set (optional)
 */
function MediaAttach_user_returnFromCreate($hookcall, $redirect, $extrainfo, $error = '')
{
    if ($error != '') {
        LogUtil::registerStatus($error);
    }

    if ($hookcall == 1) {
        return $extrainfo;
    } else {
        return pnRedirect($redirect);
    }
}

/**
 * outsourced part of the create function - the real upload functionality
 *
 * @param    int     nr                file index (for multiple files)
 * @param    array   file              the file array
 * @param    string  title             title field
 * @param    string  description       description field
 * @param    array   categories        category array
 * @param    string  modname           the current module name
 * @param    string  objectid          the object id
 * @param    string  url               redirect url for db save
 * @param    array   definition        definition for the current module
 * @param    int      hookcall            called  by hook (0 or 1)
 */
function MediaAttach_user_performsingleupload($nr, $file, $title, $description, $categories, $modname, $objectid, $url, $definition, $hookcall)
{
    $msglog = '';
    $errmsg = '';

    if ((!is_array($file)) || (is_array($file) && ($file['error'] != '0'))) {
        if (is_array($file)) {
            // only php version 4.2.0+
            switch ($file['error']) {
                case UPLOAD_ERR_OK: //no error; possible file attack!
                    $errmsg = _MEDIAATTACH_ERROK;
                    break;
                case UPLOAD_ERR_INI_SIZE: //uploaded file exceeds the upload_max_filesize directive in php.ini
                    $errmsg = _MEDIAATTACH_ERRINISIZE;
                    break;
                case UPLOAD_ERR_FORM_SIZE: //uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form
                    $errmsg = _MEDIAATTACH_ERRFORMSIZE;
                    break;
                case UPLOAD_ERR_PARTIAL: //uploaded file was only partially uploaded
                    $errmsg = _MEDIAATTACH_ERRPARTIAL;
                    break;
                case UPLOAD_ERR_NO_FILE: //no file was uploaded
                    if ($hookcall == 0) {
                        $errmsg = _MEDIAATTACH_ERRNOFILE;
                    }
                    break;
                case UPLOAD_ERR_NO_TMP_DIR: //missing a temporary folder
                    $errmsg = _MEDIAATTACH_ERRNOTMPDIR;
                    break;
                default: //a default error, just in case!  :)
                    $errmsg = _MEDIAATTACH_ERROK;
                    break;
            }
            if ($errmsg != '') {
                $msglog .= '<li><strong>' . _MEDIAATTACH_UPLOADFILE . ' ' . $nr . '</strong>:<br /><div style="padding-left: 30px">' . $errmsg . '</div></li>';
            }
        }
        return $msglog;
    }

    $filename = $file['name'];
    $extensionarr = split("\.", $filename);
    $extension = $extensionarr[count($extensionarr) - 1];

    $msgpref = '<li><strong>' . _MEDIAATTACH_UPLOADFILE . ' ' . $nr . '</strong> (' . $filename . '):<br /><div style="padding-left: 30px">';

    list($filename, $destFilePath) = _maIntGetFilenameForDefinition($filename, $extension, $definition['naming'], $definition['namingprefix']);

    // Size check
    if ($file['size'] > $definition['maxsize']) {
        $msglog .= $msgpref . _MEDIAATTACH_ERRSIZE . '</div></li>';
        return $msglog;
    }

    $mimetype = $file['type'];

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

    // data seems to be okay

    $imageFormats = array('gif', 'jpg', 'jpeg', 'png');
    if (pnModGetVar('MediaAttach', 'shrinkimages') == 1 && in_array(strtolower($extension), $imageFormats)) {
        // shrink image to maximum size

        // temporary save for editing
        $tmp_file = tempnam(pnConfigGetVar('temp'), 'MediaAttach');
        if (!move_uploaded_file($file['tmp_name'], $tmp_file)) {
            $msglog .= $msgpref . _MEDIAATTACH_ERRMOVE . ' (could not move ' . $file['tmp_name'] . ' to ' . $tmp_file . ')</div></li>';
            return $msglog;
        }

        // get image information
        $imageinfo = getimagesize($tmp_file);

        // file is not an image
        if (!$imageinfo) {
            $msglog .= $msgpref . _MEDIAATTACH_ERRFORMAT . '</div></li>';
            unlink($tmp_file);
            return $msglog;
        }

        //$extension = image_type_to_extension($imageinfo[2], false);
        //TODO: check again if extension has changed. possible file renaming required here

        // perform the shrink procedure
        pnModAPIFunc('MediaAttach', 'user', 'shrinkimage', $tmp_file);

        if (!copy($tmp_file, $destFilePath)) {
            $msglog .= $msgpref . _MEDIAATTACH_ERRMOVE . ' (could not move ' . $tmp_file . ' to ' . $destFilePath . ')</div></li>';
            unlink($tmp_file);
            return $msglog;
        }
        unlink($tmp_file);

    } else {
        if (!move_uploaded_file($file['tmp_name'], $destFilePath)) {
            $msglog .= $msgpref . _MEDIAATTACH_ERRMOVE . ' (could not move ' . $file['tmp_name'] . ' to ' . $destFilePath . ')</div></li>';
            return $msglog;
        }
    }

    $upload = array('modname'    => $modname,
                    'objectid'   => $objectid,
                    'definition' => $definition['did'],
                    'uid'        => pnUserGetVar('uid'),
                    'title'      => $title,
                    'desc'       => str_replace("\n", "<br />", $description),
                    'extension'  => $extension,
                    'mimetype'   => $mimetype,
                    'filename'   => $filename,
                    'filesize'   => $file['size'],
                    'url'        => $url);
    $upload['__CATEGORIES__'] = $categories;

    $fileid = pnModAPIFunc('MediaAttach', 'user', 'createupload', $upload);

    if ($fileid == false) {
        $msglog .= $msgpref . _MEDIAATTACH_ERRINSERTFILE;

    } else {
        $upload['fileid'] = $fileid;
        $msglog .= $msgpref . _MEDIAATTACH_UPLOADCREATED;

        if ($definition['sendmails'] == 1) {
            $mailheaders =  'From:' . pnConfigGetVar('sitename') . '<' . pnConfigGetVar('adminmail') . ">\n";
            $mailheaders .= "X-Mailer: MediaAttach using PHP/" . phpversion() . "\n";
            $mailsubject = _MEDIAATTACH_NEWMAILSUBJECT;
            $mailbody    = _MEDIAATTACH_NEWMAILBODY . ":\n\n\nModule:" . $modname . "\n";
            if ($title != '') {
                $mailbody .= _MEDIAATTACH_TITLE . ': ' . $title . "\n\n";
            }
            if ($description != '') {
                $mailbody .= _MEDIAATTACH_DESCRIPTION . ': ' . $description . "\n\n";
            }
            $mailbody .= "\n\n\nLink: " . $url;
            pnmail($definition['recipient'], $mailsubject, $mailbody, $mailheaders);
        }
    }
    $msglog .= '</div></li>';

    return $msglog;
}
