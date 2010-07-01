{* $Id: MediaAttach_block_newestfiles.tpl 155 2006-09-11 20:11:19Z weckamc $ *}
{* Purpose of this template: Block display *}

<ul style="text-align: left; list-style: none; margin-left: -30px;">
    {foreach item="file" from=$files}
    <li>
        {zimg src="formats/`$file.format`" alt=$file.extension style="padding-right: 5px"}
        {if $file.url neq ''}
        <a href="{$file.url|pnvarprephtmldisplay|pnvarcensor}">
            {$file.title|pnmodcallhooks|pnvarprephtmldisplay|pnvarcensor}
        </a>
        {else}
        {$file.title|pnmodcallhooks|pnvarprephtmldisplay|pnvarcensor}
        {/if}
        {if $file.extension ne "extvid"}
        ({mafilesize size=$file.filesize}
        {/if}
    </li>
    {/foreach}
</ul>