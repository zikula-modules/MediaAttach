{* $Id: MediaAttach_block_newestfiles_modify.tpl 155 2006-09-11 20:11:19Z weckamc $ *}
{* Purpose of this template: Block configuration options *}

<div class="z-adminformrow">
    <label for="MediaAttach_numitems">{gt text="Number of files to display"}</label>
    <input id="MediaAttach_numitems" type="text" name="numitems" value="{$numitems|pnvarprephtmldisplay}" size="5" />
</div>
<div class="z-adminformrow">
    <label for="MediaAttach_formats">{gt text="Show only files of these formats (optional)"}</label>
    <select id="MediaAttach_formats" name="formats[]" size="10" multiple="multiple" style="width: 100px">
        {foreach item="currentformat" from=$allformats}
        <option value="{$currentformat.extension|pnvarprephtmldisplay}"
            {foreach item=myformat from=$formats}
            {if $myformat eq $currentformat.extension} selected="selected"{/if}
            {/foreach}
        >{$currentformat.extension|pnvarprephtmldisplay}</option>
        {/foreach}
    </select>
</div>