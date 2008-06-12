<?php
/**
 * MediaAttach
 *
 * @version      $Id: pnsearchapi.php 76 2008-03-05 5:43:16Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * Search plugin info
 **/
function MediaAttach_searchapi_info()
{
    return array('title'     => 'MediaAttach',
                 'functions' => array('MediaAttach' => 'search'));
}

/**
 * Search form component
 **/
function MediaAttach_searchapi_options($args)
{
    if (SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_READ)) {
        $render = pnRender::getInstance('MediaAttach');
        $render->assign('active', (isset($args['active']) && isset($args['active']['MediaAttach'])) || !isset($args['active']));
        return $render->fetch('MediaAttach_search.htm');
    }

    return '';
}


/**
 * Search plugin main function
 **/
function MediaAttach_searchapi_search($args)
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_READ)) {
        return true;
    }

    pnModDBInfoLoad('Search');
    $pntable      = pnDBGetTables();
    $filestable   = $pntable['ma_files'];
    $filescolumn  = $pntable['ma_files_column'];
    $searchTable  = $pntable['search_result'];
    $searchColumn = $pntable['search_result_column'];

    $where = search_construct_where($args,
                                    array($filescolumn['title'],
                                          $filescolumn['desc']));

    // exclude admin files
    $where .= ' AND ' . $filescolumn['modname'] . " != 'MediaAttach'"
            . ' AND ' . $filescolumn['objectid'] . " < 99999999";

    $sql = 'SELECT ' . $filescolumn['fileid'] . ' AS fileid, '
                     . $filescolumn['modname'] . ' AS modname, '
                     . $filescolumn['objectid'] . ' AS objectid,'
                     . $filescolumn['date'] . ' AS filedate,'
                     . $filescolumn['title'] . ' AS title, '
                     . $filescolumn['desc'] . ' AS text, '
                     . $filescolumn['url'] . ' AS url'
         . ' FROM ' . $filestable . ' WHERE ' . $where;

    $result = DBUtil::executeSQL($sql);
    if (!$result) {
        return LogUtil::registerError (_GETFAILED);
    }

    $sessionId = session_id();

    $insertSql = 'INSERT INTO ' . $searchTable . '('
                . $searchColumn['title'] . ','
                . $searchColumn['text'] . ','
                . $searchColumn['extra'] . ','
                . $searchColumn['module'] . ','
                . $searchColumn['created'] . ','
                . $searchColumn['session']
                . ') VALUES ';

    // Process the result set and insert into search result table
    for (; !$result->EOF; $result->MoveNext()) {
        $file = $result->GetRowAssoc(2);

        if (SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$file[fileid]", ACCESS_OVERVIEW)) {
            $sql = $insertSql . '('
                   . '\'' . DataUtil::formatForStore($file['title']) . '\', '
                   . '\'' . DataUtil::formatForStore($file['text']) . '\', '
                   . '\'' . DataUtil::formatForStore($file['url']) . '\', '
                   . '\'' . 'MediaAttach' . '\', '
                   . '\'' . DataUtil::formatForStore($file['filedate']) . '\', '
                   . '\'' . DataUtil::formatForStore($sessionId) . '\')';

            $insertResult = DBUtil::executeSQL($sql);
            if (!$insertResult) {
                return LogUtil::registerError (_GETFAILED);
            }
        }
    }

    return true;
}

/**
 * Do last minute access checking and assign URL to items
 */
function MediaAttach_searchapi_search_check(&$args)
{
    $datarow = &$args['datarow'];

    $datarow['url'] = $datarow['extra'];

    return true;
}
