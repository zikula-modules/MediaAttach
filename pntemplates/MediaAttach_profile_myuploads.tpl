{* $Id: MediaAttach_profile_myuploads.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Upload management *}

<h2>{zimg src="folder_documents.gif" modname="core" set="icons/extrasmall" style="margin-right: 5px"}{gt text="My uploads"}</h2>
<div>

    {include file="MediaAttach_navform.tpll" hiddenType="account" hiddenFunc="viewuploads" categorization=false sorting=true perpage=true displayswitch=true}

    {if $filesthere eq 0}
    <p class="centered" style="margin-top: 50px">
        {gt text="No files were uploaded yet"}
    </p>
    {else}
    {if $preview}
    {if $onlyimages}
    {include file="MediaAttach_user_inlinelist_Pages.tpl"}
    {else}
    {include file="MediaAttach_user_inlinelist.tpl"}
    {/if}
    {else}
    {include file="MediaAttach_user_filelist.tpl"}
    {/if}
    {/if}

    <br />
    {pager show="page" rowcount=$pager.numitems limit=$pager.itemsperpage posvar=startnum shift=1}

</div>