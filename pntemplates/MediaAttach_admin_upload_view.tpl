{* $Id: MediaAttach_admin_upload_view.tpl 218 2007-08-10 11:41:45Z weckamc $ *}
{* Purpose of this template: Upload management *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="lists.gif" set="icons/large" __alt="User uploads" }</div>

    <h2>{gt text="User uploads"}</h2>

    {include file="MediaAttach_navform.tpll" hiddenType="admin" hiddenFunc="viewuploads" categorization=false sorting=true perpage=true displayswitch=true}

    {if $filesthere eq 0}
    <p class="z-center" style="margin-top: 50px">
        {gt text="No files were uploaded yet"}
    </p>
    {else}
    {if $preview}
    {if $onlyimages}
    {include file="MediaAttach_user_inlinelist_Pages.tpl"}
    {else}
    {include file="MediaAttach_admin_upload_inline.tpl"}
    {/if}
    {else}
    {include file="MediaAttach_admin_upload_filelist.tpl"}
    {/if}
    {pager show="page" rowcount=$pager.numitems limit=$pager.itemsperpage posvar=startnum shift=1}
    {/if}

</div>
{include file="MediaAttach_admin_footer.tpl"}