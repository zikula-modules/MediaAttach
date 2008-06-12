<?php
/**
 * MediaAttach
 *
 * @version      $Id: add_stylesheet_header.php 101 2008-03-21 9:49:14Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * utility func for adding stylesheets
 *
 */
function MediaAttach_userapi_add_stylesheet_header()
{
    // add the style sheet file to the additional_header array
    $themeinfo = ThemeUtil::getInfo(ThemeUtil::getIDFromName(pnUserGetTheme()));
    $xhtmltag = ($themeinfo['xhtml']) ? ' /' : '';

    $stylesheet = 'modules/MediaAttach/pnstyle/style.css';
    $stylesheetlink = '<link rel="stylesheet" href="' . $stylesheet . '" type="text/css"' . $xhtmltag . '>' . "\n";
    global $additional_header;
    if (is_array($additional_header)) {
        $values = array_flip($additional_header);
        if (!array_key_exists($stylesheetlink, $values) && file_exists($stylesheet) && is_readable($stylesheet)) {
            $additional_header[] = $stylesheetlink;
        }
    } else {
        if (file_exists($stylesheet) && is_readable($stylesheet)) {
            $additional_header[] = $stylesheetlink;
        }
    }
    return;
}
