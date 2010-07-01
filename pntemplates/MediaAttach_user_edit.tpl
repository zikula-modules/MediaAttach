{* $Id: MediaAttach_user_edit.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Upload editing *}

<h2>{gt text="Edit this file"}</h2>
<form action="{zmodurl modname="MediaAttach" type="user" func="update"}" method="post" enctype="application/x-www-form-urlencoded" class="maform">
    <fieldset>
        <legend>{gt text="Content"}</legend>

        <input type="hidden" name="authid" value="{$authid}" />
        <input type="hidden" name="fileid" value="{$file.fileid}" />
        <input type="hidden" name="backurl" value="{$backurl}" />

        {zmodurl modname="MediaAttach" func="display" fileid=$file.fileid assign="fileurl"}
        <label class="maleft">{gt text="File"}:</label>
        <a href="{$fileurl|pnvarprepfordisplay}">
            {zimg src="formats/`$file.format`" alt=$file.extension style="padding-right: 5px"}
            {$file.filename}
        </a><br />

        <label class="maleft">{gt text="Module"}:</label>
        <a href="{$file.url|pnvarprepfordisplay}">{zmodgetinfo modname=$file.modname info="displayname"}</a><br />

        <label class="maleft">{gt text="User"}:</label>
        {$file.username|userprofilelink|pnvarprephtmldisplay}<br />

        <label class="maleft">{gt text="Date"}:</label>
        {$file.date|dateformat:datetimebrief}<br />

        <label for="MediaAttach_title" class="maleft">{gt text="Title"}:</label>
        <input id="MediaAttach_title" name="MediaAttach_title" type="text" maxlength="64" value="{$file.title}" /><br />

        <label for="MediaAttach_description" class="maleft">{gt text="Description"}:</label>
        <textarea id="MediaAttach_description" name="MediaAttach_description" rows="5" cols="25">{$file.desc}</textarea><br />

        <label for="mafilecats_Main_">{gt text="Categories"}:</label><br />
        {gt text="Choose Categorie" assign="lblDef"}
        {nocache}
        <ul style="list-style-type: none">
        {foreach from=$categories key=property item=category}
            {array_field_isset array=$file.__CATEGORIES__ field=$property assign="catExists"}
            {if $catExists}
                {array_field_isset array=$file.__CATEGORIES__.$property field="id" returnValue=1 assign="selectedValue"}
            {else}
                {assign var="selectedValue" value="0"}
            {/if}
            <li>{selector_category category=$category name="mafilecats[$property]" field="id" selectedValue=$selectedValue defaultValue="0" defaultText=$lblDef editLink=false}</li>
        {/foreach}
        </ul>
        {/nocache}
        <br />

        <label class="maleft">{gt text="Mime type"}:</label>
        {$file.mimetype}<br />

        <label class="maleft">{gt text="Filesize"}:</label>
        {mafilesize size=$file.filesize}<br />

        {zmodcallhooks hookobject="item" hookaction="modify" module="MediaAttach" hookid=$file.fileid}
        <input name="submit" type="submit" value="{gt text="Update this file"}" class="maright" />
        <a href="{$backurl|@base64_decode|pnvarprepfordisplay}" title="{gt text="Cancel item edits."}">{gt text="Cancel"}</a>
    </fieldset>
    <fieldset>
        <legend>{gt text="Meta data"}</legend>
        <ul>
            {zusergetvar name=uname uid=$file.cr_uid assign=username}
            <li>{gt text="Created by %s" tag1=$username}</li>
            <li>{gt text="Created on %s" tag1=$file.cr_date|dateformat}</li>
            {zusergetvar name=uname uid=$file.lu_uid assign=username}
            <li>{gt text="Last updated by %s" tag1=$username}</li>
            <li>{gt text="Updated on %s" tag1=$file.lu_date|dateformat}</li>
        </ul>
    </fieldset>
</form>
