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
 * Returns the content of a file
 *
 * @param   string   file        file name
 * @return  mixed                file content
 */
function MediaAttach_filesystemapi_readfile($args) {
    if (!isset($args['file'])) {
        return false;
    }

    $file = realpath($args['file']);
    unset($args);

    return file_get_contents($file);
}

