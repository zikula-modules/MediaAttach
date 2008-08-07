<?php
/**
 * MediaAttach
 *
 * @version      $Id: torrent.php 37 2008-02-29 20:39:48Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


Loader::requireOnce('modules/MediaAttach/common.php');
Loader::requireOnce('modules/MediaAttach/pnincludes/File_Bittorrent2/Exception.php');
Loader::requireOnce('modules/MediaAttach/pnincludes/File_Bittorrent2/Encode.php');
Loader::requireOnce('modules/MediaAttach/pnincludes/File_Bittorrent2/MakeTorrent.php');

/**
 * display data of an upload
 *
 * @param    fileid      int     upload id to display data for
 * @return   output      the data
 */
function MediaAttach_user_torrent($args)
{
    $fileid = (int) FormUtil::getPassedValue('fileid', (isset($args['fileid'])) ? $args['fileid'] : 0, 'GET');
    unset($args);

    if (!($file = pnModAPIFunc('MediaAttach', 'user', 'getupload', array('fileid' => $fileid)))) {
        return LogUtil::registerError(_GETFAILED);
    }

    if (!SecurityUtil::checkPermission('MediaAttach::', "$file[modname]:$file[objectid]:$fileid", ACCESS_READ)) {
        return LogUtil::registerPermissionError();
    }

    //special check for pnForum: has current user access to topic the upload belongs to?
    if ($file['modname'] == 'pnForum') {
        if (!pnModAPIFunc('pnForum', 'user', 'gettopicreadpermission', array('topic_id' => $file['objectid']))) {
            return LogUtil::registerPermissionError();
        }
    }

    $uploaddir = pnModGetVar('MediaAttach', 'uploaddir');
    $fullfilename = $uploaddir . '/' . $file['filename'];

    $cachedir = pnModGetVar('MediaAttach', 'cachedir');
    $cachedir = str_replace(getenv('DOCUMENT_ROOT'), '', $cachedir);
    if (substr($cachedir, 0, 1) == '/') {
        $cachedir = substr($cachedir, 1, strlen($cachedir)-1);
    }

    $torrentFile = $cachedir . '/' . md5($fullfilename) . '.torrent';

    if (!file_exists($torrentFile)) {
        $MakeTorrent = new File_Bittorrent2_MakeTorrent($fullfilename);

        // Set the announce URL
        $MakeTorrent->setAnnounce(pnGetBaseURL());
        // Set the comment
        $MakeTorrent->setComment($file['title'] . ': ' . $file['description']);
        // Set the piece length (in KB)
        $MakeTorrent->setPieceLength(256);
        // Build the torrent
        $metainfo = $MakeTorrent->buildTorrent();

        Loader::loadClass('FileUtil');
        FileUtil::writeFile($torrentFile, $metainfo);
    }

    header("Content-type: application/x-bittorrent");
    header("Content-Disposition: attachment; filename=" . $torrentFile . ";");
    header("Content-Transfer-Encoding: binary");
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public", false);
    header("Content-Description: File Transfer");

    Loader::loadClass('FileUtil');
    $data = FileUtil::readFile($torrentFile/*, true*/);

    echo $data;

    return true;
}
