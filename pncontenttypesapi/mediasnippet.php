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

Loader::requireOnce('modules/MediaAttach/common.php');

/**
 * content plugin class
 */
class MediaAttach_contenttypesapi_mediaSnippetPlugin extends contentTypeBase
{
    var $fileID;
    var $pasteMode;
    var $floatMode;
    var $thumbnr;

    function getModule()
    {
        return 'MediaAttach';
    }
    function getName()
    {
        return 'mediasnippet';
    }
    function getTitle()
    {
        $dom = ZLanguage::getModuleDomain('MediaAttach');
        return __('MediaAttach file', $dom);
    }
    function getDescription()
    {
        $dom = ZLanguage::getModuleDomain('MediaAttach');
        return __('Display a single MediaAttach file.', $dom);
    }

    function loadData(&$data)
    {
        if (!isset($data['pasteMode']))
            $data['pasteMode'] = 'embed';
        if (!isset($data['floatMode']))
            $data['floatMode'] = 'none';
        if (!isset($data['thumbnr']))
            $data['thumbnr'] = pnModGetVar('MediaAttach', 'defaultthumb');

        $this->fileID = $data['mafile'];
        $this->pasteMode = $data['pasteMode'];
        $this->floatMode = $data['floatMode'];
        $this->thumbnr = $data['thumbnr'];
    }

    function display()
    {
        if (!empty($this->fileID) && !empty($this->pasteMode) && !empty($this->floatMode) && !empty($this->thumbnr)) {
            return pnModFunc('MediaAttach', 'external', 'display', array('fileid' => $this->fileID, 'displaymode' => $this->pasteMode, 'floatmode' => $this->floatMode, 'thumbnr' => $this->thumbnr));
        }
        return '';
    }

    function displayEditing()
    {
        $dom = ZLanguage::getModuleDomain('MediaAttach');
        if (!empty($this->fileID) && !empty($this->pasteMode)) {
            return pnModFunc('MediaAttach', 'external', 'display', array('fileid' => $this->fileID, 'displaymode' => $this->pasteMode, 'thumbnr' => $this->thumbnr));
        }
        return __('No media file selected', $dom);
    }

    function getDefaultData()
    {
        return array('fileID' => null, 'pasteMode' => 'embed', 'floatMode' => 'none', 'thumbnr' => pnModGetVar('MediaAttach', 'defaultthumb'));
    }

    function startEditing(&$render)
    {
        array_push($render->plugins_dir, 'modules/MediaAttach/pntemplates/pnform');
    }
}

function MediaAttach_contenttypesapi_mediasnippet($args)
{
    return new MediaAttach_contenttypesapi_mediaSnippetPlugin();
}
