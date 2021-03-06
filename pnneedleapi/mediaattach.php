<?php
/**
 * MediaAttach: MultiHook needle implementation
 *
 * @version      $Id: mediaattach.php 114 2008-05-05 6:24:14Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * replace a given MediaAttach needle
 * @param  nid      int   needle id
 * @return string   replaced value for the needle
 */
function MediaAttach_needleapi_mediaattach($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    // Get arguments from argument array
    $nid = $args['nid'];
    unset($args);

    // cache the results
    static $cache;
    if (!isset($cache)) {
        $cache = array();
    }

    if (!empty($nid)) {
        if(!isset($cache[$nid])) {
            // not in cache array

            if(!pnModAvailable('MediaAttach')) {
                $cache[$nid] = '<em>' . DataUtil::formatForDisplay(__('Sorry! The MediaAttach module is not available.',$dom)) . '</em>';
            }

            $result = '<em title="' . DataUtil::formatForDisplay(sprintf(_MH_NEEDLEDATAERROR, $nid, 'MediaAttach')) . '">MEDIAATTACH' . $nid . '</em>';

            //set default type
            $type = 'P';
            //nid is like type_fileid whereas type is P for physical or I for inline display
            $temp = explode('-', $nid);
            if (is_array($temp) && count($temp) >= 2) {
                $type = $temp[0];
                $fileid = (int) $temp[1];
            }

            $file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid));
            if ($file === false) {
                $cache[$nid] = '<em>Unknown item (' . $nid . ')</em>';

            } elseif (!SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$fileid", ACCESS_READ)) {
                $cache[$nid] = '';

            } else {
                // set a flag to clarify that this is a hook call
                $file['definition']['hookcall'] = true;

                $render = & pnRender::getInstance('MediaAttach', false);

                $definition = array('displayfiles' => $file['defdisplayfiles'],
                                    'sendmails'    => $file['defsendmails'],
                                    'downloadmode' => $file['defdownloadmode'],
                                    'recipient'    => $file['defrecipient'],
                                    'maxsize'      => $file['defmaxsize'],
                                    'naming'       => $file['defnaming'],
                                    'namingprefix' => $file['defnamingprefix'],
                                    'numfiles'     => $file['defnumfiles'],
                                    'hookcall'     => true);
                $render->assign('definition', $definition);

                $render->assign('currentuser', pnUserGetVar('uid'));
                $render->assign('file', $file);

                $templateset = ($type == 'I') ? 'inlinelist' : 'filelist';
                $cache[$nid] = $render->fetch(_maIntChooseTemplate($render, 'user', $templateset . '_single', $file['modname']));
            }
        }
        $result = $cache[$nid];

    } else {
        $result = '<em>' . __('No correct needle id given') . '</em>';
    }

    return $result;
}
