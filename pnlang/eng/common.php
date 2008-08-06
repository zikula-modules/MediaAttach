<?php
// $Id: common.php 223 2007-08-12 09:22:59Z weckamc $
/*  ----------------------------------------------------------------------
 *  LICENSE
 *
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License (GPL)
 *  as published by the Free Software Foundation, either version 2
 *  of the License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  To read the license please visit http://www.gnu.org/copyleft/gpl.html
 *  ----------------------------------------------------------------------
 */

/**
 *
 * @version      $Id: common.php 223 2007-08-12 09:22:59Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

define('_MEDIAATTACH',                          'MediaAttach');

define('_MEDIAATTACH_UPLOAD',                   'Upload');
define('_MEDIAATTACH_UPLOADFILES',              'Upload files');
define('_MEDIAATTACH_UPLOADAFILE',              'Upload a file');
define('_MEDIAATTACH_DESC',                     'Description');
define('_MEDIAATTACH_GROUP',                    'Group');
define('_MEDIAATTACH_ALLOWEDFORMATS',           'Allowed formats');
define('_MEDIAATTACH_MAXSIZE',                  'Max. size');
define('_MEDIAATTACH_MAXFILES',                 'Max. files');
define('_MEDIAATTACH_MAXIMUMS',                 'Maximums');
define('_MEDIAATTACH_MAXIMUMFILES',             'files');
define('_MEDIAATTACH_QUOTA',                    'Quota');
define('_MEDIAATTACH_QUOTAYOUHAVE',             'You have');
define('_MEDIAATTACH_QUOTAOF',                  'of');
define('_MEDIAATTACH_QUOTAUSED',                'used');
define('_MEDIAATTACH_QUOTAFULL',                'You have no more memory for uploads available');
define('_MEDIAATTACH_FILE',                     'File');
define('_MEDIAATTACH_TITLE',                    'Title');
define('_MEDIAATTACH_DESCRIPTION',              'Description');
define('_MEDIAATTACH_INFO',                     'Info');
define('_MEDIAATTACH_FILESIZE',                 'Filesize');
define('_MEDIAATTACH_ATTACHMENT',               'File attachments');
define('_MEDIAATTACH_ADMINATTACHMENT',          'Admin files');
define('_MEDIAATTACH_UPLOADCREATED',            'The file has been uploaded successfully');
define('_MEDIAATTACH_NEWMAILSUBJECT',           'A new file has been uploaded');
define('_MEDIAATTACH_NEWMAILBODY',              'Hi! Here is the information about the file');
define('_MEDIAATTACH_DLMAILSUBJECT',            'Your requested file');
define('_MEDIAATTACH_DLMAILBODY',               'Hi! Here is the file which you sent yourself on our site');
define('_MEDIAATTACH_DOWNLOADIT',               'Download this file');
define('_MEDIAATTACH_VIEWIT',                   'View this file');
define('_MEDIAATTACH_SENDIT',                   'Send this file to your mail address');
define('_MEDIAATTACH_FILEINFO',                 'Information about this file');
define('_MEDIAATTACH_TOPROFILE',                'To the profile of');
define('_MEDIAATTACH_UPLOADMAILSENT',           'The mail has been sent to you successfully');
define('_MEDIAATTACH_UPLOADMAILNOTSENT',        'Sorry, the mail could not be sent to you');

define('_MEDIAATTACH_BYTES',                    'Bytes');
define('_MEDIAATTACH_KB',                       'KB');
define('_MEDIAATTACH_MB',                       'MB');
define('_MEDIAATTACH_GB',                       'GB');

define('_MEDIAATTACH_NORIGHTS',                 'Sorry, you have no permission for uploading files');
define('_MEDIAATTACH_NOANON',                   'Sorry, uploads are only available for registered users');
define('_MEDIAATTACH_DIRERR',                   'Sorry, MediaAttach has not been configured yet');
define('_MEDIAATTACH_ERROK',                    'There was a problem with the upload');
define('_MEDIAATTACH_ERRINISIZE',               'The file is too big');
define('_MEDIAATTACH_ERRFORMSIZE',              'The file is too big');
define('_MEDIAATTACH_ERRPARTIAL',               'The file was only partially uploaded');
define('_MEDIAATTACH_ERRNOFILE',                'No file selected');
define('_MEDIAATTACH_ERRNOTMPDIR',              'There is no temporary folder specified');
define('_MEDIAATTACH_ERRFORMAT',                'The file has an invalid file format');
define('_MEDIAATTACH_ERRSIZE',                  'The file is bigger than allowed');
define('_MEDIAATTACH_ERRSAMENAME',              'There already a file exists which has the same name');
define('_MEDIAATTACH_ERRMOVE',                  'Some problems occured while processing this file');

define('_MEDIAATTACH_ERRINSERTFILE',            'Sorry, the data of your file could not be written into the database');
define('_MEDIAATTACH_WARNINGMULTIPLEPAGES',     'Please choose your file only if you are going to submit the data finally (no preview), otherwise it will not be stored properly. Will be fixed in a future version.');

//Upload files
define('_MEDIAATTACH_NOTITLE',                  'No title');
define('_MEDIAATTACH_UPLOADUPLOAD',             'Newest uploads');
define('_MEDIAATTACH_UPLOADFILE',               'File');
define('_MEDIAATTACH_UPLOADMODNAME',            'Module');
define('_MEDIAATTACH_UPLOADUSER',               'User');
define('_MEDIAATTACH_UPLOADDATE',               'Date');
define('_MEDIAATTACH_UPLOADTITLE',              'Title');
define('_MEDIAATTACH_UPLOADDESC',               'Description');
define('_MEDIAATTACH_UPLOADMIMETYPE',           'Mime type');
define('_MEDIAATTACH_UPLOADFILESIZE',           'Filesize');
define('_MEDIAATTACH_UPLOADDELETE',             'Delete this file');
define('_MEDIAATTACH_UPLOADEDIT',               'Edit this file');
define('_MEDIAATTACH_UPLOADUPDATE',             'Update this file');
define('_MEDIAATTACH_UPLOADDLCOUNT',            '%count% times downloaded');
define('_MEDIAATTACH_UPLOADNOUPLOADS',          'No files were uploaded yet');
define('_MEDIAATTACH_UPLOADNOIMAGES',           'No images available yet');
define('_MEDIAATTACH_UPLOADFILTERBY',           'Filter by');
define('_MEDIAATTACH_UPLOADSORTBY',             'Sort by');
define('_MEDIAATTACH_UPLOADSORTBYDATE',         'date');
define('_MEDIAATTACH_UPLOADSORTBYTITLE',        'title');
define('_MEDIAATTACH_UPLOADSORTBYMODULE',       'module');
define('_MEDIAATTACH_UPLOADSORTBYUSERNAME',     'username');
define('_MEDIAATTACH_UPLOADSORTBYFILENAME',     'filename');
define('_MEDIAATTACH_UPLOADSORTBYFILETYPE',     'filetype');
define('_MEDIAATTACH_UPLOADSORTBYFILESIZE',     'filesize');
define('_MEDIAATTACH_UPLOADSORTDIRASC',         'ascending');
define('_MEDIAATTACH_UPLOADSORTDIRDESC',        'descending');
define('_MEDIAATTACH_UPLOADPERPAGE',            'Entries per page');

define('_MEDIAATTACH_SEARCHINCLUDE_TITLE',          'Files and media');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBY',         'Sort by');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYDATE',     'date');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYTITLE',    'title');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYMODULE',   'module');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYUSERNAME', 'username');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILENAME', 'filename');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILETYPE', 'filetype');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILESIZE', 'filesize');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTDIRASC',     'ascending');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTDIRDESC',    'descending');

define('_MEDIAATTACH_SEARCHINCLUDE_RESULTS',    'Uploads');
define('_MEDIAATTACH_SEARCHINCLUDE_HITS',       'Results');
define('_MEDIAATTACH_SEARCHINCLUDE_NOENTRIES',  'no uploads found');
define('_MEDIAATTACH_FROM',                     'from');
define('_MEDIAATTACH_ON',                       'on');

define('_MEDIAATTACH_ADMINMAIN',                'Start');
define('_MEDIAATTACH_ADMINADMINUPLOADS',        'Admin uploads');
define('_MEDIAATTACH_ADMINUSERUPLOADS',         'User uploads');
define('_MEDIAATTACH_ADMINDEFINITIONS',         'Definitions');
define('_MEDIAATTACH_ADMINFORMATS',             'Formats');
define('_MEDIAATTACH_ADMINGROUPS',              'Groups');
define('_MEDIAATTACH_ADMINQUOTAS',              'Quotas');
define('_MEDIAATTACH_ADMINCONFIG',              'Config');
define('_MEDIAATTACH_ADMINMANUAL',              'Manual');
define('_MEDIAATTACH_ADMINTMAIN',               'Go the start page of MediaAttach admin section');
define('_MEDIAATTACH_ADMINTADMINUPLOADS',       'Upload and import admin files');
define('_MEDIAATTACH_ADMINTUSERUPLOADS',        'Management of user files');
define('_MEDIAATTACH_ADMINTDEFINITIONS',        'Manage module definitions');
define('_MEDIAATTACH_ADMINTFORMATS',            'File formats');
define('_MEDIAATTACH_ADMINTGROUPS',             'File format groups');
define('_MEDIAATTACH_ADMINTQUOTAS',             'Quotas');
define('_MEDIAATTACH_ADMINTCONFIG',             'The MediaAttach configuration');
define('_MEDIAATTACH_ADMINTMANUAL',             'The worth to read pdf manual');

define('_MEDIAATTACH_WELCOME',                  'Welcome to the MediaAttach admin area');
define('_MEDIAATTACH_FILESTOTAL',               '%count% files total');
define('_MEDIAATTACH_ACTIONS',                  'Actions');
define('_MEDIAATTACH_NONE',                     'None');
define('_MEDIAATTACH_ONLYOWN',                  'Only own');
define('_MEDIAATTACH_ALL',                      'All');


//Definitions
define('_MEDIAATTACH_DEFINITIONDEFS',           'Upload definitions');
define('_MEDIAATTACH_DEFINITIONNOMODULES',      'MediaAttach could not find a module, for which it has been activated. Please go to the module settings and activate MediaAttach for one or more modules of your choice.');
define('_MEDIAATTACH_DEFINITIONMODNAME',        'Module');
define('_MEDIAATTACH_DEFINITIONGROUPS',         'Groups');
define('_MEDIAATTACH_DEFINITIONSHOW',           'Show definition');
define('_MEDIAATTACH_DEFINITIONHIDE',           'Hide definition');
define('_MEDIAATTACH_DEFINITIONFOR',            'Definition for');
define('_MEDIAATTACH_DEFINITIONDSPFILES',       'Show uploaded files in the user section');
define('_MEDIAATTACH_DEFINITIONSENDMAILS',      'Send a mail after uploading');
define('_MEDIAATTACH_DEFINITIONRECIPIENT',      'Recipient of the mail');
define('_MEDIAATTACH_DEFINITIONMAXSIZE',        'Maximum file size during upload');
define('_MEDIAATTACH_DEFINITIONDOWNLOADMODE',   'Download mode');
define('_MEDIAATTACH_DEFINITIONPHYSICAL',       'Physical');
define('_MEDIAATTACH_DEFINITIONINLINE',         'Inline');
define('_MEDIAATTACH_DEFINITIONNAMING',         'Naming convention');
define('_MEDIAATTACH_DEFINITIONNAMORIG',        'Original filename');
define('_MEDIAATTACH_DEFINITIONNAMRAND',        'Random filename');
define('_MEDIAATTACH_DEFINITIONNAMSTAT',        'Numbered with prefix');
define('_MEDIAATTACH_DEFINITIONPREFIX',         'Prefix');
define('_MEDIAATTACH_DEFINITIONNUMFILES',       'Number of files');
define('_MEDIAATTACH_DEFINITIONADD',            'Add definition');
define('_MEDIAATTACH_DEFINITIONEDIT',           'Edit this definition');
define('_MEDIAATTACH_DEFINITIONNEW',            'Create a new definition');
define('_MEDIAATTACH_DEFINITIONUPDATE',         'Update this definition');

//Formats
define('_MEDIAATTACH_FORMATS',                  'File formats');
define('_MEDIAATTACH_FILETYPE',                 'File type');
define('_MEDIAATTACH_IMAGE',                    'Image');
define('_MEDIAATTACH_GROUPS',                   'Groups');
define('_MEDIAATTACH_FORMATADD',                'Add filetype');
define('_MEDIAATTACH_FORMATDELETE',             'Delete this filetype');
define('_MEDIAATTACH_FORMATEDIT',               'Edit this filetype');
define('_MEDIAATTACH_FORMATNEW',                'Create a new filetype');
define('_MEDIAATTACH_FORMATUPDATE',             'Update this filetype');
define('_MEDIAATTACH_FORMATDANGER',             'Warning: Allowing this filetype can be a potential security risk!');

//Groups
define('_MEDIAATTACH_GROUPGROUPS',              'File groups');
define('_MEDIAATTACH_GROUPNAME',                'Name');
define('_MEDIAATTACH_GROUPDIR',                 'Directory');
define('_MEDIAATTACH_GROUPIMAGE',               'Image');
define('_MEDIAATTACH_GROUPFORMATS',             'File types');
define('_MEDIAATTACH_GROUPADD',                 'Add group');
define('_MEDIAATTACH_GROUPDELETE',              'Delete this group');
define('_MEDIAATTACH_GROUPEDIT',                'Edit this group');
define('_MEDIAATTACH_GROUPNEW',                 'Create a new group');
define('_MEDIAATTACH_GROUPUPDATE',              'Update this group');

//Quotas
define('_MEDIAATTACH_QUOTASGROUPS',             'Groups');
define('_MEDIAATTACH_QUOTASUSERS',              'Users');
define('_MEDIAATTACH_QUOTASNOUSERS',            'No user quotas defined');
define('_MEDIAATTACH_QUOTASNEWUSER',            'New user quota');
define('_MEDIAATTACH_QUOTASUSERCREATE',         'Create Quota');
define('_MEDIAATTACH_QUOTASGROUPNAME',          'Name');
define('_MEDIAATTACH_QUOTASUSERNAME',           'Name');
define('_MEDIAATTACH_QUOTASQUOTA'    ,          'Quota');
define('_MEDIAATTACH_QUOTASACTION',             'Send it');
define('_MEDIAATTACH_QUOTASUPDATE',             'Change quotas');
define('_MEDIAATTACH_QUOTASDELETE',             'Delete this quota');

//Configuration
define('_MEDIAATTACH_CONFIGURATION',            'Configuration');
define('_MEDIAATTACH_CONFIGIMAGE',              'Image settings');
define('_MEDIAATTACH_CONFIGCATMODES',           'Categorization settings');
define('_MEDIAATTACH_MEDIAATTACHDIR',           'MediaAttach installation directory');
define('_MEDIAATTACH_DOCROOT',                  'HTML root');
define('_MEDIAATTACH_UPLOADDIR',                'Upload folder (absolute, ideally outside the HTML root):');
define('_MEDIAATTACH_CACHEDIR',                 'Cache folder (relative from HTML root):');
define('_MEDIAATTACH_DIROKAY',                  'Everything allright');
define('_MEDIAATTACH_DIRNOTWRITABLE',           'This directory is not writable for the web server');
define('_MEDIAATTACH_DIRNODIR',                 'This is not a directory');
define('_MEDIAATTACH_DIRNOTEXIST',              'This directory does not exist');
define('_MEDIAATTACH_MAILER',                   'Allow users sending files in mails to theirselves');
define('_MEDIAATTACH_SENDFILES',                'Activate this function');
define('_MEDIAATTACH_MAXMAILSIZE',              'Maximum filesize for mails:');
define('_MEDIAATTACH_USEQUOTA',                 'Activate quotas');
define('_MEDIAATTACH_OWNHANDLING',              'Users are able to edit and delete their own files');
define('_MEDIAATTACH_USEFRONTPAGE',             'Activate frontpage in user section');
define('_MEDIAATTACH_USEACCOUNTPAGE',           'Activate account page in user section');
define('_MEDIAATTACH_ALLOWOWNHANDLING',         'Allow this option');
define('_MEDIAATTACH_DEFAULTTHUMBSIZE',         'Default sizes of thumbnails (you can create as many formats as desired):');
define('_MEDIAATTACH_SHRINKIMAGES',             'Shrink big images');
define('_MEDIAATTACH_DEFAULTSHRINKSIZE',        'Maximum image size:');
define('_MEDIAATTACH_CONFIGPIXEL',              'pixels');
define('_MEDIAATTACH_USETHUMBCROPPER',          'Allow cropping of thumbnails');
define('_MEDIAATTACH_CROPSIZEMODE',             'Behaviour of the selection tool');
define('_MEDIAATTACH_USECROPFIXEDSIZE',         'Enforce default size');
define('_MEDIAATTACH_USECROPVARSIZEAR',         'Keep size variable and enforce aspect ratio');
define('_MEDIAATTACH_USECROPVARSIZE',           'Keep size and aspect ratio variable');

define('_MEDIAATTACH_CATMODECATEGORIES',        'MediaAttach categories (Categories module)');
define('_MEDIAATTACH_CATMODEMODULES',           'Modules');
define('_MEDIAATTACH_CATMODEUSERS',             'Users');
define('_MEDIAATTACH_CATDEFAULTMODE',           'Default mode:');
define('_MEDIAATTACH_CATDEFAULTMODENONE',       'No categorization');
define('_MEDIAATTACH_CATDEFAULTMODECATEGORIES', 'Categories');
define('_MEDIAATTACH_CATDEFAULTMODEMODULES',    'Modules');
define('_MEDIAATTACH_CATDEFAULTMODEUSERS',      'Users');

define('_MEDIAATTACH_HTACCESSHINT',             'MediaAttach can automatically write a .htaccess file into your upload directory to avoid direct access to uploaded files. Notice that not all webservers support .htaccess files.');
define('_MEDIAATTACH_HTACCESSGENERATE',         'Generate .htaccess');

define('_MEDIAATTACH_PHPINISETTINGS',           'Important settings in php.ini, which are relevant for uploads');
define('_MEDIAATTACH_VERSIONCHECK',             'Version-Check');
define('_MEDIAATTACH_YOURVERSION',              'Your Version');
define('_MEDIAATTACH_NEWVERSION',               'There is a new Version available');
define('_MEDIAATTACH_DOWNLOADNOW',              'Download now');
define('_MEDIAATTACH_TDOWNLOADNOW',             'Download the newest version of MediaAttach');
define('_MEDIAATTACH_NONEWVERSION',             'Your version is the newest');

define('_MEDIAATTACH_ACTION',                   'Action');

define('_MEDIAATTACH_FILEFILTER',               'Files to show');
define('_MEDIAATTACH_NUMITEMS',                 'Number of files to display');
define('_MEDIAATTACH_FORMATFILTER',             'Show only files of these formats (optional)');
define('_MEDIAATTACH_DISPLAYTYPE',              'Sorting');
define('_MEDIAATTACH_NEWESTFILES',              'Newest files');
define('_MEDIAATTACH_RANDOMFILES',              'Random files');

define('_MEDIAATTACH_FORMATSSHOW',              'show');
define('_MEDIAATTACH_FORMATSHIDE',              'hide');

define('_MEDIAATTACH_MYUPLOADS',                'My uploads');

define('_MEDIAATTACH_ADMINFILESHINT',           'To use admin files a definition must be created for MediaAttach. Therefore click in the menu on "definitions".');

define('_MEDIAATTACH_IMPORTFILESFROMFS',        'Import files from a server directory');
define('_MEDIAATTACH_IMPORTFILESFROMFSHINT',    'Simply go to the desired directory, select the files to import and start. The upload filesize limit is not being used here.');
define('_MEDIAATTACH_IMPORTFILESFROMMODULE',    'Import files from another module');
define('_MEDIAATTACH_IMPORTFILESFROMMODULEHINT', 'MediaAttach has found the following modules from which files can be imported.');
define('_MEDIAATTACH_IMPORTFILESFROMMODULEHINT2', 'Existing hierarchies are converted in the form of Categories.');
define('_MEDIAATTACH_IMPORTLIMITSHINT',         'The upload filesize limits are not being used here.');
define('_MEDIAATTACH_IMPORTSTART',              'Start import');
define('_MEDIAATTACH_IMPORTCREATED',            'The file has been imported successfully');

define('_MEDIAATTACH_VALIDATIONGROUPNAMEREQUIRED',  'Please enter a name for the new group.');
define('_MEDIAATTACH_VALIDATIONGROUPNAMEALPHANUM',  'The group name may only contain letters and numbers.');
define('_MEDIAATTACH_VALIDATIONDIRECTORYREQUIRED',  'Please enter a directory for the new group');
define('_MEDIAATTACH_VALIDATIONDIRECTORYALPHANUM',  'The directory may only contain letters and numbers.');
define('_MEDIAATTACH_VALIDATIONEXTENSIONREQUIRED',  'Please enter an extension for the new filetype.');
define('_MEDIAATTACH_VALIDATIONEXTENSIONALPHANUM',  'The extension may only contain letters and numbers.');
define('_MEDIAATTACH_VALIDATIONCATEGORYNAMEREQUIRED',  'Please enter a name for the new category.');
define('_MEDIAATTACH_VALIDATIONCATEGORYNAMEALPHANUM',  'The category name may only contain letters and numbers.');

define('_MEDIAATTACH_ERRORALLOWEDFILENUM',      'You are not allowed to upload more than %m% files at once.');
define('_MEDIAATTACH_ERRORALREADYSELECTED',     'This file has already been selected.');
define('_MEDIAATTACH_ERROREXTENSIONNOTALLOWED', 'The filetype of this file is not allowed.');
define('_MEDIAATTACH_ERRORNOFILESSELECTED',     'No file has been chosen yet.');
define('_MEDIAATTACH_ERRORALREADYRUNNING',      'There is already a file being uploaded.');

define('_MEDIAATTACH_ADDFILE',                  'Add file');
define('_MEDIAATTACH_INFOFORATTACHMENTBOX',     'Added files will be listed here.');
define('_MEDIAATTACH_INFOFORDROPBOX',           'Drop any added files here to remove them.');
define('_MEDIAATTACH_UPLOADING',                'Uploading...');

define('_MEDIAATTACH_FILEINFOGENERALINFO',      'General information');
define('_MEDIAATTACH_FILEINFOFILETYPE',         'Filetype:');
define('_MEDIAATTACH_FILEINFOFILESIZE',         'Filesize:');
define('_MEDIAATTACH_FILEINFOMIMETYPE',         'Mimetype:');
define('_MEDIAATTACH_FILEINFOENCODING',         'Encoding:');
define('_MEDIAATTACH_FILEINFOPLAYTIME',         'Playtime:');
define('_MEDIAATTACH_FILEINFOSECONDS',          'sec.');

define('_MEDIAATTACH_FILEINFOHASHINFO',         'Hash information');
define('_MEDIAATTACH_FILEINFOMD5ENTIREFILE',    'md5 entire file:');
define('_MEDIAATTACH_FILEINFOMD5CRAWDATA',      'md5 compressed raw data:');
define('_MEDIAATTACH_FILEINFOMD5URAWDATA',      'md5 uncompressed raw data:');
define('_MEDIAATTACH_FILEINFOMD5RAWDATA',       'md5 raw data:');
define('_MEDIAATTACH_FILEINFOSHA1ENTIREFILE',   'sha1 entire file:');
define('_MEDIAATTACH_FILEINFOSHA1RAWDATA',      'sha1 raw data:');

define('_MEDIAATTACH_FILEINFOAUDIOINFO',        'Audio information');
define('_MEDIAATTACH_FILEINFOIMAGEINFO',        'Image information');
define('_MEDIAATTACH_FILEINFOVIDEOINFO',        'Video information');
define('_MEDIAATTACH_FILEINFOAVGBITRATE',       'Average bitrate:');
define('_MEDIAATTACH_FILEINFOKBPS',             'kbps');
define('_MEDIAATTACH_FILEINFOBITRATEMODE',      'Bitrate mode:');
define('_MEDIAATTACH_FILEINFOBITRATECBR',       'CBR (Constant Bit Rate)');
define('_MEDIAATTACH_FILEINFOBITRATEVBR',       'VBR (Variable Bit Rate)');
define('_MEDIAATTACH_FILEINFOSAMPLERATE',       'Sample rate:');
define('_MEDIAATTACH_FILEINFOHERTZ',            'Hertz');
define('_MEDIAATTACH_FILEINFOBITSPERSAMPLE',    'Bits per sample:');
define('_MEDIAATTACH_FILEINFOCHANNELMODE',      'Channelmode:');
define('_MEDIAATTACH_FILEINFONOOFCHANNELS',     'No. of channels:');
define('_MEDIAATTACH_FILEINFOAUDIOCODEC',       'Audio compression codec:');
define('_MEDIAATTACH_FILEINFOVIDEOCODEC',       'Video compression codec:');
define('_MEDIAATTACH_FILEINFOENCODER',          'Encoder:');
define('_MEDIAATTACH_FILEINFOCOMPRESSIONRATIO', 'Compression ratio:');
define('_MEDIAATTACH_FILEINFOLOSSLESS',         'Lossless:');
define('_MEDIAATTACH_FILEINFOLOSSLESSCOMP',     'lossless compression');
define('_MEDIAATTACH_FILEINFOLOSSYCOMP',        'lossy compression');
define('_MEDIAATTACH_FILEINFOFRAMERATE',        'Frame rate:');
define('_MEDIAATTACH_FILEINFOFPS',              'fps');
define('_MEDIAATTACH_FILEINFOSIZE',             'Size:');
define('_MEDIAATTACH_FILEINFOWIDTH',            'Width:');
define('_MEDIAATTACH_FILEINFOHEIGHT',           'Height:');
define('_MEDIAATTACH_FILEINFOPIXEL',            'pixels');
define('_MEDIAATTACH_FILEINFOPIXELDAR',         'Pixel display aspect ratio:');
define('_MEDIAATTACH_FILEINFOBGCOLOR',          'Background colour:');
define('_MEDIAATTACH_FILEINFOTAGINFO',          'Tag information');
define('_MEDIAATTACH_FILEINFOEXIF',             'EXIF information');

define('_MEDIAATTACH_PROFILEUPLOADS',           'Upload status');
define('_MEDIAATTACH_PROFILEFILESUPLOADED',     '%count% files uploaded');
define('_MEDIAATTACH_PROFILETOTAL',             'total');

define('_MEDIAATTACH_EXTERNALONLYIMAGES',       'Only images');
define('_MEDIAATTACH_EXTERNALOUTPUT',           'Display mode');
define('_MEDIAATTACH_EXTERNALOUTPUTLINK',       'Link to the file');
define('_MEDIAATTACH_EXTERNALOUTPUTINLINE',     'Embed the item inline');
define('_MEDIAATTACH_EXTERNALOUTPUTPHYSICAL',   'Embed the item physically');
define('_MEDIAATTACH_EXTERNALPASTEAS',          'Paste as');
define('_MEDIAATTACH_EXTERNALPASTETHUMBWITHLINK', 'Thumbnail with link to view original image');
define('_MEDIAATTACH_EXTERNALPASTETHUMBWITHLINKDL', 'Thumbnail with link to download original image');
define('_MEDIAATTACH_EXTERNALPASTETHUMB',       'Thumbnail');
define('_MEDIAATTACH_EXTERNALPASTEORIGINAL',    'Original image');
define('_MEDIAATTACH_EXTERNALPASTETHUMBLINK',   'Link to thumbnail');
define('_MEDIAATTACH_EXTERNALPASTEORIGINALLINK', 'Link to original image');
define('_MEDIAATTACH_EXTERNALPASTEID',           'File ID');

define('_MEDIAATTACH_CATMODE',                  'Display mode:');
define('_MEDIAATTACH_PREVIEW',                  'Preview');
define('_MEDIAATTACH_ONLYIMAGES',               'Only images');

define('_MEDIAATTACH_SWFBROWSEFILES',           'Browse files');
define('_MEDIAATTACH_SWFQUEUEISEMPTY',          'Queue is empty');
define('_MEDIAATTACH_SWFCANCELQUEUE',           'Cancel queue');
define('_MEDIAATTACH_SWFFILESELECTION',         'MediaAttach files...');
define('_MEDIAATTACH_SWFCBFILEQUEUE',           'File queue');
define('_MEDIAATTACH_SWFCBFILECANCELLED',       'cancelled');
define('_MEDIAATTACH_SWFCBFILESQUEUED',         'files queued');
define('_MEDIAATTACH_SWFCBUPLOADINGFILE',       'Uploading file');
define('_MEDIAATTACH_SWFCBUPLOADINGOF',         'of');
define('_MEDIAATTACH_SWFALLFILESUPLOADED',      'All files uploaded...');

define('_MEDIAATTACH_LINKEXTVIDEO',             'Embed external video');
define('_MEDIAATTACH_EXTVIDEOURL',              'Video Page URL');
define('_MEDIAATTACH_EXTVIDEOSUPPORTED',        'Supported providers');
define('_MEDIAATTACH_EXTVIDCREATED',            'The video has been embedded successfully');
define('_MEDIAATTACH_EXTVIDERRORDOMAIN',        'Error: this is an invalid or unsupported URL.');
define('_MEDIAATTACH_EXTVIDERRORGRAB',          'Sorry, could not determine video information.');

define('_MEDIAATTACH_CROPTHUMBDEACTIVATED',     'Thumbnail cropping is deactivated.');
define('_MEDIAATTACH_CROPTHUMB',                'Crop thumbnail');
define('_MEDIAATTACH_CROPCHOOSE',               'Choose your desired preview image.');
define('_MEDIAATTACH_CROPFIXEDSIZE',            'The selection window size is not changeable.');
define('_MEDIAATTACH_CROPVARSIZEAR',            'The selection window size is changeable, the aspect ratio will be kept.');
define('_MEDIAATTACH_CROPVARSIZE',              'The selection window size and the aspect ratio are changeable.');
define('_MEDIAATTACH_CROPNOSCRIPT',             'This function requires JavaScript.');

define('_CATREGCREATEFAILED',                   'An error occured while creating the category registries.');
define('_CATREGDELETEFAILED',                   'An error occured while deleting the category registries.');
define('_REGISTERSELFFAILED',                   'Admin uploads could not be prepared. This is not critical.');

