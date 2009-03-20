<?php
/**
 * MediaAttach
 *
 * @version      $Id: common_mimetypes.php 100 2008-03-12 16:30:43Z weckamc $
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * utility function to retrieve the way of displaying a file in inline mode
 */
function _maGetInlineSnippetName($mimetype)
{
    $res = false;

    switch ($mimetype) {

        /* image and flash types */

        case 'image/bmp':                              // BMP
                                $res = 'image';
                                break;
        case 'image/gif':                              // GIF
        case 'image/jpeg':                             // JPG
        case 'image/pjpeg':
        case 'image/png':                              // PNG
                                $res = 'imagegd';
                                break;
        case 'application/x-shockwave-flash':          // SWF
                                $res = 'flash';
                                break;
        case 'video/x-flv':                            // FLV
                                $res = 'flv';
                                break;
        case 'image/x-targa':                          // TGA
        case 'image/tiff':                             // TIF
                                $res = 'unknown';
                                break;

        /* archive types */

        case 'application/zip':                        // ZIP
        case 'application/x-zip':
        case 'application/x-zip-compressed':
                                $res = 'comp_zip';
                                break;
        case 'application/x-rar':                      // RAR
                                $res = 'comp_rar';
                                break;
        case 'application/tar':                        // TAR
        case 'application/x-tar':
        case 'application/x-gtar':
                                $res = 'comp_tar';
                                break;

        /* text types */

        case 'text/css':                               // CSS
        case 'text/x-csv':                             // CSV
        case 'text/html':                              // HTML
        case 'text/plain':                             // TXT
        case 'text/x-java':                            // JAVA
        case 'application/xml':                        // XML
        case 'text/xml':
        case 'application/vnd.mozilla.xul+xml':        // XUL
                                $res = 'plain';
                                break;

        /* document types */
        case 'application/pdf':                        // PDF
                                $res = 'doc_pdf';
                                break;
        case 'application/msword':                     // DOC
        case 'application/msexcel':                    // XLS
                                $res = 'doc_msoffice';
                                break;
        case 'application/vnd.oasis.opendocument.text': // ODT
        case 'application/vnd.oasis.opendocument.spreadsheet': // ODS
        case 'application/vnd.oasis.opendocument.presentation': // ODP
                                $res = 'doc_ooffice';
                                break;
        case 'application/postscript':                 // AI, PS
                                $res = 'unknown';
                                break;

        /* audio and video types */

        case 'video/x-ms-asf':        // ASF
//        case 'video/avi':             // AVI
                                $res = 'wmp';
                                break;
        case 'video/quicktime':       // MOV
        case 'video/avi':             // AVI
        case 'audio/mid':             // MID
        case 'audio/wav':             // WAV
        case 'audio/mpg':             // MPG
        
                                $res = 'quicktime';
                                break;
         /*let mp3 files get played back by a fancy flash player  http://flash-mp3-player.net/players/maxi/ */
        case 'audio/mpeg4':
        case 'audio/mpg4':
        case 'audio/mp4':
        case 'video/mpeg':
        case 'audio/mpeg':
        case 'audio/mpeg3':
        case 'audio/mpg3':
        case 'audio/mp3':             // MP3
                                $res = 'mp3';
                                break;

        case 'application/vnd.rn-realmedia':
        case 'audio/vnd.rn-realvideo':                // RA
        case 'video/vnd.rn-realvideo':
        case 'audio/x-pn-realaudio':
        case 'audio/x-realaudio':
                                $res = 'real';
                                break;
        case 'audio/x-wav':
        case 'audio/x-ms-wma':
        case 'video/x-ms-wmv':
                                $res = 'wmp';
                                break;

        case 'application/octet-stream':
        default:

    }

    return $res;
}

/**
 * utility function to guess a mimetype by it's extension
 */
function _maGuessMimetypeFromExtension($extension) {
    $res = 'unknown';

    switch ($extension) {
        case 'bmp':                            // BMP
                $res = 'image/bmp';
                break;
        case 'gif':                            // GIF
                $res = 'image/gif';
                break;
        case 'jpeg':                           // JPG
        case 'jpg':
                $res = 'image/jpeg';
                break;
        case 'png':                            // PNG
                $res = 'image/png';
                break;
        case 'swf':                            // SWF
                $res = 'application/x-shockwave-flash';
                break;
        case 'flv':                            // FLV
                $res = 'video/x-flv';
                break;

        case 'tga':                            // TGA
                $res = 'image/x-targa';
                break;
        case 'tif':                            // TIF
        case 'tiff':
                $res = 'image/tiff';
                break;
        case 'pcx':                            // PCX
                $res = 'unknown';
                break;


        case 'ace':                            // ACE
        case 'cab':                            // CAB
        case 'iso':                            // ISO
        case 'lha':                            // LHA
        case 'lzh':                            // LZH
                $res = 'unknown';
                break;
        case 'rar':                            // RAR
                $res = 'application/x-rar';
                break;
        case 'tar':                            // TAR
                $res = 'application/x-tar';
                break;
        case 'jar':                            // JAR
        case 'zip':                            // ZIP
                $res = 'application/zip';
                break;


        case 'css':                            // CSS
                $res = 'text/css';
                break;
        case 'csv':                            // CSV
                $res = 'text/x-csv';
                break;
        case 'htm':                            // HTM
        case 'html':                           // HTML
                $res = 'text/html';
                break;
        case 'java':                           // JAVA
                $res = 'text/x-java';
                break;
        case 'c':                              // C
        case 'cpp':                            // CPP
        case 'h':                              // H
        case 'pas':                            // PAS
        case 'php':                            // PHP
        case 'txt':                            // TXT
        case 'xml':                            // XML
        case 'reg':                            // windows regsitry @todo which mimetype has ms registry files ?
                $res = 'text/xml';
                break;
        case 'xul':                            // XUL
                $res = 'application/vnd.mozilla.xul+xml';
                break;



        case 'pdf':                            // PDF
                $res = 'application/pdf';
                break;
        case 'doc':                            // DOC
                $res = 'application/msword';
                break;
        case 'xls':                            // XLS
                $res = 'application/msexcel';
                break;
        case 'ppt':                            // PPT
                $res = 'application/powerpoint';
                break;
        case 'odt':                            // ODT
                $res = 'application/vnd.oasis.opendocument.text';
                break;
        case 'ods':                            // ODS
                $res = 'application/vnd.oasis.opendocument.spreadsheet';
                break;
        case 'odp':                            // ODP
                $res = 'application/vnd.oasis.opendocument.presentation';
                break;
        case 'ai':                             // AI
        case 'ps':                             // PS
                $res = 'application/postscript';
                break;


        case 'asf':                            // ASF
                $res = 'video/x-ms-asf';
                break;
        case 'avi':                            // AVI
                $res = 'video/avi';
                break;
        case 'mid':                            // MID
                $res = 'audio/mid';
                break;
        case 'mov':                            // MOV
                $res = 'video/quicktime';
                break;
        case 'mp3':                            // MP3
                $res = 'audio/mp3';
                break;
        case 'mp4':                            // MP4
                $res = 'audio/mp4';
                break;
        case 'mpe':
        case 'mpeg':
        case 'mpg':                            // MPG
                $res = 'video/mpeg';
                break;
        case 'wav':                            // WAV
                $res = 'audio/wav';
                break;
        case 'ra':                             // RA
                $res = 'audio/x-realaudio';
                break;
        case 'wma':                            // WMA
                $res = 'audio/x-ms-wma';
                break;
        case 'wmv':                            // WMV
                $res = 'video/x-ms-wmv';
                break;

        default:
                $res = 'unknown';
                break;
    }

    return $res;
}
