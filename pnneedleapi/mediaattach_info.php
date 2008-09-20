<?php
/**
 * MediaAttach: MultiHook needle information
 *
 * @version      $Id: mediaattach_info.php 22 2008-02-23 6:42:14Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * MediaAttach needle info
 * @param none
 * @return string with short usage description
 */
function MediaAttach_needleapi_mediaattach_info($args)
{
    $info = array('module'  => 'MediaAttach',
                  'info'    => 'MEDIAATTACH{P-fileid|I-fileid}',
                  'inspect' => false);
    return $info;
}
