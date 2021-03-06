{* $Id: MediaAttach_admin_upload_inline_single.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: One entry within the inline list template for the admin files *}

<p id="file{$file.fileid}"><strong>{$file.title}</strong>{if $file.extension ne "extvid"} ({mafilesize size=$file.filesize}){/if}</p>

<div style="float: right; margin-right: 15px">
    {mafilebuttons file=$file edit=1 delete=1}
</div>

<div style="float: right; margin: 0 15px; width: 180px">
    {if $file.desc ne ""}{$file.desc}<br />{/if}
    {gt text="from"} {$file.username|userprofilelink|pnvarprephtmldisplay}<br />
    {gt text="on"} {$file.date|dateformat:datetimebrief}<br />
    {include file="MediaAttach_file_categories.tpl"}
</div>

<div style="float: right; margin: 5px 15px; width: 75px">
    {mafilebuttons file=$file view=1 info=1 dl=1 mail=1}
</div>

<div style="margin: 0 15px">
    {getinlinesnippet file=$file}
</div>

{if $file.extension ne "extvid"}
<div id="fileinfo{$file.fileid}" style="display: none">
    {zmodfunc modname="MediaAttach" type="fileinfo" func="showfileinfo" fileid=$file.fileid}
</div>

<script type="text/javascript">
    /* <![CDATA[ */
    function maSwitchFileInfo{$file.fileid}(event) {{
        maSwitchDisplayState('fileinfo{$file.fileid}');
        Event.stop(event);
    }}
    $('fileinfo{$file.fileid}_switch').observe('click', maSwitchFileInfo{$file.fileid});
    $('fileinfo{$file.fileid}_switch').observe('keypress', maSwitchFileInfo{$file.fileid});
    /* ]]> */
</script>
{/if}
<hr style="clear: both" />