{* $Id: $ *}
{* Purpose of this template: Shows the file categories *}


{assign var="catCount" value=$file.__CATEGORIES__|@count}
{if $catCount > 0 }
    {assign var="linkCats" value="0"}

    {zmodgetvar module="MediaAttach" name="usefrontpage" assign="usefrontpage"}
    {zmodgetvar module="MediaAttach" name="usedcatmodes" assign="usedcatmodes"}

    {if $usefrontpage && ($usedcatmodes & 1)}
        {* user front page is used and Categories are enabled *}
        {assign var="linkCats" value="1"}
    {/if}

    <strong>{gt text="Categories"}:</strong>
    {foreach name="categoryloop" key="prop" item="cat" from=$file.__CATEGORIES__}
        {if $linkCats}<a href="{zmodurl modname="MediaAttach" type="user" func="main" catmode=1 cat_prop=$prop cat_id=$cat.id sortby=$sortby sortdir=$sortdir itemsperpage=$itemsperpage preview=$preview onlyimages=$onlyimages}">{/if}
        {zusergetlang assign="currentlang"}
        {if $cat.display_name && $cat.display_name.$currentlang}{$cat.display_name.$currentlang}
        {else}{$cat.name|pnvarprepfordisplay}
        {/if}
        {if $linkCats}</a>{/if}
        {if !$smarty.foreach.categoryloop.last}, {/if}
    {/foreach}
{/if}
