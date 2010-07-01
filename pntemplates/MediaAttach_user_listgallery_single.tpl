{* $Id: $ *}
{* Purpose of this template: One entry within the lightbox inlinelist *}

{if ($definition.displayfiles eq 1 && $currentuser eq $file.uid) || $definition.displayfiles eq 2}
{if $file.extension eq "gif" || $file.extension eq "jpg" || $file.extension eq "jpeg" || $file.extension eq "png"}

{zmodfunc modname="MediaAttach" type="user" func="download" thumb=1 thumbnr=$thumbnr fileid=$file.fileid assign="previewfile"}

<div style="float: left; width: 25%; height: 150px">
    <a href="{zmodurl modname="MediaAttach" func="download" fileid=$file.fileid inline=1}" class="highslide" onclick="return hs.expand(this, 
        {{wrapperClassName : 'highslide-white', spaceForCaption: 30, captionId: 'description{$file.fileid}', outlineType: 'rounded-white'}})">
        {mathumb id="maimg`$file.fileid`" src=$previewfile alt=$file.title title=$file.title}
    </a>
    <br />
    {mafilebuttons file=$file view=0 dl=1 edit=1 delete=1}
</div>

<div id="controlbar{$file.fileid}" class="highslide-overlay controlbar">
    <a href="#" class="previous" onclick="return hs.previous(this)" title="Zur&uuml;ck (linke Pfeiltaste)"></a>
    <a href="#" class="next" onclick="return hs.next(this)" title="Weiter (rechte Pfeiltaste)"></a>
    <a href="#" class="highslide-move" onclick="return false" title="Klicken und ziehen um das Bild zu bewegen"></a>
    <a href="#" class="close" onclick="return hs.close(this)" title="Schlie&szlig;en"></a>
</div>

<div class="highslide-caption" id="description{$file.fileid}">
    <p id="file{$file.fileid}"><strong>{$file.title}</strong>{if $file.extension ne "extvid"} ({mafilesize size=$file.filesize}){/if}</p>
    {if $file.desc ne ""}{$file.desc}<br />{/if}
    {gt text="from"} {$file.username|pnvarprephtmldisplay}, {gt text="on"} {$file.date|dateformat:datetimebrief}<br />
    {include file="MediaAttach_file_categories.tpl"}
</div>

<script type="text/javascript">
/* <![CDATA[ */
    hs.registerOverlay(
        {{
            thumbnailId: 'maimg{$file.fileid}',
            overlayId: 'controlbar{$file.fileid}',
            position: 'top right',
            hideOnMouseOut: true
        }}
    );
/* ]]> */
</script>
{/if}
{/if}
