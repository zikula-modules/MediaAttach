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
 * get definition of the current module
 *
 * @param    modname   string    Name of the module to get upload definition for
 * @return   array     the definition or false on failure
 */
function MediaAttach_definitionsapi_getmoduledefinition($args)
{
    if (!isset($args['modname'])) {
        return LogUtil::registerError(_MODARGSERROR);
    }

    $modname = $args['modname'];
    unset($args);

    $pntables = pnDBGetTables();
    $defcolumn = $pntables['ma_defs_column'];
    $where = "WHERE $defcolumn[modname] = '" . DataUtil::formatForStore($modname) . "'";
    $def = DBUtil::selectObjectArray('ma_defs', $where);

    if ($def === false) {
        return LogUtil::registerError(_GETFAILED);
    }

    $definition = array('state' => '0', 'numfiles' => '1');
    if ($def) {
        $groups = pnModAPIFunc('MediaAttach', 'filetypes', 'getdefgroups', array('did' => $def[0]['did']));

        $numGroups = count($groups);
        $formats = array();
        $allformats = array();
        for ($i = 0; $i < $numGroups; $i++) {
            $currentformats = pnModAPIFunc('MediaAttach', 'filetypes', 'getgroupformats', array('gid' => $groups[$i]['gid']));
            $allformats = array_merge($allformats, $currentformats);
        }

        usort($allformats, 'sortbyextension');

        $numFormats = count($allformats);
        for ($i = 0; $i < $numFormats; $i++) {
            if ($i > 0) {
                if ($allformats[$i]['extension'] != $allformats[$i - 1]['extension']) {
                    array_push($formats, $allformats[$i]);
                }
            }
            else {
                array_push($formats, $allformats[$i]);
            }
        }

        $definition = array(
               'state'         => '1',
               'did'           => DataUtil::formatForDisplay($def[0]['did']),
               'groups'        => $groups,
               'formats'       => $formats,
               'displayfiles'  => DataUtil::formatForDisplay($def[0]['displayfiles']),
               'sendmails'     => DataUtil::formatForDisplay($def[0]['sendmails']),
               'recipient'     => DataUtil::formatForDisplay($def[0]['recipient']),
               'maxsize'       => DataUtil::formatForDisplay($def[0]['maxsize']),
               'downloadmode'  => DataUtil::formatForDisplay($def[0]['downloadmode']),
               'naming'        => DataUtil::formatForDisplay($def[0]['naming']),
               'namingprefix'  => DataUtil::formatForDisplay($def[0]['namingprefix']),
               'numfiles'      => DataUtil::formatForDisplay($def[0]['numfiles']));
    }

    return $definition;
}

function sortbyextension($a, $b) {
    return strnatcasecmp($a['extension'], $b['extension']);
}

