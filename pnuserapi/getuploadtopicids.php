<?php
/**
 * MediaAttach
 *
 * @version      $Id: getuploadtopicids.php 22 2008-02-23 21:30:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * this method determines if uploads are existing for all entries in a given topic array (Dizkus)
 *
 * @param    topics       array        the topics
 * @return   array        array('id' => boolean) showing which object has uploads
 */
function MediaAttach_userapi_getuploadtopicids($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!isset($args['topics']) || !is_array($args['topics'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    if (!SecurityUtil::checkPermission('MediaAttach::', 'Dizkus::', ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }

    $topicstates = array();
    foreach ($args['topics'] as $topic) {
        $topicstates[$topic['topic_id']] = false;
    }
    unset($args);


    $pntables    = pnDBGetTables();
    $filescolumn = $pntables['ma_files_column'];

    $where     = "$filescolumn[modname] = 'Dizkus' AND $filescolumn[objectid] IN (";
    $firstOver = false;
    foreach ($topicstates as $topicid => $state) {
        if ($firstOver) $where .= ', ';
        $where .= DataUtil::formatForStore($topicid);
        if (!$firstOver) $firstOver = true;
    }
    $where .= ')';

    $result = DBUtil::selectObjectArray('ma_files', $where);

    if ($result === false) {
        return false;
    }

    foreach ($result as $file) {
        $topicstates[$file['objectid']] = true;
    }

    return $topicstates;
}
