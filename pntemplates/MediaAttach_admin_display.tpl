{* $Id$ *}
{* Purpose of this template: Display one particular file within the admin area *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="demo.gif" set="icons/large" alt=$file.title}</div>

    {zpagesetvar name="title" value=$file.title}
    <h2>{$file.title|pnmodcallhooks|pnvarprephtmldisplay}{if $file.extension ne "extvid"} ({mafilesize size=$file.filesize}){/if}</h2>

    <div id="file{$file.fileid}">
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
            {mafilebuttons file=$file info=1 dl=1 mail=1}
        </div>

        <div style="margin: 0 15px">
            {getinlinesnippet file=$file}
        </div>
        {if $file.extension ne "extvid"}
        <div id="fileinfo{$file.fileid}" style="display: none">
            {zmodfunc modname="MediaAttach" type="fileinfo" func="showfileinfo" fileid=$file.fileid}
        </div>
        {/if}
        <p>
            <a href="{$file.url|pnvarprepfordisplay}" title="{gt text="Back"}">
                {zimg src="agt_back.gif" modname="core" set="icons/extrasmall" __alt="Back"  __title="Back" }
                {gt text="Back"}
            </a>
        </p>

        {zmodurl modname="MediaAttach" type="user" func="display" fileid=$file.fileid assign="returnurl"}
        {zmodcallhooks hookobject="item" hookaction="display" hookid=$file.fileid module="MediaAttach" returnurl=$returnurl}
    </div>

    {if $file.extension ne "extvid"}
    <script type="text/javascript">
        /* <![CDATA[ */
        function maSwitchFileInfo{$file.fileid}(event) {{
            maSwitchDisplayState('fileinfo{$file.fileid}');
            Event.stop(event);
        }}
        $('fileinfo{$file.fileid}_switch').observe('click', maSwitchFileInfo{$file.fileid}, false);
        $('fileinfo{$file.fileid}_switch').observe('keypress', maSwitchFileInfo{$file.fileid}, false);
        /* ]]> */
    </script>
    {/if}

</div>
{include file="MediaAttach_admin_footer.tpl"}