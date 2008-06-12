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
 * Creates the given directory
 *
 * @param   string   directory      directory name
 * @return  bool                    true on success or false on failure
 */
function MediaAttach_filesystemapi_createdirectory($args) {
    if (!isset($args['directory'])) {
        return false;
    }

    $directory = realpath($args['directory']);
    unset($args);

    if (!file_exists($directory)) {
        $erg = mkdir($directory);
    }
    else {
        $erg = false;
    }
    return $erg;
}

