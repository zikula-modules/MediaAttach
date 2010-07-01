{* $Id: MediaAttach_admin_upload_inline.tpl 217 2007-08-09 20:28:42Z weckamc $ *}
{* Purpose of this template: The inline list template for the admin files *}

{zuserloggedin assign="isLoggedIn"}
{capture assign="numFiles"}{$files|@count}{/capture}
{if $isLoggedIn || $numFiles > 0}
<div id="myfilelist">
    {foreach name="fileloop" item="file" from=$files}
    {include file="MediaAttach_admin_upload_inline_single.tpl"}
    {/foreach}
</div>
{/if}
