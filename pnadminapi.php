<?php
/**
 * MediaAttach
 *
 * @version      $Id: pnadminapi.php 57 2008-03-02 08:54:43Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
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
    $links = array();

    pnModLangLoad('MediaAttach', 'admin');

    if (SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'main'),
                         'text' => _MEDIAATTACH_ADMINMAIN,
                         'title' => _MEDIAATTACH_ADMINTMAIN,
                         'id' => 'MediaAttach_start');
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'view'),
                         'text' => _MEDIAATTACH_ADMINADMINUPLOADS,
                         'title' => _MEDIAATTACH_ADMINTADMINUPLOADS,
                         'id' => 'MediaAttach_adminuploads');
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'viewuploads'),
                         'text' => _MEDIAATTACH_ADMINUSERUPLOADS,
                         'title' => _MEDIAATTACH_ADMINTUSERUPLOADS,
                         'id' => 'MediaAttach_useruploads');
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'viewdefinitions'),
                         'text' => _MEDIAATTACH_ADMINDEFINITIONS,
                         'title' => _MEDIAATTACH_ADMINTDEFINITIONS,
                         'id' => 'MediaAttach_definitions');
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'viewformats'),
                         'text' => _MEDIAATTACH_ADMINFORMATS,
                         'title' => _MEDIAATTACH_ADMINTFORMATS,
                         'id' => 'MediaAttach_formats');
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'viewgroups'),
                         'text' => _MEDIAATTACH_ADMINGROUPS,
                         'title' => _MEDIAATTACH_ADMINTGROUPS,
                         'id' => 'MediaAttach_groups');
        if (pnModGetVar('MediaAttach', 'usequota') == 1) {
            $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'viewquotas'),
                             'text' => _MEDIAATTACH_ADMINQUOTAS,
                             'title' => _MEDIAATTACH_ADMINTQUOTAS,
                             'id' => 'MediaAttach_quotas');
        }
        $links[] = array('url' => pnModURL('MediaAttach', 'admin', 'modifyconfig'),
                         'text' => _MEDIAATTACH_ADMINCONFIG,
                         'title' => _MEDIAATTACH_ADMINTCONFIG,
                         'id' => 'MediaAttach_config');
    }

    $userlang = pnUserGetLang();
    if ($userlang != 'deu') {
        $userlang = 'eng';
    }

    $links[] = array('url' => 'modules/MediaAttach/pndocs/MediaAttach-Manual-' . $userlang . '.pdf',
                     'text' => _MEDIAATTACH_ADMINMANUAL,
                     'title' => _MEDIAATTACH_ADMINTMANUAL,
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
