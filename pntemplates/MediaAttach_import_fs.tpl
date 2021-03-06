{* $Id: MediaAttach_import_fs.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Import from server filesystem *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="edit.gif" set="icons/large" alt=$templatetitle}</div>

    <h2>{gt text="Import files from a server directory"}</h2>

    <p class="z-informationmsg">{gt text="Simply go to the desired directory, select the files to import and start. The upload filesize limit is not being used here."} {gt text="The upload filesize limits are not being used here."}</p>

    <form class="z-form" action="{zmodurl modname="MediaAttach" type="admin" func="importfsprocess"}" method="post" enctype="application/x-www-form-urlencoded" id="MediaAttach_config_form">
        <div>
            <input type="hidden" name="authid" value="{$authid}" />
            <fieldset>
                <legend>{$currentdir}</legend>
                {foreach item="curDir" from=$dirs}
                {if $curDir ne "."}
                <div class="z-formnote">
                    {zimg src="folder.gif" __alt="Folder" style="margin-right: 5px"}
                    <a href="{zmodurl modname="MediaAttach" type="admin" func="importfsform" curd="`$currentdir`/`$curDir`"}">{$curDir}</a>
                </div>
                {/if}
                {/foreach}

                <div class="z-formnote">
                    <input type="checkbox" name="markall" id="markall" onclick="maToggleImportFiles(this);" />
                    <label for="markall" style="text-align: left">{gt text="Select all"}</label>
                </div>

                {assign var="filenr" value="-1"}
                {gt text="Choose Category" assign="lblDef"}
                {foreach name="fileloop" item="curFile" from=$files}
                {assign var="filenr" value=$filenr+1}
                <div class="z-formnote">
                    <input type="checkbox" id="file{$filenr}" name="file{$filenr}" value="1"  />
                    <label for="file{$filenr}" style="text-align: left; margin-left: 2em">{$curFile.filename|pnvarprepfordisplay} ({mafilesize size=$curFile.filesize})</label>
                </div>

                <div id="filedesc{$filenr}">
                    <div class="z-formrow">
                        <label for="title{$filenr}">{gt text="Title"}</label>
                        <input id="title{$filenr}" name="title{$filenr}" type="text" maxlength="32" value="{$curFile.filename|pnvarprepfordisplay}" />
                    </div>
                    <div class="z-formrow">
                        <label for="description{$filenr}">{gt text="Description"}</label>
                        <textarea id="description{$filenr}" name="description{$filenr}" rows="3" cols="30">{$curFile.filename|pnvarprepfordisplay}</textarea>
                    </div>
                    <div class="z-formrow">
                        <label>{gt text="Categories"}</label>
                        {nocache}
                        {foreach from=$categories key=property item=category}
                        <div class="z-formnote">{selector_category category=$category name="mafilecats_`$filenr`[$property]" field="id" selectedValue=0 defaultValue="0" defaultText=$lblDef editLink=false}</div>
                        {/foreach}
                        {/nocache}
                    </div>
                    <hr />
                </div>

                <script type="text/javascript">
                    /* <![CDATA[ */
                    Element.hide('filedesc{$filenr}');

                    function maSwitchFileDesc{$filenr}() {{
                        maSwitchDisplayState('filedesc{$filenr}');
                    }}
                    $('file{$filenr}').observe('click', maSwitchFileDesc{$filenr});
                    $('file{$filenr}').observe('keypress', maSwitchFileDesc{$filenr});
                    /* ]]> */
                </script>

                {foreachelse}
                {gt text="No files were uploaded yet"}
                {/foreach}

                <input type="hidden" name="numfiles" value="{$filenr+1}" />
                <input type="hidden" name="curd" value="{$currentdir}" />
                <div class="z-formbuttons">
                    <input name="submit" type="submit" value="{gt text="Start import"}" />
                </div>
            </fieldset>
        </div>
    </form>
</div>