{* $Id: MediaAttach_user_delete.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Confirmation for upload deletion *}

<form class="z-form" action="{zmodurl modname="MediaAttach" type="user" func="delete"}" method="post" enctype="application/x-www-form-urlencoded">
    <div>
        <input type="hidden" name="authid" value="{$authid}" />
        <input type="hidden" name="confirmation" value="1" />
        <input type="hidden" name="fileid" value="{$file.fileid}" />
        <input type="hidden" name="backurl" value="{$backurl}" />
        <fieldset>
            <legend>{gt text="Delete this file"}</legend>
            <div class="z-formrow">
                <label>{gt text="File"}</label>
                <span>
                    <a href="{zmodurl modname="MediaAttach" func="display" fileid=$file.fileid}">
                        {zimg src="formats/`$file.format`" alt=$file.extension style="padding-right: 5px"}
                        {$file.filename}
                    </a>
                </span>
            </div>
            <div class="z-formrow">
                <label>{gt text="Module"}</label>
                <span><a href="{$file.url|pnvarprepfordisplay}">{zmodgetinfo modname=$file.modname info="displayname"}</a></span>
            </div>
            <div class="z-formrow">
                <label>{gt text="User"}</label>
                <span>{$file.username|userprofilelink}</span>
            </div>
            <div class="z-formrow">
                <label>{gt text="Date"}</label>
                <span>{$file.date|dateformat:datetimebrief}</span>
            </div>
            <div class="z-formrow">
                <label>{gt text="Title"}</label>
                <span>{$file.title}</span>
            </div>
            <div class="z-formrow">
                <label>{gt text="Description"}</label>
                <span>{$file.desc}</span>
            </div>
            <div class="z-formrow">
                <label>{gt text="Mime type"}</label>
                <span>{$file.mimetype}</span>
            </div>
            <div class="z-formrow">
                <label>{gt text="Filesize"}</label>
                <span>{mafilesize size=$file.filesize}</span>
            </div>
        </fieldset>
        <div class="z-formbuttons">
            {zbutton src="button_ok.gif" set="icons/small" __alt="Confirm deletion?" __title="Confirm deletion?"}
            <a href="{$backurl|@base64_decode|pnvarprepfordisplay}" title="{gt text="Cancel item deletion."}">{zimg modname=core src="button_cancel.gif" set="icons/small" __alt="Cancel" __title="Cancel"}</a>
        </div>
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
    </div>
</form>