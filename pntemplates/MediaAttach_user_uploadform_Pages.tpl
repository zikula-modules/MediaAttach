{* $Id: $ *}

{zajaxheader modname="MediaAttach" filename=MediaAttach.js}

{zmodfunc modname="MediaAttach" type="user" func="showfilelist" objectid=$objectid}
{if $allowadd}
    <a id="myuploadform_switch" href="javascript:void(0);" title="{gt text="Upload files"}" style="display: none">
        {gt text="Upload files"}
    </a>
{if $activateExternalVideos}
  | <a id="myextvidform_switch" href="javascript:void(0);" title="{gt text="Embed external video"}" style="display: none">
        {gt text="Embed external video"}
    </a>
{/if}
    <form id="myuploadform" action="{zmodurl modname="MediaAttach" type="user" func="createupload"}" method="post" enctype="multipart/form-data" class="maform">
{*
        {if $usequota eq 0 || $usequota eq 1 && $usedquota < $allowedquota}
        <fieldset style="float: left; width: 50%">
        {else}
        <fieldset>
        {/if}
*}
        <fieldset>
            <input type="hidden" name="authid" id="MediaAttach_authid" value="{$authid}" />
            <input type="hidden" name="MediaAttach_redirect" id="MediaAttach_redirect" value="{$redirect}" />
            <input type="hidden" name="MediaAttach_modname" id="MediaAttach_modname" value="{$modname}" />
            <input type="hidden" name="MediaAttach_objectid" id="MediaAttach_objectid" value="{$objectid}" />

            <label class="maleft">{gt text="Allowed formats"}:</label>
            <a id="allowedformats_switch" href="javascript:void(0);" style="display: none">
                <span id="showformats">{gt text="show"}</span>
                <span id="hideformats" style="display: none">{gt text="hide"}</span>
            </a>
            <p id="allowedformats" style="float: left; margin-left: 13.3em">{foreach name="formatloop" item="currentformat" from=$definition.formats}{$currentformat.extension}{if !$smarty.foreach.formatloop.last}, {/if}{/foreach}</p><br />

            {if $usequota eq 1}
                <label class="maleft">{gt text="Quota"}:</label>
                {gt text="You have"} {mafilesize size=$usedquota} {gt text="of"} {mafilesize size=$allowedquota} {gt text="used"}<br />
            {/if}
            {if $usequota eq 0 || $usequota eq 1 && $usedquota < $allowedquota}
                {gt text="Choose Category" assign="lblDef"}
                <div id="fileInputFrame">
                    <label class="maleft">{gt text="Maximums"}:</label>
                    <input type="hidden" id="MediaAttach_maxfiles" name="maxfiles" value="{$definition.numfiles}" />
                    <input type="hidden" name="MAX_FILE_SIZE" value="{$definition.maxsize}" />
                    {$definition.numfiles} {gt text="files"} / {mafilesize size=$definition.maxsize}<br />

                    <label id="labelfile" for="MediaAttach_uploadfile" class="maleft">{gt text="File"}:</label>
                    <input id="MediaAttach_uploadfile" type="file" /><br />

                    <label id="labeltitle" for="MediaAttach_title" class="maleft">{gt text="Title"}:</label>
                    <input id="MediaAttach_title" type="text" maxlength="64" /><br />

                    <label id="labeldesc" for="MediaAttach_description" class="maleft">{gt text="Description"}:</label>
                    <textarea id="MediaAttach_description" rows="3" cols="30"></textarea><br />

                    <label for="mafilecats_Main_" class="maleft">{gt text="Categories"}:</label><br />
                    {nocache}
                    <ul id="maCatSelector" class="maCatSelector">
                    {foreach from=$categories key=property item=category}
                        <li>{selector_category category=$category name="mafilecats[$property]" field="id" selectedValue=0 defaultValue="0" defaultText=$lblDef editLink=false}</li>
                    {/foreach}
                    </ul>
                    {/nocache}
                    <br />

                    <input type="button" id="addNewUploadFile" value="{gt text="Add file"}" />
                </div>
            {else}
                <p>{gt text="You have no more memory for uploads available"}</p>
            {/if}
        </fieldset>

        {if $usequota eq 0 || $usequota eq 1 && $usedquota < $allowedquota}
        <fieldset style="margin: 10px 15px 0 15px">
            <ul id="addedUploadList">
                <li>{gt text="Added files will be listed here."}</li>
            </ul>

            <ul class="" style="position: relative" id="uploadRemoveBox">
                <li>{gt text="Drop any added files here to remove them."}</li>
            </ul>

            <iframe id="myuploadframe" name="myuploadframe" src="ajax.php?module=MediaAttach&amp;func=performupload" style="display: none"></iframe>

            {zmodcallhooks hookobject=item hookaction=new module=MediaAttach}
            <input type="submit" value="{gt text="Upload"}" class="maadminright" />
            {zimg id="ajax_indicator" style="display: none" modname="core" set="ajax" src="indicator_circle.gif" alt=""}<br />
            <span id="myuploadresult" style="display: none">{gt text="Uploading..."}</span>
        </fieldset>
        {/if}
        <br style="clear: left" />
    </form>
{if $activateExternalVideos}
<form id="myextvidform" action="{zmodurl modname="MediaAttach" type="user" func="createextvid"}" method="post" class="maform">
    <fieldset>
        <legend>{gt text="Embed external video"}</legend>
        <input type="hidden" name="authid" value="{$authid}" />
        <input type="hidden" name="MediaAttach_modname" value="{$modname}" />
        <input type="hidden" name="MediaAttach_redirect" value="{$redirect}" />
        <input type="hidden" name="MediaAttach_objectid" value="{$objectid}" />

        <label class="mamarginleft">{gt text="Supported providers"}:</label>
        <a id="supportedproviders_switch" href="javascript:void(0);" style="display: none">
            <span id="showproviders">{gt text="show"}</span>
            <span id="hideproviders" style="display: none">{gt text="hide"}</span>
        </a>
        <p id="supportedproviders" style="float: left; margin-left: 14em">{foreach name="proloop" item="provider" from=$supportedProviders}{$provider.name|pnvarprepfordisplay}{if !$smarty.foreach.proloop.last}, {/if}{/foreach}</p><br />

        <label id="lblurl" for="MediaAttach_videourl" class="mamarginleft">{gt text="Video Page URL"}:</label>
        <input id="MediaAttach_videourl" name="MediaAttach_videourl" type="text" size="40" />
        <input type="submit" value="{gt text="Submit"}" />
        <br />

        <label for="maextvidcats_Main_" class="mamarginleft">{gt text="Categories"}:</label><br />
        {nocache}
        <ul class="maCatSelector" style="margin-left: 14em">
        {foreach from=$categories key=property item=category}
            <li>{selector_category category=$category name="maextvidcats[$property]" field="id" selectedValue=0 defaultValue="0" defaultText=$lblDef editLink=false}</li>
        {/foreach}
        </ul>
        {/nocache}
    </fieldset>
</form>
{/if}
    <script type="text/javascript" language="javascript">
    /* <![CDATA[ */
        maInitUploadFormView();

    {if $usequota eq 0 || $usequota eq 1 && $usedquota < $allowedquota}
        var allowedExtensions = new Array({foreach name="formatloop" item="currentformat" from=$definition.formats}".{$currentformat.extension}"{if !$smarty.foreach.formatloop.last}, {/if}{/foreach});
        var errorAllowedFilenum = "{gt text="You are not allowed to upload more than %m% files at once." m=$definition.numfiles}";
        var errorAlreadySelected = "{gt text="This file has already been selected."}";
        var errorExtensionNotAllowed = "{gt text="The filetype of this file is not allowed."}";
        var errorNoFilesSelected = "{gt text="No file has been chosen yet."}";
        var errorAlreadyRunning = "{gt text="There is already a file being uploaded."}";

        Droppables.add('uploadRemoveBox', {{
            accept: 'addedUpload',
            hoverclass: 'dropActive',
            onDrop: function(element) {{
                element.parentNode.removeChild(element);
            }}
        }});

        $('addNewUploadFile').observe('click', maAddNewUploadFile);
        $('addNewUploadFile').observe('keypress', maAddNewUploadFile);
        $('myuploadform').observe('submit', maSubmitUploadForm);
        $('myuploadframe').observe('load', maResponseUpload);
    {/if}

    {if $activateExternalVideos}
        maInitExtVideoFormView();
    {/if}
    /* ]]> */
    </script>
{/if}
