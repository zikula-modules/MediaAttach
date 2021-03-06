{* $Id: MediaAttach_admin_format_edit.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Format editing *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="edit.gif" set="icons/large" __alt="Edit this filetype" }</div>
    <h2>{gt text="Edit this filetype"}</h2>
    <form class="z-form" id="editformatform" action="{zmodurl modname="MediaAttach" type="admin" func="updateformat"}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="authid" value="{$authid}" />
            <input type="hidden" name="fid" value="{$format.fid}" />
            <input type="hidden" id="MediaAttach_extension" name="extension" value="{$format.extension}" />
            <fieldset>
                <legend>{gt text="Edit this filetype"}</legend>

                <div class="z-formrow">
                    <label>{gt text="File type"}</label>
                    <span>{$format.extension}</span>
                </div>

                <div class="z-formrow">
                    <label for="MediaAttach_image">{gt text="Image"}</label>
                    <div>{maimageselect selected=$format.image type="formats"}</div>
                </div>

                <div class="z-formrow">
                    <label for="MediaAttach_groups_select">{gt text="Groups"}</label>
                    <select id="MediaAttach_groups_select" name="groups[]" size="10" multiple="multiple">
                        {foreach item="currentgroup" from=$allgroups}
                        <option value="{$currentgroup.gid}"
                            {foreach item=mygroup from=$groups}
                            {if $mygroup.gid eq $currentgroup.gid} selected="selected"{/if}
                            {/foreach}
                        >{$currentgroup.groupname}</option>
                        {/foreach}
                    </select>
                </div>
            </fieldset>
            <div class="z-formbuttons">
                {zbutton src="button_ok.gif" set="icons/small" __alt="Update this filetype" __title="Update this filetype"}
                <a href="{zmodurl modname="MediaAttach" type="admin" func="viewformats"}">{zimg modname=core src="button_cancel.gif" set="icons/small" __alt="Cancel" __title="Cancel"}</a>
            </div>
        </div>
    </form>

</div>
{include file="MediaAttach_admin_footer.tpl"}
