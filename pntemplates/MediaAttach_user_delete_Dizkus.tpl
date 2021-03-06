{* $Id: MediaAttach_user_delete_pnForum.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Confirmation for upload deletion in Dizkus *}

<form action="{zmodurl modname="MediaAttach" type="user" func="delete"}" method="post" enctype="application/x-www-form-urlencoded" class="maform">
    <fieldset>
        <legend>{gt text="Delete this file"}</legend>
        <input type="hidden" name="authid" value="{$authid}" />
        <input type="hidden" name="confirmation" value="1" />
        <input type="hidden" name="fileid" value="{$file.fileid}" />
        <input type="hidden" name="backurl" value="{$backurl}" />

        <label class="maleft">{gt text="File"}:</label>
        <a href="{zmodurl modname="MediaAttach" func="display" fileid=$file.fileid}">
            {zimg src="formats/`$file.format`" alt=$file.extension style="padding-right: 5px"}
            {$file.filename}
        </a><br />

        <label class="maleft">{gt text="Module"}:</label>
        <a href="{$file.url|pnvarprepfordisplay}">{zmodgetinfo modname=$file.modname info="displayname"}</a><br />

        <label class="maleft">{gt text="User"}:</label>
        {$file.username|userprofilelink}<br />

        <label class="maleft">{gt text="Date"}:</label>
        {$file.date|dateformat:datetimebrief}<br />

        <label class="maleft">{gt text="Title"}:</label>
        {$file.title}<br />

        <label class="maleft">{gt text="Description"}:</label>
        {$file.desc}<br />

        <label class="maleft">{gt text="Mime type"}:</label>
        {$file.mimetype}<br />

        <label class="maleft">{gt text="Filesize"}:</label>
        {mafilesize size=$file.filesize}<br />

        <input name="submit" type="submit" value="{gt text="Confirm deletion?"}" class="maright" />
        <a href="{$backurl|@base64_decode|pnvarprepfordisplay}" title="{gt text="Cancel item deletion."}">{gt text="Cancel"}</a>
    </fieldset>
</form>