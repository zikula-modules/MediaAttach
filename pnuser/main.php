<?php
/**
 * MediaAttach
 *
 * @version      $Id: main.php 114 2008-05-05 6:42:14Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * the main user function
 *
 * @return       output       The main user interface.
 */
function MediaAttach_user_main()
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }

    if (pnModGetVar('MediaAttach', 'usefrontpage') == 0) {
        return LogUtil::registerError(_MODULENODIRECTACCESS);
    }

    // Check that the upload and cache folders are Ok 
    $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');

    if (!pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => $uploaddir))
      || !pnModAPIFunc('MediaAttach', 'filesystem', 'checkdirectory', array('directory' => pnModGetVar('MediaAttach', 'cachedir')))) {
        return false;
    }

    // Main parameters processing
    $itemsperpage = (int) FormUtil::getPassedValue('itemsperpage', 20,       'GET');
    $startnum     = (int) FormUtil::getPassedValue('startnum',     0,       'GET');
    $sortby       =       FormUtil::getPassedValue('sortby',       'date',   'GET');
    $sortdir      =       FormUtil::getPassedValue('sortdir',      ($sortby == 'date') ? 'desc' : 'asc', 'GET');
    $preview      = (int) FormUtil::getPassedValue('preview',      0,        'GET');
    $onlyimages   = (int) FormUtil::getPassedValue('onlyimages',   0,        'GET');

    $formatFilter = ($onlyimages == 1) ? array('gif', 'jpg', 'jpeg', 'png') : '';

    $fetchArgs = array('startnum'     => $startnum,
                       'numitems'     => $itemsperpage,
                       'sortby'       => $sortby,
                       'sortdir'      => $sortdir,
                       'formatFilter' => $formatFilter);

    // Categorization processing
    $allCatModes = array(MEDIAATTACH_CATMODE_NONE, MEDIAATTACH_CATMODE_CATEGORIES, MEDIAATTACH_CATMODE_MODULES, MEDIAATTACH_CATMODE_USERS);
    $usedcatmodes = pnModGetVar('MediaAttach', 'usedcatmodes');
    $cat_use_categories = ($usedcatmodes & MEDIAATTACH_CATMODE_CATEGORIES);
    $cat_use_modules = ($usedcatmodes & MEDIAATTACH_CATMODE_MODULES);
    $cat_use_users = ($usedcatmodes & MEDIAATTACH_CATMODE_USERS);
    $catdefaultmode = pnModGetVar('MediaAttach', 'defaultcatmode');

    $cat_id = (int) SessionUtil::getVar('MediaAttach_cat_id', 0);
    $cat_id = (int) FormUtil::getPassedValue('cat_id', $cat_id, 'GET');

    $catmode     = (int) SessionUtil::getVar('MediaAttach_catmode', $catdefaultmode);
    $formCatMode = (int) FormUtil::getPassedValue('catmode', 999, 'GET');

    // Validate the categorization mode
    if (in_array($formCatMode, $allCatModes) && $formCatMode != $catmode) {
        // categorization mode was changed
        $catmode = $formCatMode;
        $cat_id  = 0;

    } elseif (!in_array($catmode, $allCatModes)) {
        // invalid categorization mode, fallback to default
        $catmode = $catdefaultmode;
    }

    // If the mode is using categories, get the property
    if ($catmode == MEDIAATTACH_CATMODE_CATEGORIES) {
        if (!($class = Loader::loadClass('CategoryRegistryUtil'))) {
            pn_exit (pnML('_UNABLETOLOADCLASS', array('s' => 'CategoryRegistryUtil')));
        }
        $cat_prop = (string) SessionUtil::getVar('MediaAttach_cat_prop', '');
        $cat_prop = (string) FormUtil::getPassedValue('cat_prop', $cat_prop, 'GET');
        $catRegistry = pnModAPIFunc('MediaAttach', 'cat', 'getCategoryTree');
        if ((empty($cat_prop) || !in_array($cat_prop, array_keys($catRegistry))) && !empty($cat_id)) {
            $cat_prop = '';
            $cat_id = 0;
        }
    } else {
        $cat_prop = '';
        $cat_id = 0;
    }

    // Store the last used values in the session
    SessionUtil::setVar('MediaAttach_catmode', $catmode);
    SessionUtil::setVar('MediaAttach_cat_id', $cat_id);
    SessionUtil::setVar('MediaAttach_cat_prop', $cat_prop);

    // Process the output
    $allCategories = array();
    $pagetitle = '';

    if ($catmode != MEDIAATTACH_CATMODE_NONE) {
        // fetch the files depending the categorization mode
        if ($cat_id > 0) {
            switch ($catmode) {
                case MEDIAATTACH_CATMODE_CATEGORIES:
                        // fetch files for category
                        if (!($class = Loader::loadClass('CategoryUtil'))) {
                            pn_exit (pnML('_UNABLETOLOADCLASS', array('s' => 'CategoryUtil')));
                        }
                        $currentlang = pnUserGetLang();
                        $category = CategoryUtil::getCategoryByID($cat_id);

                        // Check for an specific category template
                        $matemplate = pnModAPIFunc('MediaAttach', 'cat', 'getCategoryTemplate',
                                                   array('category' => $category,
                                                         'property' => $cat_prop));

                        // Get all the subcategories to include in the catFilter
                        $catstofilter = array();
                        $categories = CategoryUtil::getCategoriesByPath($category['path'], '', 'path');
                        $ak = array_keys($categories);
                        foreach ($ak as $key) {
                            $catstofilter[] = $categories[$key]['id'];
                        }
                        $pagetitle = (isset($category['display_name']) && isset($category['display_name'][$currentlang])) ? $category['display_name'][$currentlang] : $category['name'];

                        $fetchArgs['catFilter'] = array($cat_prop => $catstofilter);

                        break;

                case MEDIAATTACH_CATMODE_MODULES:
                        // fetch the files of an specific module 
                        $modInfo   = pnModGetInfo($cat_id);
                        $pagetitle = $modInfo['displayname'];

                        $fetchArgs['moduleFilter'] = $modInfo['name'];

                        break;

                case MEDIAATTACH_CATMODE_USERS:
                        // fetch the files of an specific user 
                        $pagetitle = pnUserGetVar('uname', $cat_id);

                        $fetchArgs['userFilter'] = $cat_id;

                        break;
            }
            $files = pnModAPIFunc('MediaAttach', 'user', 'getalluploads', $fetchArgs);

        } else {
            // fetch all the available categories depending the mode
            switch ($catmode) {
                case MEDIAATTACH_CATMODE_CATEGORIES:
                        $allCategories = pnModAPIFunc('MediaAttach', 'cat', 'getCategories');
                        $allCategories = pnModAPIFunc('MediaAttach', 'cat', 'orderCategories', array('categories' => $allCategories));
                        break;

                case MEDIAATTACH_CATMODE_MODULES:
                        $allCategories = pnModAPIFunc('MediaAttach', 'cat', 'getModules');
                        break;

                case MEDIAATTACH_CATMODE_USERS:
                        $allCategories = pnModAPIFunc('MediaAttach', 'cat', 'getUsers');
                        break;
            }
            $files = 0;
            //TODO: sorting of all the entries list
        }

    } else {
        // Without categorization, then list all the files
        $files = pnModAPIFunc('MediaAttach', 'user', 'getalluploads', $fetchArgs);
    }

    PageUtil::AddVar('stylesheet', ThemeUtil::getModuleStylesheet('MediaAttach'));

    $render = pnRender::getInstance('MediaAttach', false);
    // Categorization vars
    $render->assign('catmode',            $catmode);
    $render->assign('cat_use_categories', $cat_use_categories);
    $render->assign('cat_use_modules',    $cat_use_modules);
    $render->assign('cat_use_users',      $cat_use_users);
    $render->assign('categories',         $allCategories);
    $render->assign('cat_id',             $cat_id);
    $render->assign('cat_prop',           $cat_prop);

    // Main parameters
    $render->assign('pagetitle',          $pagetitle);
    $render->assign('sortby',             DataUtil::formatForDisplay($sortby));
    $render->assign('sortdir',            DataUtil::formatForDisplay($sortdir));
    $render->assign('itemsperpage',       $itemsperpage);
    $render->assign('preview',            $preview);
    $render->assign('onlyimages',         $onlyimages);

    if ($files) {
        // Add relevant display information
        $ownHandling = pnModGetVar('MediaAttach', 'ownhandling');
        $currentUser = pnUserGetVar('uid');
        $numFiles = count($files);
        for ($i = 0; $i < $numFiles; $i++) {
            $files[$i] = _maIntPrepFileForTemplate($files[$i], $currentUser, $ownHandling);
        }

        $thumbnr = (int) FormUtil::getPassedValue('thumbnr', 0, 'GET');
        if ($thumbnr == 0) {
            $thumbnr = pnModGetVar('MediaAttach', 'defaultthumb');
        }
        $render->assign('thumbnr', $thumbnr);

        // Assign the category customized template if exists
        if (isset($matemplate) && $render->template_exists($matemplate)) {
            $render->assign('matemplate', $matemplate);
        } else {
            $render->assign('matemplate', 0);
        }

        // Assign the files information to the template
        $render->assign('files', $files);
        $render->assign('pager', array('numitems'     => pnModAPIFunc('MediaAttach', 'user', 'countuploads', $fetchArgs),
                                       'itemsperpage' => $itemsperpage));

        $definition = array('displayfiles' => 2, // show all files
                            'sendmails' => 0,
                            'downloadmode' => $preview);
        $render->assign('definition', $definition);
    }

    return $render->fetch('MediaAttach_user_main.htm');
}
