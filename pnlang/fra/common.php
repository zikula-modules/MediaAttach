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

/**
 * translated by
 * @author Yokav
 */

define('_MEDIAATTACH',                          'MediaAttach');

define('_MEDIAATTACH_UPLOAD',                   'Dépôt');
define('_MEDIAATTACH_UPLOADFILES',              'Dépôt de fichiers');
define('_MEDIAATTACH_UPLOADAFILE',              'Déposer un fichier');
define('_MEDIAATTACH_DESC',                     'Description');
define('_MEDIAATTACH_GROUP',                    'Groupe');
define('_MEDIAATTACH_ALLOWEDFORMATS',           'Formats autorisés');
define('_MEDIAATTACH_MAXSIZE',                  'Taille Max.');
define('_MEDIAATTACH_MAXFILES',                 'Fichiers Max.');
define('_MEDIAATTACH_MAXIMUMS',                 'Maximums');
define('_MEDIAATTACH_MAXIMUMFILES',             'fichiers');
define('_MEDIAATTACH_QUOTA',                    'Quota');
define('_MEDIAATTACH_QUOTAYOUHAVE',             'Vous avez');
define('_MEDIAATTACH_QUOTAOF',                  'de');
define('_MEDIAATTACH_QUOTAUSED',                'utilisé');
define('_MEDIAATTACH_QUOTAFULL',                'Vous n\'avez pas assez de mémoire pour que les transferts soient possible');
define('_MEDIAATTACH_FILE',                     'Fichier');
define('_MEDIAATTACH_TITLE',                    'Titre');
define('_MEDIAATTACH_DESCRIPTION',              'Description');
define('_MEDIAATTACH_INFO',                     'Info');
define('_MEDIAATTACH_FILESIZE',                 'Taille');
define('_MEDIAATTACH_ATTACHMENT',               'Fichier attaché');
define('_MEDIAATTACH_ADMINATTACHMENT',          'Administrer les fichiers');
define('_MEDIAATTACH_UPLOADCREATED',            'Fichier déposé avec succès');
define('_MEDIAATTACH_NEWMAILSUBJECT',           'Un nouveau fichier a été déposé');
define('_MEDIAATTACH_NEWMAILBODY',              'Bonjour! Voici des infos à propos de ce fichier');
define('_MEDIAATTACH_DLMAILSUBJECT',            'Votre fichier déposé');
define('_MEDIAATTACH_DLMAILBODY',               'Bonjour! Voici le fichier que vous avez déposé sur notre site');
define('_MEDIAATTACH_DOWNLOADIT',               'Télécharger ce fichier');
define('_MEDIAATTACH_VIEWIT',                   'Voir le fichier');
define('_MEDIAATTACH_SENDIT',                   'Envoyer le fichier à votre adresse de courriel');
define('_MEDIAATTACH_FILEINFO',                 'Information à propos de ce fichier');
define('_MEDIAATTACH_TOPROFILE',                'Pour le profil de');
define('_MEDIAATTACH_UPLOADMAILSENT',           'Le courriel a été envoyé avec succès');
define('_MEDIAATTACH_UPLOADMAILNOTSENT',        'Désolé, nous ne pouvons vous envoyer ce courriel.');

define('_MEDIAATTACH_BYTES',                    'Bits');
define('_MEDIAATTACH_KB',                       'KB');
define('_MEDIAATTACH_MB',                       'MB');
define('_MEDIAATTACH_GB',                       'GB');

define('_MEDIAATTACH_NORIGHTS',                 'Désolé, vous n\'avez pas la permission de déposer des fichiers');
define('_MEDIAATTACH_NOANON',                   'Désolé, seuls les membres enregistrés peuvent déposer des fichiers');
define('_MEDIAATTACH_DIRERR',                   'Désolé, MediaAttach n\'est pas encore configuré');
define('_MEDIAATTACH_ERROK',                    'Il y a un problème de transfert');
define('_MEDIAATTACH_ERRINISIZE',               'Le fichier est trop gros');
define('_MEDIAATTACH_ERRFORMSIZE',              'Le fichier est trop gros');
define('_MEDIAATTACH_ERRPARTIAL',               'Le fichier a été transféré partiellement');
define('_MEDIAATTACH_ERRNOFILE',                'Pas de fichier sélectionné');
define('_MEDIAATTACH_ERRNOTMPDIR',              'Aucun répertoire temporaire spécifié');
define('_MEDIAATTACH_ERRFORMAT',                'Format de fichier non autorisé');
define('_MEDIAATTACH_ERRSIZE',                  'Le fichier est supérieur à la taille autorisée');
define('_MEDIAATTACH_ERRSAMENAME',              'Il y a déjà un fichier qui porte exactement le même nom');
define('_MEDIAATTACH_ERRMOVE',                  'Des problèmes ce sont produits pendant le traitement de ce fichier');

define('_MEDIAATTACH_ERRINSERTFILE',            'Désolé, les données de votre fichier ne peuvent être stockées dans la base de données');
define('_MEDIAATTACH_WARNINGMULTIPLEPAGES',     'Merci de choisir le fichier que vous allez soumettre au final (pas de prévisualisation intermédiaire), sinon il ne sera pas stocké correctement. Cette fonctionnalité sera implémenter prochaînement.');

//Upload files
define('_MEDIAATTACH_NOTITLE',                  'Pas de titre');
define('_MEDIAATTACH_UPLOADUPLOAD',             'Nouveaux dépôts');
define('_MEDIAATTACH_UPLOADFILE',               'Fichier');
define('_MEDIAATTACH_UPLOADMODNAME',            'Module');
define('_MEDIAATTACH_UPLOADUSER',               'Utilisateur');
define('_MEDIAATTACH_UPLOADDATE',               'Date');
define('_MEDIAATTACH_UPLOADTITLE',              'Titre');
define('_MEDIAATTACH_UPLOADDESC',               'Description');
define('_MEDIAATTACH_UPLOADMIMETYPE',           'Type Mime');
define('_MEDIAATTACH_UPLOADFILESIZE',           'Taille');
define('_MEDIAATTACH_UPLOADDELETE',             'Supprimer ce fichier');
define('_MEDIAATTACH_UPLOADEDIT',               'Editer ce fichier');
define('_MEDIAATTACH_UPLOADUPDATE',             'Mettre à jour ce fichier');
define('_MEDIAATTACH_UPLOADDLCOUNT',            '%count% temps de transfert');
define('_MEDIAATTACH_UPLOADNOUPLOADS',          'Aucun fichier déposé actuellement');
define('_MEDIAATTACH_UPLOADNOIMAGES',           'Aucune images actuellement');
define('_MEDIAATTACH_UPLOADFILTERBY',           'Filtrer par');
define('_MEDIAATTACH_UPLOADSORTBY',             'Trier par');
define('_MEDIAATTACH_UPLOADSORTBYDATE',         'date');
define('_MEDIAATTACH_UPLOADSORTBYTITLE',        'titre');
define('_MEDIAATTACH_UPLOADSORTBYMODULE',       'module');
define('_MEDIAATTACH_UPLOADSORTBYUSERNAME',     'utilisateur');
define('_MEDIAATTACH_UPLOADSORTBYFILENAME',     'nom de fichier');
define('_MEDIAATTACH_UPLOADSORTBYFILETYPE',     'type');
define('_MEDIAATTACH_UPLOADSORTBYFILESIZE',     'taille');
define('_MEDIAATTACH_UPLOADSORTDIRASC',         'ascendant');
define('_MEDIAATTACH_UPLOADSORTDIRDESC',        'descendant');
define('_MEDIAATTACH_UPLOADPERPAGE',            'Résultats par page');

define('_MEDIAATTACH_SEARCHINCLUDE_TITLE',          'Fichiers et médias');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBY',         'Trier par');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYDATE',     'date');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYTITLE',    'titre');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYMODULE',   'module');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYUSERNAME', 'utilisateur');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILENAME', 'nom de fichier');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILETYPE', 'type');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILESIZE', 'taille');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTDIRASC',     'ascendant');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTDIRDESC',    'descendant');

define('_MEDIAATTACH_SEARCHINCLUDE_RESULTS',    'Dépôts');
define('_MEDIAATTACH_SEARCHINCLUDE_HITS',       'Résultats');
define('_MEDIAATTACH_SEARCHINCLUDE_NOENTRIES',  'Aucun résultat');
define('_MEDIAATTACH_FROM',                     'depuis');
define('_MEDIAATTACH_ON',                       'sur');

define('_MEDIAATTACH_ADMINMAIN',                'Départ');
define('_MEDIAATTACH_ADMINADMINUPLOADS',        'Dépôts Admin');
define('_MEDIAATTACH_ADMINUSERUPLOADS',         'Dépôts Utilisateur');
define('_MEDIAATTACH_ADMINDEFINITIONS',         'Définitions');
define('_MEDIAATTACH_ADMINFORMATS',             'Formats');
define('_MEDIAATTACH_ADMINGROUPS',              'Groupes');
define('_MEDIAATTACH_ADMINQUOTAS',              'Quotas');
define('_MEDIAATTACH_ADMINCONFIG',              'Config');
define('_MEDIAATTACH_ADMINMANUAL',              'Manuel');
define('_MEDIAATTACH_ADMINTMAIN',               'Aller à la page Admin de MediaAttach');
define('_MEDIAATTACH_ADMINTADMINUPLOADS',       'Déposer et importer des fichiers Admin');
define('_MEDIAATTACH_ADMINTUSERUPLOADS',        'Gestionnaire des fichiers utilisateurs');
define('_MEDIAATTACH_ADMINTDEFINITIONS',        'Gérer les définitions du module');
define('_MEDIAATTACH_ADMINTFORMATS',            'Formats de fichiers');
define('_MEDIAATTACH_ADMINTGROUPS',             'Groupe de formats');
define('_MEDIAATTACH_ADMINTQUOTAS',             'Quotas');
define('_MEDIAATTACH_ADMINTCONFIG',             'Configuration de MediaAttach');
define('_MEDIAATTACH_ADMINTMANUAL',             'Lire le manuel (pdf)');

define('_MEDIAATTACH_WELCOME',                  'Bienvenue dans l\'aire Admin de MediaAttach admin area');
define('_MEDIAATTACH_FILESTOTAL',               '%count% fichiers total');
define('_MEDIAATTACH_ACTIONS',                  'Actions');
define('_MEDIAATTACH_NONE',                     'Aucune');
define('_MEDIAATTACH_ONLYOWN',                  'La sienne seulement');
define('_MEDIAATTACH_ALL',                      'Toutes');


//Definitions
define('_MEDIAATTACH_DEFINITIONDEFS',           'Définitions du dépôt');
define('_MEDIAATTACH_DEFINITIONNOMODULES',      'MediaAttach ne trouve pas le module pour lequel il a été activé. Merci de vous rendre dans le module de configuration des Modules et d\'activer MediaAttach comme hook pour un ou plusieurs modules de votre choix.');
define('_MEDIAATTACH_DEFINITIONMODNAME',        'Module');
define('_MEDIAATTACH_DEFINITIONGROUPS',         'Groupes');
define('_MEDIAATTACH_DEFINITIONSHOW',           'Montrer la définition');
define('_MEDIAATTACH_DEFINITIONHIDE',           'Masquer la définition');
define('_MEDIAATTACH_DEFINITIONFOR',            'Définition pour');
define('_MEDIAATTACH_DEFINITIONDSPFILES',       'Montrer les fichiers déposés dans la partie utilisateur');
define('_MEDIAATTACH_DEFINITIONSENDMAILS',      'Envoyer un courriel après le transfert');
define('_MEDIAATTACH_DEFINITIONRECIPIENT',      'Destinataire du courriel');
define('_MEDIAATTACH_DEFINITIONMAXSIZE',        'Maximum de fichiers pendant le transfert');
define('_MEDIAATTACH_DEFINITIONDOWNLOADMODE',   'Mode de téléchargement');
define('_MEDIAATTACH_DEFINITIONPHYSICAL',       'Physique');
define('_MEDIAATTACH_DEFINITIONINLINE',         'En ligne');
define('_MEDIAATTACH_DEFINITIONNAMING',         'Convention de nommage');
define('_MEDIAATTACH_DEFINITIONNAMORIG',        'Nom orignel');
define('_MEDIAATTACH_DEFINITIONNAMRAND',        'Nom aléatoire');
define('_MEDIAATTACH_DEFINITIONNAMSTAT',        'Numéroté avec préfixe');
define('_MEDIAATTACH_DEFINITIONPREFIX',         'Préfixe');
define('_MEDIAATTACH_DEFINITIONNUMFILES',       'Nombre de fichiers');
define('_MEDIAATTACH_DEFINITIONADD',            'Ajouter une définition');
define('_MEDIAATTACH_DEFINITIONEDIT',           'Editer cette définition');
define('_MEDIAATTACH_DEFINITIONNEW',            'Créer une nouvelle défiinition');
define('_MEDIAATTACH_DEFINITIONUPDATE',         'Actualiser cette définition');

//Formats
define('_MEDIAATTACH_FORMATS',                  'Formats de fichier');
define('_MEDIAATTACH_FILETYPE',                 'Type');
define('_MEDIAATTACH_IMAGE',                    'Image');
define('_MEDIAATTACH_GROUPS',                   'Groupes');
define('_MEDIAATTACH_FORMATADD',                'Ajouter un type');
define('_MEDIAATTACH_FORMATDELETE',             'Supprimer ce type');
define('_MEDIAATTACH_FORMATEDIT',               'Editer ce type');
define('_MEDIAATTACH_FORMATNEW',                'Créer un nouveau type');
define('_MEDIAATTACH_FORMATUPDATE',             'Actualiser ce type');
define('_MEDIAATTACH_FORMATDANGER',             'Attention : Autoriser ce type ouvre un risque potentiel !');

//Groups
define('_MEDIAATTACH_GROUPGROUPS',              'Groupes de formats');
define('_MEDIAATTACH_GROUPNAME',                'Noms');
define('_MEDIAATTACH_GROUPDIR',                 'Répertoires');
define('_MEDIAATTACH_GROUPIMAGE',               'Image');
define('_MEDIAATTACH_GROUPFORMATS',             'Types');
define('_MEDIAATTACH_GROUPADD',                 'Ajouter un groupe');
define('_MEDIAATTACH_GROUPDELETE',              'Supprimer ce groupe');
define('_MEDIAATTACH_GROUPEDIT',                'Editer ce groupe');
define('_MEDIAATTACH_GROUPNEW',                 'Créer un nouveau groupe');
define('_MEDIAATTACH_GROUPUPDATE',              'Actualiser ce groupe');

//Quotas
define('_MEDIAATTACH_QUOTASGROUPS',             'Groupes');
define('_MEDIAATTACH_QUOTASUSERS',              'Utilisateurs');
define('_MEDIAATTACH_QUOTASNOUSERS',            'Pas de quotas utilisateur définis');
define('_MEDIAATTACH_QUOTASNEWUSER',            'Nouveau quota utilisateur');
define('_MEDIAATTACH_QUOTASUSERCREATE',         'Créer un quota');
define('_MEDIAATTACH_QUOTASGROUPNAME',          'Nom');
define('_MEDIAATTACH_QUOTASUSERNAME',           'Nom');
define('_MEDIAATTACH_QUOTASQUOTA'    ,          'Quota');
define('_MEDIAATTACH_QUOTASACTION',             'Envoyer');
define('_MEDIAATTACH_QUOTASUPDATE',             'Modifier les quotas');
define('_MEDIAATTACH_QUOTASDELETE',             'Supprimer ce quota');

//Configuration
define('_MEDIAATTACH_CONFIGURATION',            'Configuration');
define('_MEDIAATTACH_CONFIGIMAGE',              'Paramètres images');
define('_MEDIAATTACH_CONFIGCATMODES',           'Paramètres de catégorisation');
define('_MEDIAATTACH_MEDIAATTACHDIR',           'Répertoire de MediaAttach');
define('_MEDIAATTACH_DOCROOT',                  'racine HTML');
define('_MEDIAATTACH_UPLOADDIR',                'Répertoire de dépôt (absolu et de préférence en dehors du répertoire racine HTML):');
define('_MEDIAATTACH_CACHEDIR',                 'Répertoire cache (relatif au réêrtpore HTML racine):');
define('_MEDIAATTACH_DIROKAY',                  'Tout est bon');
define('_MEDIAATTACH_DIRNOTWRITABLE',           'Ecriture impossible dans ce répertoire (changer les permissions)');
define('_MEDIAATTACH_DIRNODIR',                 'Ce n\'est pas un répertoire');
define('_MEDIAATTACH_DIRNOTEXIST',              'Ce répertoire n\'exite pas');
define('_MEDIAATTACH_MAILER',                   'Autoriser les utilisateurs à s\'envoyer à eux-mêmes des fichiers');
define('_MEDIAATTACH_SENDFILES',                'Activer cette fonction');
define('_MEDIAATTACH_MAXMAILSIZE',              'Taille maximum par courriel:');
define('_MEDIAATTACH_USEQUOTA',                 'Activer les quotas');
define('_MEDIAATTACH_OWNHANDLING',              'Les utilisateurs peuvent éditer et supprimer leurs propres fichiers');
define('_MEDIAATTACH_USEFRONTPAGE',             'Activer la page de démarrage dans la partie utilisateurs');
define('_MEDIAATTACH_USEACCOUNTPAGE',           'Activer la page de account dans la partie utilisateurs');
define('_MEDIAATTACH_ALLOWOWNHANDLING',         'Autoriser cette option');
define('_MEDIAATTACH_DEFAULTTHUMBSIZE',         'Taille par défaut des vignettes (Vous pouvez créer autant de formats que nécessaires):');
define('_MEDIAATTACH_SHRINKIMAGES',             'Adapter les grosses images');
define('_MEDIAATTACH_DEFAULTSHRINKSIZE',        'Taille maximum des images:');
define('_MEDIAATTACH_CONFIGPIXEL',              'pixels');
define('_MEDIAATTACH_USETHUMBCROPPER',          'Autoriser le recadrage des vignettes');
define('_MEDIAATTACH_CROPSIZEMODE',             'Comportement de l\'outil de sélection');
define('_MEDIAATTACH_USECROPFIXEDSIZE',         'Forcer la taille par défaut');
define('_MEDIAATTACH_USECROPVARSIZEAR',         'Conserver la taille variable et forcer le ratio');
define('_MEDIAATTACH_USECROPVARSIZE',           'Conserver la taille et le ratio variables');

define('_MEDIAATTACH_CATMODECATEGORIES',        'MediaAttach catégories (Categories module)');
define('_MEDIAATTACH_CATMODEMODULES',           'Modules');
define('_MEDIAATTACH_CATMODEUSERS',             'Utilisateurs');
define('_MEDIAATTACH_CATDEFAULTMODE',           'Mode par défautl:');
define('_MEDIAATTACH_CATDEFAULTMODENONE',       'Pas de catégorisation');
define('_MEDIAATTACH_CATDEFAULTMODECATEGORIES', 'Catégories');
define('_MEDIAATTACH_CATDEFAULTMODEMODULES',    'Modules');
define('_MEDIAATTACH_CATDEFAULTMODEUSERS',      'Utilisateurs');

define('_MEDIAATTACH_HTACCESSHINT',             'MediaAttach peut écrire automatiquement un fichier .htaccess dans le répertoire de dépôt pour empêcher les téléchargements direct. Notez que tous les serveurs ne supportent pas  ces fichiers .htaccess.');
define('_MEDIAATTACH_HTACCESSGENERATE',         'Générer .htaccess');

define('_MEDIAATTACH_PHPINISETTINGS',           'Paramètres important du  php.ini, utiles pour les dépôts');
define('_MEDIAATTACH_VERSIONCHECK',             'Version-Check');
define('_MEDIAATTACH_YOURVERSION',              'Votre version');
define('_MEDIAATTACH_NEWVERSION',               'Il y a une nouvelle version');
define('_MEDIAATTACH_DOWNLOADNOW',              'Télécharger maintenant');
define('_MEDIAATTACH_TDOWNLOADNOW',             'Télécharger la dernière version de MediaAttach');
define('_MEDIAATTACH_NONEWVERSION',             'Votre version est la plus récente');

define('_MEDIAATTACH_ACTION',                   'Action');

define('_MEDIAATTACH_FILEFILTER',               'Fichiers à montrer');
define('_MEDIAATTACH_NUMITEMS',                 'Nombre de fichiers à afficher');
define('_MEDIAATTACH_FORMATFILTER',             'Montrer seulement les fichiers de ces formats (optionel)');
define('_MEDIAATTACH_DISPLAYTYPE',              'Tri en cours');
define('_MEDIAATTACH_NEWESTFILES',              'Derniers fichiers');
define('_MEDIAATTACH_RANDOMFILES',              'Fichiers aléatoires');

define('_MEDIAATTACH_FORMATSSHOW',              'montrer');
define('_MEDIAATTACH_FORMATSHIDE',              'masquer');

define('_MEDIAATTACH_MYUPLOADS',                'Mes dépôts');

define('_MEDIAATTACH_ADMINFILESHINT',           'Pour utiliser les fichiers admin, une définition doit être créée pour MediaAttach. Cliquez sur le menu "Définitions".');

define('_MEDIAATTACH_IMPORTFILESFROMFS',        'Importer des fichiers depuis un répertoire du serveur');
define('_MEDIAATTACH_IMPORTFILESFROMFSHINT',    'Aller dans le répertoire à importer, sélectionner les fichiersà importer et démarrer. La limite de la taille de dépôt est désactivée dans ce cas.');
define('_MEDIAATTACH_IMPORTFILESFROMMODULE',    'Importer des fichiers depuis un autre module');
define('_MEDIAATTACH_IMPORTFILESFROMMODULEHINT', 'MediaAttach peut importer les fichiers des modules suivants :');
define('_MEDIAATTACH_IMPORTFILESFROMMODULEHINT2', 'Les hiérarchies existantes seront converties en Catégories.');
define('_MEDIAATTACH_IMPORTLIMITSHINT',         'La limite de la taille de dépôt est désactivée dans ce cas.');
define('_MEDIAATTACH_IMPORTSTART',              'Importer');
define('_MEDIAATTACH_IMPORTCREATED',            'Fichier importé avec succès');

define('_MEDIAATTACH_VALIDATIONGROUPNAMEREQUIRED',  'Merci de saisir un nom pour le nouveau groupe.');
define('_MEDIAATTACH_VALIDATIONGROUPNAMEALPHANUM',  'Le nom de groupe ne peut contenir que des lettres et des chiffres.');
define('_MEDIAATTACH_VALIDATIONDIRECTORYREQUIRED',  'Sélectionner un répertoire pour le groupe');
define('_MEDIAATTACH_VALIDATIONDIRECTORYALPHANUM',  'Le nom de répertoire ne peut contenir que des lettres et des chiffres..');
define('_MEDIAATTACH_VALIDATIONEXTENSIONREQUIRED',  'Merci de saisir un nouveau nom pour cette extension.');
define('_MEDIAATTACH_VALIDATIONEXTENSIONALPHANUM',  'L\'extension ne peut contenir que des lettres et des chiffres.');
define('_MEDIAATTACH_VALIDATIONCATEGORYNAMEREQUIRED',  'Merci de saisir un nouveau nom de catégorie');
define('_MEDIAATTACH_VALIDATIONCATEGORYNAMEALPHANUM',  'Le nom de catégorie ne peut contenir que des lettres et des chiffres.');

define('_MEDIAATTACH_ERRORALLOWEDFILENUM',      'Vous n\'êtes pas autorisés à déposer plus %m% fichiers à la fois.');
define('_MEDIAATTACH_ERRORALREADYSELECTED',     'ce fichier est déjà sélectionné.');
define('_MEDIAATTACH_ERROREXTENSIONNOTALLOWED', 'Type non autorisé.');
define('_MEDIAATTACH_ERRORNOFILESSELECTED',     'Aucun fichier choisi.');
define('_MEDIAATTACH_ERRORALREADYRUNNING',      'Il y a déjà un transfert en cours.');

define('_MEDIAATTACH_ADDFILE',                  'Ajouter un fichier');
define('_MEDIAATTACH_INFOFORATTACHMENTBOX',     'Les fichiers ajoutés sont listés ici.');
define('_MEDIAATTACH_INFOFORDROPBOX',           'Déplacer ici les fichiers que vous ne souhaitez plus ajouter.');
define('_MEDIAATTACH_UPLOADING',                'Transfert en cours...');

define('_MEDIAATTACH_FILEINFOGENERALINFO',      'Information générale');
define('_MEDIAATTACH_FILEINFOFILETYPE',         'Type:');
define('_MEDIAATTACH_FILEINFOFILESIZE',         'Taille:');
define('_MEDIAATTACH_FILEINFOMIMETYPE',         'Type Mime:');
define('_MEDIAATTACH_FILEINFOENCODING',         'Encodage:');
define('_MEDIAATTACH_FILEINFOPLAYTIME',         'Durée:');
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
define('_MEDIAATTACH_FILEINFOBITSPERSAMPLE',    'Bits par sample:');
define('_MEDIAATTACH_FILEINFOCHANNELMODE',      'Channelmode:');
define('_MEDIAATTACH_FILEINFONOOFCHANNELS',     'No. de channels:');
define('_MEDIAATTACH_FILEINFOAUDIOCODEC',       'Audio compression codec:');
define('_MEDIAATTACH_FILEINFOVIDEOCODEC',       'Video compression codec:');
define('_MEDIAATTACH_FILEINFOENCODER',          'Encoder:');
define('_MEDIAATTACH_FILEINFOCOMPRESSIONRATIO', 'Compression ratio:');
define('_MEDIAATTACH_FILEINFOLOSSLESS',         'Lossless:');
define('_MEDIAATTACH_FILEINFOLOSSLESSCOMP',     'lossless compression');
define('_MEDIAATTACH_FILEINFOLOSSYCOMP',        'lossy compression');
define('_MEDIAATTACH_FILEINFOFRAMERATE',        'Frame rate:');
define('_MEDIAATTACH_FILEINFOFPS',              'fps');
define('_MEDIAATTACH_FILEINFOSIZE',             'Taille:');
define('_MEDIAATTACH_FILEINFOWIDTH',            'Largeur:');
define('_MEDIAATTACH_FILEINFOHEIGHT',           'Hauteur:');
define('_MEDIAATTACH_FILEINFOPIXEL',            'pixels');
define('_MEDIAATTACH_FILEINFOPIXELDAR',         'Pixel affiché aspect ratio:');
define('_MEDIAATTACH_FILEINFOBGCOLOR',          'Couleur d\'arrière plan:');
define('_MEDIAATTACH_FILEINFOTAGINFO',          'Tag information');
define('_MEDIAATTACH_FILEINFOEXIF',             'EXIF information');

define('_MEDIAATTACH_PROFILEUPLOADS',           'Status de transfert');
define('_MEDIAATTACH_PROFILEFILESUPLOADED',     '%count% fichiers transférés');
define('_MEDIAATTACH_PROFILETOTAL',             'total');

define('_MEDIAATTACH_EXTERNALONLYIMAGES',       'Seulement des images');
define('_MEDIAATTACH_EXTERNALOUTPUT',           'Display mode');
define('_MEDIAATTACH_EXTERNALOUTPUTLINK',       'Link to the file');
define('_MEDIAATTACH_EXTERNALOUTPUTINLINE',     'Embed the item inline');
define('_MEDIAATTACH_EXTERNALOUTPUTPHYSICAL',   'Embed the item physically');
define('_MEDIAATTACH_EXTERNALPASTEAS',          'Copier comme');
define('_MEDIAATTACH_EXTERNALPASTETHUMBWITHLINK', 'Vignette avec lien affichant l\'image originale');
define('_MEDIAATTACH_EXTERNALPASTETHUMBWITHLINKDL', 'Vignette avec lien pour télécharger l\'image orignale');
define('_MEDIAATTACH_EXTERNALPASTETHUMB',       'Vignette');
define('_MEDIAATTACH_EXTERNALPASTEORIGINAL',    'Image originale');
define('_MEDIAATTACH_EXTERNALPASTETHUMBLINK',   'Lien vers la vignette');
define('_MEDIAATTACH_EXTERNALPASTEORIGINALLINK', 'Lien vers image originale');
define('_MEDIAATTACH_EXTERNALPASTEID',           'ID du fichier');
define('_MEDIAATTACH_EXTERNALPASTEORIGINALWITHLINK',    'Original image with link to itself');

define('_MEDIAATTACH_CATMODE',                  'Mode d\'affichage:');
define('_MEDIAATTACH_PREVIEW',                  'Previsualiser');
define('_MEDIAATTACH_ONLYIMAGES',               'Images seulement');

define('_MEDIAATTACH_SWFBROWSEFILES',           'Parcourir les fichiers');
define('_MEDIAATTACH_SWFQUEUEISEMPTY',          'File vide');
define('_MEDIAATTACH_SWFCANCELQUEUE',           'Annuler la file');
define('_MEDIAATTACH_SWFFILESELECTION',         'MediaAttach fichiers...');
define('_MEDIAATTACH_SWFCBFILEQUEUE',           'File de fichiers');
define('_MEDIAATTACH_SWFCBFILECANCELLED',       'annulé');
define('_MEDIAATTACH_SWFCBFILESQUEUED',         'fichiers qui étaient en file');
define('_MEDIAATTACH_SWFCBUPLOADINGFILE',       'Transfert de la file en cours');
define('_MEDIAATTACH_SWFCBUPLOADINGOF',         'de');
define('_MEDIAATTACH_SWFALLFILESUPLOADED',      'Tous les fichiers ont été transférés...');

define('_MEDIAATTACH_LINKEXTVIDEO',             'Embed external video');
define('_MEDIAATTACH_EXTVIDEOURL',              'Video Page URL');
define('_MEDIAATTACH_EXTVIDEOSUPPORTED',        'Fournisseurs supportés');
define('_MEDIAATTACH_EXTVIDCREATED',            'The video has been embedded successfully');
define('_MEDIAATTACH_EXTVIDERRORDOMAIN',        'Error: this is an invalid or unsupported URL.');
define('_MEDIAATTACH_EXTVIDERRORGRAB',          'Sorry, could not determine video information.');

define('_MEDIAATTACH_CROPTHUMBDEACTIVATED',     'Thumbnail cropping is deactivated.');
define('_MEDIAATTACH_CROPTHUMB',                'Recadrer la vignette');
define('_MEDIAATTACH_CROPCHOOSE',               'Choisir l\'image de prévisualisation.');
define('_MEDIAATTACH_CROPFIXEDSIZE',            'La taille de la fenêtre de sélection est inchangeable.');
define('_MEDIAATTACH_CROPVARSIZEAR',            'La taille de la fenêtre de sélection est changeable, le ratio sera conservé.');
define('_MEDIAATTACH_CROPVARSIZE',              'La taille et le ratio de la fenêtre de sélection sont modifiables.');
define('_MEDIAATTACH_CROPNOSCRIPT',             'cette fonction nécéssite JavaScript.');

define('_CATREGCREATEFAILED',                   'Une erreur s\'est produite durant la création de catégorie.');
define('_CATREGDELETEFAILED',                   'Une erreur s\'est produite durant la suppression de catégorie.');
define('_REGISTERSELFFAILED',                   'Admin uploads could not be prepared. This is not critical.');

