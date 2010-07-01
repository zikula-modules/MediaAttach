{* $Id: MediaAttach_admin_format_view.tpl 155 2006-09-11 20:11:19Z weckamc $ *}
{* Purpose of this template: Format management *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="windowlist.gif" set="icons/large" __alt="File formats"}</div>

    <h2>{gt text="File formats"}</h2>

    <p>
        <a id="new_format_switch" href="javascript:void(0);" style="display: none">{gt text="Create a new filetype"}</a>
    </p>

    <div id="new_format">
        <form class="z-form" id="newformatform" action="{zmodurl modname="MediaAttach" type="admin" func="createformat"}" method="post" enctype="application/x-www-form-urlencoded">
            <div>
                <input type="hidden" name="authid" value="{$authid}" />
                <fieldset>
                    <legend>{gt text="Add filetype"}</legend>
                    <div class="z-formrow">
                        <label for="MediaAttach_extension">{gt text="File type"}</label>
                        <input type="text" class="required validate-alphanum" id="MediaAttach_extension" name="extension" maxlength="5" />
                        <p id="advice-required-MediaAttach_extension" class="z-formnote custom-advice" style="display: none">{gt text="Please enter an extension for the new filetype."}</p>
                        <p id="advice-validate-alphanum-MediaAttach_extension" class="z-formnote custom-advice" style="display: none">{gt text="The extension may only contain letters and numbers."}</p>
                    </div>
                    <div class="z-formrow">
                        <label for="MediaAttach_image">{gt text="Image"}</label>
                        <div>{maimageselect selected="modules/MediaAttach/pnimages/formats/unknown.gif" type="formats"}</div>
                    </div>
                    <div class="z-formrow">
                        <label for="MediaAttach_groups_select">{gt text="Groups"}</label>
                        <select id="MediaAttach_groups_select" name="groups[]" size="10" multiple="multiple">
                            {foreach item="currentgroup" from=$groups}
                            <option value="{$currentgroup.gid}" selected="selected">{$currentgroup.groupname}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="z-formbuttons">
                        <input name="submit" type="submit" value="{gt text="Add filetype"}" />
                    </div>
                </fieldset>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        maInitFormatView();
    </script>

    <table class="z-datatable" summary="{gt text="File formats"}">
        <colgroup>
            <col id="filetype" />
            <col id="groups" />
            <col id="actions" />
        </colgroup>
        <thead>
            <tr>
                <th id="f" scope="col" abbr="{gt text="File type"}">{gt text="File type"}</th>
                <th id="g" scope="col" abbr="{gt text="Groups"}">{gt text="Groups"}</th>
                <th id="a" scope="col" abbr="{gt text="Actions"}">{gt text="Actions"}</th>
            </tr>
        </thead>
        <tbody>
            {foreach item="fileType" from=$formats}
            <tr class="{cycle values="z-odd,z-even"}">
                <td headers="f">
                    {zimg src="formats/`$fileType.image`" modname="MediaAttach" alt=$fileType.extension style="padding-right: 5px"}
                    {$fileType.extension}
                    {foreach item="currentdanger" from=$danger}
                    {if $fileType.extension eq $currentdanger}
                    <span style="color: red; font-weight: 700">{gt text="Warning: Allowing this filetype can be a potential security risk!"}</span>
                    {/if}
                    {/foreach}
                </td>
                <td headers="g">
                    {foreach item="currentgroup" from=$fileType.groups}
                    {zimg src="folder/`$currentgroup.image`" modname="MediaAttach" __alt="icon" style="padding-right: 5px"}
                    {$currentgroup.groupname}
                    <br />
                    {/foreach}
                </td>
                <td headers="a" style="text-align: center; white-space: nowrap;">
                    <form action="{zmodurl modname="MediaAttach" type="admin" func="editformat}" method="post" style="display: inline">
                        <input type="hidden" name="fid" value="{$fileType.fid}" />
                        {zimg src="edit.gif" modname="core" set="icons/extrasmall" assign="editimg"}
                        <input type="image" name="submit" src="{$editimg.src}" alt="{gt text="Edit"}" />
                    </form>
                    <form action="{zmodurl modname="MediaAttach" type="admin" func="deleteformat"}" method="post" style="display: inline">
                        <input type="hidden" name="fid" value="{$fileType.fid}" />
                        {zimg src="edit_remove.gif" modname="core" set="icons/extrasmall" assign="delimg"}
                        <input type="image" name="submit" src="{$delimg.src}" alt="{gt text="Delete"}" />
                    </form>
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>

</div>
{include file="MediaAttach_admin_footer.tpl"}