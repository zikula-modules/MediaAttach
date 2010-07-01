{* $Id: $ *}
{* Purpose of this template: User main area *}

{zajaxheader modname="MediaAttach" filename=MediaAttach.js}

{assign var="showcatlist" value="0"}
{if $catmode > 0 && $cat_id == 0}
    {assign var="showcatlist" value="1"}
{/if}

<h2>{zimg src="attach.gif" modname="core" set="icons/small" style="margin-right: 5px"}{zmodgetinfo modname="MediaAttach" info="displayname"} v{zmodgetinfo modname="MediaAttach" info="version"}
{if $showcatlist == 1}
    {if $catmode eq 1} . {gt text="MediaAttach categories (Categories module)"}
    {elseif $catmode eq 2} . {gt text="Modules"}
    {elseif $catmode eq 4} . {gt text="Users"}
    {/if}
{/if}
</h2>

{include file="MediaAttach_navform.tpll" hiddenType="user" hiddenFunc="main" categorization=true sorting=true perpage=true displayswitch=true}

{insert name="getstatusmsg"}
<br />

{if $showcatlist == 1}
    {zusergetlang assign="currentlang"}
    {foreach name="categoryloop" item="cat" from=$categories}
        {*if $cat.filecount > 0*}
            {if $cat.display_name && $cat.display_name.$currentlang}{assign var="catname" value=$cat.display_name.$currentlang}
            {else}{assign var="catname" value=$cat.name}
            {/if}

            {assign var="numLevel" value=$cat.ipath_relative|regex_replace:"/[0-9]/":""|strlen}
            {assign var="indentpx" value=$numLevel*35}
            <div{if $indentpx > 0} style="margin-left: {$indentpx}px"{/if}>
            <h3>{$catname|pnvarprepfordisplay} ({$cat.filecount|default:0})</h3>
            <p><a href="{zmodurl modname="MediaAttach" type="user" func="main" catmode=$catmode cat_prop=$cat.catprop cat_id=$cat.id sortby=$sortby sortdir=$sortdir itemsperpage=$itemsperpage preview=$preview onlyimages=$onlyimages}">{gt text="View"} {$catname|pnvarprepfordisplay}</a></p>
            {if !$smarty.foreach.categoryloop.last}<hr />{/if}<br />
            </div>
        {*/if*}
    {/foreach}
{else}
    {* file list *}
    {if $pagetitle}<h2 class="ma_pagetitle">{$pagetitle}</h2>{/if}
    {if $files eq 0}
        <p class="centered" style="margin-top: 50px">
            {gt text="No files were uploaded yet"}
        </p>
    {else}
		{if $matemplate}
            {include file=$matemplate}
        {elseif $preview}
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
    {pager display="startnum" rowcount=$pager.numitems limit=$pager.itemsperpage posvar=startnum}
{/if}

{if $pagetitle}
    <p><a href="{zmodurl modname="MediaAttach" type="user" func="main" catmode=$catmode cat_id="0" sortby=$sortby sortdir=$sortdir itemsperpage=$itemsperpage preview=$preview onlyimages=$onlyimages}">{gt text="Back"}</a></p>
{/if}
