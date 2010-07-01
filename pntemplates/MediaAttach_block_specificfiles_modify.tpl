{* $Id: MediaAttach_block_specificfiles_modify.tpl 155 2006-09-11 20:11:19Z weckamc $ *}
{* Purpose of this template: Block configuration options *}

<div class="z-adminformrow">
    <label for="MediaAttach_files">{gt text="Files to show"}</label>
    <select id="MediaAttach_files" name="files[]" size="10" multiple="multiple" style="width: 200px">
        {foreach item="currentfile" from=$allfiles}
        <option value="{$currentfile.fileid|pnvarprephtmldisplay}"
            {foreach item=myfile from=$files}
            {if $myfile eq $currentfile.fileid} selected="selected"{/if}
            {/foreach}
        >{$currentfile.title|pnvarprephtmldisplay} ({$currentfile.filename|pnvarprephtmldisplay})</option>
        {/foreach}
    </select>
</div>