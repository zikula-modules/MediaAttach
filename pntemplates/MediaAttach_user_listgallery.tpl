{* $Id: $ *}
{* Purpose of this template: lightbox template *}

{if $definition.displayfiles ne 0}
{zuserloggedin assign="isLoggedIn"}
{capture assign="numFiles"}{$files|@count}{/capture}
{if $isLoggedIn || $numFiles > 0}
    {zpageaddvar name="javascript" value="modules/MediaAttach/pnjavascript/MediaAttach.js"}
    {zpageaddvar name="javascript" value="javascript/ajax/scriptaculous.js"}
    {zpageaddvar name="javascript" value="javascript/ajax/lightbox.js"}
    {zpageaddvar name="stylesheet" value="javascript/ajax/lightbox/lightbox.css"}

    {zusergetvar name="uid" assign="currentuser"}
    <div id="myfilelist">
        {foreach name="fileloop" item="file" from=$files}
            {include file="MediaAttach_user_listgallery_single.tpl"}
        {foreachelse}
            <p>{gt text="No images available yet"}</p>
        {/foreach}
    </div>
    <br style="clear: left" />
    <br />
{/if}
{/if}