{* $Id$ *}
{* Purpose of this template: Display several file information for previewing from other modules *}

<div id="file{$file.fileid}" class="z-formrow">
    <div class="z-label">
        {zimg src="formats/`$file.format`" modname="MediaAttach" style="padding-right: 5px"}
        {$file.title|pnmodcallhooks|pnvarprephtmldisplay}{if $file.extension ne "extvid"} ({mafilesize size=$file.filesize}){/if}

        {if $file.desc ne ""}{$file.desc}<br />{/if}
        {gt text="from"} {$file.username|userprofilelink|pnvarprephtmldisplay}<br />
        {gt text="on"} {$file.date|dateformat:datetimebrief}<br />
        {include file="MediaAttach_file_categories.tpl"}
    </div>

    {if $file.extension ne "zip" && $file.extension ne "tar" && $file.extension ne "rar"}
    <div>
        {getinlinesnippet file=$file externalPreview=1}
    </div>
    {/if}

    {* commented out because this seems to be too heavy for the default Ajax timeout
    {if $file.extension ne "extvid"}
    <div id="fileinfo">
        {zmodfunc modname="MediaAttach" type="fileinfo" func="showfileinfo" fileid=$file.fileid}
    </div>
    {/if}
    *}

</div>
