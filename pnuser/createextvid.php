<?php
/**
 * MediaAttach
 *
 * @version      $Id: createextvid.php 59 2008-03-02 09:57:48Z weckamc $
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
 * supplied by MediaAttach_user_viewupload to create a new upload
 * This function is also a create hook.
 * It can be called by other modules like Dizkus if they
 * want to integrate upload functionality during a create process.
 *
 * @param   MediaAttach_videourl    string   URL of video page
 * @param   MediaAttach_objectid    string   ID of the item the upload is for (taken from HTTP put)
 * @param   MediaAttach_redirect    string   URL to return to (taken from HTTP put)
 */
function MediaAttach_user_createextvid($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (isset($args) && is_array($args)) {
        extract($args);
        unset($args);
    }

    $videoURL             = FormUtil::getPassedValue('MediaAttach_videourl', '', 'POST');
    $MediaAttach_modname  = FormUtil::getPassedValue('MediaAttach_modname',  pnModGetName(), 'POST');
    $MediaAttach_objectid = FormUtil::getPassedValue('MediaAttach_objectid', null, 'POST');
    $MediaAttach_redirect = FormUtil::getPassedValue('MediaAttach_redirect', null, 'POST');

    if (!$videoURL || !$MediaAttach_modname || !$MediaAttach_objectid || !$MediaAttach_redirect) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $MediaAttach_redirect = str_replace('&amp;', '&', base64_decode($MediaAttach_redirect)) . '#files';

    if (pnSessionGetVar('MediaAttachCreateLock') == '1') {
        return pnRedirect($MediaAttach_redirect);
    }

    if (!SecurityUtil::checkPermission('MediaAttach::', "$MediaAttach_modname:: ", ACCESS_COMMENT)) {
        return LogUtil::registerPermissionError($MediaAttach_redirect);
    }

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(__("Invalid 'authkey':  this probably means that you pressed the 'Back' button, or that the page 'authkey' expired. Please refresh the page and try again.", $dom));
        return pnRedirect($MediaAttach_redirect);
    }

    $definition = pnModAPIFunc('MediaAttach', 'definitions', 'getmoduledefinition', array('modname' => $MediaAttach_modname));

    // extract domain
    $urlInfos  = parse_url($videoURL);
    $proDomain = $urlInfos['host'];
    // strip out www subdomain
    if (StringUtil::left($proDomain, 4) == 'www.') {
        $proDomain = substr($proDomain, 4, strlen($proDomain) - 4);
    }

    // find if domain provider is supported
    $supportedProviders = pnModAPIFunc('MediaAttach', 'extvideo', 'getproviders');
    $provider = array();
    $domainIsSupported = false;
    foreach($supportedProviders as $currentprovider) {
        if (in_array($proDomain, $currentprovider['domains'])) {
            $domainIsSupported = true;
            $provider = $currentprovider;
            break;
        }
    }

    if ($domainIsSupported == false) {
        LogUtil::registerError(__('Error: this is an invalid or unsupported URL.', $dom));
        return pnRedirect($MediaAttach_redirect);
    }

    // fetch page
    if (!class_exists('Snoopy')) {
        Loader::includeOnce('modules/MediaAttach/pnincludes/Snoopy/Snoopy.class.php');
    }
    $snoopy = new Snoopy;
    $snoopy->fetch($videoURL);
    $pageInfo = _maGrabPageInfo($snoopy->results, $provider['searchpattern']);
    if ($pageInfo === false || !is_array($pageInfo)) {
        LogUtil::registerError(__('Sorry, could not determine video information.', $dom));
        return pnRedirect($MediaAttach_redirect);
    }
//die(print_r($pageInfo));
    if (!isset($provider['filetypes']['mimetype'])) {
        $filetypeInfo = $provider['filetypes'][0]; // FIXME
    } else {
        $filetypeInfo = $provider['filetypes'];
    }

    $file = array('filepath'    => $pageInfo['filepath'],
                  'mimetype'    => $filetypeInfo['mimetype']);

    $cats = FormUtil::getPassedValue('maextvidcats', null, 'POST');

    $msglog = MediaAttach_user_addExternalVideo($file, $pageInfo['title'], $pageInfo['desc'], $cats, $MediaAttach_modname, $MediaAttach_objectid, $MediaAttach_redirect, $definition);

    if (!empty($msglog)) $msglog = '<ul>' . $msglog . '</ul>';

    LogUtil::registerStatus($msglog);
    return pnRedirect($MediaAttach_redirect);
}

/*
 * helper function for searching the needed parts of a fetched video page
 *
 */
function _maGrabPageInfo($pageContent, $searchPattern)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $title    = __('No title', $dom);
    $desc     = '';
    $filepath = '';

    // extract title
    if (preg_match("#" . $searchPattern['titleStart'] . "(.*?)" . $searchPattern['titleEnd'] . "#s", $pageContent, $matches)) {
        $title = DataUtil::convertFromUTF8($matches[1]);
    } else {
//die('DEBUG: FEHLER 1');
        return false;
    }

    // extract description
    if (preg_match("#" . $searchPattern['descStart'] . "(.*?)" . $searchPattern['descEnd'] . "#s", $pageContent, $matches)) {
        $desc = DataUtil::convertFromUTF8($matches[1]);
    } else {
//die('DEBUG: FEHLER 2');
        return false;
    }

    // extract filename
    if (preg_match("#" . $searchPattern['fileStart'] . "(.*?)" . $searchPattern['fileEnd'] . "#s", $pageContent, $matches)) {
        $filepath = $matches[1];
    } else {
//die('DEBUG: FEHLER 3');
        return false;
    }

    if ($searchPattern['filePfix'] != '') {
        $filepath = $searchPattern['filePfix'] . $filepath;
    }
    if ($searchPattern['fileSfix'] != '') {
        $filepath .= $searchPattern['fileSfix'];
    }

    return array('title' => $title, 'desc' => $desc, 'filepath' => $filepath);
}

/**
 * outsourced part of the create function - the real upload functionality
 *
 * @param    file           array    the file array
 * @param    title          string   title field
 * @param    description    string   description field
 * @param    categories     array    category array
 * @param    modname        string   the current module name
 * @param    objectid       string   the object id
 * @param    url            string   redirect url for db save
 * @param    definition     array    definition for the current module
 */
function MediaAttach_user_addExternalVideo($file, $title, $description, $categories, $modname, $objectid, $url, $definition)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $msglog = '';
    $errmsg = '';

    $msgpref = '<li><strong>' . $file['filepath'] . '</strong>:<br /><div style="padding-left: 30px">';

    $upload = array('modname'    => $modname,
                    'objectid'   => $objectid,
                    'definition' => $definition['did'],
                    'uid'        => pnUserGetVar('uid'),
                    'title'      => $title,
                    'desc'       => str_replace("\n", "<br />", $description),
                    'extension'  => 'extvid',
                    'mimetype'   => $file['mimetype'],
                    'filename'   => $file['filepath'],
                    'filesize'   => 0,
                    'url'        => $url);
    $upload['__CATEGORIES__'] = $categories;

    $fileid = pnModAPIFunc('MediaAttach', 'user', 'createupload', $upload);

    if ($fileid == false) {
        $msglog .= $msgpref . __('Sorry, the data of your file could not be written into the database', $dom);
    } else {
        $upload['fileid'] = $fileid;
        $msglog .= $msgpref . __('The video has been embedded successfully', $dom);

        if ($definition['sendmails'] == 1) {
            $mailheaders =  'From:' . pnConfigGetVar('sitename') . '<' . pnConfigGetVar('adminmail') . ">\n";
            $mailheaders .= "X-Mailer: MediaAttach using PHP/" . phpversion() . "\n";
            $mailsubject = __('A new file has been uploaded', $dom);
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
