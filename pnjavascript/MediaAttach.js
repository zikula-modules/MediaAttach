<!--
// $Id: MediaAttach.js 223 2007-08-12 09:22:59Z weckamc $

    function maSwitchDisplayState(id) {
      var maObj = $(id);
      if (maObj.getStyle('display') == 'none') {
          Effect.BlindDown(maObj);
      } else {
          Effect.BlindUp(maObj);
      }
    }

    function maSwitchDisplayUploadForm() {
        maSwitchDisplayState('myuploadform');
    }

    function maSwitchDisplayExtVidForm() {
        maSwitchDisplayState('myextvidform');
    }

    function maCheckNamingDiv(id) {
        var mylist = $('MediaAttach_naming' + id);
        if (mylist.selectedIndex == 2) {
            Effect.BlindDown('divnamingprefix' + id);
        } else {
            Effect.BlindUp('divnamingprefix' + id);
        }
    }

    function maCheckMailDiv(id) {
        var mycheckbox = $('MediaAttach_sendmails' + id);
        if (mycheckbox.checked == true) {
            Effect.BlindDown('divmail' + id);
        } else {
            Effect.BlindUp('divmail' + id);
        }
    }

    function maCheckMailerEntry() {
        var mycheckbox = $('mailfiles');
        if (mycheckbox.checked == true) {
            Effect.BlindDown('mailerdt');
            Effect.BlindDown('mailerdd');
        } else {
            Effect.BlindUp('mailerdt');
            Effect.BlindUp('mailerdd');
        }
    }

    function maCheckShrinkEntry() {
        var mycheckbox = $('shrinkimages');
        if (mycheckbox.checked == true) {
            Effect.BlindDown('shrinksizedt');
            Effect.BlindDown('shrinksizedd');
        } else {
            Effect.BlindUp('shrinksizedt');
            Effect.BlindUp('shrinksizedd');
        }
    }

    function maCheckCropSizeEntry() {
        var mycheckbox = $('usethumbcropper');
        if (mycheckbox.checked == true) {
            Effect.BlindDown('cropsizemodedt');
            Effect.BlindDown('cropsizemodedd');
        } else {
            Effect.BlindUp('cropsizemodedt');
            Effect.BlindUp('cropsizemodedd');
        }
    }

    function maCheckCatMode1() {
        var mylist = $('catdefaultmode');
        if (mylist.selectedIndex == 1 && $('catmodecategories').checked == false) {
            mylist.selectedIndex = 0;
        }
    }
    function maCheckCatMode2() {
        var mylist = $('catdefaultmode');
        if (mylist.selectedIndex == 2 && $('catmodemodules').checked == false) {
            mylist.selectedIndex = 0;
        }
    }
    function maCheckCatMode3() {
        var mylist = $('catdefaultmode');
        if (mylist.selectedIndex == 3 && $('catmodeusers').checked == false) {
            mylist.selectedIndex = 0;
        }
    }
    function maCheckCatModes() {
        var mylist = $('catdefaultmode');
        var selIndex = mylist.selectedIndex;

        if (selIndex == 1) {
            $('catmodecategories').checked = true;

        } else if (selIndex == 2) {
            $('catmodemodules').checked = true;

        } else if (selIndex == 3) {
            $('catmodeusers').checked = true;
        }
    }


    function maCheckDefLink(modname) {
        maSwitchDisplayState('showlink' + modname + 'one');
        maSwitchDisplayState('showlink' + modname + 'two');
        maSwitchDisplayState('show_definition' + modname);
    }


    function initNewDefinition(modname) {
        $('divmail' + modname).hide();
        $('divnamingprefix' + modname).hide();

        $('new_definition' + modname).hide();
        $('new_definition' + modname + '_switch').show();
    }

    function initShowDefinition(modname) {
        $('show_definition' + modname).hide();
        $('show_definition' + modname + '_switch').show();
    }


    function maSwitchDisplayNewFormatForm() {
        maSwitchDisplayState('new_format');
    }

    function maInitFormatView() {
        $('new_format').hide();
        var newFormatSwitch = $('new_format_switch');
        newFormatSwitch.show();

        newFormatSwitch.observe('click', maSwitchDisplayNewFormatForm);
        newFormatSwitch.observe('keypress', maSwitchDisplayNewFormatForm);

        var valid = new Validation('newformatform');
        //var result = valid.validate(); //true or false
    }

    function maSwitchDisplayNewGroupForm() {
        maSwitchDisplayState('new_group');
    }

    function maInitGroupView() {
        $('new_group').hide();
        var newGroupSwitch = $('new_group_switch');
        newGroupSwitch.show();

        newGroupSwitch.observe('click', maSwitchDisplayNewGroupForm);
        newGroupSwitch.observe('keypress', maSwitchDisplayNewGroupForm);

        var valid = new Validation('newgroupform');
        //var result = valid.validate(); //true or false
    }

    function maToggleImportFiles(marker) {
        var form = marker.form;
        var state = marker.checked;
        var filenr = 0;
        for (i = 0; i < form.elements.length; i++) {
            currentElement = form.elements[i];
            if (currentElement.type == 'checkbox' && currentElement.name.match(/^file/)) {
                if (currentElement.checked != state) {
                    currentElement.checked = state;
                    maSwitchDisplayState('filedesc' + filenr);
                }
                filenr++;
            }
        }
    }



    function maCheckFormatsLink() {
        maSwitchDisplayState('showformats');
        maSwitchDisplayState('hideformats');
        maSwitchDisplayState('allowedformats');
    }

    function maCheckProvidersLink() {
        maSwitchDisplayState('showproviders');
        maSwitchDisplayState('hideproviders');
        maSwitchDisplayState('supportedproviders');
    }

    function maInitUploadFormView() {
        $('allowedformats').hide();
        var allowedFormatsSwitch = $('allowedformats_switch');
        allowedFormatsSwitch.show();
        allowedFormatsSwitch.observe('click', maCheckFormatsLink);
        allowedFormatsSwitch.observe('keypress', maCheckFormatsLink);

        $('myuploadform').hide();
        var myUploadFormSwitch = $('myuploadform_switch');
        myUploadFormSwitch.show();
        myUploadFormSwitch.observe('click', maSwitchDisplayUploadForm);
        myUploadFormSwitch.observe('keypress', maSwitchDisplayUploadForm);
    }

    function maInitExtVideoFormView() {
        $('supportedproviders').hide();
        var supportedProvidersSwitch = $('supportedproviders_switch');
        supportedProvidersSwitch.show();
        supportedProvidersSwitch.observe('click', maCheckProvidersLink);
        supportedProvidersSwitch.observe('keypress', maCheckProvidersLink);

        $('myextvidform').hide();
        var myExtVideoFormSwitch = $('myextvidform_switch');
        myExtVideoFormSwitch.show();
        myExtVideoFormSwitch.observe('click', maSwitchDisplayExtVidForm);
        myExtVideoFormSwitch.observe('keypress', maSwitchDisplayExtVidForm);
    }

    var withinForum = false;

    function maInitUploadFormFunction() {
        $('uploadformwrappernonjs').hide();
        $('uploadformwrapperjs').show();

        Droppables.add('uploadRemoveBox', {
            accept: 'addedUpload',
            hoverclass: 'dropActive',
            onDrop: function(element) {
                element.parentNode.removeChild(element);
            }
        });

        $('addNewUploadFile').observe('click', maAddNewUploadFile);
        $('addNewUploadFile').observe('keypress', maAddNewUploadFile);
    }

    var uploadFormName = 'myuploadform';

    function maInitUploadFormAsynchronous() {
        if (withinForum) {
            var DizkusForms = new Array('newtopicform', 'quickreplyform', 'replyform');
            DizkusForms.each(function(entry) {
                if ($(entry)) {
                    uploadFormName = entry;
                }
            });
        }

        Event.observe(uploadFormName, 'submit', maSubmitUploadForm);
        $('myuploadframe').observe('load', maResponseUpload);
    }

    function maAddNewUploadFile(event) {
        var fileInputFrame = $('fileInputFrame');
        //find relevant input element within the IDed div tag
        var thisInputFile = $A(fileInputFrame.getElementsByTagName('input')).find(function(element, index) {
            if(element.type.toLowerCase() == 'file') {
                return true;
            }
        });

        var thisInputTitle = $A(fileInputFrame.getElementsByTagName('input')).find(function(element, index) {
            if(element.type.toLowerCase() == 'text') {
                return true;
            }
        });

        var thisInputDesc = $A(fileInputFrame.getElementsByTagName('textarea'))[0];

        var fileName = $F(thisInputFile);
        //check if a file is selected.
        if(fileName == '') {
            new Effect.Highlight(thisInputFile);
            Event.stop(event);
            return;
        }

        //check if extension of selected file is allowed
        var extensionAllowed = false;

        while (fileName.indexOf("\\") != -1) {
            fileName = fileName.slice(fileName.indexOf("\\") + 1);
        }
        fileName = fileName.toLowerCase();
        allowedExtensions.each(function(entry) {
            if (fileName.lastIndexOf(entry) != -1) {
                extensionAllowed = true;
            }
        });
        if (extensionAllowed == false) {
            alert(errorExtensionNotAllowed);
            Event.stop(event);
            return;
        }

        //check if a title has been entered.
        if($F(thisInputTitle) == '') {
            new Effect.Highlight(thisInputTitle);
            Event.stop(event);
            return;
        }

        //check if a description has been entered.
        if($F(thisInputDesc) == '') {
            new Effect.Highlight(thisInputDesc);
            Event.stop(event);
            return;
        }

        //check for maximum number of files allowed
        var listedFiles = $A($('addedUploadList').getElementsByTagName('li'));
        if (listedFiles.length > $F('MediaAttach_maxfiles')) {
            alert(errorAllowedFilenum);
            Event.stop(event);
            return;
        }

        var alreadyselected = false;
        //check if selected file has already been chosen
        listedFiles.each(function(entry) {
            if (entry.innerHTML.indexOf($F(thisInputFile)) != -1) {
                alreadyselected = true;
            }
        });

        if (alreadyselected == true) {
            alert(errorAlreadySelected);
            Event.stop(event);
            return;
        }

        //create a new text input containing all selected category ids
        var thisInputCats = Builder.node('input', {type: 'text', name: 'MediaAttach_categories[]'});

        //the input elements get hidden
        $(thisInputFile).hide();
        $(thisInputTitle).hide();
        $(thisInputDesc).hide();
        $(thisInputCats).hide();

        //the "un-named" inputs are now named with their field array names
        thisInputFile.setAttribute('name', 'MediaAttach_uploadfiles[]');
        thisInputTitle.setAttribute('name', 'MediaAttach_titles[]');
        thisInputDesc.setAttribute('name', 'MediaAttach_descriptions[]');



        var categoryInfo = '';
        var categoryFields = $A($('maCatSelector').getElementsByTagName('select'));
        var catCounter = 0;
        if (categoryFields.length > 0) {
            categoryFields.each(function(categoryField) {
                var catFieldID = categoryField.id;
                var catProperty = catFieldID.gsub('mafilecats_', '').gsub('_', '');
                if (catCounter > 0) categoryInfo += ',';
                categoryInfo += catProperty + ':' + $F(catFieldID);
                catCounter++;
            });
        }

        $(thisInputCats).value = categoryInfo;                         // assign id list

        //li node is created with the selected file path inside
        var li = Builder.node('li', {className: 'addedUpload'}, $F(thisInputTitle) + ' (' + $F(thisInputFile) + ')');

        //the hidden input elements are moved into the li node
        li.appendChild(thisInputFile);
        li.appendChild(thisInputTitle);
        li.appendChild(thisInputDesc);
        li.appendChild(thisInputCats);

        //the li node is appended to list of added upload files
        $('addedUploadList').appendChild(li);

        //the li node gets Draggable
        new Draggable(li, {revert: true});

        //new "un-named" input fields are set to the missing places.
        if (withinForum) {
            new Insertion.After('labelfile', "<input id='MediaAttach_uploadfile' type='file' size='13' class='mamarginleft' />");
            new Insertion.After('labeltitle', "<input id='MediaAttach_title' type='text' size='30' maxlength='32' class='mamarginleft' />");
            new Insertion.After('labeldesc', "<textarea id='MediaAttach_description' rows='3' cols='30' class='mamarginleft'></textarea>");
        }
        else {
            new Insertion.After('labelfile', "<input id='MediaAttach_uploadfile' type='file' />");
            new Insertion.After('labeltitle', "<input id='MediaAttach_title' type='text' maxlength='32' />");
            new Insertion.After('labeldesc', "<textarea id='MediaAttach_description' rows='3' cols='30'></textarea>");
        }
    }

    var uploadStatus = false;
    var newTopicUpload = false;
    var newTopicRedirect = '';

    function maSubmitUploadForm(event) {
        //check if files are selected
        var filesavailable = false;
        var listedFiles = $A($('addedUploadList').getElementsByTagName('input'));
        if (listedFiles.length == 0) {
            if (!withinForum) {
                alert(errorNoFilesSelected);
            }
            Event.stop(event);
            return;
        }

        if (uploadStatus == true) {
            alert(errorAlreadyRunning);
            Event.stop(event);
            return;
        } else {
            $(uploadFormName).setAttribute('action', 'ajax.php?module=MediaAttach&func=performupload');
            $(uploadFormName).setAttribute('target', 'myuploadframe');

            uploadStatus = true;
            $('ajax_indicator').show();
            $('myuploadresult').show();
            $(uploadFormName).setStyle({cursor: 'wait'});
        }
        //submit
    }

    function getUploadFrameDocument() {
        var uploadFrame = $('myuploadframe');
        var uploadFrameDocument = null;

        if (uploadFrame.contentDocument) {
            // DOM - Gecko, Konqueror, Opera
            uploadFrameDocument = uploadFrame.contentDocument;

        } else if (uploadFrame.contentWindow) {
            // IE5.5 and IE6 (+ Gecko, Konqueror, Opera)
            uploadFrameDocument = uploadFrame.contentWindow.document;

        } else if (uploadFrame.document) {
            // IE5 (+ Konqueror, Opera)
            uploadFrameDocument = uploadFrame.document;
        }
        return uploadFrameDocument;
    }

    function maResponseUpload()
    {
        var uploadFrameDocument = getUploadFrameDocument();
        var resultText = pndejsonize(uploadFrameDocument.body.innerHTML);

        if (resultText && resultText.message && resultText.message != '...') {
            $(uploadFormName).setStyle({cursor: 'auto'});
            $(uploadFormName).hide();
            $('ajax_indicator').hide();
            $('myuploadresult').hide();
            $('myuploadresult').update('');
            pnupdateauthids(resultText.authid);

            var listedFiles = $A($('addedUploadList').getElementsByTagName('li'));
            var inputFile, inputTitle, inputDesc;
            var counter = 0;
            listedFiles.each(function(entry) {
                if (entry.childNodes.length > 1) {
                    //consider only <li> elements containing upload fields
                    inputFile = entry.childNodes[1];
                    inputTitle = entry.childNodes[2];
                    inputDesc = entry.childNodes[3];

                    if (resultText.messages[counter]) {
                        //alert(resultText.messages[counter]);
                        //$('myuploadresult').update(resultText.messages[counter]);
                        //$('myuploadresult').show();
                    }

                    //remove entry from attachment list
                    entry.parentNode.removeChild(entry);

                    if ($('myfilelist') && resultText.listentries[counter]) {
                        //create new entry in current filelist
                        var listTag = $('myfilelist').tagName.toLowerCase();
                        var newTag;
                        if (listTag == 'div') newTag = 'div';
                        else if (listTag == 'dl') newTag = 'dt';

                        var newElem = Builder.node(newTag);
                        $('myfilelist').appendChild(newElem);
                        newElem.update(Base64.decode(resultText.listentries[counter]));
                    }

                    counter++;
                }
            });

            if (newTopicUpload) {
                window.location.href = newTopicRedirect;
            }

            uploadStatus = false;
        }
    }

    function maSubmitNaviForm() {
        $('maNavForm').submit();
    }





/**
*
*  Base64 encode / decode
*  http://www.webtoolkit.info/
*
**/

var Base64 = {

    // private property
    _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

    // public method for encoding
    encode : function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;

        input = Base64._utf8_encode(input);

        while (i < input.length) {

            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output +
            this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
            this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

        }

        return output;
    },

    // public method for decoding
    decode : function (input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {

            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);

            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }

        }

        output = Base64._utf8_decode(output);

        return output;

    },

    // private method for UTF-8 encoding
    _utf8_encode : function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {

            var c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            } else if ((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            } else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    },

    // private method for UTF-8 decoding
    _utf8_decode : function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;

        while ( i < utftext.length ) {

            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            } else if ((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            } else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }

        return string;
    }

}

-->