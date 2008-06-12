<?php
/**
 * MediaAttach
 *
 * @version      $Id: function.getinlinesnippet.php 210 2007-08-08 12:58:50Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common_mimetypes.php');


/**
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        array       file         given file array
 * @param        boolean     blockcall    optional - if true the plugin was called from a block (for ensuring unique id attributes) 
 * @param        int         thumbnr      thumbnail number: 1..x (optional, default to modvar setting)
 * @return       string      according template
 */
function smarty_function_getinlinesnippet($params, &$smarty) 
{
    if (!isset($params['file'])) {
        $smarty->trigger_error("smarty_function_getinlinesnippet: missing parameter 'file'");
        return false;
    }

    if (!is_array($params['file']) || !isset($params['file']['mimetype'])) {
        $smarty->trigger_error("smarty_function_getinlinesnippet: wrong parameter 'file'");
        return false;
    }

    if (!isset($params['blockcall']) || !is_bool($params['blockcall'])) {
        $params['blockcall'] = false;
    }

    if (!isset($params['externalPreview']) || ($params['externalPreview'] != 0 && $params['externalPreview'] != 1)) {
        $params['externalPreview'] = 0;
    }

    $thumbnr = (isset($params['thumbnr']) && is_numeric($params['thumbnr'])) ? $params['thumbnr'] : (int) FormUtil::getPassedValue('thumbnr', 0, 'GETPOST');
    if ($thumbnr == 0) {
        pnModGetVar('MediaAttach', 'defaultthumb');
    }

    $res = false;

    // catch some cases when a better mimetype is available
    if ($params['file']['mimetype'] == 'application/x-executable-file'
        && $params['file']['mimetype'] != $params['file']['fileInfo']['mime_type']) {
            $params['file']['mimetype'] = $params['file']['fileInfo']['mime_type'];
    }

    $snippetName = '';
    if ($params['file']['extension'] == 'extvid') {
        $snippetName = 'extvideo';
    }
    else {
        $snippetName = _maGetInlineSnippetName($params['file']['mimetype']);
        if (!$snippetName) {
            $mimetype = _maGuessMimetypeFromExtension($params['file']['extension']);
            $snippetName = _maGetInlineSnippetName($mimetype);
        }
    }

    $render = pnRender::getInstance('MediaAttach', false);
    $render->assign('file', $params['file']);
    $render->assign('idprefix', ($params['blockcall']) ? 'block' : '');
    $render->assign('externalPreview', $params['externalPreview']);

    $render->assign('thumbnr', $thumbnr);

    if ($params['file']['extension'] == 'extvid') {
        // extract domain
        $urlInfos = parse_url($params['file']['filename']);
        $proDomain = $urlInfos['host'];
        // strip out www subdomain
        if (substr($proDomain, 0, 4) == 'www.') {
            $proDomain = substr($proDomain, 4, strlen($proDomain) - 4);
        }

        $supportedProviders = pnModAPIFunc('MediaAttach', 'extvideo', 'getproviders');
        $provider = array();
        foreach($supportedProviders as $currentprovider) {
            if (in_array($proDomain, $currentprovider['domains'])) {
                $provider = $currentprovider;
                break;
            }
        }

        $render->assign('provider', $provider);
    }


    $res = $render->fetch('inline/inline_' . $snippetName . '.htm');
    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $res);
    }
    else {
        return $res;
    }
}
