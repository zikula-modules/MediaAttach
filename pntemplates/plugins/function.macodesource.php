<?php
/**
 * MediaAttach
 *
 * @version      $Id: function.macodesource.php 210 2007-08-08 12:58:50Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        array       file         array of file to beautify
 * @return       mixed       analyzation results
 */
function smarty_function_macodesource($params, &$smarty)
{
    if (!isset($params['file'])) {
        $smarty->trigger_error("smarty_function_macodesource: missing parameter 'file'");
        return false;
    }

    if (!is_array($params['file'])) {
        $smarty->trigger_error("smarty_function_macodesource: wrong parameter 'file'");
        return false;
    }

    Loader::loadClass('FileUtil');
    $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');
    $filedata = FileUtil::readFile($uploaddir . '/' . $params['file']['filename'], true);

    // decide which language to use
    switch ($params['file']['mimetype']) {
        case 'text/css':                               // CSS
            $language = 'css';
            break;
        case 'text/html':                              // HTML
            $language = 'html4strict';
            break;
        case 'text/plain':                             // TXT
            $language = 'text';
            break;
        case 'text/x-java':                            // JAVA
            $language = 'java';
            break;
        case 'application/xml':                        // XML
        case 'text/xml':
        case 'application/vnd.mozilla.xul+xml':        // XUL
            $language = 'xml';
            break;
        default:
            switch ($params['file']['extension']) {
                case 'c':                              // C
                    $language = 'c';
                    break;
                case 'cpp':                            // CPP
                case 'h':                              // H
                    $language = 'cpp';
                    break;
                case 'css':                            // CSS
                    $language = 'css';
                    break;
                case 'htm':                            // HTM
                case 'html':                           // HTML
                    $language = 'html4strict';
                    break;
                case 'java':                           // JAVA
                    $language = 'java';
                    break;
                case 'pas':                            // PAS
                    $language = 'pascal';
                    break;
                case 'php':                            // PHP
                    $language = 'php';
                    break;
                case 'xml':                            // XML
                case 'xul':                            // XUL
                    $language = 'xml';
                    break;
                case 'txt':                            // TXT
                default:
                    $language = 'text';
                    break;
            }
            break;
    }

    //consider that geshi could already be loaded by pn_bbcode
    if (!class_exists('GeSHi')) {
        Loader::requireOnce('modules/MediaAttach/pnincludes/geshi/geshi.php');
    }
    $geshi =& new GeSHi($filedata, $language, 'modules/MediaAttach/pnincludes/geshi/geshi/');
    $geshi->set_tab_width(4);
    $geshi->set_case_keywords(GESHI_CAPS_LOWER);
    $geshi->set_header_type(GESHI_HEADER_DIV);
    $geshi->set_link_styles(GESHI_LINK,    'padding-left: 0px; background-image: none;');
    $geshi->set_link_styles(GESHI_HOVER,   'padding-left: 0px; background-image: none;');
    $geshi->set_link_styles(GESHI_ACTIVE,  'padding-left: 0px; background-image: none;');
    $geshi->set_link_styles(GESHI_VISITED, 'padding-left: 0px; background-image: none;');

    $numbers = true;
    if($numbers == true) {
        $geshi->set_line_style('color: blue; font-weight: bold;', 'color: green;');
        $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
        $geshi->start_line_numbers_at(1);
    }
    else {
        $geshi->enable_line_numbers(GESHI_NO_LINE_NUMBERS);
    }
    $res = $geshi->parse_code();


    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $res);
    }
    else {
        return $res;
    }
}
