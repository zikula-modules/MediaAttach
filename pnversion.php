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

$dom = ZLanguage::getModuleDomain('MediaAttach');
$modversion['name']           = 'MediaAttach';
$modversion['description']    = __('Uploads and file management', $dom);
$modversion['displayname']    = __('MediaAttach', $dom);
$modversion['version']        = '1.1.1.0';
$modbversion['url']           = __('mediaattach', $dom);

$modversion['changelog']      = 'http://code.zikula.org/mediaattach/browser/trunk/MediaAttach/CHANGELOG';
$modversion['credits']        = 'pndocs/credits.txt';
$modversion['help']           = 'http://code.zikula.org/mediaattach';
$modversion['license']        = 'pndocs/license.txt';
$modversion['official']       = '0';
$modversion['author']         = 'Axel Guckelsberger';
$modversion['contact']        = 'http://guite.de/';

$modversion['admin']          = '1';
$modversion['securityschema'] = array('MediaAttach::'         => 'Module:Item ID:Upload ID',
                                      'MediaAttach:Category:' => 'CategoryID::');