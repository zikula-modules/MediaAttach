{* $Id: $ *}
{* Purpose of this template: One entry within the lightbox inlinelist *}

{if ($definition.displayfiles eq 1 && $currentuser eq $file.uid) || $definition.displayfiles eq 2}
{if $file.extension eq "gif" || $file.extension eq "jpg" || $file.extension eq "jpeg" || $file.extension eq "png"}

{zmodfunc modname="MediaAttach" type="user" func="download" thumb=1 thumbnr=$thumbnr fileid=$file.fileid assign="previewfile"}

<div style="float: left; margin-right: 3px">
    <a href="{zmodurl modname="MediaAttach" func="download" fileid=$file.fileid inline=1}" rel="lightbox" title="{$file.filetitle}">
        {mathumb id="maimg`$file.fileid`" src=$previewfile alt=$file.title title=$file.title}
    </a>
    <br />
    {mafilebuttons file=$file view=1 dl=1 edit=1 delete=1}
</div>

{/if}
{/if}
