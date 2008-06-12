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


Loader::requireOnce('modules/MediaAttach/common.php');


/**
 * item selector class for content plugin
 */
class mediaattachItemSelector extends pnFormPlugin
{
    var $inputName;
    var $dataField;
    var $dataBased;
    var $group;
    var $mandatory;
    var $isValid = true;
    var $errorMessage;
    var $myLabel;

    var $selectedItemId = 0;

    function getFilename()
    {
        return __FILE__;
    }


    function create(&$render, $params)
    {
        $this->inputName = $this->id;
        $this->dataBased = (array_key_exists('dataBased', $params) ? $params['dataBased'] : true);
        $this->dataField = (array_key_exists('dataField', $params) ? $params['dataField'] : $this->id);
        $this->mandatory = (array_key_exists('mandatory', $params) ? $params['mandatory'] : true);
    }


    function load(&$render, &$params)
    {
        $this->loadValue($render, $render->get_template_vars());
    }

    function initialize(&$render)
    {
        $render->pnFormAddValidator($this);
    }

    function render(&$render)
    {
        PageUtil::AddVar('javascript', 'javascript/ajax/prototype.js');
        PageUtil::AddVar('javascript', 'modules/MediaAttach/pnjavascript/finditem.js');
        PageUtil::AddVar('stylesheet', ThemeUtil::getModuleStylesheet('MediaAttach'));

        $html = '';

        $ownRenderer = pnRender::getInstance('MediaAttach', false);
        $ownRenderer->assign('baseID', $this->inputName);

        $definitionid = (int) FormUtil::getPassedValue('did', 0, 'POST');
        $ownRenderer->assign('definitionid', $definitionid);
        $ownRenderer->assign('mainCategory', pnModAPIFunc('MediaAttach', 'cat', 'getMainCat'));

        $definitions = pnModAPIFunc('MediaAttach', 'definitions', 'getalldefinitions');
        if (!$definitions) {
            $ownRenderer->assign('modules', 0);
            return $ownRenderer->fetch('MediaAttach_external_selectitem.html');
        }

        $ownRenderer->assign('modules', 1);
        $ownRenderer->assign('definitions', $definitions);
        $ownRenderer->assign('selectedFileID', $this->selectedItemId);

        if ($definitionid != 0) {
            $modname = '';
            foreach($definitions as $currentDef) {
                if ($currentDef['did'] == $definitionid) {
                    $modname = $currentDef['modname'];
                    break;
                }
            }

            if (empty($modname)) {
                return LogUtil::registerError(_MODARGSERROR);
            }
            else if (!SecurityUtil::checkPermission('MediaAttach::', "$modname:: ", ACCESS_COMMENT)) {
                return LogUtil::registerPermissionError();
            }

            $fetchArgs = array();
            $fetchArgs['moduleFilter'] = $modname;
        }
        else if (!SecurityUtil::checkPermission('MediaAttach::', "::", ACCESS_COMMENT)) {
            return LogUtil::registerPermissionError();
        }

        $catID = (int) FormUtil::getPassedValue('catid', 0, 'POST');
        $ownRenderer->assign('catID', $catID);
        if ($catID != 0) {
            $fetchArgs['catFilter'] = array($catID);
        }

        $ownRenderer->assign('pastemode', 'embed');

        _maIntProcessFileList($ownRenderer, 50, $fetchArgs, 'POST');

        return $ownRenderer->fetch('MediaAttach_external_selectitem.html');

    }

    function decode(&$render) {
        $this->clearValidation($render);
        $fileid = FormUtil::getPassedValue($this->inputName, null, 'POST');
        if (get_magic_quotes_gpc())
            $fileid = stripslashes($fileid);

        $this->selectedItemId = (int) $fileid;
    }

    function validate(&$render) {
        if ($this->mandatory && empty($this->selectedItemId)) {
            $this->setError(_PNFORM_MANDATORYSELECTERROR);
        }
    }

    function setError($msg) {
        $this->isValid = false;
        $this->errorMessage = $msg;
    }

    function clearValidation(&$render) {
        $this->isValid = true;
        $this->errorMessage = null;
    }

    function saveValue(&$render, &$data) {
        if ($this->dataBased) {
            if ($this->group == null) {
                $data[$this->dataField] = $this->selectedItemId;
            }
            else {
                if (!array_key_exists($this->group, $data))
                    $data[$this->group] = array();
                $data[$this->group][$this->dataField] = $this->selectedItemId;
            }
        }
    }

    function loadValue(&$render, &$values) {
        if ($this->dataBased) {
            $value = null;

            if ($this->group == null) {
                if ($this->dataField != null  &&  isset($values[$this->dataField]))
                    $value = $values[$this->dataField];
            }
            else {
                if (isset($values[$this->group])) {
                    $data = $values[$this->group];
                    if (isset($data[$this->dataField])) {
                        $value = $data[$this->dataField];
                    }
                }
            }

            $this->selectedItemId = $value;
        }
    }
}



function smarty_function_mediaattachitemselector($params, &$render)
{
  return $render->pnFormRegisterPlugin('mediaattachItemSelector', $params);
}

