
<?php
/**
 * MediaAttach
 *
 * @version      $Id: MediaAttach_admin_modifyconfighandler.class.php 218 2007-08-10 11:41:45Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

Loader::requireOnce('modules/MediaAttach/common.php');


class MediaAttach_admin_modifyconfighandler extends Form_Handler
{
    var $id;

    function initialize(&$render)
    {
        $dom = ZLanguage::getModuleDomain('MediaAttach');
        $this->id = (int) FormUtil::getPassedValue('id', 0, 'GETPOST');
        $render->caching = false;
        $render->add_core_data();

        $render->assign('docroot', DataUtil::formatForDisplay(pnServerGetVar('DOCUMENT_ROOT')));

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

        $render->assign('cropsizemodeItems', array(array('text' => __('Enforce default size', $dom), 'value' => 0),
                                                   array('text' => __('Keep size variable and enforce aspect ratio', $dom), 'value' => 1),
                                                   array('text' => __('Keep size and aspect ratio variable', $dom),   'value' => 2)));
        $render->assign('cropsizemode', pnModGetVar('MediaAttach', 'cropsizemode'));

        $usedcatmodes = pnModGetVar('MediaAttach', 'usedcatmodes');
        $render->assign('cat_use_categories', ($usedcatmodes & MEDIAATTACH_CATMODE_CATEGORIES));
        $render->assign('cat_use_modules',    ($usedcatmodes & MEDIAATTACH_CATMODE_MODULES));
        $render->assign('cat_use_users',      ($usedcatmodes & MEDIAATTACH_CATMODE_USERS));

        $render->assign('catdefaultmodeItems', array(array('text' => __('No categorization', $dom),        'value' => MEDIAATTACH_CATMODE_NONE),
                                                     array('text' => __('Categories', $dom),  'value' => MEDIAATTACH_CATMODE_CATEGORIES),
                                                     array('text' => __('Modules', $dom),     'value' => MEDIAATTACH_CATMODE_MODULES),
                                                     array('text' => __('Users', $dom),       'value' => MEDIAATTACH_CATMODE_USERS)));
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
        $newestversion  = $currentversion;
        if (ini_get('allow_url_fopen') == '1') {
            $newestversion = file('http://guite.de/downloads/MediaAttach_version.txt');
            $newestversion = $newestversion[0];
        }
        $render->assign('yourversion', trim($currentversion));
        $render->assign('newestversion', trim($newestversion));

        return true;
    }


    function handleCommand(&$render, &$args)
    {
        $dom = ZLanguage::getModuleDomain('MediaAttach');
        if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
            return LogUtil::registerPermissionError();
        }

        if ($args['commandName'] == 'submit') {
            if (!$render->pnFormIsValid()) {
                return false;
            }
            $data = $render->pnFormGetValues();

            if (StringUtil::right($data['uploaddir'], 1) == '/') {
                $data['uploaddir'] = StringUtil::left($data['uploaddir'], strlen($data['uploaddir']) - 1);
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

            if (StringUtil::right($data['cachedir'], 1) == '/') {
                $data['cachedir'] = StringUtil::left($data['cachedir'], strlen($data['cachedir']) - 1);
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

            LogUtil::registerStatus(__('Done! Module configuration updated.', $dom));
            pnModCallHooks('module', 'updateconfig', 'MediaAttach', array('module' => 'MediaAttach'));
        }

        return true;
    }
}
