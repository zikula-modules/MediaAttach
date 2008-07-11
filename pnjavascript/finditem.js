//=============================================================================
// Stand alone file selector for MediaAttach
// (C) Axel Guckelsberger (2007)
// based on Mediashare implementation
// (C) Jorn Wildt 2006
//=============================================================================

//=============================================================================
// External interface functions
//=============================================================================

function MediaAttachFindItemPS(targetId, maURL)
{
  currentMediaAttachInput = document.getElementById(targetId);
  if (currentMediaAttachInput == null)
    alert("Unknown input element '" + targetId + "'");

  window.open(maURL, "", getPopupAttributes());
}

function MediaAttachFindItemXinha(editor, maURL)
{
  // Save editor for access in selector window
  currentMediaAttachEditor = editor;

  window.open(maURL, "", getPopupAttributes());
}

function getPopupAttributes()
{
    var pWidth = screen.width * 0.75;
    var pHeight = screen.height * 0.66;
    return "width="+pWidth+",height="+pHeight+",scrollbars,resizable";
}


//=============================================================================
// Internal stuff
//=============================================================================

// htmlArea 3.0 editor for access in selector window
var currentMediaAttachEditor = null;
var currentMediaAttachInput = null;

var mediaAttach = {}

mediaAttach.find = {}

mediaAttach.find.onParamChanged = function() {
    $('selectorForm').submit();
}

mediaAttach.find.handleCancel = function() {
    var w = parent.window;
    window.close();
    w.focus();
}


function getPasteSnippet(mode, fileID) {
  var useMultiHookOutput = false;
  if ($('MediaAttach_output') && $('MediaAttach_output').selectedIndex != 0 ) {
      useMultiHookOutput = true;
  }
  if (useMultiHookOutput == false) {
    var titleText = $F('imgtitle' + fileID);
    var descText = $F('imgdesc' + fileID);
    var fileUrl = document.location.pnbaseURL + document.location.entrypoint + '?module=MediaAttach&func=download&fileid=' + fileID;
    var fileUrlEnc = document.location.pnbaseURL + document.location.entrypoint + '?module=MediaAttach&amp;func=download&amp;fileid=' + fileID;

    var fromGuppy = $F('fromguppy');

    if ($('MediaAttach_onlyimages').checked) {
        var mylist = $('MediaAttach_pasteas');
        var selIndex = mylist.selectedIndex;

        var thumbUrl = document.location.pnbaseURL + $F('imgpreview' + fileID);
        var inlineUrl = fileUrlEnc + "&amp;inline=1";

        if (selIndex == 0) {
            // thumbnail with link to view original
            return "<a href=\"" + inlineUrl + "\" title=\"" + descText + "\"><img src=\"" + thumbUrl + "\" alt=\"" + titleText + "\" /></a>";
        }
        else if (selIndex == 1) {
            // thumbnail with link to download original
            return "<a href=\"" + fileUrlEnc + "\" title=\"" + descText + "\"><img src=\"" + thumbUrl + "\" alt=\"" + titleText + "\" /></a>";
        }
        if (selIndex == 2) {
            // thumbnail image
            return "<img src=\"" + thumbUrl + "\" alt=\"" + titleText + "\" />";
        }
        else if (selIndex == 3) {
            // original image
            return "<img src=\"" + inlineUrl + "\" alt=\"" + titleText + "\" />";
        }

        else if (selIndex > 1 && selIndex < 6) {
            if (mode == "url") {
                // plugin mode
                if (selIndex == 4) {
                    // link to thumbnail
                    return fileUrl + "&thumb=1";
                }
                else if (selIndex == 5) {
                    // link to original
                    return fileUrl + "&inline=1";
                }
                else {
                    return fileUrl;
                }
            }
            else {
                // editor mode
                if (selIndex == 4) {
                    // link to thumbnail
                    return "<a href=\"" + thumbUrl + "\" title=\"" + descText + "\">" + titleText + "</a>";
                }
                else if (selIndex > 4) {
                    // link to original
                    return "<a href=\"" + fileUrlEnc + "\" title=\"" + descText + "\">" + titleText + "</a>";
                }
            }
        }
        else if (selIndex == 6) {
            // link to original download
            if (mode == "url") {
                return fileUrl;
            }
            else {
                return "<a href=\"" + fileUrlEnc + "\" title=\"" + descText + "\">" + titleText + "</a>";
            }
        }
        else if (selIndex == 7) {
            return fileID;
        }
    }
    else if (fromGuppy == 1) {
        var mylist = $('MediaAttach_pasteas');
        var selIndex = mylist.selectedIndex;
        if (selIndex == 0) {
            return fileUrl;
        }
        else if (selIndex == 1) {
            return fileID;
        }
    }
    else {
        // link to original download
        if (mode == "url") {
            return fileUrl;
        }
        else {
            return "<a href=\"" + fileUrlEnc + "\" title=\"" + descText + "\">" + titleText + "</a>";
        }
    }
  }
  else {
      var needleMode = 'P'
      if ($('MediaAttach_output').selectedIndex == 1) {
          needleMode = 'I';
      }
      return 'FILEMANAGER' + needleMode + '-' + fileID;
  }
}


  // User clicks on "select item" button
mediaAttach.find.selectItem = function(fileID) {
    if (window.opener.currentMediaAttachEditor != null) {
        var html = getPasteSnippet('html', fileID);

        window.opener.currentMediaAttachEditor.focusEditor();
        window.opener.currentMediaAttachEditor.insertHTML(html);
    }
    else {
        var html = getPasteSnippet('url', fileID);
        var currentInput = window.opener.currentMediaAttachInput;

        if (currentInput.tagName == 'INPUT') {
            // Simply overwrite value of input elements
        currentInput.value = html;
        }
        else if (currentInput.tagName == 'TEXTAREA') {
            // Try to paste into textarea - technique depends on environment
            if (typeof document.selection != "undefined") {
                // IE: Move focus to textarea (which fortunately keeps its current selection) and overwrite selection
                currentInput.focus();
                window.opener.document.selection.createRange().text = html;
            }
            else if (typeof currentInput.selectionStart != "undefined") {
                // Firefox: Get start and end points of selection and create new value based on old value
                var startPos = currentInput.selectionStart;
                var endPos = currentInput.selectionEnd;
                currentInput.value = currentInput.value.substring(0, startPos)
                                                            + html
                                                            + currentInput.value.substring(endPos, currentInput.value.length);
            }
            else {
                // Others: just append to the current value
                currentInput.value += html;
            }
        }
    }
    window.opener.focus();
    window.close();
}


function handleOnClickCancel() {
    window.opener.focus();
    window.close();
}




//=============================================================================
// MediaAttach item selector for pnForms
//=============================================================================

mediaAttach.itemSelector = {};
mediaAttach.itemSelector.items = {};
mediaAttach.itemSelector.baseID = 0;
mediaAttach.itemSelector.selectedFileID = 0;

function onCategoryChanged() {
    mediaAttach.itemSelector.onParamChanged();
}

mediaAttach.itemSelector.onLoad = function(baseID, selectedFileID) {
    mediaAttach.itemSelector.baseID = baseID;
    mediaAttach.itemSelector.selectedFileID = selectedFileID;

    $('mafile_catid').observe('change', onCategoryChanged, false);

    mediaAttach.itemSelector.getFileList();
}

mediaAttach.itemSelector.onParamChanged = function() {
    var baseID = mediaAttach.itemSelector.baseID;
    $('ajax_indicator').show();

    mediaAttach.itemSelector.getFileList();
}

mediaAttach.itemSelector.getFileList = function() {
    var baseID = mediaAttach.itemSelector.baseID;
    var pars = 'did=' + $F(baseID + '_did') + '&' +
               'catid=' + $F(baseID + '_catid') + '&' +
               'sortby=' + $F(baseID + '_sortby') + '&' +
               'sortdir=' + $F(baseID + '_sortdir') + '&' +
               'searchfor=' + $F(baseID + '_filterby');

    var thumbInput = $('pnFormForm').getInputs('radio', 'thumbnr').find(function(r) { return r.checked });
    pars += '&thumbnr=' + thumbInput.value;

    var url = 'ajax.php?module=MediaAttach&func=getfilelist';

    new Ajax.Request(url, { method: 'post',
                            parameters: pars,
                            onSuccess: function(response) { mediaAttach.itemSelector.gotItems(response); },
                            onFailure: mediaAttach.itemSelector.handleError});
}

mediaAttach.itemSelector.gotItems = function(response) {
    var baseID = mediaAttach.itemSelector.baseID;
    var result = pndejsonize(response.responseText);

    mediaAttach.itemSelector.items[baseID] = result.files;

    $('ajax_indicator').hide();

    itemSelector = $(baseID + '_fileid');
    itemSelector.length = 0;

    for (i = 0; i < result.files.length; ++i) {
        var item = result.files[i];
        itemSelector.options[i] = new Option(item.title + ' (' + item.extension + ')', item.fileid, false);
    }

    if (mediaAttach.itemSelector.selectedFileID > 0) {
        $(baseID + '_fileid').value = mediaAttach.itemSelector.selectedFileID;
    }

    if (result.files.length > 0) {
        if (mediaAttach.itemSelector.selectedFileID > 0) {
            for (i = 0; i < result.files.length; ++i) {
                if (result.files[i].fileid == mediaAttach.itemSelector.selectedFileID) {
                    $(baseID + '_previewcontainer').update(window.atob(result.files[i].previewInfo));
                    break;
                }
            }
        }
        else {
            $(baseID + '_previewcontainer').update(window.atob(result.files[0].previewInfo));
        }
        $(baseID + '_previewcontainer').show();
    }
    else {
        $(baseID + '_previewcontainer').hide();
    }
}

mediaAttach.itemSelector.onFileChanged = function(baseId) {
    var baseID = mediaAttach.itemSelector.baseID;
    var itemSelector = $(baseID + '_fileid');
    $(baseID + '_previewcontainer').update(window.atob(mediaAttach.itemSelector.items[baseID][itemSelector.selectedIndex].previewInfo));
    mediaAttach.itemSelector.selectedFileID = $F(baseID + '_fileid');
}

mediaAttach.itemSelector.handleError = function(response) {
    alert(response.responseText);
}

