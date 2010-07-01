{* $Id: MediaAttach_admin_upload_filelist.tpl 218 2007-08-10 11:41:45Z weckamc $ *}
{* Purpose of this template: Shows the list of admin files *}

{zuserloggedin assign="isLoggedIn"}
{capture assign="numFiles"}{$files|@count}{/capture}
{if $isLoggedIn || $numFiles > 0}
<dl id="myfilelist" style="margin-left: 50px">
    {foreach item="file" from=$files}
    {include file="MediaAttach_admin_upload_filelist_single.tpl"}
    {/foreach}
</dl>
{/if}
