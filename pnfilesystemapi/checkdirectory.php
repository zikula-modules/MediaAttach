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


/*
 * Checks if the given directory exists and if it is writable
 *
 * @param   string   directory      directory name
 * @return  bool                    true on success or false on failure
 */
function MediaAttach_filesystemapi_checkdirectory($args) {
    if (!isset($args['directory'])) {
        return false;
    }

    $directory = realpath(DataUtil::formatForOS($args['directory'], true));
    unset($args);

    if (substr($directory, -1) != '/') {
        $directory .= '/';
    }

    if (is_array($directory)) {
        foreach($directory as $currentDirectory) {
            if (!file_exists($currentDirectory) || !is_dir($currentDirectory) || !is_writable($currentDirectory)) {
                return false;
            }
        }
    }
    else {
        if (!file_exists($directory) || !is_dir($directory) || !is_writable($directory)) {
            return false;
        }
    }
    return true;
}

