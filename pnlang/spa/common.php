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
define('_MEDIAATTACH_DESC',                     'Descripción');
define('_MEDIAATTACH_GROUP',                    'Grupo');
define('_MEDIAATTACH_ALLOWEDFORMATS',           'Formatos permitidos');
define('_MEDIAATTACH_MAXSIZE',                  'Tamaño max.');
define('_MEDIAATTACH_MAXFILES',                 'Max. archivos');
define('_MEDIAATTACH_MAXIMUMS',                 'Límites');
define('_MEDIAATTACH_MAXIMUMFILES',             'archivos');
define('_MEDIAATTACH_QUOTA',                    'Cuota');
define('_MEDIAATTACH_QUOTAYOUHAVE',             'Tu tienes');
define('_MEDIAATTACH_QUOTAOF',                  'de');
define('_MEDIAATTACH_QUOTAUSED',                'usado');
define('_MEDIAATTACH_QUOTAFULL',                'No tienes más espacio disponible para subir archivos');
define('_MEDIAATTACH_FILE',                     'Archivo');
define('_MEDIAATTACH_TITLE',                    'Título');
define('_MEDIAATTACH_DESCRIPTION',              'Descripción');
define('_MEDIAATTACH_INFO',                     'Info');
define('_MEDIAATTACH_FILESIZE',                 'Tamaño');
define('_MEDIAATTACH_ATTACHMENT',               'Archivos adjuntos');
define('_MEDIAATTACH_ADMINATTACHMENT',          'Admin archivos');
define('_MEDIAATTACH_UPLOADCREATED',            'El archivo ha sido subido satisfactoriamente');
define('_MEDIAATTACH_NEWMAILSUBJECT',           'Un nuevo archivo ha sido subido');
define('_MEDIAATTACH_NEWMAILBODY',              'Hola! Aquí está la información acerca del archivo');
define('_MEDIAATTACH_DLMAILSUBJECT',            'El archivo solicitado');
define('_MEDIAATTACH_DLMAILBODY',               'Hola! Aquí está el archivo que te mandaste a ti mismo');
define('_MEDIAATTACH_DOWNLOADIT',               'Descarga este archivo');
define('_MEDIAATTACH_VIEWIT',                   'Ver este archivo');
define('_MEDIAATTACH_SENDIT',                   'Enviar este archivo a tu dirección de correo');
define('_MEDIAATTACH_FILEINFO',                 'Información acerca de este archivo');
define('_MEDIAATTACH_TOPROFILE',                'A el perfil de');
define('_MEDIAATTACH_UPLOADMAILSENT',           'El correo ha sido enciado satisfactoriamente');
define('_MEDIAATTACH_UPLOADMAILNOTSENT',        'Disculpa, el correo no pudo ser enviado');

define('_MEDIAATTACH_BYTES',                    'Bytes');
define('_MEDIAATTACH_KB',                       'KB');
define('_MEDIAATTACH_MB',                       'MB');
define('_MEDIAATTACH_GB',                       'GB');

define('_MEDIAATTACH_NORIGHTS',                 'Disculpa, no tienes permiso para subir archivos');
define('_MEDIAATTACH_NOANON',                   'Disculpa, subir archivos sólo se le es permitido a usuarios registrados');
define('_MEDIAATTACH_DIRERR',                   'Disculpa, MediaAttach no ha sido configurado todavía');
define('_MEDIAATTACH_ERROK',                    'Hubo un problema subiendo el archivo');
define('_MEDIAATTACH_ERRINISIZE',               'El archivo es muy grande');
define('_MEDIAATTACH_ERRFORMSIZE',              'El archivo es muy grande');
define('_MEDIAATTACH_ERRPARTIAL',               'El archivo fue subido sólo parcialmente');
define('_MEDIAATTACH_ERRNOFILE',                'No hay ningún archivo seleccionado');
define('_MEDIAATTACH_ERRNOTMPDIR',              'No se ha especificado ningúna carpeta temporal');
define('_MEDIAATTACH_ERRFORMAT',                'El archivo tiene un formado no válido');
define('_MEDIAATTACH_ERRSIZE',                  'El archivo es más grande de lo permitido');
define('_MEDIAATTACH_ERRSAMENAME',              'Ya existe un archivo con ese mismo nombre');
define('_MEDIAATTACH_ERRMOVE',                  'Algunos problemas ocurrieron mientras se procesaba el archivo');

define('_MEDIAATTACH_ERRINSERTFILE',            'Disculpa, los datos del archivo no pudieron ser actualizados en la base de datos');
define('_MEDIAATTACH_WARNINGMULTIPLEPAGES',     'Por favor escoge tu archivo sólo si vas a enviar los datos definitivamente (no previsualización), de lo contrario no será almacenada correctamente. Esto será arreglado en una versión futura.');

//Upload files
define('_MEDIAATTACH_NOTITLE',                  'Sin título');
define('_MEDIAATTACH_UPLOADUPLOAD',             'Subidos recientemente');
define('_MEDIAATTACH_UPLOADFILE',               'Archivo');
define('_MEDIAATTACH_UPLOADMODNAME',            'Módulo');
define('_MEDIAATTACH_UPLOADUSER',               'Usuario');
define('_MEDIAATTACH_UPLOADDATE',               'fecha');
define('_MEDIAATTACH_UPLOADTITLE',              'Título');
define('_MEDIAATTACH_UPLOADDESC',               'Descripción');
define('_MEDIAATTACH_UPLOADMIMETYPE',           'Tipo mime');
define('_MEDIAATTACH_UPLOADFILESIZE',           'Tamaño');
define('_MEDIAATTACH_UPLOADDELETE',             'Birrar este archivo');
define('_MEDIAATTACH_UPLOADEDIT',               'Editar este archivo');
define('_MEDIAATTACH_UPLOADUPDATE',             'Subir este archivo');
define('_MEDIAATTACH_UPLOADDLCOUNT',            '%count% veces descargado');
define('_MEDIAATTACH_UPLOADNOUPLOADS',          'No se han subido archivos todavía');
define('_MEDIAATTACH_UPLOADNOIMAGES',           'No hay imágenes disponibles todavía');
define('_MEDIAATTACH_UPLOADFILTERBY',           'Filtrar por');
define('_MEDIAATTACH_UPLOADSORTBY',             'Ordenado por');
define('_MEDIAATTACH_UPLOADSORTBYDATE',         'fecha');
define('_MEDIAATTACH_UPLOADSORTBYTITLE',        'título');
define('_MEDIAATTACH_UPLOADSORTBYMODULE',       'módulo');
define('_MEDIAATTACH_UPLOADSORTBYUSERNAME',     'nombre de usuario');
define('_MEDIAATTACH_UPLOADSORTBYFILENAME',     'nombre de archivo');
define('_MEDIAATTACH_UPLOADSORTBYFILETYPE',     'tipo de archivo');
define('_MEDIAATTACH_UPLOADSORTBYFILESIZE',     'tamaño');
define('_MEDIAATTACH_UPLOADSORTDIRASC',         'ascendente');
define('_MEDIAATTACH_UPLOADSORTDIRDESC',        'descendente');
define('_MEDIAATTACH_UPLOADPERPAGE',            'Entradas por página');

define('_MEDIAATTACH_SEARCHINCLUDE_TITLE',          'Subir archivos');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBY',         'Ordenar por');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYDATE',     'fecha');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYTITLE',    'título');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYMODULE',   'módulo');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYUSERNAME', 'nombre de usuario');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILENAME', 'nombre de archivo');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILETYPE', 'tipo de archivo');
define('_MEDIAATTACH_SEARCHINCLUDE_SORTBYFILESIZE', 'tamaño');
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
define('_MEDIAATTACH_ADMINTMAIN',               'Ir a la página inicial de la sección de administración de MediaAttach');
define('_MEDIAATTACH_ADMINTADMINUPLOADS',       'Subir e importar archivos');
define('_MEDIAATTACH_ADMINTUSERUPLOADS',        'Administrar los archivos de los usuarios');
define('_MEDIAATTACH_ADMINTDEFINITIONS',        'Adminstrar las definiciones de los módulos');
define('_MEDIAATTACH_ADMINTFORMATS',            'Formatos de archivo');
define('_MEDIAATTACH_ADMINTGROUPS',             'Grupos de formatos de archivo');
define('_MEDIAATTACH_ADMINTQUOTAS',             'Cuotas');
define('_MEDIAATTACH_ADMINTCONFIG',             'Configuración de MediaAttach');
define('_MEDIAATTACH_ADMINTMANUAL',             'Lo valioso de leer el manual pdf');

define('_MEDIAATTACH_WELCOME',                  'Bienvenido a el área de administración de MediaAttach');
define('_MEDIAATTACH_FILESTOTAL',               '%count% total de archivos');
define('_MEDIAATTACH_ACTIONS',                  'Acciones');
define('_MEDIAATTACH_NONE',                     'Ninguno');
define('_MEDIAATTACH_ONLYOWN',                  'Sólo el dueño');
define('_MEDIAATTACH_ALL',                      'Todos');


//Definitions
define('_MEDIAATTACH_DEFINITIONDEFS',           'Definiciones de los adjuntos');
define('_MEDIAATTACH_DEFINITIONNOMODULES',      'MediaAttach no pudo encontrar el(los) módulo(s) a el(los) cual(es) adjuntar archivos. Por favor ve al panel de administración de los Módulos y activa el Hook MediaAttach para uno o más módulos según necesites.');
define('_MEDIAATTACH_DEFINITIONMODNAME',        'Módulo');
define('_MEDIAATTACH_DEFINITIONGROUPS',         'Grupos');
define('_MEDIAATTACH_DEFINITIONSHOW',           'Mostrar definición');
define('_MEDIAATTACH_DEFINITIONHIDE',           'Ocultar definición');
define('_MEDIAATTACH_DEFINITIONFOR',            'Definición para');
define('_MEDIAATTACH_DEFINITIONDSPFILES',       'Mostrar archivos subidos in la sección de usuarios');
define('_MEDIAATTACH_DEFINITIONSENDMAILS',      'Enviar un correo después de subida');
define('_MEDIAATTACH_DEFINITIONRECIPIENT',      'Destinatario del correo');
define('_MEDIAATTACH_DEFINITIONMAXSIZE',        'Tamaño máximo del archivo a subir');
define('_MEDIAATTACH_DEFINITIONDOWNLOADMODE',   'Modo de descarga');
define('_MEDIAATTACH_DEFINITIONPHYSICAL',       'Físico');
define('_MEDIAATTACH_DEFINITIONINLINE',         'en línea');
define('_MEDIAATTACH_DEFINITIONNAMING',         'Convención de nombres de archivo');
define('_MEDIAATTACH_DEFINITIONNAMORIG',        'Nombre original');
define('_MEDIAATTACH_DEFINITIONNAMRAND',        'Nombre aleatorio');
define('_MEDIAATTACH_DEFINITIONNAMSTAT',        'Numerado con un prefijo');
define('_MEDIAATTACH_DEFINITIONPREFIX',         'Prefijo');
define('_MEDIAATTACH_DEFINITIONNUMFILES',       'Número de archivos');
define('_MEDIAATTACH_DEFINITIONADD',            'Añadir definición');
define('_MEDIAATTACH_DEFINITIONEDIT',           'Editar esta definición');
define('_MEDIAATTACH_DEFINITIONNEW',            'Crear una nueva definición');
define('_MEDIAATTACH_DEFINITIONUPDATE',         'Actualizar esta definición');

//Formats
define('_MEDIAATTACH_FORMATS',                  'Formatos de archivo');
define('_MEDIAATTACH_FILETYPE',                 'Tipo de archivo');
define('_MEDIAATTACH_IMAGE',                    'Imágen');
define('_MEDIAATTACH_GROUPS',                   'Grupos');
define('_MEDIAATTACH_FORMATADD',                'Añadir tipo de archivo');
define('_MEDIAATTACH_FORMATDELETE',             'Borrar este tipo de archivo');
define('_MEDIAATTACH_FORMATEDIT',               'Editar este tipo de archivo');
define('_MEDIAATTACH_FORMATNEW',                'Crear un nuevo tipo de archivo');
define('_MEDIAATTACH_FORMATUPDATE',             'Actualizar este tipo de archivo');
define('_MEDIAATTACH_FORMATDANGER',             'Advertencia: Permitir este tipo de archivo puede ser un riesgo potencial de seguridad!');

//Groups
define('_MEDIAATTACH_GROUPGROUPS',              'Grupos de archivos');
define('_MEDIAATTACH_GROUPNAME',                'Nombre');
define('_MEDIAATTACH_GROUPDIR',                 'Carpeta');
define('_MEDIAATTACH_GROUPIMAGE',               'Imágen');
define('_MEDIAATTACH_GROUPFORMATS',             'Tipos de archivo');
define('_MEDIAATTACH_GROUPADD',                 'Añadir grupo');
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
define('_MEDIAATTACH_CONFIGURATION',            'Configuración');
define('_MEDIAATTACH_CONFIGIMAGE',              'Configuración de imágenes');
define('_MEDIAATTACH_CONFIGCATMODES',           'Ajustes para la categorización');
define('_MEDIAATTACH_MEDIAATTACHDIR',           'Carpeta de instalación de MediaAttach');
define('_MEDIAATTACH_DOCROOT',                  'Raíz del sitio');
define('_MEDIAATTACH_UPLOADDIR',                'Carpeta de carga (idealmente fuera de la raíz del sitio):');
define('_MEDIAATTACH_CACHEDIR',                 'Carpeta de caché (debe estar dentro de la raíz del sitio):');
define('_MEDIAATTACH_DIROKAY',                  'Está bien configurada');
define('_MEDIAATTACH_DIRNOTWRITABLE',           'Esta carpeta no es escribible por el servidor Web');
define('_MEDIAATTACH_DIRNODIR',                 'Esta no es una carpeta');
define('_MEDIAATTACH_DIRNOTEXIST',              'Esta carpeta no existe');
define('_MEDIAATTACH_MAILER',                   'Permitir a los usuarios enviarse archivos en correos a ellos mismos');
define('_MEDIAATTACH_SENDFILES',                'Activar esta función');
define('_MEDIAATTACH_MAXMAILSIZE',              'Tamaño de archivo máximo en los correos:');
define('_MEDIAATTACH_USEQUOTA',                 'Activar cuotas');
define('_MEDIAATTACH_OWNHANDLING',              'Los usuarios pueden editar y borrar sus propios archivos');
define('_MEDIAATTACH_USEFRONTPAGE',             'Activar página de entrada en la sección de usuarios');
define('_MEDIAATTACH_USEACCOUNTPAGE',           'Activar página de account en la sección de usuarios');
define('_MEDIAATTACH_ALLOWOWNHANDLING',         'Permitir esta opción');
define('_MEDIAATTACH_DEFAULTTHUMBSIZE',         'Tamaño predeterminado de las miniaturas:');
define('_MEDIAATTACH_SHRINKIMAGES',             'Disminuir las imágenes grandes');
define('_MEDIAATTACH_DEFAULTSHRINKSIZE',        'Tamaño de imágen máximo:');
define('_MEDIAATTACH_CONFIGPIXEL',              'pixéles');
define('_MEDIAATTACH_USETHUMBCROPPER',          'Permitir el ajuste de miniaturas');
define('_MEDIAATTACH_CROPSIZEMODE',             'Comportamiento de la herramienta seleccionada');
define('_MEDIAATTACH_USECROPFIXEDSIZE',         'Forzar el tamaño predeterminado');
define('_MEDIAATTACH_USECROPVARSIZEAR',         'Mantener el tamaño variable y forzar la relación de aspecto');
define('_MEDIAATTACH_USECROPVARSIZE',           'Mantener variables el tamaño y la relación de aspecto');

define('_MEDIAATTACH_CATMODECATEGORIES',        'Categorías de MediaAttach (Módulo de Categorías)');
define('_MEDIAATTACH_CATMODEMODULES',           'Módulos');
define('_MEDIAATTACH_CATMODEUSERS',             'Usuarios');
define('_MEDIAATTACH_CATDEFAULTMODE',           'Modo por defecto:');
define('_MEDIAATTACH_CATDEFAULTMODENONE',       'Sin categorización');
define('_MEDIAATTACH_CATDEFAULTMODECATEGORIES', 'Categorías');
define('_MEDIAATTACH_CATDEFAULTMODEMODULES',    'Módulos');
define('_MEDIAATTACH_CATDEFAULTMODEUSERS',      'Usuarios');

define('_MEDIAATTACH_HTACCESSHINT',             'MediaAttach puede automáticamente escribir un archivo .htaccess en la carpeta de uploads para evitar el acceso directo a los archivos subidos. Debes saber que todos los servidores web soportan los archivos .htaccess.');
define('_MEDIAATTACH_HTACCESSGENERATE',         'generar .htaccess');

define('_MEDIAATTACH_PHPINISETTINGS',           'Ajustes importantes en el php.ini, los cuales son relevantes para subir archivos');
define('_MEDIAATTACH_VERSIONCHECK',             'Última versión');
define('_MEDIAATTACH_YOURVERSION',              'Tu versión');
define('_MEDIAATTACH_NEWVERSION',               'Hay una nueva versión disponible!');
define('_MEDIAATTACH_DOWNLOADNOW',              'Descárgala ahora');
define('_MEDIAATTACH_TDOWNLOADNOW',             'Descarga la última versión de MediaAttach');
define('_MEDIAATTACH_NONEWVERSION',             'Tu versión es la más reciente.');

define('_MEDIAATTACH_ACTION',                   'Acción');

define('_MEDIAATTACH_FILEFILTER',               'Archivos a mostrar');
define('_MEDIAATTACH_NUMITEMS',                 'Número de archivos a mostrar');
define('_MEDIAATTACH_FORMATFILTER',             'Mostrar sólo los archivos con estos formatos (opcional)');
define('_MEDIAATTACH_DISPLAYTYPE',              'Ordenamiento');
define('_MEDIAATTACH_NEWESTFILES',              'Archivos recientes');
define('_MEDIAATTACH_RANDOMFILES',              'Archivos aleatorios');

define('_MEDIAATTACH_FORMATSSHOW',              'mostrar');
define('_MEDIAATTACH_FORMATSHIDE',              'ocultar');

define('_MEDIAATTACH_MYUPLOADS',                'Mis archivos');

define('_MEDIAATTACH_ADMINFILESHINT',           'para usar archivos de adminstración activa el hook de MediaAttach para MediaAttach y crea una definicón.');

define('_MEDIAATTACH_IMPORTFILESFROMFS',        'Importar archivos de una carpeta del servidor');
define('_MEDIAATTACH_IMPORTFILESFROMFSHINT',    'Simplemente ve a la carpeta deseada, selecciona los archivos a importar y comienza. The upload filesize limit is not being used here.');
define('_MEDIAATTACH_IMPORTFILESFROMMODULE',    'Importar archivos desde otro módulo');
define('_MEDIAATTACH_IMPORTFILESFROMMODULEHINT', 'MediaAttach ha encontrado los siguientes módulos de los cuales se pueden importar archivos.');
define('_MEDIAATTACH_IMPORTFILESFROMMODULEHINT2', 'Las jerarquías existentes serán convertidas en categorías.');
define('_MEDIAATTACH_IMPORTLIMITSHINT',         'Los límites de subida no son usados aqui.');
define('_MEDIAATTACH_IMPORTSTART',              'Comenzar importación');
define('_MEDIAATTACH_IMPORTCREATED',            'El archivo ha sido importado exitosamente');

define('_MEDIAATTACH_VALIDATIONGROUPNAMEREQUIRED',  'Por favor digita un nombre para el nuevo grupo.');
define('_MEDIAATTACH_VALIDATIONGROUPNAMEALPHANUM',  'El nombre del grupo sólo debe contener letras y números.');
define('_MEDIAATTACH_VALIDATIONDIRECTORYREQUIRED',  'Por favor asigna una carpeta para el nuevo grupo');
define('_MEDIAATTACH_VALIDATIONDIRECTORYALPHANUM',  'La carpeta debe tener solamente letras y números.');
define('_MEDIAATTACH_VALIDATIONEXTENSIONREQUIRED',  'Por favor digita la extensión del nuevo tipo de archivo.');
define('_MEDIAATTACH_VALIDATIONEXTENSIONALPHANUM',  'La extensión sólo debe contener letras y números.');
define('_MEDIAATTACH_VALIDATIONCATEGORYNAMEREQUIRED',  'Por favor digita un nombre para la nueva categoría.');
define('_MEDIAATTACH_VALIDATIONCATEGORYNAMEALPHANUM',  'La categoría debe tener solamente letras y números.');

define('_MEDIAATTACH_ERRORALLOWEDFILENUM',      'No puedes subir más de %m% archivos a la vez.');
define('_MEDIAATTACH_ERRORALREADYSELECTED',     'Este archivo ya fue seleccionado.');
define('_MEDIAATTACH_ERROREXTENSIONNOTALLOWED', 'Este tipo de archivo no es permitido.');
define('_MEDIAATTACH_ERRORNOFILESSELECTED',     'Aún no se ha escogido ningún archivo.');
define('_MEDIAATTACH_ERRORALREADYRUNNING',      'Ya se está subiendo un archivo.');

define('_MEDIAATTACH_ADDFILE',                  'Añadir archivo');
define('_MEDIAATTACH_INFOFORATTACHMENTBOX',     'Los archivos añadidos serán listados aquí.');
define('_MEDIAATTACH_INFOFORDROPBOX',           'Arrastra aquí cualquier archivo añadido para removerlo.');
define('_MEDIAATTACH_UPLOADING',                'Subiendo...');

define('_MEDIAATTACH_FILEINFOGENERALINFO',      'Información general');
define('_MEDIAATTACH_FILEINFOFILETYPE',         'Tipo de archivo:');
define('_MEDIAATTACH_FILEINFOFILESIZE',         'Tamaño:');
define('_MEDIAATTACH_FILEINFOMIMETYPE',         'Tipo mime:');
define('_MEDIAATTACH_FILEINFOENCODING',         'Codificación:');
define('_MEDIAATTACH_FILEINFOPLAYTIME',         'Duración:');
define('_MEDIAATTACH_FILEINFOSECONDS',          'seg.');

define('_MEDIAATTACH_FILEINFOHASHINFO',         'Información encriptada');
define('_MEDIAATTACH_FILEINFOMD5ENTIREFILE',    'md5 del archivo entero:');
define('_MEDIAATTACH_FILEINFOMD5CRAWDATA',      'md5 datos comprimidos:');
define('_MEDIAATTACH_FILEINFOMD5URAWDATA',      'md5 datos no comprimidos:');
define('_MEDIAATTACH_FILEINFOMD5RAWDATA',       'md5 datos en bruto:');
define('_MEDIAATTACH_FILEINFOSHA1ENTIREFILE',   'sha1 del archivo entero:');
define('_MEDIAATTACH_FILEINFOSHA1RAWDATA',      'sha1 de los datos en bruto:');

define('_MEDIAATTACH_FILEINFOAUDIOINFO',        'Información del Audio');
define('_MEDIAATTACH_FILEINFOIMAGEINFO',        'Información de la Imágen');
define('_MEDIAATTACH_FILEINFOVIDEOINFO',        'Información del Video');
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
define('_MEDIAATTACH_FILEINFOAUDIOCODEC',       'Codec de compresión de Audio:');
define('_MEDIAATTACH_FILEINFOVIDEOCODEC',       'Codec de compresión de Video:');
define('_MEDIAATTACH_FILEINFOENCODER',          'Codificador:');
define('_MEDIAATTACH_FILEINFOCOMPRESSIONRATIO', 'Razón de compresión:');
define('_MEDIAATTACH_FILEINFOLOSSLESS',         'Sin pérdidas:');
define('_MEDIAATTACH_FILEINFOLOSSLESSCOMP',     'compresión sin perdidas');
define('_MEDIAATTACH_FILEINFOLOSSYCOMP',        'compresión con pérditas');
define('_MEDIAATTACH_FILEINFOFRAMERATE',        'Cuadros por segundo:');
define('_MEDIAATTACH_FILEINFOFPS',              'fps');
define('_MEDIAATTACH_FILEINFOSIZE',             'Tamaño:');
define('_MEDIAATTACH_FILEINFOWIDTH',            'Ancho:');
define('_MEDIAATTACH_FILEINFOHEIGHT',           'Alto:');
define('_MEDIAATTACH_FILEINFOPIXEL',            'pixéles');
define('_MEDIAATTACH_FILEINFOPIXELDAR',         'Relación de aspecto:');
define('_MEDIAATTACH_FILEINFOBGCOLOR',          'Color de fondo:');
define('_MEDIAATTACH_FILEINFOTAGINFO',          'Información de etiqueta');
define('_MEDIAATTACH_FILEINFOEXIF',             'Información EXIF');

define('_MEDIAATTACH_PROFILEUPLOADS',           'Estado de la subida');
define('_MEDIAATTACH_PROFILEFILESUPLOADED',     '%count% archivos subidos');
define('_MEDIAATTACH_PROFILETOTAL',             'total');

define('_MEDIAATTACH_EXTERNALONLYIMAGES',       'Sólo imágenes');
define('_MEDIAATTACH_EXTERNALOUTPUT',           'Display mode');
define('_MEDIAATTACH_EXTERNALOUTPUTLINK',       'Link to the file');
define('_MEDIAATTACH_EXTERNALOUTPUTINLINE',     'Embed the item inline');
define('_MEDIAATTACH_EXTERNALOUTPUTPHYSICAL',   'Embed the item physically');
define('_MEDIAATTACH_EXTERNALPASTEAS',          'Pegar cómo');
define('_MEDIAATTACH_EXTERNALPASTETHUMBWITHLINK', 'Miniatura con elnace a la imágen original');
define('_MEDIAATTACH_EXTERNALPASTETHUMBWITHLINKDL', 'Miniatura con enlace de descarga de la imágen original');
define('_MEDIAATTACH_EXTERNALPASTETHUMB',       'Imágenes Miniatura');
define('_MEDIAATTACH_EXTERNALPASTEORIGINAL',    'Imágen original');
define('_MEDIAATTACH_EXTERNALPASTETHUMBLINK',   'Enlace a la miniatura');
define('_MEDIAATTACH_EXTERNALPASTEORIGINALLINK', 'Enlace a la imágen original');
define('_MEDIAATTACH_EXTERNALPASTEID',           'ID de archivo');

define('_MEDIAATTACH_CATMODE',                  'Modo de visualización:');
define('_MEDIAATTACH_PREVIEW',                  'Previsualizar');
define('_MEDIAATTACH_ONLYIMAGES',               'Sólo imágenes');

define('_MEDIAATTACH_SWFBROWSEFILES',           'Explorar archivos');
define('_MEDIAATTACH_SWFQUEUEISEMPTY',          'La cola está vacía');
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
define('_MEDIAATTACH_EXTVIDERRORDOMAIN',        'Error: esta URL no es válida o no está soportada.');
define('_MEDIAATTACH_EXTVIDERRORGRAB',          'Disculpa, no se pudo determinar la información del medio.');

define('_MEDIAATTACH_CROPTHUMB',                'Ajustar thumbnail');
define('_MEDIAATTACH_CROPCHOOSE',               'Escoje tu imágen de previsualización deseada.');
define('_MEDIAATTACH_CROPFIXEDSIZE',            'El tamaño de la ventana de selección no es modificable.');
define('_MEDIAATTACH_CROPVARSIZEAR',            'El tamaño de la ventana de selección es modificable, la relación de aspecto se mantendrá.');
define('_MEDIAATTACH_CROPVARSIZE',              'El tamaño de la ventana de selección y la relación de aspecto son modificables.');
define('_MEDIAATTACH_CROPNOSCRIPT',             'Esta funcion requiere JavaScript.');

define('_CATREGCREATEFAILED',                   'Un error ha ocurrido mientras se creaban los registros de las categorías.');
define('_CATREGDELETEFAILED',                   'un error ha ocurrido mientras se borraban los registros de las categorías.');
define('_REGISTERSELFFAILED',                   'Error no crítico: Archivos de admin no pudieron ser preparados.');
