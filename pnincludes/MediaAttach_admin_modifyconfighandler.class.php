<?php
/**
 * MediaAttach
 *
 * @version      $Id: MediaAttach_admin_modifyconfighandler.class.php 218 2007-08-10 11:41:45Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

Loader::requireOnce('modules/MediaAttach/common.php');


class MediaAttach_admin_modifyconfighandler
{
    var $id;

    function initialize(&$render)
    {
        $this->id = (int) FormUtil::getPassedValue('id', 0, 'GETPOST');
        $render->caching = false;
        $render->add_core_data();

        $render->assign('docroot', DataUtil::formatForDisplay(getenv('DOCUMENT_ROOT')));

        $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');
        if (file_exists($uploaddir . '/')) {
            $render->assign('updirexists', '1');
            if (is_dir($uploaddir . '/')) {
                $render->assign('updirisdir', '1');
                if (is_writable($uploaddir . '/')) {
                    $render->assign('updiriswritable', '1');
                    $render->assign('htaccessexists', file_exists($uploaddir . '/.htaccess') ? '1' : '0');
                }
                else {
                    $render->assign('updiriswritable', '0');
                }
            }
            else $render->assign('updirisdir', '0');
        }
        else $render->assign('updirexists', '0');

        $cachedir = pnModGetVar('MediaAttach', 'cachedir');
        if (file_exists($cachedir . '/')) {
            $render->assign('cachedirexists', '1');
            if (is_dir($cachedir . '/')) {
                $render->assign('cachedirisdir', '1');
                $render->assign('cachediriswritable', (is_writable($cachedir . '/')) ? '1' : '0');
            }
            else $render->assign('cachedirisdir', '0');
        }
        else $render->assign('cachedirexists', '0');

        $render->assign('thumbsizes', pnModGetVar('MediaAttach', 'thumbsizes'));
        $render->assign('defaultthumb', pnModGetVar('MediaAttach', 'defaultthumb'));

        $render->assign('cropsizemodeItems', array(array('text' => _MEDIAATTACH_USECROPFIXEDSIZE, 'value' => 0),
                                                   array('text' => _MEDIAATTACH_USECROPVARSIZEAR, 'value' => 1),
                                                   array('text' => _MEDIAATTACH_USECROPVARSIZE,   'value' => 2)));
        $render->assign('cropsizemode', pnModGetVar('MediaAttach', 'cropsizemode'));

        $usedcatmodes = pnModGetVar('MediaAttach', 'usedcatmodes');
        $render->assign('cat_use_categories', ($usedcatmodes & MEDIAATTACH_CATMODE_CATEGORIES));
        $render->assign('cat_use_modules',    ($usedcatmodes & MEDIAATTACH_CATMODE_MODULES));
        $render->assign('cat_use_users',      ($usedcatmodes & MEDIAATTACH_CATMODE_USERS));

        $render->assign('catdefaultmodeItems', array(array('text' => _MEDIAATTACH_CATDEFAULTMODENONE,        'value' => MEDIAATTACH_CATMODE_NONE),
                                                     array('text' => _MEDIAATTACH_CATDEFAULTMODECATEGORIES,  'value' => MEDIAATTACH_CATMODE_CATEGORIES),
                                                     array('text' => _MEDIAATTACH_CATDEFAULTMODEMODULES,     'value' => MEDIAATTACH_CATMODE_MODULES),
                                                     array('text' => _MEDIAATTACH_CATDEFAULTMODEUSERS,       'value' => MEDIAATTACH_CATMODE_USERS)));
        $render->assign('catdefaultmode', pnModGetVar('MediaAttach', 'defaultcatmode'));

        $render->assign('mediaattachdir',      DataUtil::formatForDisplay(str_replace('/pnincludes', '', dirname(__FILE__))));
        $render->assign('open_basedir',        DataUtil::formatForDisplay(ini_get('open_basedir')));
        $render->assign('file_uploads',        DataUtil::formatForDisplay(ini_get('file_uploads')));
        $render->assign('upload_max_filesize', DataUtil::formatForDisplay(ini_get('upload_max_filesize')));
        $render->assign('upload_tmp_dir',      DataUtil::formatForDisplay(ini_get('upload_tmp_dir')));
        $render->assign('post_max_size',       DataUtil::formatForDisplay(ini_get('post_max_size')));
        $render->assign('max_input_time',      DataUtil::formatForDisplay(ini_get('max_input_time')));
        $render->assign('mailer',              DataUtil::formatForDisplay(pnModAvailable('Mailer')));
        $render->assign('maxmailsize',         DataUtil::formatForDisplay(((int) pnModGetVar('MediaAttach', 'maxmailsize')) / 1024));

        $currentversion = pnModGetInfo(pnModGetIDFromName('MediaAttach'));
        $currentversion = $currentversion['version'];
        $newestversion = file('http://guite.de/downloads/MediaAttach_version.txt');
        $render->assign('yourversion', trim($currentversion));
        $render->assign('newestversion', trim($newestversion[0]));

        return true;
    }


    function handleCommand(&$render, &$args)
    {
        if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
            return LogUtil::registerPermissionError();
        }

        if ($args['commandName'] == 'submit') {
            if (!$render->pnFormIsValid()) {
                return false;
            }
            $data = $render->pnFormGetValues();

            if (substr($data['uploaddir'], -1) == '/') {
                $data['uploaddir'] = substr($data['uploaddir'], 0, strlen($data['uploaddir']) - 1);
            }
            pnModSetVar('MediaAttach', 'uploaddir', $data['uploaddir']);
            $uploaddir = $data['uploaddir'];
            if (file_exists($uploaddir . '/')) {
                $render->assign('updirexists', '1');
                if (is_dir($uploaddir . '/')) {
                    $render->assign('updirisdir', '1');
                    if (is_writable($uploaddir . '/')) {
                        $render->assign('updiriswritable', '1');
                        $render->assign('htaccessexists', file_exists($uploaddir . '/.htaccess') ? '1' : '0');
                    }
                    else {
                        $render->assign('updiriswritable', '0');
                    }
                }
                else $render->assign('updirisdir', '0');
            }
            else $render->assign('updirexists', '0');

            if (substr($data['cachedir'], -1) == '/') {
                $data['cachedir'] = substr($data['cachedir'], 0, strlen($data['cachedir']) - 1);
            }
            pnModSetVar('MediaAttach', 'cachedir', $data['cachedir']);
            $cachedir = $data['cachedir'];
            if (file_exists($cachedir . '/')) {
                $render->assign('cachedirexists', '1');
                if (is_dir($cachedir . '/')) {
                    $render->assign('cachedirisdir', '1');
                    $render->assign('cachediriswritable', (is_writable($cachedir . '/')) ? '1' : '0');
                }
                else $render->assign('cachedirisdir', '0');
            }
            else $render->assign('cachedirexists', '0');

            pnModSetVar('MediaAttach', 'mailfiles', $data['mailfiles']);
            pnModSetVar('MediaAttach', 'maxmailsize', $data['maxmailsize'] * 1024);
            pnModSetVar('MediaAttach', 'usequota', $data['usequota']);
            pnModSetVar('MediaAttach', 'ownhandling', $data['ownhandling']);
            pnModSetVar('MediaAttach', 'usefrontpage', $data['usefrontpage']);
            pnModSetVar('MediaAttach', 'useaccountpage', $data['useaccountpage']);

            $thumbsizes = Array();
            $i = 1;
            while (!empty($data['thumb' . $i . 'width']) && !empty($data['thumb' . $i . 'height'])
                && is_numeric($data['thumb' . $i . 'width']) && is_numeric($data['thumb' . $i . 'width'])) {
                $thumbsizes[] = Array($data['thumb' . $i . 'width'], $data['thumb' . $i . 'height']);
                $i++;
            }

            pnModSetVar('MediaAttach', 'thumbsizes', $thumbsizes);
            $render->assign('thumbsizes', $thumbsizes);
            pnModSetVar('MediaAttach', 'defaultthumb', $data['defaultthumb']);

            pnModSetVar('MediaAttach', 'usethumbcropper', $data['usethumbcropper']);
            pnModSetVar('MediaAttach', 'cropsizemode', $data['cropsizemode']);
            pnModSetVar('MediaAttach', 'shrinkimages', $data['shrinkimages']);
            pnModSetVar('MediaAttach', 'shrinkwidth',  $data['shrinkwidth']);
            pnModSetVar('MediaAttach', 'shrinkheight', $data['shrinkheight']);

            $usedcatmodes = 0;
            if ($data['catmodecategories']) $usedcatmodes += MEDIAATTACH_CATMODE_CATEGORIES;
            if ($data['catmodemodules'])    $usedcatmodes += MEDIAATTACH_CATMODE_MODULES;
            if ($data['catmodeusers'])      $usedcatmodes += MEDIAATTACH_CATMODE_USERS;
            pnModSetVar('MediaAttach', 'usedcatmodes', $usedcatmodes);
            pnModSetVar('MediaAttach', 'defaultcatmode', $data['catdefaultmode']);

            LogUtil::registerStatus(_CONFIGUPDATED);
            pnModCallHooks('module', 'updateconfig', 'MediaAttach', array('module' => 'MediaAttach'));
        }

        return true;
    }
}
