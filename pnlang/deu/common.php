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
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

define('_MEDIAATTACH',                          'MediaAttach');

define('_MEDIAATTACH_UPLOAD',                   'Hochladen');
define('_MEDIAATTACH_UPLOADFILES',              'Dateien hochladen');
define('_MEDIAATTACH_UPLOADAFILE',              'Eine Datei hochladen');
define('_MEDIAATTACH_DESC',                     'Beschreibung');
define('_MEDIAATTACH_GROUP',                    'Gruppe');
define('_MEDIAATTACH_ALLOWEDFORMATS',           'Erlaubte Formate');
define('_MEDIAATTACH_MAXSIZE',                  'Max. Größe');
define('_MEDIAATTACH_MAXFILES',                 'Max. Dateien');
define('_MEDIAATTACH_MAXIMUMS',                 'Maximalwerte');
define('_MEDIAATTACH_MAXIMUMFILES',             'Dateien');
define('_MEDIAATTACH_QUOTA',                    'Quota');
define('_MEDIAATTACH_QUOTAYOUHAVE',             'Sie haben');
define('_MEDIAATTACH_QUOTAOF',                  'von');
define('_MEDIAATTACH_QUOTAUSED',                'belegt');
define('_MEDIAATTACH_QUOTAFULL',                'Sie haben Ihren Upload-Speicher ausgereizt.');
define('_MEDIAATTACH_FILE',                     'Datei');
define('_MEDIAATTACH_TITLE',                    'Titel');
define('_MEDIAATTACH_DESCRIPTION',              'Beschreibung');
define('_MEDIAATTACH_INFO',                     'Info');
define('_MEDIAATTACH_FILESIZE',                 'Dateigröße');
define('_MEDIAATTACH_ATTACHMENT',               'Datei-Anhänge');
define('_MEDIAATTACH_ADMINATTACHMENT',          'Admin-Dateien');
define('_MEDIAATTACH_UPLOADCREATED',            'Die Datei wurde erfolgreich hochgeladen');
define('_MEDIAATTACH_NEWMAILSUBJECT',           'Eine neue Datei wurde hochgeladen');
define('_MEDIAATTACH_NEWMAILBODY',              'Hi! Hier die Infos zu der Datei');
define('_MEDIAATTACH_DLMAILSUBJECT',            'Ihre angeforderte Datei');
define('_MEDIAATTACH_DLMAILBODY',               'Hi! Hier die Datei, die Sie sich auf der Site zugesendet haben');
define('_MEDIAATTACH_DOWNLOADIT',               'Diese Datei herunterladen');
define('_MEDIAATTACH_VIEWIT',                   'Diese Datei anschauen');
define('_MEDIAATTACH_SENDIT',                   'Diese Datei per Mail an Sie senden');
define('_MEDIAATTACH_FILEINFO',                 'Informationen zu dieser Datei');
define('_MEDIAATTACH_TOPROFILE',                'Zum Profil von');
define('_MEDIAATTACH_UPLOADMAILSENT',           'Die Mail wurde erfolgreich an Sie versendet');
define('_MEDIAATTACH_UPLOADMAILNOTSENT',        'Die Mail konnte leider nicht versendet werden');

define('_MEDIAATTACH_BYTES',                    'Bytes');
define('_MEDIAATTACH_KB',                       'KB');
define('_MEDIAATTACH_MB',                       'MB');
define('_MEDIAATTACH_GB',                       'GB');

define('_MEDIAATTACH_NORIGHTS',                 'Sie haben keine Berechtigung um Dateien hochzuladen');
define('_MEDIAATTACH_NOANON',                   'Es steht nur angemeldeten Benutzern frei Dateien hochzuladen');
define('_MEDIAATTACH_DIRERR',                   'MediaAttach wurde noch nicht konfiguriert');
define('_MEDIAATTACH_ERROK',                    'Es ist ein Problem mit Ihrem Upload aufgetreten');
define('_MEDIAATTACH_ERRINISIZE',               'Die Datei ist zu groß');
define('_MEDIAATTACH_ERRFORMSIZE',              'Die Datei ist zu groß');
define('_MEDIAATTACH_ERRPARTIAL',               'Die Datei konnte nur teilweise hochgeladen werden');
define('_MEDIAATTACH_ERRNOFILE',                'Keine Datei selektiert');
define('_MEDIAATTACH_ERRNOTMPDIR',              'Es ist kein temporärer Ordner definiert');
define('_MEDIAATTACH_ERRFORMAT',                'Die Datei hat ein unerlaubtes Dateiformat');
define('_MEDIAATTACH_ERRSIZE',                  'Die Datei ist zu groß');
define('_MEDIAATTACH_ERRSAMENAME',              'Es existiert schon eine Datei mit dem selben Namen');
define('_MEDIAATTACH_ERRMOVE',                  'Es ist ein Problem beim Verarbeiten der Datei aufgetreten');

define('_MEDIAATTACH_ERRINSERTFILE',            'Die Daten Ihrer Datei konnten leider nicht in die Datenbank geschrieben werden');
define('_MEDIAATTACH_WARNINGMULTIPLEPAGES',     'Bitte erst eine Datei aussuchen, wenn der Beitrag endgültig gesendet wird, da sie sonst nicht gespeichert werden kann. Wird in einer der nächsten Versionen behoben.');

//Upload-Dateien
define('_MEDIAATTACH_NOTITLE',                  'Kein Titel');
define('_MEDIAATTACH_UPLOADUPLOAD',             'Neueste Uploads');
define('_MEDIAATTACH_UPLOADFILE',               'Datei');
define('_MEDIAATTACH_UPLOADMODNAME',            'Modul');
define('_MEDIAATTACH_UPLOADUSER',               'User');
define('_MEDIAATTACH_UPLOADDATE',               'Datum');
define('_MEDIAATTACH_UPLOADTITLE',              'Titel');
define('_MEDIAATTACH_UPLOADDESC',               'Beschreibung');
define('_MEDIAATTACH_UPLOADMIMETYPE',           'Mime-Typ');
define('_MEDIAATTACH_UPLOADFILESIZE',           'Dateigröße');
define('_MEDIAATTACH_UPLOADDELETE',             'Diese Datei entfernen');
define('_MEDIAATTACH_UPLOADEDIT',               'Diese Datei editieren');
define('_MEDIAATTACH_UPLOADUPDATE',             'Diese Datei aktualisieren');
define('_MEDIAATTACH_UPLOADDLCOUNT',            '%count% mal heruntergeladen');
define('_MEDIAATTACH_UPLOADNOUPLOADS',          'Es wurden noch keine Dateien hochgeladen');
define('_MEDIAATTACH_UPLOADNOIMAGES',           'Noch keine Bilder vorhanden');
define('_MEDIAATTACH_UPLOADFILTERBY',           'Filtern nach');
define('_MEDIAATTACH_UPLOADSORTBY',             'Sortieren nach');
define('_MEDIAATTACH_UPLOADSORTBYDATE',         'Datum');
define('_MEDIAATTACH_UPLOADSORTBYTITLE',        'Titel');
define('_MEDIAATTACH_UPLOADSORTBYMODULE',       'Modul');
define('_MEDIAATTACH_UPLOADSORTBYUSERNAME',     'Username');
define('_MEDIAATTACH_UPLOADSORTBYFILENAME',     'Dateiname');
define('_MEDIAATTACH_UPLOADSORTBYFILETYPE',     'Dateityp');
define('_MEDIAATTACH_UPLOADSORTBYFILESIZE',     'Dateigröße');
define('_MEDIAATTACH_UPLOADSORTDIRASC',         'Aufsteigend');
define('_MEDIAATTACH_UPLOADSORTDIRDESC',        'Absteigend');
define('_MEDIAATTACH_UPLOADPERPAGE',            'Einträge pro Seite');

define('_MEDIAATTACH_SEARCHINCLUDE_TITLE',          'Dateien und Medien');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBY',         'Sortieren nach');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYDATE',     'Datum');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYTITLE',    'Titel');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYMODULE',   'Modul');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYUSERNAME', 'Username');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILENAME', 'Dateiname');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILETYPE', 'Dateityp');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILESIZE', 'Dateigröße');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTDIRASC',     'Aufsteigend');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTDIRDESC',    'Absteigend');

define('_MEDIAATTACH_SEARCHINCLUDE_RESULTS',    'Uploads');
define('_MEDIAATTACH_SEARCHINCLUDE_HITS',       'Treffer');
define('_MEDIAATTACH_SEARCHINCLUDE_NOENTRIES',  'keine Uploads gefunden');
define('_MEDIAATTACH_FROM',                     'von');
define('_MEDIAATTACH_ON',                       'am');

define('_MEDIAATTACH_ADMINMAIN',                'Start');
define('_MEDIAATTACH_ADMINADMINUPLOADS',        'Admin-Uploads');
define('_MEDIAATTACH_ADMINUSERUPLOADS',         'User-Uploads');
define('_MEDIAATTACH_ADMINDEFINITIONS',         'Definitionen');
define('_MEDIAATTACH_ADMINFORMATS',             'Formate');
define('_MEDIAATTACH_ADMINGROUPS',              'Gruppen');
define('_MEDIAATTACH_ADMINQUOTAS',              'Quotas');
define('_MEDIAATTACH_ADMINCONFIG',              'Konfig');
define('_MEDIAATTACH_ADMINMANUAL',              'Handbuch');
define('_MEDIAATTACH_ADMINTMAIN',               'Zur Startseite vom MediaAttach Adminbereich');
define('_MEDIAATTACH_ADMINTADMINUPLOADS',       'Admin-Dateien hochladen und importieren');
define('_MEDIAATTACH_ADMINTUSERUPLOADS',        'Verwaltung der User-Dateien');
define('_MEDIAATTACH_ADMINTDEFINITIONS',        'Modul-Definitionen verwalten');
define('_MEDIAATTACH_ADMINTFORMATS',            'Dateiformate');
define('_MEDIAATTACH_ADMINTGROUPS',             'Dateiformat-Gruppen');
define('_MEDIAATTACH_ADMINTQUOTAS',             'Quotas');
define('_MEDIAATTACH_ADMINTCONFIG',             'Die Konfiguration von MediaAttach');
define('_MEDIAATTACH_ADMINTMANUAL',             'Das lesenswerte PDF-Handbuch');

define('_MEDIAATTACH_WELCOME',                  'Willkommen im MediaAttach-Adminbereich');
define('_MEDIAATTACH_FILESTOTAL',               '%count% Dateien insgesamt');
define('_MEDIAATTACH_ACTIONS',                  'Aktionen');
define('_MEDIAATTACH_NONE',                     'Keine');
define('_MEDIAATTACH_ONLYOWN',                  'Nur eigene');
define('_MEDIAATTACH_ALL',                      'Alle');


//Definitionen
define('_MEDIAATTACH_DEFINITIONDEFS',           'Upload-Definitionen');
define('_MEDIAATTACH_DEFINITIONNOMODULES',      'MediaAttach konnte keine Module finden, die MediaAttach aktiviert haben. Bitte gehen Sie zu den Modul-Einstellungen und aktivieren Sie MediaAttach bei ein oder mehreren Modulen Ihrer Wahl.');
define('_MEDIAATTACH_DEFINITIONMODNAME',        'Modul');
define('_MEDIAATTACH_DEFINITIONGROUPS',         'Gruppen');
define('_MEDIAATTACH_DEFINITIONDSPFILES',       'Hochgeladene Dateien im User-Bereich anzeigen');
define('_MEDIAATTACH_DEFINITIONSHOW',           'Definition anzeigen');
define('_MEDIAATTACH_DEFINITIONHIDE',           'Definition ausblenden');
define('_MEDIAATTACH_DEFINITIONFOR',            'Definition von');
define('_MEDIAATTACH_DEFINITIONSENDMAILS',      'Eine Mail beim Upload versenden');
define('_MEDIAATTACH_DEFINITIONRECIPIENT',      'Adressat der Mail');
define('_MEDIAATTACH_DEFINITIONMAXSIZE',        'Maximale Dateigröße beim Upload');
define('_MEDIAATTACH_DEFINITIONDOWNLOADMODE',   'Download-Modus');
define('_MEDIAATTACH_DEFINITIONPHYSICAL',       'Verlinkt');
define('_MEDIAATTACH_DEFINITIONINLINE',         'Eingebettet');
define('_MEDIAATTACH_DEFINITIONNAMING',         'Namensgebung');
define('_MEDIAATTACH_DEFINITIONNAMORIG',        'Originaler Dateiname');
define('_MEDIAATTACH_DEFINITIONNAMRAND',        'Zufalls-Dateiname');
define('_MEDIAATTACH_DEFINITIONNAMSTAT',        'Nummeriert mit Präfix');
define('_MEDIAATTACH_DEFINITIONPREFIX',         'Präfix');
define('_MEDIAATTACH_DEFINITIONNUMFILES',       'Anzahl von Dateien');
define('_MEDIAATTACH_DEFINITIONADD',            'Definition hinzufügen');
define('_MEDIAATTACH_DEFINITIONEDIT',           'Diese Definition editieren');
define('_MEDIAATTACH_DEFINITIONNEW',            'Eine neue Definition erstellen');
define('_MEDIAATTACH_DEFINITIONUPDATE',         'Diese Definition aktualisieren');

//Formate
define('_MEDIAATTACH_FORMATS',                  'Datei-Formate');
define('_MEDIAATTACH_FILETYPE',                 'Dateityp');
define('_MEDIAATTACH_IMAGE',                    'Bild');
define('_MEDIAATTACH_GROUPS',                   'Gruppen');
define('_MEDIAATTACH_FORMATADD',                'Dateityp hinzufügen');
define('_MEDIAATTACH_FORMATDELETE',             'Diesen Dateityp entfernen');
define('_MEDIAATTACH_FORMATEDIT',               'Diesen Dateityp editieren');
define('_MEDIAATTACH_FORMATNEW',                'Einen neuen Dateityp erstellen');
define('_MEDIAATTACH_FORMATUPDATE',             'Diesen Dateityp editieren');
define('_MEDIAATTACH_FORMATDANGER',             'Warnung: Die Freigabe dieses Dateitypes kann potentiell ein Sicherheitsrisiko darstellen!');

//Gruppen
define('_MEDIAATTACH_GROUPGROUPS',              'Datei-Gruppen');
define('_MEDIAATTACH_GROUPNAME',                'Name');
define('_MEDIAATTACH_GROUPDIR',                 'Verzeichnis');
define('_MEDIAATTACH_GROUPIMAGE',               'Bild');
define('_MEDIAATTACH_GROUPFORMATS',             'Dateitypen');
define('_MEDIAATTACH_GROUPADD',                 'Gruppe hinzufügen');
define('_MEDIAATTACH_GROUPDELETE',              'Diese Gruppe entfernen');
define('_MEDIAATTACH_GROUPEDIT',                'Diese Gruppe editieren');
define('_MEDIAATTACH_GROUPNEW',                 'Eine neue Gruppe erstellen');
define('_MEDIAATTACH_GROUPUPDATE',              'Diese Gruppe aktualisieren');

//Quotas
define('_MEDIAATTACH_QUOTASGROUPS',             'Gruppen');
define('_MEDIAATTACH_QUOTASUSERS',              'Benutzer');
define('_MEDIAATTACH_QUOTASNOUSERS',            'Keine Benutzer-Quotas angelegt');
define('_MEDIAATTACH_QUOTASNEWUSER',            'Neue Benutzer-Quota');
define('_MEDIAATTACH_QUOTASUSERCREATE',         'Quota erstellen');
define('_MEDIAATTACH_QUOTASGROUPNAME',          'Name');
define('_MEDIAATTACH_QUOTASUSERNAME',           'Name');
define('_MEDIAATTACH_QUOTASQUOTA'    ,          'Quota');
define('_MEDIAATTACH_QUOTASACTION',             'Abschicken');
define('_MEDIAATTACH_QUOTASUPDATE',             'Quotas editieren');
define('_MEDIAATTACH_QUOTASDELETE',             'Diese Quota entfernen');

//Konfig
define('_MEDIAATTACH_CONFIGURATION',            'Konfiguration');
define('_MEDIAATTACH_CONFIGIMAGE',              'Bildeinstellungen');
define('_MEDIAATTACH_CONFIGCATMODES',           'Kategorisierungseinstellungen');
define('_MEDIAATTACH_MEDIAATTACHDIR',           'MediaAttach Installations-Verzeichnis');
define('_MEDIAATTACH_DOCROOT',                  'WebRoot');
define('_MEDIAATTACH_UPLOADDIR',                'Upload-Verzeichnis (absolut, idealerweise außerhalb des WebRoots):');
define('_MEDIAATTACH_CACHEDIR',                 'Cache-Verzeichnis (relativ zum WebRoot):');
define('_MEDIAATTACH_DIROKAY',                  'Alles in Ordnung');
define('_MEDIAATTACH_DIRNOTWRITABLE',           'Der Webserver darf nicht in das Verzeichnis schreiben');
define('_MEDIAATTACH_DIRNODIR',                 'Das ist kein Verzeichnis');
define('_MEDIAATTACH_DIRNOTEXIST',              'Das Verzeichnis existiert nicht');
define('_MEDIAATTACH_MAILER',                   'Erlaube Benutzern das Versenden von Dateien per Mail an sich selbst');
define('_MEDIAATTACH_SENDFILES',                'Diese Funktion aktivieren');
define('_MEDIAATTACH_MAXMAILSIZE',              'Maximale Dateigröße in Mails:');
define('_MEDIAATTACH_USEQUOTA',                 'Quotas aktivieren');
define('_MEDIAATTACH_OWNHANDLING',              'Benutzer haben das Recht ihre eigenen Dateien zu verwalten');
define('_MEDIAATTACH_USEFRONTPAGE',             'Startseite im Userbereich aktivieren');
define('_MEDIAATTACH_USEACCOUNTPAGE',           'Account-Seite im Userbereich aktivieren');
define('_MEDIAATTACH_ALLOWOWNHANDLING',         'Diese Option erlauben');
define('_MEDIAATTACH_DEFAULTTHUMBSIZE',         'Standardgrößen von Thumbnails (Sie können beliebig viele Formate anlegen):');
define('_MEDIAATTACH_SHRINKIMAGES',             'Große Bilder verkleinern');
define('_MEDIAATTACH_DEFAULTSHRINKSIZE',        'Maximalgröße von Bildern:');
define('_MEDIAATTACH_CONFIGPIXEL',              'Pixel');
define('_MEDIAATTACH_USETHUMBCROPPER',          'Ausschneiden von Thumbnails erlauben');
define('_MEDIAATTACH_CROPSIZEMODE',             'Verhalten des Auswahlwerkzeugs');
define('_MEDIAATTACH_USECROPFIXEDSIZE',         'Standardgröße erzwingen');
define('_MEDIAATTACH_USECROPVARSIZEAR',         'Größe variabel halten und Bildproportionen erzwingen');
define('_MEDIAATTACH_USECROPVARSIZE',           'Größe und Bildproportionen variabel halten');

define('_MEDIAATTACH_CATMODECATEGORIES',        'MediaAttach-Kategorien (Categories-Modul)');
define('_MEDIAATTACH_CATMODEMODULES',           'Module');
define('_MEDIAATTACH_CATMODEUSERS',             'Benutzer');
define('_MEDIAATTACH_CATDEFAULTMODE',           'Standardmodus:');
define('_MEDIAATTACH_CATDEFAULTMODENONE',       'Keine Kategorisierung');
define('_MEDIAATTACH_CATDEFAULTMODECATEGORIES', 'Categories');
define('_MEDIAATTACH_CATDEFAULTMODEMODULES',    'Module');
define('_MEDIAATTACH_CATDEFAULTMODEUSERS',      'Benutzer');

define('_MEDIAATTACH_HTACCESSHINT',             'MediaAttach kann automatisch eine .htaccess-Datei in Ihr Upload-Verzeichnis schreiben um direkten Zugriff auf die hochgeladenen Dateien zu unterbinden. Man beachte, dass nicht alle Webserver .htaccess-Dateien supporten.');
define('_MEDIAATTACH_HTACCESSGENERATE',         '.htaccess generieren');

define('_MEDIAATTACH_PHPINISETTINGS',           'Wichtige Einstellungen in der php.ini, die bei Uploads relevant sind');
define('_MEDIAATTACH_VERSIONCHECK',             'Versions-Check');
define('_MEDIAATTACH_YOURVERSION',              'Ihre Version');
define('_MEDIAATTACH_NEWVERSION',               'Es ist eine neue Version vorhanden');
define('_MEDIAATTACH_DOWNLOADNOW',              'Jetzt herunterladen');
define('_MEDIAATTACH_TDOWNLOADNOW',             'Download der neuesten Version von MediaAttach');
define('_MEDIAATTACH_NONEWVERSION',             'Ihre Version ist die aktuelle');

define('_MEDIAATTACH_ACTION',                   'Aktion');

define('_MEDIAATTACH_NUMITEMS',                 'Anzahl der anzuzeigenden Dateien');
define('_MEDIAATTACH_FILEFILTER',               'Anzuzeigende Dateien');
define('_MEDIAATTACH_FORMATFILTER',             'Zeige nur Dateien mit diesen Formaten (optional)');
define('_MEDIAATTACH_DISPLAYTYPE',              'Sortierung');
define('_MEDIAATTACH_NEWESTFILES',              'Neueste Dateien');
define('_MEDIAATTACH_RANDOMFILES',              'Zufallsauswahl');

define('_MEDIAATTACH_FORMATSSHOW',              'anzeigen');
define('_MEDIAATTACH_FORMATSHIDE',              'ausblenden');

define('_MEDIAATTACH_MYUPLOADS',                'Meine Uploads');

define('_MEDIAATTACH_ADMINFILESHINT',           'Um Admin-Dateien zu benutzen, muss eine Definition für MediaAttach erstellt werden. Klicken Sie dazu im Menü auf "Definitionen".');

define('_MEDIAATTACH_IMPORTFILESFROMFS',        'Dateien aus einem Server-Verzeichnis importieren');
define('_MEDIAATTACH_IMPORTFILESFROMFSHINT',    'Einfach in das gewünschte Verzeichnis wechseln, die zu importierenden Dateien aussuchen und starten.');
define('_MEDIAATTACH_IMPORTFILESFROMMODULE',    'Dateien aus einem anderen Modul importieren');
define('_MEDIAATTACH_IMPORTFILESFROMMODULEHINT', 'MediaAttach hat folgende Module gefunden, aus denen Dateien importiert werden können.');
define('_MEDIAATTACH_IMPORTFILESFROMMODULEHINT2', 'Bestehende Hierarchien werden in Form von Categories konvertiert.');
define('_MEDIAATTACH_IMPORTLIMITSHINT',         'Die Größenbeschränkungen der normalen Uploads gelten hierbei nicht.');
define('_MEDIAATTACH_IMPORTSTART',              'Import starten');
define('_MEDIAATTACH_IMPORTCREATED',            'Die Datei wurde erfolgreich importiert');

define('_MEDIAATTACH_VALIDATIONGROUPNAMEREQUIRED',  'Bitte geben Sie den Namen der neuen Gruppe ein.');
define('_MEDIAATTACH_VALIDATIONGROUPNAMEALPHANUM',  'Der Name darf nur aus Buchstaben und Ziffern bestehen.');
define('_MEDIAATTACH_VALIDATIONDIRECTORYREQUIRED',  'Bitte geben Sie das Verzeichnis der neuen Gruppe ein.');
define('_MEDIAATTACH_VALIDATIONDIRECTORYALPHANUM',  'Das Verzeichnis darf nur aus Buchstaben und Ziffern bestehen.');
define('_MEDIAATTACH_VALIDATIONEXTENSIONREQUIRED',  'Bitte geben Sie die Erweiterung des neuen Dateityps ein.');
define('_MEDIAATTACH_VALIDATIONEXTENSIONALPHANUM',  'Die Erweiterung darf nur aus Buchstaben und Ziffern bestehen.');
define('_MEDIAATTACH_VALIDATIONCATEGORYNAMEREQUIRED',  'Bitte geben Sie den Namen der neuen Kategorie ein.');
define('_MEDIAATTACH_VALIDATIONCATEGORYNAMEALPHANUM',  'Der Name darf nur aus Buchstaben und Ziffern bestehen.');

define('_MEDIAATTACH_ERRORALLOWEDFILENUM',      'Sie dürfen nicht mehr als %m% Dateien auf einmal hochladen.');
define('_MEDIAATTACH_ERRORALREADYSELECTED',     'Diese Datei wurde bereits ausgesucht.');
define('_MEDIAATTACH_ERROREXTENSIONNOTALLOWED', 'Das Format dieser Datei ist nicht erlaubt.');
define('_MEDIAATTACH_ERRORNOFILESSELECTED',     'Es wurde keine Datei ausgesucht.');
define('_MEDIAATTACH_ERRORALREADYRUNNING',      'Es wird bereits eine Datei hochgeladen.');

define('_MEDIAATTACH_ADDFILE',                  'Datei hinzu');
define('_MEDIAATTACH_INFOFORATTACHMENTBOX',     'Die Dateien werden hier aufgelistet.');
define('_MEDIAATTACH_INFOFORDROPBOX',           'Dateien hierhin ziehen um sie wieder zu entfernen.');
define('_MEDIAATTACH_UPLOADING',                'Upload gestartet...');


define('_MEDIAATTACH_FILEINFOGENERALINFO',      'Allgemeine Infos');
define('_MEDIAATTACH_FILEINFOFILETYPE',         'Dateityp:');
define('_MEDIAATTACH_FILEINFOFILESIZE',         'Dateigröße:');
define('_MEDIAATTACH_FILEINFOMIMETYPE',         'Mimetyp:');
define('_MEDIAATTACH_FILEINFOENCODING',         'Kodierung:');
define('_MEDIAATTACH_FILEINFOPLAYTIME',         'Dauer:');
define('_MEDIAATTACH_FILEINFOSECONDS',          'Sek.');

define('_MEDIAATTACH_FILEINFOHASHINFO',         'Hash Info');
define('_MEDIAATTACH_FILEINFOMD5ENTIREFILE',    'md5 gesamte Datei:');
define('_MEDIAATTACH_FILEINFOMD5CRAWDATA',      'md5 komprimierte Raw-Daten:');
define('_MEDIAATTACH_FILEINFOMD5URAWDATA',      'md5 unkomprimierte Raw-Daten:');
define('_MEDIAATTACH_FILEINFOMD5RAWDATA',       'md5 Raw-Daten:');
define('_MEDIAATTACH_FILEINFOSHA1ENTIREFILE',   'sha1 gesamte Datei:');
define('_MEDIAATTACH_FILEINFOSHA1RAWDATA',      'sha1 Raw-Daten:');

define('_MEDIAATTACH_FILEINFOAUDIOINFO',        'Audio Info');
define('_MEDIAATTACH_FILEINFOIMAGEINFO',        'Image Info');
define('_MEDIAATTACH_FILEINFOVIDEOINFO',        'Video Info');
define('_MEDIAATTACH_FILEINFOAVGBITRATE',       'Durchschnittliche Bitrate:');
define('_MEDIAATTACH_FILEINFOKBPS',             'kbps');
define('_MEDIAATTACH_FILEINFOBITRATEMODE',      'Bitrate-Modus:');
define('_MEDIAATTACH_FILEINFOBITRATECBR',       'CBR (Konstante Bitrate)');
define('_MEDIAATTACH_FILEINFOBITRATEVBR',       'VBR (Variable Bitrate)');
define('_MEDIAATTACH_FILEINFOSAMPLERATE',       'Sample-Rate:');
define('_MEDIAATTACH_FILEINFOHERTZ',            'Hertz');
define('_MEDIAATTACH_FILEINFOBITSPERSAMPLE',    'Bits pro Sample:');
define('_MEDIAATTACH_FILEINFOCHANNELMODE',      'Channelmodus:');
define('_MEDIAATTACH_FILEINFONOOFCHANNELS',     'Anzahl Channels:');
define('_MEDIAATTACH_FILEINFOAUDIOCODEC',       'Audio Kompressions-Codec:');
define('_MEDIAATTACH_FILEINFOVIDEOCODEC',       'Video Compressions-Codec:');
define('_MEDIAATTACH_FILEINFOENCODER',          'Kodierer:');
define('_MEDIAATTACH_FILEINFOCOMPRESSIONRATIO', 'Kompressionsrate:');
define('_MEDIAATTACH_FILEINFOLOSSLESS',         'Verlust:');
define('_MEDIAATTACH_FILEINFOLOSSLESSCOMP',     'verlustfreie Kompression');
define('_MEDIAATTACH_FILEINFOLOSSYCOMP',        'verlustbehaftete Kompression');
define('_MEDIAATTACH_FILEINFOFRAMERATE',        'Frame-Rate:');
define('_MEDIAATTACH_FILEINFOFPS',              'fps');
define('_MEDIAATTACH_FILEINFOSIZE',             'Größe:');
define('_MEDIAATTACH_FILEINFOWIDTH',            'Breite:');
define('_MEDIAATTACH_FILEINFOHEIGHT',           'Höhe:');
define('_MEDIAATTACH_FILEINFOPIXEL',            'Pixel');
define('_MEDIAATTACH_FILEINFOPIXELDAR',         'Pixel display aspect ratio:');
define('_MEDIAATTACH_FILEINFOBGCOLOR',          'Hintergrundfarbe:');
define('_MEDIAATTACH_FILEINFOTAGINFO',          'Tag Info');
define('_MEDIAATTACH_FILEINFOEXIF',             'EXIF-Info');

define('_MEDIAATTACH_PROFILEUPLOADS',           'Upload-Status');
define('_MEDIAATTACH_PROFILEFILESUPLOADED',     '%count% Dateien hochgeladen');
define('_MEDIAATTACH_PROFILETOTAL',             'insgesamt');

define('_MEDIAATTACH_EXTERNALONLYIMAGES',       'Nur Bilder');
define('_MEDIAATTACH_EXTERNALOUTPUT',           'Darstellungsmodus');
define('_MEDIAATTACH_EXTERNALOUTPUTLINK',       'Link zu der Datei');
define('_MEDIAATTACH_EXTERNALOUTPUTINLINE',     'Eingebettete Anzeige');
define('_MEDIAATTACH_EXTERNALOUTPUTPHYSICAL',   'Verlinkte Anzeige');
define('_MEDIAATTACH_EXTERNALPASTEAS',          'Einfügen als');
define('_MEDIAATTACH_EXTERNALPASTETHUMBWITHLINK', 'Thumbnail mit Link zur Ansicht des Originalbildes');
define('_MEDIAATTACH_EXTERNALPASTETHUMBWITHLINKDL', 'Thumbnail mit Link zum Download des Originalbildes');
define('_MEDIAATTACH_EXTERNALPASTETHUMB',       'Thumbnail');
define('_MEDIAATTACH_EXTERNALPASTEORIGINAL',    'Originalbild');
define('_MEDIAATTACH_EXTERNALPASTETHUMBLINK',   'Link zum Thumbnail');
define('_MEDIAATTACH_EXTERNALPASTEORIGINALLINK', 'Link zum Originalbild');
define('_MEDIAATTACH_EXTERNALPASTEID',           'ID der Datei');

define('_MEDIAATTACH_CATMODE',                  'Anzeigemodus:');
define('_MEDIAATTACH_PREVIEW',                  'Vorschau');
define('_MEDIAATTACH_ONLYIMAGES',               'Nur Bilder');

define('_MEDIAATTACH_SWFBROWSEFILES',           'Dateien auswählen');
define('_MEDIAATTACH_SWFQUEUEISEMPTY',          'Keine Dateien ausgewählt');
define('_MEDIAATTACH_SWFCANCELQUEUE',           'Liste abbrechen');
define('_MEDIAATTACH_SWFFILESELECTION',         'MediaAttach-Dateien...');
define('_MEDIAATTACH_SWFCBFILEQUEUE',           'Datei-Liste');
define('_MEDIAATTACH_SWFCBFILECANCELLED',       'abgebrochen');
define('_MEDIAATTACH_SWFCBFILESQUEUED',         'Dateien in der Liste');
define('_MEDIAATTACH_SWFCBUPLOADINGFILE',       'Lade Datei');
define('_MEDIAATTACH_SWFCBUPLOADINGOF',         'von');
define('_MEDIAATTACH_SWFALLFILESUPLOADED',      'Alle Dateien hochgeladen...');

define('_MEDIAATTACH_LINKEXTVIDEO',             'Externes Video einbinden');
define('_MEDIAATTACH_EXTVIDEOURL',              'Video-Seite des Anbieters');
define('_MEDIAATTACH_EXTVIDEOSUPPORTED',        'Unterstützte Anbieter');
define('_MEDIAATTACH_EXTVIDCREATED',            'Das Video wurde erfolgreich eingebunden');
define('_MEDIAATTACH_EXTVIDERRORDOMAIN',        'Fehler: dies ist eine ungültige oder nicht unterstützte URL.');
define('_MEDIAATTACH_EXTVIDERRORGRAB',          'Sorry, konnte die Video-Informationen nicht ermitteln.');

define('_MEDIAATTACH_CROPTHUMBDEACTIVATED',     'Das Ausschneiden von Vorschaubildern ist deaktiviert.');
define('_MEDIAATTACH_CROPTHUMB',                'Vorschaubild ausschneiden');
define('_MEDIAATTACH_CROPCHOOSE',               'Wählen Sie Ihr gewünschtes Vorschaubild aus.');
define('_MEDIAATTACH_CROPFIXEDSIZE',            'Die Größe des Auswahlfensters ist nicht veränderbar.');
define('_MEDIAATTACH_CROPVARSIZEAR',            'Die Größe des Auswahlfensters ist veränderbar, die Bildproportionen bleiben dabei erhalten.');
define('_MEDIAATTACH_CROPVARSIZE',              'Die Größe des Auswahlfensters und die Bildproportionen sind veränderbar.');
define('_MEDIAATTACH_CROPNOSCRIPT',             'Diese Funktion benötigt JavaScript.');

define('_CATREGCREATEFAILED',                   'Es ist ein Fehler beim Erstellen der Category-Registries aufgetreten.');
define('_CATREGDELETEFAILED',                   'Es ist ein Fehler beim Entfernen der Category-Registries aufgetreten.');
define('_REGISTERSELFFAILED',                   'Die Admin-Uploads konnten nicht automatisch freigeschaltet werden. Dies ist nicht kritisch.');

