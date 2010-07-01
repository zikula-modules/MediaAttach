{* $Id: MediaAttach_admin_main.tpl 155 2006-09-11 20:11:19Z weckamc $ *}
{* Purpose of this template: Admin main area *}

{include file="MediaAttach_admin_header.tpl"}
<div class="z-admincontainer">
    <h2>{gt text="Welcome to the MediaAttach admin area"}</h2>

    {if $numUploads > 0 && $sizeUploads > "0"}
    <p class="z-informationmsg">{gt text="%s files total" tag1=$numUploads} ({$sizeUploads})</p>
    {else}
    <p class="z-informationmsg">{gt text="No files were uploaded yet"}</p>
    {/if}

</div>
{include file="MediaAttach_admin_footer.tpl"}