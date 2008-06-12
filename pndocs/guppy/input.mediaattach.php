<?php

require_once 'modules/pagesetter/guppy/plugins/input.string.php';


class GuppyInput_mediaattach extends GuppyInput_string
{
  function render($guppy)
  {
    $htmlClass = 'mshtml';

    if ($this->mandatory)
      if ($this->data == '')
        $htmlClass .= " mde";
      else
        $htmlClass .= " mdt";

    $style = $this->getHtmlStyle();
    if ($style != '')
      $style = " style=\"$style\"";

    if ($this->readonly)
      $readonly = " readonly=\"1\"";
    else
      $readonly = '';

    $imgHtml = htmlspecialchars($this->value);

    $html = "<script type=\"text/javascript\" src=\"modules/MediaAttach/pnjavascript/finditem.js\"></script>\n";

    $html .= "<input type=\"text\" name=\"" . $this->name . "\" id=\"" . $this->ID . "\" class=\"$htmlClass\" $style value=\"$imgHtml\"$readonly/>";

    $id = $this->ID;

    $popupUrl =  pnGetBaseURL() . pnModUrl('MediaAttach', 'external', 'finditem', array('guppy' => '1'));
    $popupHtml = "&nbsp; <button type=\"button\" class=\"popup-button\" onclick=\"MediaAttachFindItemPS('$id','$popupUrl')\">...</button>";

    return $html . $popupHtml;
  }


  function validate()
  {
    if (!parent::validate())
      return false;

    if (!$this->mandatory  &&  $this->value == '')
      return true;

    return true;
  }


  // ===[ Pagesetter interface ]==============================================

  function active()
  {
    return true;
  }

  function getTitle()
  {
    return 'MediaAttach-Datei';
  }

  function getSqlType()
  {
    return 'VARCHAR(255)';
  }
}

?>
