{* $Id: MediaAttach_user_filelist_single_pnForum.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: One entry within the file list for Dizkus *}

{if ($definition.displayfiles eq 1 && $currentuser eq $file.uid) || $definition.displayfiles eq 2}
    <div id="file{$file.fileid}" class="mafilebox z-clearfix">
        <div style="float: right; width: 15%; text-align: right">
            {mafilebuttons file=$file edit=1 delete=1}
        </div>
        <div style="float: left; width: 80%">
            {zimg src="formats/`$file.format`" modname="MediaAttach" __alt="Download this file" style="padding-right: 5px"}
            {$file.title}{if $file.extension ne "extvid"} ({mafilesize size=$file.filesize}){/if}<br />
            {include file="MediaAttach_file_categories.tpl"}

            {mafilebuttons file=$file view=1 info=1 dl=1 mail=1}
            &nbsp;
            ({$file.username|userprofilelink|pnvarprephtmldisplay}, &nbsp;{$file.date|dateformat:datetimebrief})
{if $file.extension ne "extvid"}
           &nbsp;
            {gt text="%s times downloaded" tag1=$file.dlcount}

            <div id="fileinfo{$file.fileid}" style="display: none">
                {zmodfunc modname="MediaAttach" type="fileinfo" func="showfileinfo" fileid=$file.fileid}
            </div>
{/if}
        </div>
    </div>
{if $file.extension ne "extvid"}
    <script type="text/javascript" language="javascript">
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
{/if}