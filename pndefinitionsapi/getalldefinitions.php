<?php
/**
 * MediaAttach
 *
 * @version      $Id: $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * get all modules with their definitions
 *
 * @return   array   array of definitions, or false on failure
 */
function MediaAttach_definitionsapi_getalldefinitions()
{
    if (!SecurityUtil::checkPermission('MediaAttach::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $hookedMods = pnModAPIFunc('Modules', 'admin', 'gethookedmodules', array('hookmodname' => 'MediaAttach'));

    $definitions = array();
    foreach($hookedMods as $currentModule => $dummy) {
        $definitions[] = array('modname'      => $currentModule,
                               'state'        => '0',
                               'did'          => '',
                               'groups'       => '',
                               'displayfiles' => '',
                               'sendmails'    => '',
                               'recipient'    => '',
                               'maxsize'      => '',
                               'downloadmode' => '',
                               'naming'       => '',
                               'namingprefix' => '',
                               'numfiles'     => '');
    }


    $pntables = pnDBGetTables();
    $dcolumn = $pntables['ma_defs_column'];

    $numDefs = count($definitions);
    for ($i = 0; $i < $numDefs; $i++) {
        $where = "WHERE $dcolumn[modname] = '" . DataUtil::formatForStore($definitions[$i]['modname']) . "'";
        $dbdef = DBUtil::selectObjectArray('ma_defs', $where);

        if ($dbdef === false) {
            return LogUtil::registerError(_GETFAILED);
        }

        if ($dbdef) {
            $groups = pnModAPIFunc('MediaAttach', 'filetypes', 'getdefgroups', array('did' => $dbdef[0]['did']));
            $definitions[$i]['state'] = 1;
            $definitions[$i]['did'] = DataUtil::formatForDisplay($dbdef[0]['did']);
            $definitions[$i]['displayfiles'] = DataUtil::formatForDisplay($dbdef[0]['displayfiles']);
            $definitions[$i]['groups'] = $groups;
            $definitions[$i]['sendmails'] = DataUtil::formatForDisplay($dbdef[0]['sendmails']);
            $definitions[$i]['recipient'] = DataUtil::formatForDisplay($dbdef[0]['recipient']);
            $definitions[$i]['maxsize'] = DataUtil::formatForDisplay($dbdef[0]['maxsize']);
            $definitions[$i]['downloadmode'] = DataUtil::formatForDisplay($dbdef[0]['downloadmode']);
            $definitions[$i]['naming'] = DataUtil::formatForDisplay($dbdef[0]['naming']);
            $definitions[$i]['namingprefix'] = DataUtil::formatForDisplay($dbdef[0]['namingprefix']);
            $definitions[$i]['numfiles'] = DataUtil::formatForDisplay($dbdef[0]['numfiles']);
        }
    }

    return $definitions;
}

