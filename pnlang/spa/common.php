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

/**
 * translated by
 * @author Mateo Tibaquira [mateo]
 */

define('_MEDIAATTACH',                          'MediaAttach');

define('_MEDIAATTACH_UPLOAD',                   'Subir');
define('_MEDIAATTACH_UPLOADFILES',              'Subir archivos');
define('_MEDIAATTACH_UPLOADAFILE',              'Subir un archivo');
define('_MEDIAATTACH_DESC',                     'Descripci�n');
define('_MEDIAATTACH_GROUP',                    'Grupo');
define('_MEDIAATTACH_ALLOWEDFORMATS',           'Formatos permitidos');
define('_MEDIAATTACH_MAXSIZE',                  'Tama�o max.');
define('_MEDIAATTACH_MAXFILES',                 'Max. archivos');
define('_MEDIAATTACH_MAXIMUMS',                 'L�mites');
define('_MEDIAATTACH_MAXIMUMFILES',             'archivos');
define('_MEDIAATTACH_QUOTA',                    'Cuota');
define('_MEDIAATTACH_QUOTAYOUHAVE',             'Tu tienes');
define('_MEDIAATTACH_QUOTAOF',                  'de');
define('_MEDIAATTACH_QUOTAUSED',                'usado');
define('_MEDIAATTACH_QUOTAFULL',                'No tienes m�s espacio disponible para subir archivos');
define('_MEDIAATTACH_FILE',                     'Archivo');
define('_MEDIAATTACH_TITLE',                    'T�tulo');
define('_MEDIAATTACH_DESCRIPTION',              'Descripci�n');
define('_MEDIAATTACH_INFO',                     'Info');
define('_MEDIAATTACH_FILESIZE',                 'Tama�o');
define('_MEDIAATTACH_ATTACHMENT',               'Archivos adjuntos');
define('_MEDIAATTACH_ADMINATTACHMENT',          'Admin archivos');
define('_MEDIAATTACH_UPLOADCREATED',            'El archivo ha sido subido satisfactoriamente');
define('_MEDIAATTACH_NEWMAILSUBJECT',           'Un nuevo archivo ha sido subido');
define('_MEDIAATTACH_NEWMAILBODY',              'Hola! Aqu� est� la informaci�n acerca del archivo');
define('_MEDIAATTACH_DLMAILSUBJECT',            'El archivo solicitado');
define('_MEDIAATTACH_DLMAILBODY',               'Hola! Aqu� est� el archivo que te mandaste a ti mismo');
define('_MEDIAATTACH_DOWNLOADIT',               'Descarga este archivo');
define('_MEDIAATTACH_VIEWIT',                   'Ver este archivo');
define('_MEDIAATTACH_SENDIT',                   'Enviar este archivo a tu direcci�n de correo');
define('_MEDIAATTACH_FILEINFO',                 'Informaci�n acerca de este archivo');
define('_MEDIAATTACH_TOPROFILE',                'A el perfil de');
define('_MEDIAATTACH_UPLOADMAILSENT',           'El correo ha sido enciado satisfactoriamente');
define('_MEDIAATTACH_UPLOADMAILNOTSENT',        'Disculpa, el correo no pudo ser enviado');

define('_MEDIAATTACH_BYTES',                    'Bytes');
define('_MEDIAATTACH_KB',                       'KB');
define('_MEDIAATTACH_MB',                       'MB');
define('_MEDIAATTACH_GB',                       'GB');

define('_MEDIAATTACH_NORIGHTS',                 'Disculpa, no tienes permiso para subir archivos');
define('_MEDIAATTACH_NOANON',                   'Disculpa, subir archivos s�lo se le es permitido a usuarios registrados');
define('_MEDIAATTACH_DIRERR',                   'Disculpa, MediaAttach no ha sido configurado todav�a');
define('_MEDIAATTACH_ERROK',                    'Hubo un problema subiendo el archivo');
define('_MEDIAATTACH_ERRINISIZE',               'El archivo es muy grande');
define('_MEDIAATTACH_ERRFORMSIZE',              'El archivo es muy grande');
define('_MEDIAATTACH_ERRPARTIAL',               'El archivo fue subido s�lo parcialmente');
define('_MEDIAATTACH_ERRNOFILE',                'No hay ning�n archivo seleccionado');
define('_MEDIAATTACH_ERRNOTMPDIR',              'No se ha especificado ning�na carpeta temporal');
define('_MEDIAATTACH_ERRFORMAT',                'El archivo tiene un formado no v�lido');
define('_MEDIAATTACH_ERRSIZE',                  'El archivo es m�s grande de lo permitido');
define('_MEDIAATTACH_ERRSAMENAME',              'Ya existe un archivo con ese mismo nombre');
define('_MEDIAATTACH_ERRMOVE',                  'Algunos problemas ocurrieron mientras se procesaba el archivo');

define('_MEDIAATTACH_ERRINSERTFILE',            'Disculpa, los datos del archivo no pudieron ser actualizados en la base de datos');
define('_MEDIAATTACH_WARNINGMULTIPLEPAGES',     'Por favor escoge tu archivo s�lo si vas a enviar los datos definitivamente (no previsualizaci�n), de lo contrario no ser� almacenada correctamente. Esto ser� arreglado en una versi�n futura.');

//Upload files
define('_MEDIAATTACH_NOTITLE',                  'Sin t�tulo');
define('_MEDIAATTACH_UPLOADUPLOAD',             'Subidos recientemente');
define('_MEDIAATTACH_UPLOADFILE',               'Archivo');
define('_MEDIAATTACH_UPLOADMODNAME',            'M�dulo');
define('_MEDIAATTACH_UPLOADUSER',               'Usuario');
define('_MEDIAATTACH_UPLOADDATE',               'fecha');
define('_MEDIAATTACH_UPLOADTITLE',              'T�tulo');
define('_MEDIAATTACH_UPLOADDESC',               'Descripci�n');
define('_MEDIAATTACH_UPLOADMIMETYPE',           'Tipo mime');
define('_MEDIAATTACH_UPLOADFILESIZE',           'Tama�o');
define('_MEDIAATTACH_UPLOADDELETE',             'Birrar este archivo');
define('_MEDIAATTACH_UPLOADEDIT',               'Editar este archivo');
define('_MEDIAATTACH_UPLOADUPDATE',             'Subir este archivo');
define('_MEDIAATTACH_UPLOADDLCOUNT',            '%count% veces descargado');
define('_MEDIAATTACH_UPLOADNOUPLOADS',          'No se han subido archivos todav�a');
define('_MEDIAATTACH_UPLOADNOIMAGES',           'No hay im�genes disponibles todav�a');
define('_MEDIAATTACH_UPLOADFILTERBY',           'Filtrar por');
define('_MEDIAATTACH_UPLOADSORTBY',             'Ordenado por');
define('_MEDIAATTACH_UPLOADSORTBYDATE',         'fecha');
define('_MEDIAATTACH_UPLOADSORTBYTITLE',        't�tulo');
define('_MEDIAATTACH_UPLOADSORTBYMODULE',       'm�dulo');
define('_MEDIAATTACH_UPLOADSORTBYUSERNAME',     'nombre de usuario');
define('_MEDIAATTACH_UPLOADSORTBYFILENAME',     'nombre de archivo');
define('_MEDIAATTACH_UPLOADSORTBYFILETYPE',     'tipo de archivo');
define('_MEDIAATTACH_UPLOADSORTBYFILESIZE',     'tama�o');
define('_MEDIAATTACH_UPLOADSORTDIRASC',         'ascendente');
define('_MEDIAATTACH_UPLOADSORTDIRDESC',        'descendente');
define('_MEDIAATTACH_UPLOADPERPAGE',            'Entradas por p�gina');

define('_MEDIAATTACH_SEARCHINCLUDE_TITLE',          'Subir archivos');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBY',         'Ordenar por');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYDATE',     'fecha');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYTITLE',    't�tulo');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYMODULE',   'm�dulo');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYUSERNAME', 'nombre de usuario');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILENAME', 'nombre de archivo');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILETYPE', 'tipo de archivo');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILESIZE', 'tama�o');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTDIRASC',     'ascendente');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTDIRDESC',    'descendente');

define('_MEDIAATTACH_SEARCHINCLUDE_RESULTS',    'Archivos adjuntos');
define('_MEDIAATTACH_SEARCHINCLUDE_HITS',       'Resultados');
define('_MEDIAATTACH_SEARCHINCLUDE_NOENTRIES',  'no se encontraron archivos adjuntos');
define('_MEDIAATTACH_FROM',                     'De');
define('_MEDIAATTACH_ON',                       'el');

define('_MEDIAATTACH_ADMINMAIN',                'Inicio');
define('_MEDIAATTACH_ADMINADMINUPLOADS',        'Archivos de admin');
define('_MEDIAATTACH_ADMINUSERUPLOADS',         'Adjuntos de usuarios');
define('_MEDIAATTACH_ADMINDEFINITIONS',         'Definiciones');
define('_MEDIAATTACH_ADMINFORMATS',             'Formatos');
define('_MEDIAATTACH_ADMINGROUPS',              'Grupos');
define('_MEDIAATTACH_ADMINQUOTAS',              'Cuotas');
define('_MEDIAATTACH_ADMINCONFIG',              'Config');
define('_MEDIAATTACH_ADMINMANUAL',              'Manual');
define('_MEDIAATTACH_ADMINTMAIN',               'Ir a la p�gina inicial de la secci�n de administraci�n de MediaAttach');
define('_MEDIAATTACH_ADMINTADMINUPLOADS',       'Subir e importar archivos');
define('_MEDIAATTACH_ADMINTUSERUPLOADS',        'Administrar los archivos de los usuarios');
define('_MEDIAATTACH_ADMINTDEFINITIONS',        'Adminstrar las definiciones de los m�dulos');
define('_MEDIAATTACH_ADMINTFORMATS',            'Formatos de archivo');
define('_MEDIAATTACH_ADMINTGROUPS',             'Grupos de formatos de archivo');
define('_MEDIAATTACH_ADMINTQUOTAS',             'Cuotas');
define('_MEDIAATTACH_ADMINTCONFIG',             'Configuraci�n de MediaAttach');
define('_MEDIAATTACH_ADMINTMANUAL',             'Lo valioso de leer el manual pdf');

define('_MEDIAATTACH_WELCOME',                  'Bienvenido a el �rea de administraci�n de MediaAttach');
define('_MEDIAATTACH_FILESTOTAL',               '%count% total de archivos');
define('_MEDIAATTACH_ACTIONS',                  'Acciones');
define('_MEDIAATTACH_NONE',                     'Ninguno');
define('_MEDIAATTACH_ONLYOWN',                  'S�lo el due�o');
define('_MEDIAATTACH_ALL',                      'Todos');


//Definitions
define('_MEDIAATTACH_DEFINITIONDEFS',           'Definiciones de los adjuntos');
define('_MEDIAATTACH_DEFINITIONNOMODULES',      'MediaAttach no pudo encontrar el(los) m�dulo(s) a el(los) cual(es) adjuntar archivos. Por favor ve al panel de administraci�n de los M�dulos y activa el Hook MediaAttach para uno o m�s m�dulos seg�n necesites.');
define('_MEDIAATTACH_DEFINITIONMODNAME',        'M�dulo');
define('_MEDIAATTACH_DEFINITIONGROUPS',         'Grupos');
define('_MEDIAATTACH_DEFINITIONSHOW',           'Mostrar definici�n');
define('_MEDIAATTACH_DEFINITIONHIDE',           'Ocultar definici�n');
define('_MEDIAATTACH_DEFINITIONFOR',            'Definici�n para');
define('_MEDIAATTACH_DEFINITIONDSPFILES',       'Mostrar archivos subidos in la secci�n de usuarios');
define('_MEDIAATTACH_DEFINITIONSENDMAILS',      'Enviar un correo despu�s de subida');
define('_MEDIAATTACH_DEFINITIONRECIPIENT',      'Destinatario del correo');
define('_MEDIAATTACH_DEFINITIONMAXSIZE',        'Tama�o m�ximo del archivo a subir');
define('_MEDIAATTACH_DEFINITIONDOWNLOADMODE',   'Modo de descarga');
define('_MEDIAATTACH_DEFINITIONPHYSICAL',       'F�sico');
define('_MEDIAATTACH_DEFINITIONINLINE',         'en l�nea');
define('_MEDIAATTACH_DEFINITIONNAMING',         'Convenci�n de nombres de archivo');
define('_MEDIAATTACH_DEFINITIONNAMORIG',        'Nombre original');
define('_MEDIAATTACH_DEFINITIONNAMRAND',        'Nombre aleatorio');
define('_MEDIAATTACH_DEFINITIONNAMSTAT',        'Numerado con un prefijo');
define('_MEDIAATTACH_DEFINITIONPREFIX',         'Prefijo');
define('_MEDIAATTACH_DEFINITIONNUMFILES',       'N�mero de archivos');
define('_MEDIAATTACH_DEFINITIONADD',            'A�adir definici�n');
define('_MEDIAATTACH_DEFINITIONEDIT',           'Editar esta definici�n');
define('_MEDIAATTACH_DEFINITIONNEW',            'Crear una nueva definici�n');
define('_MEDIAATTACH_DEFINITIONUPDATE',         'Actualizar esta definici�n');

//Formats
define('_MEDIAATTACH_FORMATS',                  'Formatos de archivo');
define('_MEDIAATTACH_FILETYPE',                 'Tipo de archivo');
define('_MEDIAATTACH_IMAGE',                    'Im�gen');
define('_MEDIAATTACH_GROUPS',                   'Grupos');
define('_MEDIAATTACH_FORMATADD',                'A�adir tipo de archivo');
define('_MEDIAATTACH_FORMATDELETE',             'Borrar este tipo de archivo');
define('_MEDIAATTACH_FORMATEDIT',               'Editar este tipo de archivo');
define('_MEDIAATTACH_FORMATNEW',                'Crear un nuevo tipo de archivo');
define('_MEDIAATTACH_FORMATUPDATE',             'Actualizar este tipo de archivo');
define('_MEDIAATTACH_FORMATDANGER',             'Advertencia: Permitir este tipo de archivo puede ser un riesgo potencial de seguridad!');

//Groups
define('_MEDIAATTACH_GROUPGROUPS',              'Grupos de archivos');
define('_MEDIAATTACH_GROUPNAME',                'Nombre');
define('_MEDIAATTACH_GROUPDIR',                 'Carpeta');
define('_MEDIAATTACH_GROUPIMAGE',               'Im�gen');
define('_MEDIAATTACH_GROUPFORMATS',             'Tipos de archivo');
define('_MEDIAATTACH_GROUPADD',                 'A�adir grupo');
define('_MEDIAATTACH_GROUPDELETE',              'Borrar este grupo');
define('_MEDIAATTACH_GROUPEDIT',                'Editar este grupo');
define('_MEDIAATTACH_GROUPNEW',                 'Crear un nuevo grupo');
define('_MEDIAATTACH_GROUPUPDATE',              'Actualizar este grupp');

//Quotas
define('_MEDIAATTACH_QUOTASGROUPS',             'Grupos');
define('_MEDIAATTACH_QUOTASUSERS',              'Usuarios');
define('_MEDIAATTACH_QUOTASNOUSERS',            'No se han definido las cuotas de usuario');
define('_MEDIAATTACH_QUOTASNEWUSER',            'Nueva cuota de usuario');
define('_MEDIAATTACH_QUOTASUSERCREATE',         'Crear Cuota');
define('_MEDIAATTACH_QUOTASGROUPNAME',          'Nombre');
define('_MEDIAATTACH_QUOTASUSERNAME',           'Nombre');
define('_MEDIAATTACH_QUOTASQUOTA'    ,          'Cuota');
define('_MEDIAATTACH_QUOTASACTION',             'Enviar');
define('_MEDIAATTACH_QUOTASUPDATE',             'Cambiar cuotas');
define('_MEDIAATTACH_QUOTASDELETE',             'Borrar esta cuota');

//Configuration
define('_MEDIAATTACH_CONFIGURATION',            'Configuraci�n');
define('_MEDIAATTACH_CONFIGIMAGE',              'Configuraci�n de im�genes');
define('_MEDIAATTACH_CONFIGCATMODES',           'Ajustes para la categorizaci�n');
define('_MEDIAATTACH_MEDIAATTACHDIR',           'Carpeta de instalaci�n de MediaAttach');
define('_MEDIAATTACH_DOCROOT',                  'Ra�z del sitio');
define('_MEDIAATTACH_UPLOADDIR',                'Carpeta de carga (idealmente fuera de la ra�z del sitio):');
define('_MEDIAATTACH_CACHEDIR',                 'Carpeta de cach� (debe estar dentro de la ra�z del sitio):');
define('_MEDIAATTACH_DIROKAY',                  'Est� bien configurada');
define('_MEDIAATTACH_DIRNOTWRITABLE',           'Esta carpeta no es escribible por el servidor Web');
define('_MEDIAATTACH_DIRNODIR',                 'Esta no es una carpeta');
define('_MEDIAATTACH_DIRNOTEXIST',              'Esta carpeta no existe');
define('_MEDIAATTACH_MAILER',                   'Permitir a los usuarios enviarse archivos en correos a ellos mismos');
define('_MEDIAATTACH_SENDFILES',                'Activar esta funci�n');
define('_MEDIAATTACH_MAXMAILSIZE',              'Tama�o de archivo m�ximo en los correos:');
define('_MEDIAATTACH_USEQUOTA',                 'Activar cuotas');
define('_MEDIAATTACH_OWNHANDLING',              'Los usuarios pueden editar y borrar sus propios archivos');
define('_MEDIAATTACH_USEFRONTPAGE',             'Activar p�gina de entrada en la secci�n de usuarios');
define('_MEDIAATTACH_USEACCOUNTPAGE',           'Activar p�gina de account en la secci�n de usuarios');
define('_MEDIAATTACH_ALLOWOWNHANDLING',         'Permitir esta opci�n');
define('_MEDIAATTACH_DEFAULTTHUMBSIZE',         'Tama�o predeterminado de las miniaturas:');
define('_MEDIAATTACH_SHRINKIMAGES',             'Disminuir las im�genes grandes');
define('_MEDIAATTACH_DEFAULTSHRINKSIZE',        'Tama�o de im�gen m�ximo:');
define('_MEDIAATTACH_CONFIGPIXEL',              'pix�les');
define('_MEDIAATTACH_USETHUMBCROPPER',          'Permitir el ajuste de miniaturas');
define('_MEDIAATTACH_CROPSIZEMODE',             'Comportamiento de la herramienta seleccionada');
define('_MEDIAATTACH_USECROPFIXEDSIZE',         'Forzar el tama�o predeterminado');
define('_MEDIAATTACH_USECROPVARSIZEAR',         'Mantener el tama�o variable y forzar la relaci�n de aspecto');
define('_MEDIAATTACH_USECROPVARSIZE',           'Mantener variables el tama�o y la relaci�n de aspecto');

define('_MEDIAATTACH_CATMODECATEGORIES',        'Categor�as de MediaAttach (M�dulo de Categor�as)');
define('_MEDIAATTACH_CATMODEMODULES',           'M�dulos');
define('_MEDIAATTACH_CATMODEUSERS',             'Usuarios');
define('_MEDIAATTACH_CATDEFAULTMODE',           'Modo por defecto:');
define('_MEDIAATTACH_CATDEFAULTMODENONE',       'Sin categorizaci�n');
define('_MEDIAATTACH_CATDEFAULTMODECATEGORIES', 'Categor�as');
define('_MEDIAATTACH_CATDEFAULTMODEMODULES',    'M�dulos');
define('_MEDIAATTACH_CATDEFAULTMODEUSERS',      'Usuarios');

define('_MEDIAATTACH_HTACCESSHINT',             'MediaAttach puede autom�ticamente escribir un archivo .htaccess en la carpeta de uploads para evitar el acceso directo a los archivos subidos. Debes saber que todos los servidores web soportan los archivos .htaccess.');
define('_MEDIAATTACH_HTACCESSGENERATE',         'generar .htaccess');

define('_MEDIAATTACH_PHPINISETTINGS',           'Ajustes importantes en el php.ini, los cuales son relevantes para subir archivos');
define('_MEDIAATTACH_VERSIONCHECK',             '�ltima versi�n');
define('_MEDIAATTACH_YOURVERSION',              'Tu versi�n');
define('_MEDIAATTACH_NEWVERSION',               'Hay una nueva versi�n disponible!');
define('_MEDIAATTACH_DOWNLOADNOW',              'Desc�rgala ahora');
define('_MEDIAATTACH_TDOWNLOADNOW',             'Descarga la �ltima versi�n de MediaAttach');
define('_MEDIAATTACH_NONEWVERSION',             'Tu versi�n es la m�s reciente.');

define('_MEDIAATTACH_ACTION',                   'Acci�n');

define('_MEDIAATTACH_FILEFILTER',               'Archivos a mostrar');
define('_MEDIAATTACH_NUMITEMS',                 'N�mero de archivos a mostrar');
define('_MEDIAATTACH_FORMATFILTER',             'Mostrar s�lo los archivos con estos formatos (opcional)');
define('_MEDIAATTACH_DISPLAYTYPE',              'Ordenamiento');
define('_MEDIAATTACH_NEWESTFILES',              'Archivos recientes');
define('_MEDIAATTACH_RANDOMFILES',              'Archivos aleatorios');

define('_MEDIAATTACH_FORMATSSHOW',              'mostrar');
define('_MEDIAATTACH_FORMATSHIDE',              'ocultar');

define('_MEDIAATTACH_MYUPLOADS',                'Mis archivos');

define('_MEDIAATTACH_ADMINFILESHINT',           'para usar archivos de adminstraci�n activa el hook de MediaAttach para MediaAttach y crea una definic�n.');

define('_MEDIAATTACH_IMPORTFILESFROMFS',        'Importar archivos de una carpeta del servidor');
define('_MEDIAATTACH_IMPORTFILESFROMFSHINT',    'Simplemente ve a la carpeta deseada, selecciona los archivos a importar y comienza. The upload filesize limit is not being used here.');
define('_MEDIAATTACH_IMPORTFILESFROMMODULE',    'Importar archivos desde otro m�dulo');
define('_MEDIAATTACH_IMPORTFILESFROMMODULEHINT', 'MediaAttach ha encontrado los siguientes m�dulos de los cuales se pueden importar archivos.');
define('_MEDIAATTACH_IMPORTFILESFROMMODULEHINT2', 'Las jerarqu�as existentes ser�n convertidas en categor�as.');
define('_MEDIAATTACH_IMPORTLIMITSHINT',         'Los l�mites de subida no son usados aqui.');
define('_MEDIAATTACH_IMPORTSTART',              'Comenzar importaci�n');
define('_MEDIAATTACH_IMPORTCREATED',            'El archivo ha sido importado exitosamente');

define('_MEDIAATTACH_VALIDATIONGROUPNAMEREQUIRED',  'Por favor digita un nombre para el nuevo grupo.');
define('_MEDIAATTACH_VALIDATIONGROUPNAMEALPHANUM',  'El nombre del grupo s�lo debe contener letras y n�meros.');
define('_MEDIAATTACH_VALIDATIONDIRECTORYREQUIRED',  'Por favor asigna una carpeta para el nuevo grupo');
define('_MEDIAATTACH_VALIDATIONDIRECTORYALPHANUM',  'La carpeta debe tener solamente letras y n�meros.');
define('_MEDIAATTACH_VALIDATIONEXTENSIONREQUIRED',  'Por favor digita la extensi�n del nuevo tipo de archivo.');
define('_MEDIAATTACH_VALIDATIONEXTENSIONALPHANUM',  'La extensi�n s�lo debe contener letras y n�meros.');
define('_MEDIAATTACH_VALIDATIONCATEGORYNAMEREQUIRED',  'Por favor digita un nombre para la nueva categor�a.');
define('_MEDIAATTACH_VALIDATIONCATEGORYNAMEALPHANUM',  'La categor�a debe tener solamente letras y n�meros.');

define('_MEDIAATTACH_ERRORALLOWEDFILENUM',      'No puedes subir m�s de %m% archivos a la vez.');
define('_MEDIAATTACH_ERRORALREADYSELECTED',     'Este archivo ya fue seleccionado.');
define('_MEDIAATTACH_ERROREXTENSIONNOTALLOWED', 'Este tipo de archivo no es permitido.');
define('_MEDIAATTACH_ERRORNOFILESSELECTED',     'A�n no se ha escogido ning�n archivo.');
define('_MEDIAATTACH_ERRORALREADYRUNNING',      'Ya se est� subiendo un archivo.');

define('_MEDIAATTACH_ADDFILE',                  'A�adir archivo');
define('_MEDIAATTACH_INFOFORATTACHMENTBOX',     'Los archivos a�adidos ser�n listados aqu�.');
define('_MEDIAATTACH_INFOFORDROPBOX',           'Arrastra aqu� cualquier archivo a�adido para removerlo.');
define('_MEDIAATTACH_UPLOADING',                'Subiendo...');

define('_MEDIAATTACH_FILEINFOGENERALINFO',      'Informaci�n general');
define('_MEDIAATTACH_FILEINFOFILETYPE',         'Tipo de archivo:');
define('_MEDIAATTACH_FILEINFOFILESIZE',         'Tama�o:');
define('_MEDIAATTACH_FILEINFOMIMETYPE',         'Tipo mime:');
define('_MEDIAATTACH_FILEINFOENCODING',         'Codificaci�n:');
define('_MEDIAATTACH_FILEINFOPLAYTIME',         'Duraci�n:');
define('_MEDIAATTACH_FILEINFOSECONDS',          'seg.');

define('_MEDIAATTACH_FILEINFOHASHINFO',         'Informaci�n encriptada');
define('_MEDIAATTACH_FILEINFOMD5ENTIREFILE',    'md5 del archivo entero:');
define('_MEDIAATTACH_FILEINFOMD5CRAWDATA',      'md5 datos comprimidos:');
define('_MEDIAATTACH_FILEINFOMD5URAWDATA',      'md5 datos no comprimidos:');
define('_MEDIAATTACH_FILEINFOMD5RAWDATA',       'md5 datos en bruto:');
define('_MEDIAATTACH_FILEINFOSHA1ENTIREFILE',   'sha1 del archivo entero:');
define('_MEDIAATTACH_FILEINFOSHA1RAWDATA',      'sha1 de los datos en bruto:');

define('_MEDIAATTACH_FILEINFOAUDIOINFO',        'Informaci�n del Audio');
define('_MEDIAATTACH_FILEINFOIMAGEINFO',        'Informaci�n de la Im�gen');
define('_MEDIAATTACH_FILEINFOVIDEOINFO',        'Informaci�n del Video');
define('_MEDIAATTACH_FILEINFOAVGBITRATE',       'Promedio de rata de bits:');
define('_MEDIAATTACH_FILEINFOKBPS',             'kbps');
define('_MEDIAATTACH_FILEINFOBITRATEMODE',      'Modo de rata de bits:');
define('_MEDIAATTACH_FILEINFOBITRATECBR',       'CBR (Rata de Bits Constante)');
define('_MEDIAATTACH_FILEINFOBITRATEVBR',       'VBR (Rata de Bits Variable)');
define('_MEDIAATTACH_FILEINFOSAMPLERATE',       'Tasa de muestra:');
define('_MEDIAATTACH_FILEINFOHERTZ',            'Hertz');
define('_MEDIAATTACH_FILEINFOBITSPERSAMPLE',    'Bits por muestra:');
define('_MEDIAATTACH_FILEINFOCHANNELMODE',      'Modo de canal:');
define('_MEDIAATTACH_FILEINFONOOFCHANNELS',     'No. de canales:');
define('_MEDIAATTACH_FILEINFOAUDIOCODEC',       'Codec de compresi�n de Audio:');
define('_MEDIAATTACH_FILEINFOVIDEOCODEC',       'Codec de compresi�n de Video:');
define('_MEDIAATTACH_FILEINFOENCODER',          'Codificador:');
define('_MEDIAATTACH_FILEINFOCOMPRESSIONRATIO', 'Raz�n de compresi�n:');
define('_MEDIAATTACH_FILEINFOLOSSLESS',         'Sin p�rdidas:');
define('_MEDIAATTACH_FILEINFOLOSSLESSCOMP',     'compresi�n sin perdidas');
define('_MEDIAATTACH_FILEINFOLOSSYCOMP',        'compresi�n con p�rditas');
define('_MEDIAATTACH_FILEINFOFRAMERATE',        'Cuadros por segundo:');
define('_MEDIAATTACH_FILEINFOFPS',              'fps');
define('_MEDIAATTACH_FILEINFOSIZE',             'Tama�o:');
define('_MEDIAATTACH_FILEINFOWIDTH',            'Ancho:');
define('_MEDIAATTACH_FILEINFOHEIGHT',           'Alto:');
define('_MEDIAATTACH_FILEINFOPIXEL',            'pix�les');
define('_MEDIAATTACH_FILEINFOPIXELDAR',         'Relaci�n de aspecto:');
define('_MEDIAATTACH_FILEINFOBGCOLOR',          'Color de fondo:');
define('_MEDIAATTACH_FILEINFOTAGINFO',          'Informaci�n de etiqueta');
define('_MEDIAATTACH_FILEINFOEXIF',             'Informaci�n EXIF');

define('_MEDIAATTACH_PROFILEUPLOADS',           'Estado de la subida');
define('_MEDIAATTACH_PROFILEFILESUPLOADED',     '%count% archivos subidos');
define('_MEDIAATTACH_PROFILETOTAL',             'total');

define('_MEDIAATTACH_EXTERNALONLYIMAGES',       'S�lo im�genes');
define('_MEDIAATTACH_EXTERNALOUTPUT',           'Display mode');
define('_MEDIAATTACH_EXTERNALOUTPUTLINK',       'Link to the file');
define('_MEDIAATTACH_EXTERNALOUTPUTINLINE',     'Embed the item inline');
define('_MEDIAATTACH_EXTERNALOUTPUTPHYSICAL',   'Embed the item physically');
define('_MEDIAATTACH_EXTERNALPASTEAS',          'Pegar c�mo');
define('_MEDIAATTACH_EXTERNALPASTETHUMBWITHLINK', 'Miniatura con elnace a la im�gen original');
define('_MEDIAATTACH_EXTERNALPASTETHUMBWITHLINKDL', 'Miniatura con enlace de descarga de la im�gen original');
define('_MEDIAATTACH_EXTERNALPASTETHUMB',       'Im�genes Miniatura');
define('_MEDIAATTACH_EXTERNALPASTEORIGINAL',    'Im�gen original');
define('_MEDIAATTACH_EXTERNALPASTETHUMBLINK',   'Enlace a la miniatura');
define('_MEDIAATTACH_EXTERNALPASTEORIGINALLINK', 'Enlace a la im�gen original');
define('_MEDIAATTACH_EXTERNALPASTEID',           'ID de archivo');

define('_MEDIAATTACH_CATMODE',                  'Modo de visualizaci�n:');
define('_MEDIAATTACH_PREVIEW',                  'Previsualizar');
define('_MEDIAATTACH_ONLYIMAGES',               'S�lo im�genes');

define('_MEDIAATTACH_SWFBROWSEFILES',           'Explorar archivos');
define('_MEDIAATTACH_SWFQUEUEISEMPTY',          'La cola est� vac�a');
define('_MEDIAATTACH_SWFCANCELQUEUE',           'Cancelar cola');
define('_MEDIAATTACH_SWFFILESELECTION',         'Archivos MediaAttach...');
define('_MEDIAATTACH_SWFCBFILEQUEUE',           'Cola de Archivos');
define('_MEDIAATTACH_SWFCBFILECANCELLED',       'cancelada');
define('_MEDIAATTACH_SWFCBFILESQUEUED',         'Archivos en cola');
define('_MEDIAATTACH_SWFCBUPLOADINGFILE',       'Subiendo archivo');
define('_MEDIAATTACH_SWFCBUPLOADINGOF',         'de');
define('_MEDIAATTACH_SWFALLFILESUPLOADED',      'Todos los archivos fueron subidos...');

define('_MEDIAATTACH_LINKEXTVIDEO',             'Insertar medio externo');
define('_MEDIAATTACH_EXTVIDEOURL',              'URL del medio');
define('_MEDIAATTACH_EXTVIDEOSUPPORTED',        'Proveedores soportados');
define('_MEDIAATTACH_EXTVIDCREATED',            'El medio ha sido insertado exitosamente');
define('_MEDIAATTACH_EXTVIDERRORDOMAIN',        'Error: esta URL no es v�lida o no est� soportada.');
define('_MEDIAATTACH_EXTVIDERRORGRAB',          'Disculpa, no se pudo determinar la informaci�n del medio.');

define('_MEDIAATTACH_CROPTHUMB',                'Ajustar thumbnail');
define('_MEDIAATTACH_CROPCHOOSE',               'Escoje tu im�gen de previsualizaci�n deseada.');
define('_MEDIAATTACH_CROPFIXEDSIZE',            'El tama�o de la ventana de selecci�n no es modificable.');
define('_MEDIAATTACH_CROPVARSIZEAR',            'El tama�o de la ventana de selecci�n es modificable, la relaci�n de aspecto se mantendr�.');
define('_MEDIAATTACH_CROPVARSIZE',              'El tama�o de la ventana de selecci�n y la relaci�n de aspecto son modificables.');
define('_MEDIAATTACH_CROPNOSCRIPT',             'Esta funcion requiere JavaScript.');

define('_CATREGCREATEFAILED',                   'Un error ha ocurrido mientras se creaban los registros de las categor�as.');
define('_CATREGDELETEFAILED',                   'un error ha ocurrido mientras se borraban los registros de las categor�as.');
define('_REGISTERSELFFAILED',                   'Error no cr�tico: Archivos de admin no pudieron ser preparados.');
