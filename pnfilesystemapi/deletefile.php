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
 * Deletes a file
 *
 * @param   string   file           file name
 * @return  bool                    true on success or false on failure
 */
function MediaAttach_filesystemapi_deletefile($args) {
    if (!isset($args['file'])) {
        return false;
    }

    $file = realpath(DataUtil::formatForOS($args['file'], true));
    unset($args);

    return unlink($file);
}

