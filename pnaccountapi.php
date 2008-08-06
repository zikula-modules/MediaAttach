<?php
/**
 * MediaAttach
 *
 * @version      $Id: pnaccountapi.php 22 2008-02-23 09:30:43Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/*
 * ---------------------------------------------------------------------------------------------------------
 * Profile integration layer
 * ---------------------------------------------------------------------------------------------------------
 */

/**
 * Return an array of items to show in the your account panel
 *
 * @return   array   array of items, or false on failure
 */
function MediaAttach_accountapi_getall($args)
{
    unset($args);

    $items = array();

    $useAccountPage = pnModGetVar('MediaAttach', 'useaccountpage', '1');
    if ($useAccountPage) {
        // Create an array of links to return
        $items = array(array('url'     => pnModURL('MediaAttach', 'account', 'viewuploads'),
                            'module'  => 'MediaAttach',
                            'set'     => '',
                            'title'   => pnML(_MEDIAATTACH_MYUPLOADS),
                            'icon'    => 'profile_myuploads.png'));
    }

    // return the items
    return $items;
}
