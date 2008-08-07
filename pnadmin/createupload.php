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

/**
 * Create an upload for a specific item
 *
 * This function is called with the results of the form
 * supplied by MediaAttach_admin_viewupload to create a new upload
 * It can be called by other modules like pnForum if they
 * want to integrate upload functionality during a create process.
 *
 * @param   MediaAttach_uploadfileX    array    the upload (taken from HTTP put) (X = 1,2,3,...n)
 * @param   MediaAttach_titleX         string   The title of the upload (if any) (taken from HTTP put) (X = 1,2,3,...n)
 * @param   MediaAttach_descriptionX   string   The description of the upload (if any) (taken from HTTP put) (X = 1,2,3,...n)
 */
function MediaAttach_admin_createupload($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    if (isset($args) && is_array($args)) {
        extract($args);
        unset($args);
    }

    $MediaAttach_modname = 'MediaAttach';
    $MediaAttach_objectid = 99999999;
    $hookcall = 0;
    $extrainfo = '';
    $MediaAttach_redirect = pnModURL('MediaAttach', 'admin', 'view');


    if (!SecurityUtil::confirmAuthKey()) {
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

    Loader::requireOnce('modules/MediaAttach/pnuser/createupload.php');

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

            $upload['name'] = $jsfield_files['name'][$i];
            $upload['type'] = $jsfield_files['type'][$i];
            $upload['tmp_name'] = $jsfield_files['tmp_name'][$i];
            $upload['error'] = $jsfield_files['error'][$i];
            $upload['size'] = $jsfield_files['size'][$i];

            $msglog .= MediaAttach_user_performsingleupload($i+1, $upload, $title, $description, $cats, $MediaAttach_modname, $MediaAttach_objectid, $MediaAttach_redirect, $definition, $hookcall);
        }
    }
    else {
        //process fields from non-JS upload form

        for ($i = 1; $i <= $definition['numfiles']; $i++) {
            $title = FormUtil::getPassedValue('MediaAttach_title' . $i, _MEDIAATTACH_NOTITLE, 'POST');
            $desc = FormUtil::getPassedValue('MediaAttach_description' . $i, '', 'POST');
            $cats = FormUtil::getPassedValue('mafilecats_' . $i,      null, 'POST');

            $msglog .= MediaAttach_user_performsingleupload($i, $_FILES['MediaAttach_uploadfile' . $i], $title, $desc, $cats, $MediaAttach_modname, $MediaAttach_objectid, $MediaAttach_redirect, $definition, $hookcall);
        }
    }

    if (!empty($msglog)) $msglog = '<ul>' . $msglog . '</ul>';

    return MediaAttach_user_returnFromCreate($hookcall, $MediaAttach_redirect, $extrainfo, $msglog);
}
