{* $Id: MediaAttach_admin_view.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Admin files management *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="lists.gif" set="icons/large" __alt="Admin files" }</div>

    {if $definition.state eq 1}
    <h2>{gt text="Admin files"}</h2>

    <div class="z-menu">
        <span class="z-menuitem-title">
            [ <a id="myuploadform_switch" href="javascript:void(0);" title="{gt text="Upload files"}" style="display: none">{gt text="Upload files"}</a>

            {if $activateExternalVideos}
            | <a id="myextvidform_switch" href="javascript:void(0);" title="{gt text="Embed external video"}" style="display: none">
                {gt text="Embed external video"}
            </a>
            {/if}

            |  <a href="{zmodurl modname="MediaAttach" type="admin" func="importfsform"}" title="{gt text="Import files from a server directory"}">{gt text="Import files from a server directory"}</a>
            {assign var="numImportModules" value=$importModules|@count}

            {if $numImportModules > 0}
            |  <a href="{zmodurl modname="MediaAttach" type="admin" func="importmodform"}" title="{gt text="Import files from another module"}">{gt text="Import files from another module"}</a>
            {/if}
            ]
        </span>
    </div>

    <form id="myuploadform" class="z-form" action="{zmodurl modname="MediaAttach" type="admin" func="createupload"}" method="post" enctype="multipart/form-data">
        <div>
            <input type="hidden" name="authid" id="MediaAttach_authid" value="{$authid}" />
            <input type="hidden" name="MediaAttach_modname" id="MediaAttach_modname" value="MediaAttach" />
            <input type="hidden" name="MAX_FILE_SIZE" value="{$definition.maxsize}" />
            <fieldset>
                <legend>{gt text="Upload files"}</legend>
                <div class="z-formrow">
                    <label>{gt text="Allowed formats"}</label>
                    <div>
                        <a id="allowedformats_switch" href="javascript:void(0);" style="display: none">
                            <span id="showformats">{gt text="show"}</span>
                            <span id="hideformats" style="display: none">{gt text="hide"}</span>
                        </a>
                    </div>
                </div>
                <p id="allowedformats" class="z-formnote">{foreach name="formatloop" item="currentformat" from=$definition.formats}{$currentformat.extension}{if $smarty.foreach.formatloop.last ne true}, {/if}{/foreach}</p>

                <div class="z-formrow">
                    <label>{gt text="Max. size"}</label>
                    <span>{mafilesize size=$definition.maxsize}</span>
                </div>

                {if $usequota eq 1}
                <div class="z-formrow">
                    <label>{gt text="Quota"}</label>
                    <span>{gt text="You have"} {mafilesize size=$usedquota} {gt text="of"} {mafilesize size=$allowedquota} {gt text="used"}</span>
                </div>
                {/if}

                {if $usequota eq 0 || $usequota eq 1 && $usedquota < $allowedquota}
                {gt text="Choose Category" assign="lblDef"}
                <div id="uploadformwrappernonjs">
                    {foreach item="currentfilenum" from=$numArr}
                    <div style="margin: 5px 20px; padding-left: 20px">
                        <p style="font-weight: 700">{gt text="File"}{if $definition.numfiles > 1} {$currentfilenum}{/if}</p>

                        <div class="z-formrow">
                            <label for="MediaAttach_uploadfile{$currentfilenum}">{gt text="File"}</label>
                            <input id="MediaAttach_uploadfile{$currentfilenum}" name="MediaAttach_uploadfile{$currentfilenum}" type="file" />
                        </div>
                        <div class="z-formrow">
                            <label for="MediaAttach_title{$currentfilenum}">{gt text="Title"}</label>
                            <input id="MediaAttach_title{$currentfilenum}" name="MediaAttach_title{$currentfilenum}" maxlength="64" type="text" />
                        </div>
                        <div class="z-formrow">
                            <label for="MediaAttach_description{$currentfilenum}">{gt text="Description"}</label>
                            <textarea id="MediaAttach_description{$currentfilenum}" name="MediaAttach_description{$currentfilenum}" rows="3" cols="30"></textarea>
                        </div>
                        <div class="z-formrow">
                            <label for="mafilecats_{$currentfilenum}_Main_">{gt text="Categories"}</label>
                            {nocache}
                            {foreach from=$categories key=property item=category}
                            <div class="z-formnote">{selector_category category=$category name="mafilecats_`$currentfilenum`[$property]" field="id" selectedValue=0 defaultValue="0" defaultText=$lblDef editLink=false}</div>
                            {/foreach}
                            {/nocache}
                        </div>
                    </div>
                    {/foreach}
                </div>

                <div id="uploadformwrapperjs" style="display: none">
                    <div id="fileInputFrame">
                        <div class="z-formrow">
                            <label>{gt text="Max. files"}</label>
                            <span>{$definition.numfiles}</span>
                            <input type="hidden" id="MediaAttach_maxfiles" name="maxfiles" value="{$definition.numfiles}" />
                        </div>
                        <div class="z-formrow">
                            <label id="labelfile" for="MediaAttach_uploadfile">{gt text="File"}</label>
                            <input id="MediaAttach_uploadfile" type="file" />
                        </div>
                        <div class="z-formrow">
                            <label id="labeltitle" for="MediaAttach_title">{gt text="Title"}</label>
                            <input id="MediaAttach_title" type="text" maxlength="64" />
                        </div>
                        <div class="z-formrow">
                            <label id="labeldesc" for="MediaAttach_description">{gt text="Description"}</label>
                            <textarea id="MediaAttach_description" rows="3" cols="30"></textarea>
                        </div>
                        <div class="z-formrow">
                            <label for="mafilecats_Main_">{gt text="Categories"}</label>
                            {nocache}
                            {foreach from=$categories key=property item=category}
                            <div class="z-formnote">{selector_category category=$category name="mafilecats[$property]" field="id" selectedValue=0 defaultValue="0" defaultText=$lblDef editLink=false}</div>
                            {/foreach}
                            {/nocache}
                        </div>
                        <div class="z-formbuttons">
                            <input type="button" id="addNewUploadFile" value="{gt text="Add file"}" />
                        </div>
                    </div>

                    <ul id="addedUploadList">
                        <li>{gt text="Added files will be listed here."}</li>
                    </ul>

                    <ul class="" style="position: relative" id="uploadRemoveBox">
                        <li>{gt text="Drop any added files here to remove them."}</li>
                    </ul>
                </div>

                <iframe id="myuploadframe" name="myuploadframe" src="ajax.php?module=MediaAttach&amp;func=performupload{*admin*}" style="display: none"></iframe>


                {zmodcallhooks hookobject=item hookaction=new module=MediaAttach}
                <input type="submit" value="{gt text="Upload"}" />
                {zimg id="ajax_indicator" style="display: none" modname="core" set="ajax" src="indicator_circle.gif" alt=""}
                <span id="myuploadresult" style="display: none">{gt text="Uploading..."}</span>
                {else}
                <p class="z-warningmsg">{gt text="You have no more memory for uploads available"}</p>
                {/if}
            </fieldset>
        </div>
    </form>

    {if $activateExternalVideos}
    <form id="myextvidform" class="z-form" action="{zmodurl modname="MediaAttach" type="user" func="createextvid"}" method="post">
        <div>
            <input type="hidden" name="authid" value="{$authid}" />
            <input type="hidden" name="MediaAttach_modname" value="MediaAttach" />
            <input type="hidden" name="MediaAttach_redirect" value="{$redirect}" />
            <input type="hidden" name="MediaAttach_objectid" value="99999999" />
            <fieldset>
                <legend>{gt text="Embed external video"}</legend>
                <div class="z-formrow">
                    <label>{gt text="Supported providers"}</label>
                    <div>
                        <a id="supportedproviders_switch" href="javascript:void(0);" style="display: none">
                            <span id="showproviders">{gt text="show"}</span>
                            <span id="hideproviders" style="display: none">{gt text="hide"}</span>
                        </a>
                    </div>
                </div>
                <p class="z-formnote" id="supportedproviders">{foreach name="proloop" item="provider" from=$supportedProviders}{$provider.name|pnvarprepfordisplay}{if !$smarty.foreach.proloop.last}, {/if}{/foreach}</p>

                <div class="z-formrow">
                    <label id="lblurl" for="MediaAttach_videourl">{gt text="Video Page URL"}</label>
                    <input id="MediaAttach_videourl" name="MediaAttach_videourl" type="text" size="40" />
                </div>

                <div class="z-formrow">
                    <label for="maextvidcats_Main_">{gt text="Categories"}</label>
                    {nocache}
                    {foreach from=$categories key=property item=category}
                    <div class="z-formnote">{selector_category category=$category name="maextvidcats[$property]" field="id" selectedValue=0 defaultValue="0" defaultText=$lblDef editLink=false}</div>
                    {/foreach}
                    {/nocache}
                </div>

                <div class="z-formbuttons">
                    <input type="submit" value="{gt text="Submit"}" />
                </div>
            </fieldset>
        </div>
    </form>
    {/if}

    {include file="MediaAttach_navform.tpll" hiddenType="admin" hiddenFunc="view" categorization=false sorting=true perpage=true displayswitch=true}

    {if $preview}
    {if $onlyimages}
    {include file="MediaAttach_user_inlinelist_Pages.tpl"}
    {else}
    {include file="MediaAttach_admin_upload_inline.tpl"}
    {/if}
    {else}
    {include file="MediaAttach_admin_upload_filelist.tpl"}
    {/if}

    {pager show="page" rowcount=$pager.numitems limit=$pager.itemsperpage posvar=startnum shift=1}

    <script type="text/javascript">
        /* <![CDATA[ */
        maInitUploadFormView();

        {if $usequota eq 0 || $usequota eq 1 && $usedquota < $allowedquota}
        var allowedExtensions = new Array({foreach name="formatloop" item="currentformat" from=$definition.formats}".{$currentformat.extension}"{if $smarty.foreach.formatloop.last ne true}, {/if}{/foreach});
        var errorAllowedFilenum = "{gt text="You are not allowed to upload more than %s files at once." tag1=$definition.numfiles}";
        var errorAlreadySelected = "{gt text="This file has already been selected."}";
        var errorExtensionNotAllowed = "{gt text="The filetype of this file is not allowed."}";
        maInitUploadFormFunction();

        var errorNoFilesSelected = "{gt text="No file has been chosen yet."}";
        var errorAlreadyRunning = "{gt text="There is already a file being uploaded."}";
        $('myuploadform').observe('submit', maSubmitUploadForm);
        $('myuploadframe').observe('load', maResponseUpload);
        {/if}

        {if $activateExternalVideos}
        maInitExtVideoFormView();
        {/if}
        /* ]]> */
    </script>
    {else}
    <p>{gt text="To use admin files a definition must be created for MediaAttach. Therefore click in the menu on \"definitions\"."}</p>
    {/if}

</div>
{include file="MediaAttach_admin_footer.tpl"}