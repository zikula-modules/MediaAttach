{* $Id: MediaAttach_admin_group_delete.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Confirmation for group deletion *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="editdelete.gif" set="icons/large" __alt="Delete this group"}</div>
    <h2>{gt text="Delete this group?"}</h2>
    <form class="z-form" action="{zmodurl modname="MediaAttach" type="admin" func="deletegroup"}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="authid" value="{$authid}" />
            <input type="hidden" name="confirmation" value="1" />
            <input type="hidden" name="gid" value="{$group.gid}" />
            <fieldset>
                <legend>{gt text="Confirmation prompt"}</legend>
                <div class="z-formrow">
                    <label>{gt text="Name"}</label>
                    <span>{$group.groupname}</span>
                </div>

                <div class="z-formnote">
                    {zimg src="folder/`$group.image`" alt=$group.groupname style="padding-right: 5px"}
                </div>
            </fieldset>
            <div class="z-formbuttons">
                {zbutton src="button_ok.gif" set="icons/small" __alt="Confirm deletion?" __title="Confirm deletion?"}
                <a href="{zmodurl modname="MediaAttach" type="admin" func="viewgroups"}">{zimg modname=core src="button_cancel.gif" set="icons/small" __alt="Cancel" __title="Cancel"}</a>
            </div>
        </div>
    </form>
</div>
{include file="MediaAttach_admin_footer.tpl"}