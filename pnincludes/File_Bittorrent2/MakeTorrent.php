<?php

// +----------------------------------------------------------------------+
// | Decode and Encode data in Bittorrent format                          |
// +----------------------------------------------------------------------+
// | Copyright (C) 2004-2005                                              |
// |   Justin Jones <j.nagash@gmail.com>                                  |
// |   Markus Tacker <m@tacker.org>                                       |
// |   barry hunter <geo@barryhunter.co.uk>                               |
// +----------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or        |
// | modify it under the terms of the GNU Lesser General Public           |
// | License as published by the Free Software Foundation; either         |
// | version 2.1 of the License, or (at your option) any later version.   |
// |                                                                      |
// | This library is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU    |
// | Lesser General Public License for more details.                      |
// |                                                                      |
// | You should have received a copy of the GNU Lesser General Public     |
// | License along with this library; if not, write to the                |
// | Free Software Foundation, Inc.                                       |
// | 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA               |
// +----------------------------------------------------------------------+

/**
 * Provides a class for making .torrent files
 * from a file or directory. Produces virtually
 * identical torrent files as btmaketorrent.py
 * from Bram Cohen's original BT client.
 *
 * @author Justin Jones <j.nagash@gmail.com>
 * @author Markus Tacker <m@tacker.org>
 * @author barry hunter <geo@barryhunter.co.uk>
 * @version $Id: MakeTorrent.php 93 2009-02-07 18:50:57Z m $
 * @package File_Bittorrent2
 * @category File
 */

/**
 * Include required classes
 */
require_once 'PEAR.php';
require_once 'File/Bittorrent2/Encode.php';
require_once 'File/Bittorrent2/Exception.php';

/**
 * Provides a class for making .torrent files
 * from a file or directory. Produces virtually
 * identical torrent files as btmaketorrent.py
 * from Bram Cohen's original BT client.
 *
 * @author Justin Jones <j.nagash@gmail.com>
 * @author Markus Tacker <m@tacker.org>
 * @author barry hunter <geo@barryhunter.co.uk>
 * @package File_Bittorrent2
 * @category File
 */
class File_Bittorrent2_MakeTorrent
{
    /**
     * @var string Path to the file or directory to create the torrent from.
     */
    protected $path = '';

    /**
     * @var bool Whether or not $path is a file
     */
    protected $is_file = false;

    /**
     * @var bool Where or not $path is a directory
     */
    protected $is_dir = false;

    /**
     * @var string The .torrent announce URL
     */
    protected $announce = '';

    /**
     * @var array The .torrent announce_list extension
     */
    protected $announce_list = array();

    /**
     * @var string The .torrent comment
     */
    protected $comment = '';

    /**
     * @var string The .torrent created by string
     */
    protected $created_by = 'File_Bittorrent2_MakeTorrent $Rev: 93 $. http://pear.php.net/package/File_Bittorrent';

    /**
     * @var string The .torrent suggested name (file/dir)
     */
    protected $name = '';

    /**
     * @var string The .torrent packed piece data
     */
    protected $pieces = '';

    /**
     * @var int The size of each piece in bytes.
     */
    protected $piece_length = 524288;

    /**
     * @var array The list of files (if this is a multi-file torrent)
     */
    protected $files = array();

    /**
     * @var string|false The data gap used to join two files into the same piece. string if it contains data or false
     */
    protected $data_gap = false;

    /**
    * @var resource file pointer
    */
    protected $fp;

    /**
    * @var mixed    The last error object or null if no error has occurred.
    */
    protected $last_error;
	
	/**
	* @var bool Where or not we have a list of files
	*/
	protected $is_multifile = false;

	/**
    * @var bool     Torrent is marked as 'private'.
    */
    protected $is_private = false;

    /**
     * Constructor
     *
     * Sets up the path to the file/dir to create
     * a torrent from
     *
     * @param string Path to use
     */
    function __construct($path)
    {
        $this->setPath($path);
    }

    /**
     * Function to set the announce URL for
     * the .torrent file
     *
     * @param string announce url
     * @return bool
     */
    function setAnnounce($announce)
    {
        $this->announce = strval($announce);
        return true;
    }

    /**
     * Function to set the announce list for
     * the .torrent file
     *
     * @param array announce list
     * @return bool
     */
    function setAnnounceList(array $announce_list)
    {
        $this->announce_list = $announce_list;
        return true;
    }

    /**
     * Function to set the comment for the
     * .torrent file
     *
     * @param string comment
     * @return bool
     */
    function setComment($comment)
    {
        $this->comment = strval($comment);
        return true;
    }

    /**
     * Function to set the path for the
     * file/dir to make the .torrent for
     * Can also be set through the constructor.
     *
     * @param string path to file/dir
     * @return bool
     */
    function setPath($path)
    {
        $this->path = $path;
        if (is_dir($path)) {
            $this->is_dir = true;
            $this->name = basename($path);
        } else if (is_file($path)) {
            $this->is_file = true;
            $this->name = basename($path);
        } else {
            $this->path = '';
        }
        return true;
    }

    /**
     * Function to set the piece length for
     * the .torrent file.
     * min: 32 (32KB), max: 4096 (4MB)
     *
     * @param int piece length in kilobytes
     * @return bool
	 * @throws File_Bittorrent2_Exception if piece length is invalid
     */
    function setPieceLength($piece_length)
    {
        if ($piece_length < 32 or $piece_length > 4096) {
			throw new File_Bittorrent2_Exception('Invalid piece lenth: \'' . $piece_length . '\'', File_Bittorrent2_Exception::make);
        }
        $this->piece_length = $piece_length * 1024;
        return true;
    }

    /**
     * Function to build the .torrent file
     * based on the parameters you have set
     * with the set* functions.
     *
     * @param array custom data set to be included in the metainfo
     * @return mixed false on failure or a string containing the metainfo
	 * @throws File_Bittorrent2_Exception if no file or directory is given
     */
    function buildTorrent(array $metainfo = array())
    {
        if ($this->is_multifile) {
            //we already have the files added
            $metainfo = $this->encodeTorrent(array(),$metainfo);
        } else if ($this->is_file) {
            if (!$info = $this->addFile($this->path)) {
                return false;
            }
            if (!$metainfo = $this->encodeTorrent($info,$metainfo)) {
                return false;
            }
        } else if ($this->is_dir) {
            if (!$diradd_ok = $this->addDir($this->path)) {
                return false;
            }
            $metainfo = $this->encodeTorrent(array(),$metainfo);
        } else {
            throw new File_Bittorrent2_Exception('You must provide a file or directory.', File_Bittorrent2_Exception::make);
        }
        return $metainfo;
    }

    /**
     * Internal function which bencodes the data
     * into a valid torrent metainfo string
     *
     * @param array file data
     * @param array custom data set to be included in the metainfo 
     * @return string bencoded metainfo 
	 * @throws File_Bittorrent2_Exception if no file or directory is defined
     */
    protected function encodeTorrent(array $info = array(), array $metainfo = array())
    {
        $bencdata = $metainfo;
        $bencdata['info'] = array();
        if ($this->is_file) {
            $bencdata['info']['length'] = $info['length'];
            $bencdata['info']['md5sum'] = $info['md5sum'];
        } else if ($this->is_dir) {
            if ($this->data_gap !== false) {
                $this->pieces .= pack('H*', sha1($this->data_gap));
                $this->data_gap = false;
            }
            $bencdata['info']['files'] = $this->files;
        } else {
			throw new File_Bittorrent2_Exception('Use ' .  __CLASS__ . '::setPath() to define a file or directory.', File_Bittorrent2_Exception::make);
        }
        $bencdata['info']['name']         = $this->name;
        $bencdata['info']['piece length'] = $this->piece_length;
        $bencdata['info']['pieces']       = $this->pieces;
        if ($this->is_private === true) $bencdata['info'][ 'private' ] = 1;
        $bencdata['announce']             = $this->announce;
        if (!empty($this->announce_list)) $bencdata['announce-list']        = $this->announce_list;
        $bencdata['creation date']        = time();
        $bencdata['comment']              = $this->comment;
        $bencdata['created by']           = $this->created_by;
        
        // Encode it
        $Encoder = new File_Bittorrent2_Encode;
        return $Encoder->encode_array($bencdata);
    }

    /**
     * Internal function which generates
     * metainfo data for a file
     *
     * @param string path to the file
     * @return mixed false on failure or file metainfo data
     * @throws File_Bittorrent2_Exception if given file cannot be opened
     */
    protected function addFile($file)
    {
        if (!$this->openFile($file)) {
			throw new File_Bittorrent2_Exception('Failed to open file \'' . $file . '\'.', File_Bittorrent2_Exception::source);
        }

        $filelength = 0;
        $md5sum = md5_file($file);

        while (!feof($this->fp)) {
            $data = '';
            $datalength = 0;

            if ($this->is_dir && $this->data_gap !== false) {
                $data = $this->data_gap;
                $datalength = strlen($data);
                $this->data_gap = false;
            }

            while (!feof($this->fp) && ($datalength < $this->piece_length)) {
                $readlength = 8192;
                if (($datalength + 8192) > $this->piece_length) {
                    $readlength = $this->piece_length - $datalength;
                }

                $tmpdata = fread($this->fp, $readlength);
                $actual_readlength = strlen($tmpdata);
                $datalength += $actual_readlength;
                $filelength += $actual_readlength;

                $data .= $tmpdata;

                flush();
            }

            // We've either reached the end of the file, or
            // we have a whole piece, or both.
            if ($datalength == $this->piece_length) {
                // We have a piece.
                $this->pieces .= pack('H*', sha1($data));
            }
            if (($datalength != $this->piece_length) && feof($this->fp)) {
                // We've reached the end of the file, and
                // we dont have a whole piece.
                if ($this->is_dir) {
                    $this->data_gap = $data;
                } else {
                    $this->pieces .= pack('H*', sha1($data));
                }
            }
        }

        // Close the file pointer.
        $this->closeFile();
        $info = array(
            'length' => $filelength,
            'md5sum' => $md5sum
        );
        return $info;
    }

    /**
     * Internal function which iterates through
     * directories and subdirectories, using
     * _addFile for each file it finds.
     *
     * @param string path to the directory
     * @return void
     */
    protected function addDir($path)
    {
        $filelist = $this->dirList($path);
        sort($filelist);

        foreach ($filelist as $file) {
            $filedata = $this->addFile($file);
            if ($filedata !== false) {
                $filedata['path'] = array();
                $filedata['path'][] = basename($file);
                $dirname = dirname($file);
                while (basename($dirname) != $this->name) {
                    $filedata['path'][] = basename($dirname);
                    $dirname = dirname($dirname);
                }
                $filedata['path'] = array_reverse($filedata['path'], false);
                $this->files[] = $filedata;
            }
        }
        return true;
    }

    /**
     * Internal function which recurses through
     * subdirectory and returns an array of file paths
     *
     * @param string path to the directory
     * @return array file list
     */
    protected function dirList($dir)
    {
        $dir = realpath($dir);
        $file_list = '';
        $stack[] = $dir;

        while ($stack) {
            $current_dir = array_pop($stack);
            if ($dh = opendir($current_dir)) {
                while ( ($file = readdir($dh)) !== false ) {
                    if ($file{0} =='.') continue;
                    $current_file = $current_dir . '/' . $file;
                    if (is_file($current_file)) {
                        $file_list[] = $current_dir . '/' . $file;
                    } else if (is_dir($current_file)) {
                        $stack[] = $current_file;
                    }
                }
            }
        }
        return $file_list;
    }

    /**
     * Internal function to get the filesize
     * of a file. Workaround for files >2GB.
     *
     * @param string path to the file
     * @return int the filesize
     */
    protected function filesize($file)
    {
        $size = @filesize($file);
        if ($size == 0) {
            if (PHP_OS != 'Linux') return false;
            $size = exec('du -b ' . escapeshellarg($file));
        }
        return $size;
    }

    /**
     * Internal function to open a file.
     * Workaround for files >2GB using popen
     *
     * @param string path to the file
     * @return bool
     * @throws File_Bittorrent2_Exception if opening file fails or is larger than 2GB (on Windows only)
     */
    protected function openFile($file)
    {
        $fsize = $this->filesize($file);
        if ($fsize <= 2*1024*1024*1024) {
            if (!$this->fp = fopen($file, 'r')) {
				throw new File_Bittorrent2_Exception('Failed to open \'' . $file . '\'', File_Bittorrent2_Exception::source);
            }
            $this->fopen = true;
        } else {
            if (PHP_OS != 'Linux') {
                throw new File_Bittorrent2_Exception('File size is greater than 2GB. This is only supported under Linux.', File_Bittorrent2_Exception::make);
            }
            $this->fp = popen('cat ' . escapeshellarg($file), 'r');
            $this->fopen = false;
        }
        return true;
    }

    /**
     * Internal function to close a file pointer
     */
    protected function closeFile()
    {
        if ($this->fopen) {
            fclose($this->fp);
        } else {
            pclose($this->fp);
        }
    }
	
	/**
	* Function to set the name for
	* the .torrent file
	*
	* @param string name
	* @return bool
	*/
	function setName($name)
	{
		$this->name = strval($name);
		return true;
	}

	/**
	* Function to add a specific list of files, 
	* pass blank to the constructor then call this function
	* 
	* @param array list of filepaths to add;
	* @param string folder containing files
	* @return bool
	*/
	function addFiles($filelist,$dir)
	{
		$this->is_dir = true;
		$this->is_multifile = true;
		$this->name = basename($dir);

		sort($filelist);

		foreach ($filelist as $file) {
			$filedata = $this->addFile($dir.$file);
			if ($filedata !== false) {
				$filedata['path'] = array();
				$filedata['path'][] = basename($file);
				$dirname = dirname($dir.$file);
				while (basename($dirname) != $this->name) {
					$filedata['path'][] = basename($dirname);
					$dirname = dirname($dirname);
				}
				$filedata['path'] = array_reverse($filedata['path'], false);
				$this->files[] = $filedata;
			}
		}
		return true;
	}

	/**
	* Sets whether the torrent is marked as 'private'
	*
	* Taken from http://www.azureuswiki.com/index.php/Secure_Torrents
	*
	* Tracker sites wanting to ensure that [clients] only obtains peers
	* directly from the tracker itself (besides incoming connections)
	* should embed the key "private" with the value "1" inside the
	* "info" dict of the .torrent file:
	* <code>infod6:lengthi136547e4:name6:a............7:privatei1ee</code>
	*
	* This new field will be ignored by [older] clients, so it does not
	* break compatibility as long as they've properly implemented the BT
	* spec. Also, this new field WILL change the torrent's infohash,
	* which means that torrents made without the secure flag aren't
	* compatible with torrents made with it. If you update all the torrents
	* on your web site, you will have to ask users to re-download the torrent
	* files in order to let them connect to your tracker.
	*
	* @param bool
	*/
	public function setIsPrivate( $bool )
	{
		$this->is_private = (bool)$bool;
	}
}

?>