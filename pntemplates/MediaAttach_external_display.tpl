{* $Id$ *}
{* Purpose of this template: Display one particular file within an external context *}

{if $floatmode eq "left"}{assign var="flowstyle" value=" itemleft"}
{elseif $floatmode eq "right"}{assign var="flowstyle" value=" itemright"}
{else}{assign var="flowstyle" value=""}
{/if}

<div id="file{$file.fileid}" class="maextfile{$flowstyle}">
    {if $displaymode eq "link"}
    <p class="maextlink">
        <a href="{zmodurl modname="MediaAttach" type="user" func="display" fileid=$file.fileid}" title="{$file.title|pnvarprepfordisplay}">
            {zimg src="demo.gif" modname="core" set="icons/extrasmall" alt=$file.title style="padding-right: 5px"}
            {$file.title|pnmodcallhooks|pnvarprephtmldisplay}{if $file.extension ne "extvid"} ({mafilesize size=$file.filesize}){/if}
        </a>
        {mafilebuttons file=$file edit=1 delete=1}
    </p>
    {else}
    <p class="maexttitle">
        <strong>{$file.title|pnmodcallhooks|pnvarprephtmldisplay}{if $file.extension ne "extvid"} ({mafilesize size=$file.filesize}){/if}</strong>
        {mafilebuttons file=$file dl=1 edit=1 delete=1 thumbnr=$thumbnr}
    </p>

    <div class="maextsnippet">
        {getinlinesnippet file=$file thumbnr=$thumbnr}
    </div>

    <p class="maextdesc">
        {if $file.desc ne ""}{$file.desc}<br />{/if}
        {gt text="from"} {$file.username|userprofilelink|pnvarprephtmldisplay}<br />
        {gt text="on"} {$file.date|dateformat:datetimebrief}<br />
        {include file="MediaAttach_file_categories.tpl"}
    </p>
    {/if}
</div>
