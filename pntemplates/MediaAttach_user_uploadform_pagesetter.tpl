{* $Id: MediaAttach_user_uploadform_pagesetter.tpl 226 2007-08-13 13:32:46Z weckamc $ *}
{* Purpose of this template: shows an upload form for a special module (here Pagesetter) *}

{zajaxheader modname="MediaAttach" filename=MediaAttach.js}

<br id="files" />
{insert name="getstatusmsg"}<br /><br />
{if $definition.state eq 1}
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
            <fieldset>
                <legend>{gt text="Upload files"}</legend>
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

                <label class="maleft">{gt text="Max. size"}:</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="{$definition.maxsize}" />
                {mafilesize size=$definition.maxsize}<br />

                {if $usequota eq 1}
                    <label class="maleft">{gt text="Quota"}:</label>
                    {gt text="You have"} {mafilesize size=$usedquota} {gt text="of"} {mafilesize size=$allowedquota} {gt text="used"}<br />
                {/if}
                {if $usequota eq 0 || $usequota eq 1 && $usedquota < $allowedquota}
                    {gt text="Choose Category" assign="lblDef"}
                    <div id="uploadformwrappernonjs">
                    {foreach item="currentfilenum" from=$numArr}
                        <div style="margin: 5px 20px; padding-left: 20px">
                            <p style="font-weight: 700">{gt text="File"}{if $definition.numfiles > 1} {$currentfilenum}{/if}</p>

                            <label for="MediaAttach_uploadfile{$currentfilenum}" class="maleft">{gt text="File"}:</label>
                            <input id="MediaAttach_uploadfile{$currentfilenum}" name="MediaAttach_uploadfile{$currentfilenum}" type="file" /><br />

                            <label for="MediaAttach_title{$currentfilenum}" class="maleft">{gt text="Title"}:</label>
                            <input id="MediaAttach_title{$currentfilenum}" name="MediaAttach_title{$currentfilenum}" type="text" maxlength="64" /><br />

                            <label for="MediaAttach_description{$currentfilenum}" class="maleft">{gt text="Description"}:</label>
                            <textarea id="MediaAttach_description{$currentfilenum}" name="MediaAttach_description{$currentfilenum}" rows="3" cols="30"></textarea><br />

                            <label for="mafilecats_{$currentfilenum}_Main_" class="maleft">{gt text="Categories"}:</label><br />
                            {nocache}
                            <ul class="maCatSelector">
                            {foreach from=$categories key=property item=category}
                                <li>{selector_category category=$category name="mafilecats_`$currentfilenum`[$property]" field="id" selectedValue=0 defaultValue="0" defaultText=$lblDef editLink=false}</li>
                            {/foreach}
                            </ul>
                            {/nocache}
                            <br />
                        </div>
                    {/foreach}
                    </div>

                    <div id="uploadformwrapperjs" style="display: none">
                        <div id="fileInputFrame">
                            <label class="maleft">{gt text="Max. files"}:</label>
                            <input type="hidden" id="MediaAttach_maxfiles" name="maxfiles" value="{$definition.numfiles}" />
                            {$definition.numfiles}<br />

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

                            <input type="button" id="addNewUploadFile" value="{gt text="Add file"}" class="maadminright" /><br />
                        </div>

                        <ul id="addedUploadList">
                            <li>{gt text="Added files will be listed here."}</li>
                        </ul>

                        <ul class="" style="position: relative" id="uploadRemoveBox">
                            <li>{gt text="Drop any added files here to remove them."}</li>
                        </ul>
                    </div>

                    <iframe id="myuploadframe" name="myuploadframe" src="ajax.php?module=MediaAttach&amp;func=performupload" style="display: none"></iframe>

                    <br />
                    {zmodcallhooks hookobject=item hookaction=new module=MediaAttach}
                    <input type="submit" value="{gt text="Upload"}" class="maadminright" />
                    {zimg id="ajax_indicator" style="display: none" modname="core" set="ajax" src="indicator_circle.gif" __alt=""}
                    <span id="myuploadresult" style="display: none">{gt text="Uploading..."}</span><br />
                {else}
                    <p>{gt text="You have no more memory for uploads available"}</p>
                {/if}
            </fieldset>
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
            var errorAllowedFilenum = "{gt text="You are not allowed to upload more than %s files at once." tag1=$definition.numfiles}";
            var errorAlreadySelected = "{gt text="This file has already been selected."}";
            var errorExtensionNotAllowed = "{gt text="The filetype of this file is not allowed."}";
            maInitUploadFormFunction();

            var errorNoFilesSelected = "{gt text="No file has been chosen yet."}";
            var errorAlreadyRunning = "{gt text="There is already a file being uploaded."}";
            maInitUploadFormAsynchronous();
        {/if}

        {if $activateExternalVideos}
            maInitExtVideoFormView();
        {/if}
        /* ]]> */
        </script>
    {/if}
{/if}