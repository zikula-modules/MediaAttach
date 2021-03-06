{* $Id: MediaAttach_admin_upload_filelist_single.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: One entry within the list of admin files *}

<dt id="file{$file.fileid}" style="font-weight: 700; width: 500px">
    {zimg src="formats/`$file.format`" modname="MediaAttach" __alt="Download this file" style="padding-right: 5px"}
    {$file.title}{if $file.extension ne "extvid"} ({mafilesize size=$file.filesize}){/if}

    {mafilebuttons file=$file view=1 info=1 dl=1 mail=1}<span style="margin-left: 15px">{mafilebuttons file=$file edit=1 delete=1}</span>
</dt>
<dd>{gt text="from"} {$file.username|userprofilelink|pnvarprephtmldisplay}, {gt text="on"} {$file.date|dateformat:datetimebrief}</dd>
{if $file.extension ne "extvid"}
<dd>{gt text="%s times downloaded" tag1=$file.dlcount}</dd>
{/if}
{if $file.desc ne ""}<dd>{$file.desc}</dd>{/if}
<dd>{include file="MediaAttach_file_categories.tpl"}&nbsp;</dd>
{if $file.extension ne "extvid"}
<dd id="fileinfo{$file.fileid}" style="display: none">
    {zmodfunc modname="MediaAttach" type="fileinfo" func="showfileinfo" fileid=$file.fileid}
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
</dd>
{/if}
