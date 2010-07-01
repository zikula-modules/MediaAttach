{* $Id: $ *}
{* Purpose of this template: SWFUpload template *}

{if $definition.displayfiles ne 0}
{zuserloggedin assign="isLoggedIn"}
{capture assign="numFiles"}{$files|@count}{/capture}
{if $isLoggedIn || $numFiles > 0}
    {zpageaddvar name="javascript" value="modules/MediaAttach/pnjavascript/MediaAttach.js"}

    <h3>{gt text="File attachments"}</h3>

    {zusergetvar name="uid" assign="currentuser"}
    <div id="myfilelist">
        {foreach name="fileloop" item="file" from=$files}
            {include file="MediaAttach_user_inlinelist_single_Pages2.tpl"}
        {/foreach}
    </div>
{/if}
{/if}