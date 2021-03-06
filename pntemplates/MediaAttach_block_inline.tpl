{* $Id: MediaAttach_block_inline.tpl 194 2007-06-03 18:38:08Z weckamc $ *}
{* Purpose of this template: Block display *}

{pnpageaddvar name="stylesheet" value="modules/MediaAttach/pnstyle/style.css"}
{zajaxheader modname="MediaAttach" filename="MediaAttach.js"}

<ul style="text-align: left; list-style: none; margin-left: -30px;">
    {foreach item="file" from=$files}
    <li style="margin: 10px 0">
        {if $file.url neq ''}
        <a id="filedisplay{$file.fileid}_switch" href="javascript:void(0);">
            {$file.title|pnmodcallhooks|pnvarprephtmldisplay|pnvarcensor}
        </a>

        <div id="filedisplay{$file.fileid}" style="margin: 15px auto">
            {getinlinesnippet file=$file blockcall=true}
            <br />
            <br />
            <a href="{zmodurl modname="MediaAttach" func="display" fileid=$file.fileid}" title="{gt text="View this file"}">
                {zimg src="demo.gif" modname="core" set="icons/extrasmall" __alt="View this file"  style="padding-left: 5px"}
            </a>
            {if $file.extension ne "extvid"}
            ({mafilesize size=$file.filesize})
            {/if}
        </div>

        <script type="text/javascript">
            /* <![CDATA[ */
            $('filedisplay{$file.fileid}').hide();
            $('filedisplay{$file.fileid}_switch').show();

            function maSwitchFileDisplay{$file.fileid}(event) {{
                maSwitchDisplayState('filedisplay{$file.fileid}');
                Event.stop(event);
            }}
            $('filedisplay{$file.fileid}_switch').observe('click', maSwitchFileDisplay{$file.fileid});
            $('filedisplay{$file.fileid}_switch').observe('keypress', maSwitchFileDisplay{$file.fileid});
            /* ]]> */
        </script>
        {else}
        {$file.title|pnmodcallhooks|pnvarprephtmldisplay|pnvarcensor}
        {if $file.extension ne "extvid"}
        ({mafilesize size=$file.filesize})
        {/if}
        {/if}
    </li>
    {/foreach}
</ul>