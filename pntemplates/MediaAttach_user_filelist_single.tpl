<!--[* $Id: MediaAttach_user_filelist_single.tpl 220 2007-08-11 15:23:48Z weckamc $ *]-->
<!--[* Purpose of this template: One entry within the file list *]-->

<!--[if ($definition.displayfiles eq 1 && $currentuser eq $file.uid) || $definition.displayfiles eq 2]-->
    <dt id="file<!--[$file.fileid]-->" style="font-weight: 700; width: 500px">
        <!--[pnimg src="formats/`$file.format`" modname="MediaAttach" __alt="Download this file"  style="padding-right: 5px"]-->
        <!--[$file.title]--><!--[if $file.extension ne "extvid"]--> (<!--[mafilesize size=$file.filesize]-->)<!--[/if]-->

        <!--[mafilebuttons file=$file view=1 info=1 dl=1 mail=1]--><span style="margin-left: 15px"><!--[mafilebuttons file=$file edit=1 delete=1]--></span>
    </dt>
    <dd>
        <!--[if $file.desc ne ""]--><!--[$file.desc]--><br /><!--[/if]-->
        <!--[gt text="from"]--> <!--[$file.username|userprofilelink|pnvarprephtmldisplay]-->,
        <!--[gt text="on"]--> <!--[$file.date|dateformat:datetimebrief]--><!--[if $file.extension ne "extvid"]-->, 
        <!--[gt text="%s times downloaded" tag1=$file.dlcount]--><!--[/if]--><br />

<!--[*
<!--[if $file.extension ne "extvid"]-->
         Modem: <!--[madownloadtime size=$file.filesize speed=53.3]-->, 
        ISDN: <!--[madownloadtime size=$file.filesize speed=64]-->, 
        ISDN: <!--[madownloadtime size=$file.filesize speed=128]-->, 
        ADSL: <!--[madownloadtime size=$file.filesize speed=512]-->, 
        ADSL: <!--[madownloadtime size=$file.filesize speed=768]-->, 
        DSL: <!--[madownloadtime size=$file.filesize speed=1024]-->, 
        T1: <!--[madownloadtime size=$file.filesize speed=1500]-->, 
        10Mbit Ethernet: <!--[madownloadtime size=$file.filesize speed=10000]-->, 
        100Mbit Ethernet: <!--[madownloadtime size=$file.filesize speed=100000]-->, 
        Gigabit Ethernet: <!--[madownloadtime size=$file.filesize speed=1000000]-->
<!--[/if]-->
*]-->

        <!--[include file="MediaAttach_file_categories.tpl"]-->

<!--[if $file.extension ne "extvid"]-->
        <div id="fileinfo<!--[$file.fileid]-->" style="display: none">
            <!--[pnmodfunc modname="MediaAttach" type="fileinfo" func="showfileinfo" fileid=$file.fileid]-->
        </div>

        <script type="text/javascript" language="javascript">
        /* <![CDATA[ */
            function maSwitchFileInfo<!--[$file.fileid]-->(event) {
                maSwitchDisplayState('fileinfo<!--[$file.fileid]-->');
                Event.stop(event);
            }
            $('fileinfo<!--[$file.fileid]-->_switch').observe('click', maSwitchFileInfo<!--[$file.fileid]-->);
            $('fileinfo<!--[$file.fileid]-->_switch').observe('keypress', maSwitchFileInfo<!--[$file.fileid]-->);
        /* ]]> */
        </script>
<!--[/if]-->
    </dd>
<!--[/if]-->