<?php
/**
 * MediaAttach
 *
 * @version      $Id: pntables.php 39 2007-03-01 2:32:16Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2007 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * Populate pntables array for MediaAttach
 *
 * @return       array       The table information.
 */
function MediaAttach_pntables()
{
    $pntable = array();

    $dbdriver = DBConnectionStack::getConnectionDBDriver();


    // Formats table
    $pntable['ma_formats'] = DBUtil::getLimitedTablename('mediaattach_formats');

    $pntable['ma_formats_column'] = array('fid'            => 'pn_fid',
                                          'extension'      => 'pn_extension',
                                          'image'          => 'pn_image');

    $pntable['ma_formats_column_def'] = array('fid'        => "I AUTO PRIMARY",
                                              'extension'  => "C(10) NOTNULL DEFAULT ''",
                                              'image'      => "C(40) NOTNULL DEFAULT ''");

    $pntable['ma_formats_column_idx'] = array('extension' => array('extension'));

    $pntable['ma_formats_primary_key_column'] = 'fid';

    ObjectUtil::addStandardFieldsToTableDefinition($pntable['ma_formats_column'], 'pn_');
    ObjectUtil::addStandardFieldsToTableDataDefinition($pntable['ma_formats_column_def'], 'pn_');


    // Groups table
    $pntable['ma_groups'] = DBUtil::getLimitedTablename('mediaattach_groups');

    $pntable['ma_groups_column'] = array('gid'             => 'pn_gid',
                                         'groupname'       => 'pn_groupname',
                                         'directory'       => 'pn_directory',
                                         'image'           => 'pn_image');

    $pntable['ma_groups_column_def'] = array('gid'         => "I      AUTO PRIMARY",
                                             'groupname'   => "C(100) NOTNULL DEFAULT ''",
                                             'directory'   => "C(255) NOTNULL DEFAULT ''",
                                             'image'       => "C(40)  NOTNULL DEFAULT ''");

    $pntable['ma_groups_column_idx'] = array('groupname' => array('groupname'));

    $pntable['ma_groups_primary_key_column'] = 'gid';

    ObjectUtil::addStandardFieldsToTableDefinition($pntable['ma_groups_column'], 'pn_');
    ObjectUtil::addStandardFieldsToTableDataDefinition($pntable['ma_groups_column_def'], 'pn_');


    // Format groups table
    $pntable['ma_formatgroups'] = DBUtil::getLimitedTablename('mediaattach_formatgroups');

    $pntable['ma_formatgroups_column'] = array('fid'       => 'pn_fid',
                                               'gid'       => 'pn_gid');

    $pntable['ma_formatgroups_column_def'] = array('fid'   => "I      NOTNULL DEFAULT 0",
                                                   'gid'   => "I      NOTNULL DEFAULT 0");

    $pntable['ma_formatgroups_column_idx'] = array('fid_gid' => array('fid', 'gid'));


    // Definitions table
    $pntable['ma_defs'] = DBUtil::getLimitedTablename('mediaattach_definitions');

    $pntable['ma_defs_column'] = array('did'               => 'pn_did',
                                       'modname'           => 'pn_modname',
                                       'displayfiles'      => 'pn_displayfiles',
                                       'sendmails'         => 'pn_sendmails',
                                       'recipient'         => 'pn_recipient',
                                       'maxsize'           => 'pn_maxsize',
                                       'downloadmode'      => 'pn_downloadmode',
                                       'naming'            => 'pn_naming',
                                       'namingprefix'      => 'pn_namingprefix',
                                       'numfiles'          => 'pn_numfiles');

    $pntable['ma_defs_column_def'] = array('did'           => "I      AUTO PRIMARY",
                                           'modname'       => "C(64)  NOTNULL DEFAULT ''",
                                           'displayfiles'  => "L      NOTNULL DEFAULT 0",
                                           'sendmails'     => "L      NOTNULL DEFAULT 0",
                                           'recipient'     => "C(100) NOTNULL DEFAULT ''",
                                           'maxsize'       => "I      NOTNULL DEFAULT 0",
                                           'downloadmode'  => "L      NOTNULL DEFAULT 0",
                                           'naming'        => "L      NOTNULL DEFAULT 0",
                                           'namingprefix'  => "C(40)  NOTNULL DEFAULT ''",
                                           'numfiles'      => "L      NOTNULL DEFAULT 1");

    $pntable['ma_defs_column_idx'] = array('modname' => array('modname'));

    $pntable['ma_defs_primary_key_column'] = 'did';

    ObjectUtil::addStandardFieldsToTableDefinition($pntable['ma_defs_column'], 'pn_');
    ObjectUtil::addStandardFieldsToTableDataDefinition($pntable['ma_defs_column_def'], 'pn_');


    // Definition groups table
    $pntable['ma_defgroups'] = DBUtil::getLimitedTablename('mediaattach_defgroups');

    $pntable['ma_defgroups_column'] = array('did'          => 'pn_did',
                                            'gid'          => 'pn_gid');

    $pntable['ma_defgroups_column_def'] = array('did'      => "I      NOTNULL DEFAULT 0",
                                                'gid'      => "I      NOTNULL DEFAULT 0");

    $pntable['ma_defgroups_column_idx'] = array('did_gid' => array('did', 'gid'));


    // Files table
    $pntable['ma_files'] = DBUtil::getLimitedTablename('mediaattach_files');

    $pntable['ma_files_column'] = array('fileid'           => 'pn_fileid',
                                        'definition'       => 'pn_definition',
                                        'modname'          => 'pn_modname',
                                        'objectid'         => 'pn_objectid',
                                        'uid'              => 'pn_uid',
                                        'date'             => 'pn_date',
                                        'title'            => 'pn_title',
                                        'desc'             => 'pn_desc',
                                        'extension'        => 'pn_extension',
                                        'mimetype'         => 'pn_mimetype',
                                        'filename'         => 'pn_filename',
                                        'filesize'         => 'pn_filesize',
                                        'dlcount'          => 'pn_dlcount',
                                        'url'              => 'pn_url');

    $pntable['ma_files_column_def'] = array('fileid'       => "I      AUTO PRIMARY",
                                            'definition'   => "I      NOTNULL DEFAULT 0",
                                            'modname'      => "C(64)  NOTNULL DEFAULT ''",
                                            'objectid'     => "C(10)  NOTNULL DEFAULT ''",
                                            'uid'          => "I      NOTNULL DEFAULT 0",
                                            'date'         => "T      NOTNULL DEFAULT 0",
                                            'title'        => "C(32)  NOTNULL DEFAULT ''",
                                            'desc'         => "X      NOTNULL DEFAULT ''",
                                            'extension'    => "C(10)  NOTNULL DEFAULT ''",
                                            'mimetype'     => "C(100) NOTNULL DEFAULT ''",
                                            'filename'     => "C(255) NOTNULL DEFAULT ''",
                                            'filesize'     => "I(11)  NOTNULL DEFAULT 0",
                                            'dlcount'      => "I      NOTNULL DEFAULT 0",
                                            'url'          => "C(255) NOTNULL DEFAULT ''");

    $pntable['ma_files_column_idx'] = array('modname_objectid' => array('modname', 'objectid'));

    $pntable['ma_files_primary_key_column'] = 'fileid';

    $pntable['ma_files_db_extra_enable_categorization'] = true;

    ObjectUtil::addStandardFieldsToTableDefinition($pntable['ma_files_column'], 'pn_');
    ObjectUtil::addStandardFieldsToTableDataDefinition($pntable['ma_files_column_def'], 'pn_');


    // Quotas table
    $pntable['ma_quotas'] = DBUtil::getLimitedTablename('mediaattach_quotas');

    $pntable['ma_quotas_column'] = array('qid'             => 'pn_qid',
                                         'qtype'           => 'pn_qtype',
                                         'qguid'           => 'pn_qguid',
                                         'qamount'         => 'pn_qamount');

    $pntable['ma_quotas_column_def'] = array('qid'         => "I      AUTO PRIMARY",
                                             'qtype'       => "L      NOTNULL DEFAULT 0",
                                             'qguid'       => "I      NOTNULL DEFAULT 0",
                                             'qamount'     => "I8     NOTNULL DEFAULT 0");

    $pntable['ma_quotas_column_idx'] = array('qtype' => array('qtype'));

    $pntable['ma_quotas_primary_key_column'] = 'qid';

    ObjectUtil::addStandardFieldsToTableDefinition($pntable['ma_quotas_column'], 'pn_');
    ObjectUtil::addStandardFieldsToTableDataDefinition($pntable['ma_quotas_column_def'], 'pn_');


    return $pntable;
}
