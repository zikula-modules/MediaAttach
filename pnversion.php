<?php
/**
 * MediaAttach
 *
 * MediaAttach is a media API which provides upload capabilities and a file management suite.
 *
 * Purpose of file:  Provide version and credit information about the module
 *
 * @version      $Id: pnversion.php 1 2007-11-17 12:08:45Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2007 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


$modversion['name']           = _MEDIAATTACH_NAME;
$modversion['description']    = _MEDIAATTACH_DESCRIPTION;
$modversion['displayname']    = _MEDIAATTACH_DISPLAYNAME;
$modversion['version']        = '1.0';

$modversion['changelog']      = '';
$modversion['credits']        = 'pndocs/credits.txt';
$modversion['help']           = '';
$modversion['license']        = 'pndocs/license.txt';
$modversion['official']       = '0';
$modversion['author']         = 'Axel Guckelsberger';
$modversion['contact']        = 'http://guite.de/';

$modversion['admin']          = '1';
$modversion['securityschema'] = array('MediaAttach::'         => 'Module:Item ID:Upload ID',
                                      'MediaAttach:Category:' => 'CategoryID::');
