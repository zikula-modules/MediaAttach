<?php
/**
 * MediaAttach
 *
 * @version      $Id: pnadminapi.php 57 2008-03-02 08:54:43Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * get available admin panel links
 *
 * @return array     array of admin links
 */
function MediaAttach_adminapi_getlinks()
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    $links = array();

    if (SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'main'),
                         'text' => __('Start', $dom),
                         'title' => __('Go the start page of MediaAttach admin section', $dom),
                         'id' => 'MediaAttach_start');
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'view'),
                         'text' => __('Admin uploads', $dom),
                         'title' => __('Upload and import admin files', $dom),
                         'id' => 'MediaAttach_adminuploads');
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'viewuploads'),
                         'text' => __('User uploads', $dom),
                         'title' => __('Management of user files', $dom),
                         'id' => 'MediaAttach_useruploads');
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'viewdefinitions'),
                         'text' => __('Definitions', $dom),
                         'title' => __('Manage module definitions', $dom),
                         'id' => 'MediaAttach_definitions');
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'viewformats'),
                         'text' => __('Formats', $dom),
                         'title' => __('File formats', $dom),
                         'id' => 'MediaAttach_formats');
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'viewgroups'),
                         'text' => __('Groups', $dom),
                         'title' => __('File format groups', $dom),
                         'id' => 'MediaAttach_groups');
        if (pnModGetVar('MediaAttach', 'usequota') == 1) {
            $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'viewquotas'),
                             'text' => __('Quotas', $dom),
                             'title' => __('Quotas', $dom),
                             'id' => 'MediaAttach_quotas');
        }
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'modifyconfig'),
                         'text' => __('Config', $dom),
                         'title' => __('The MediaAttach configuration', $dom),
                         'id' => 'MediaAttach_config');
    }

    $userlang = ZLanguage::getLanguageCode();
    if ($userlang != 'deu') {
        $userlang = 'eng';
    }

    $links[] = array('url' => 'modules/MediaAttach/pndocs/MediaAttach-Manual-' . $userlang . '.pdf',
                     'text' => __('Manual', $dom),
                     'title' => __('The worth to read pdf manual', $dom),
                     'id' => 'MediaAttach_manual');

    return $links;
}

/**
 * clean up files for a removed module
 *
 * @param    $args['extrainfo']   array extrainfo array
 * @return   array extrainfo array
 */
function MediaAttach_adminapi_removehook($args)
{
    // optional arguments
    if (!isset($args['extrainfo'])) {
        $args['extrainfo'] = array();
    }

    // When called via hooks, the module name may be empty, so we get it from
    // the current module
    if (empty($args['extrainfo']['module'])) {
        $modname = pnModGetName();
    } else {
        $modname = $args['extrainfo']['module'];
    }

    DBUtil::deleteWhere('ma_files', "pn_modname='" . $modname . "'");
    return $args['extrainfo'];
}
