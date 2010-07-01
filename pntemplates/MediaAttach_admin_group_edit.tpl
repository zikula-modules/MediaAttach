{* $Id: MediaAttach_admin_group_edit.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Group editing *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="edit.gif" set="icons/large" __alt="Edit this group"}</div>
    <h2>{gt text="Edit this group"}</h2>
    <form class="z-form" id="editgroupform" action="{zmodurl modname="MediaAttach" type="admin" func="updategroup"}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="authid" value="{$authid}" />
            <input type="hidden" name="gid" value="{$group.gid}" />
            <fieldset>
                <legend>{gt text="Edit this group"}</legend>
                <div class="z-formrow">
                    <label for="MediaAttach_groupname">{gt text="Name"}</label>
                    <input type="text" class="required validate-alphanum" id="MediaAttach_groupname" name="groupname" maxlength="100" value="{$group.groupname}" />
                    <p id="advice-required-MediaAttach_groupname" class="z-formnote custom-advice" style="display: none">{gt text="Please enter a name for the new group."}</p>
                    <p id="advice-validate-alphanum-MediaAttach_groupname" class="z-formnote custom-advice" style="display: none">{gt text="The group name may only contain letters and numbers."}</p>
                </div>
                <div class="z-formrow">
                    <label for="MediaAttach_directory">{gt text="Directory"}</label>
                    <input type="text" class="required validate-alphanum" id="MediaAttach_directory" name="directory" maxlength="255" value="{$group.directory}" />
                    <p id="advice-required-MediaAttach_directory" class="z-formnote custom-advice" style="display: none">{gt text="Please enter a directory for the new group"}</p>
                    <p id="advice-validate-alphanum-MediaAttach_directory" class="z-formnote custom-advice" style="display: none">{gt text="The directory may only contain letters and numbers."}</p>
                </div>
                <div class="z-formrow">
                    <label for="MediaAttach_image">{gt text="Image"}</label>
                    <div>{maimageselect selected=$group.image type="groups"}</div>
                </div>
                <div class="z-formrow">
                    <label for="MediaAttach_formats_select">{gt text="File formats"}</label>
                    <select id="MediaAttach_formats_select" name="formats[]" size="10" multiple="multiple">
                        {foreach item="currentformat" from=$allformats}
                        <option value="{$currentformat.fid}"
                            {foreach item=myformat from=$formats}
                            {if $myformat.fid eq $currentformat.fid} selected="selected"{/if}
                            {/foreach}
                            >{$currentformat.extension}
                        </option>
                        {/foreach}
                    </select>
                </div>
                <div class="z-formbuttons">
                    {zbutton src="button_ok.gif" set="icons/small" __alt="Update this group" __title="Update this group"}
                    <a href="{zmodurl modname="MediaAttach" type="admin" func="viewgroups"}">{zimg modname=core src="button_cancel.gif" set="icons/small" __alt="Cancel" __title="Cancel"}</a>
                </div>
            </fieldset>
        </div>
    </form>

    <script type="text/javascript">
        /* <![CDATA[ */
        var valid = new Validation('editgroupform');
        //var result = valid.validate(); //true or false
        /* ]]> */
    </script>

</div>
{include file="MediaAttach_admin_footer.tpl"}