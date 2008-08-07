<?php
/**
 * MediaAttach
 *
 * @version      $Id: $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * returns dirs and files of a given directory
 *
 * @param    directory     string   directory name
 * @return   array         folder content
 */
function MediaAttach_filesystemapi_readdirectory($args) {
    if (!isset($args['directory'])) {
        return false;
    }

    $directory = realpath(DataUtil::formatForOS($args['directory'], true));
    unset($args);

    $dirs = array();
    $files = array();
    if (is_dir($directory) && $dirHandle = opendir($directory)) {
        while (false !== ($file = readdir($dirHandle))) {
            $fpath = $directory . '/' . $file;
            if (is_dir($fpath)) {
                $dirs[] = $file;
            }
            else if (!is_link($fpath) && is_file($fpath)) {
                $files[] = array('filename' => $file,
                                 'filepath' => $fpath,
                                 'filesize' => filesize($fpath));
            }
        }
        closedir($dirHandle);

        sort($dirs);
        sort($files);
    }
    return array($dirs, $files);
}
