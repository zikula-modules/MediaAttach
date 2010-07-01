{* $Id: MediaAttach_file_buttons.tpl 155 2006-09-11 20:11:19Z weckamc $ *}
{* Purpose of this template: shows different buttons for a given file *}

{if $view}
    <a href="{zmodurl modname="MediaAttach" type="`$smarty.get.type`" func="display" fileid=$file.fileid}" title="{gt text="View this file"}">
        {zimg src="demo.gif" modname="core" set="icons/extrasmall" __alt="View this file"  style="padding-left: 5px"}
    </a>
{/if}
{if $info}
    <a id="fileinfo{$file.fileid}_switch" href="{zmodurl modname="MediaAttach" type="fileinfo" func="showfileinfo" fileid=$file.fileid}" title="{gt text="Information about this file"}">
        {zimg src="comment.gif" modname="core" set="icons/extrasmall" __alt="Information about this file"  style="padding-left: 5px"}
    </a>
{/if}
{if $dl}
    <a href="{zmodurl modname="MediaAttach" type="user" func="download" fileid=$file.fileid}" title="{gt text="Download this file"}">
        {zimg src="filesave.gif" modname="core" set="icons/extrasmall" __alt="Download this file"  style="padding-left: 5px"}
    </a>
{/if}
{if $mail}
    <a href="{zmodurl modname="MediaAttach" type="user" func="sendfile" fileid=$file.fileid}" title="{gt text="Send this file to your mail address"}">
        {zimg src="mail_generic.gif" modname="core" set="icons/extrasmall" __alt="Send this file to your mail address"  style="padding-left: 5px"}
    </a>
{/if}


{if ($edit && $file.allowedit) || ($delete && $file.allowdelete)}
    {mareturnurl assign="backurl"}
    {strip}
{if $edit && $file.allowedit}
    {if $usethumbcropper eq 1 && ($file.extension eq "gif" || $file.extension eq "jpg" || $file.extension eq "png")}
        <a href="{zmodurl modname="MediaAttach" type="user" func="editthumb" fileid=$file.fileid thumbnr=$thumbnr backurl=$backurl}" title="{gt text="Crop thumbnail"}">
            {zimg src="cropthumb.png" modname="MediaAttach" __alt="Crop thumbnail"  style="padding-left: 5px"}
        </a>
    {/if}
    <a href="{zmodurl modname="MediaAttach" type="user" func="edit" fileid=$file.fileid backurl=$backurl}" title="{gt text="Edit"}">
        {zimg src="edit.gif" modname="core" set="icons/extrasmall" __alt="Edit"  style="padding-left: 5px"}
    </a>
{/if}
{if $delete && $file.allowdelete}
        <a href="{zmodurl modname="MediaAttach" type="user" func="delete" fileid=$file.fileid backurl=$backurl}" title="{gt text="Delete"}">
            {zimg src="edit_remove.gif" modname="core" set="icons/extrasmall" __alt="Delete"  style="padding-left: 5px"}
        </a>
{/if}
    {/strip}
{/if}

