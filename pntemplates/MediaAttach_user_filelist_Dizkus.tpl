{* $Id: MediaAttach_user_filelist_pnForum.tpl 155 2006-09-11 20:11:19Z weckamc $ *}
{* Purpose of this template: The filelist for Dizkus *}

{* let IE execute a js directly after rendering the DOM - this fixes that the user has to click for activating activeX for flash *}
{browserhack condition="if IE"}<script type="text/javascript" src="fix_eolas.js" defer="defer"></script>{/browserhack}

{if $definition.displayfiles ne 0}
{zuserloggedin assign="isLoggedIn"}
{capture assign="numFiles"}{$files|@count}{/capture}
{if $isLoggedIn || $numFiles > 0}
    <a name="files"></a>
    <strong>{gt text="File attachments"}</strong>
    <div id="myfilelist" style="margin: 1em 0;">
        {zusergetvar name="uid" assign="currentuser"}
        {foreach item="file" from=$files}
            {include file="MediaAttach_user_filelist_single_Dizkus.tpl"}
        {/foreach}
    </div>
{/if}
{/if}
