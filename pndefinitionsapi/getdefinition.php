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
 * get a specific definition
 *
 * @param    did        int     id of definition to get
 * @return   array      definition array
 */
function MediaAttach_definitionsapi_getdefinition($args)
{
    $dom = ZLanguage::getModuleDomain('MediaAttach');
    if (!isset($args['did']) || !is_numeric($args['did'])) {
        return LogUtil::registerError(__('Error! Could not do what you wanted. Please check your input.', $dom));
    }

    $did = $args['did'];
    unset($args);

    $definition = DBUtil::selectObjectByID('ma_defs', $did, 'did');
    return DataUtil::formatForDisplay($definition);
}

