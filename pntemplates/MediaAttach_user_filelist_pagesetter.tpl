{* $Id: MediaAttach_user_filelist_pagesetter.tpl 155 2006-09-11 20:11:19Z weckamc $ *}
{* Purpose of this template: The file list for a special module (here Pagesetter) *}

{* let IE execute a js directly after rendering the DOM - this fixes that the user has to click for activating activeX for flash *}
{browserhack condition="if IE"}<script type="text/javascript" src="fix_eolas.js" defer="defer"></script>{/browserhack}

{if $definition.displayfiles ne 0}
{zuserloggedin assign="isLoggedIn"}
{capture assign="numFiles"}{$files|@count}{/capture}
{if $isLoggedIn || $numFiles > 0}
    <h3>{gt text="File attachments"}</h3>

    <dl id="myfilelist">
    {zusergetvar name="uid" assign="currentuser"}
    {foreach item="file" from=$files}
        {include file="MediaAttach_user_filelist_single_pagesetter.tpl"}
    {/foreach}
    </dl>
{/if}
{/if}