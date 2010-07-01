{* $Id: MediaAttach_admin_format_delete.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Confirmation for format deletion *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="editdelete.gif" set="icons/large" __alt="Delete this filetype"}</div>
    <h2>{gt text="Delete this filetype?"}</h2>
    <form class="z-form" action="{zmodurl modname="MediaAttach" type="admin" func="deleteformat"}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="authid" value="{$authid}" />
            <input type="hidden" name="confirmation" value="1" />
            <input type="hidden" name="fid" value="{$format.fid}" />
            <fieldset>
                <legend>{gt text="Confirmation prompt"}</legend>
                <div class="z-formrow">
                    <label>{gt text="Extension"}</label>
                    <span>{$format.extension}</span>
                </div>
                <div class="z-formnote">
                    {zimg src="formats/`$format.image`" alt=$format.extension style="padding-right: 5px"}
                </div>
                <div class="z-formbuttons">
                    {zbutton src="button_ok.gif" set="icons/small" __alt="Confirm deletion?" __title="Confirm deletion?"}
                    <a href="{zmodurl modname="MediaAttach" type="admin" func="viewformats"}">{zimg modname=core src="button_cancel.gif" set="icons/small" __alt="Cancel" __title="Cancel"}</a>
                </div>
            </fieldset>
        </div>
    </form>
</div>
{include file="MediaAttach_admin_footer.tpl"}