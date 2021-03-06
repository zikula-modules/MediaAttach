{* $Id: MediaAttach_external_finditem.tpll 156 2008-07-18 23:30:32Z mateo $ *}
{* Purpose of this template: popup selector for scribite integration *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{lang}" lang="{lang}">
    <head>
        <title>{gt text="Files and media" domain="module_mediaattach"}</title>
        <link type="text/css" rel="stylesheet" href="{zgetbaseurl}javascript/style.css" />
        <link type="text/css" rel="stylesheet" href="{zgetbaseurl}modules/MediaAttach/pnstyle/style.css" />
        <link type="text/css" rel="stylesheet" href="{zgetbaseurl}modules/MediaAttach/pnstyle/finditem.css" />
        {zconfiggetvar name="entrypoint" assign="ourEntry"}
        <script type="text/javascript">/* <![CDATA[ */ document.location.entrypoint="{$ourEntry|default:"index.php"}"; document.location.pnbaseURL="{zgetbaseurl}"; /* ]]> */</script>
        <script type="text/javascript" src="{zgetbaseurl}javascript/ajax/prototype.js"></script>
        <script type="text/javascript" src="{zgetbaseurl}javascript/ajax/scriptaculous.js"></script>
        <script type="text/javascript" src="{zgetbaseurl}javascript/ajax/dragdrop.js"></script>
        <script type="text/javascript" src="{zgetbaseurl}javascript/ajax/effects.js"></script>
        <script type="text/javascript" src="{zgetbaseurl}javascript/ajax/pnajax.js"></script>
        <script type="text/javascript" src="{zgetbaseurl}modules/MediaAttach/pnjavascript/finditem.js"></script>
        <script type="text/javascript" src="{zgetbaseurl}modules/MediaAttach/pnjavascript/MediaAttach.js"></script>
    </head>

    <body>

        {if $modules eq 0}
        <p class="centered">
            {gt text="MediaAttach could not find a module, for which it has been activated. Please go to the module settings and activate MediaAttach for one or more modules of your choice." domain="module_mediaattach"}
        </p>
        {else}

        <form action="{$ourEntry|default:"index.php"}" id="selectorForm" method="get" class="z-form">
            <div>
                <input type="hidden" name="module" value="{zmodgetinfo module="MediaAttach" info="displayname"}" />
                <input type="hidden" name="type" value="external" />
                <input type="hidden" name="func" value="finditem" />
                <input type="hidden" id="fromguppy" name="guppy" value="{$fromGuppy}" />

                <fieldset>
                    <legend>{gt text="Files and media" domain="module_mediaattach"}</legend>

                    <div class="z-formrow">
                        <label for="MediaAttach_onlyimages">{gt text="Only images" domain="module_mediaattach"}</label>
                        <div>
                            <input type="checkbox" id="MediaAttach_onlyimages" name="onlyimages" value="1" onclick="mediaAttach.find.onParamChanged()" onkeypress="mediaattach.find.onParamChanged()" {if $onlyimages} checked="checked"{/if}/>
                            {if $onlyimages}
                            <select id="MediaAttach_thumbnr" name="thumbnr" style="width: 100px" onchange="mediaAttach.find.onParamChanged()">
                                {zmodgetvar module="MediaAttach" name="thumbsizes" assign="thumbsizes"}
                                {foreach name="thumbLoop" item="thumbsize" from=$thumbsizes}
                                <option value="{$smarty.foreach.thumbLoop.iteration}"{if $smarty.foreach.thumbLoop.iteration eq $thumbnr} selected="selected"{/if}>{$thumbsize[0]} x {$thumbsize[1]} px&nbsp;</option>
                                {/foreach}
                            </select>
                            {/if}
                        </div>
                    </div>

                    <div class="z-formrow">
                        <label for="MediaAttach_did">{gt text="Module" domain="module_mediaattach"}</label>
                        <select id="MediaAttach_did" name="did" onchange="mediaAttach.find.onParamChanged()">
                            {foreach item="currentdef" from=$definitions}
                            <option value="{$currentdef.did}"{if $currentdef.modname eq "MediaAttach"} selected="selected"{/if}>{zmodgetinfo modname=$currentdef.modname info="displayname"} ({$currentdef.modname})&nbsp;</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="z-formrow">
                        <label for="cat_id">{gt text="Category" domain="module_mediaattach"}</label>
                        {gt text="Choose Category" assign="lblDef" domain="module_mediaattach"}
                        {selector_category category=$mainCategory name="cat_id" field="id" defaultText=$lblDef editLink=false submit=true selectedValue=$catID}
                    </div>

                    {zmodavailable modname="MultiHook" assign="mhavailable"}
                    {if $mhavailable eq 1}
                    <div class="z-formrow">
                        <label for="MediaAttach_output">{gt text="Display mode" domain="module_mediaattach"}</label>
                        <select id="MediaAttach_output" name="output">
                            <option value="link">{gt text="Link to the file" domain="module_mediaattach"}</option>
                            <option value="inline">{gt text="Embed the item inline" domain="module_mediaattach"}</option>
                            <option value="physical">{gt text="Embed the item physically" domain="module_mediaattach"}</option>
                        </select>
                    </div>
                    {else}
                    <input type="hidden" id="MediaAttach_output" name="output" value="link" />
                    {/if}

                    {if $onlyimages eq 1}
                    <div class="z-formrow">
                        <label for="MediaAttach_pasteas">{gt text="Paste as" domain="module_mediaattach"}</label>
                        <select id="MediaAttach_pasteas" name="pasteas">
                            <option value="1"{if $fromGuppy ne 1} selected="selected"{/if}>{gt text="Thumbnail with link to view original image" domain="module_mediaattach"}</option>
                            <option value="2">{gt text="Thumbnail with link to download original image" domain="module_mediaattach"}</option>
                            <option value="3">{gt text="Thumbnail" domain="module_mediaattach"}</option>
                            <option value="4">{gt text="Original image" domain="module_mediaattach"}</option>
                            <option value="5">{gt text="Link to thumbnail" domain="module_mediaattach"}</option>
                            <option value="6">{gt text="Link to original image" domain="module_mediaattach"}</option>
                            <option value="7"{if $fromGuppy eq 1} selected="selected"{/if}>{gt text="File ID" domain="module_mediaattach"}</option>
                            <option value="8">{gt text="Original image with link to itself" domain="module_mediaattach"}</option>
                        </select>
                    </div>

                    {elseif $fromGuppy eq 1}
                    <div class="z-formrow">
                        <label for="MediaAttach_pasteas">{gt text="Paste as" domain="module_mediaattach"}</label>
                        <select id="MediaAttach_pasteas" name="pasteas">
                            <option value="6">{gt text="Link to original image" domain="module_mediaattach"}</option>
                            <option value="7" selected="selected">{gt text="File ID" domain="module_mediaattach"}</option>
                        </select>
                    </div>
                    {/if}

                    <div class="z-formrow">
                        <label for="filecontainer">{gt text="File" domain="module_mediaattach"}</label>
                        {if $onlyimages eq 1}
                        {zmodgetvar module="MediaAttach" name="thumbsizes" assign="thumbsizes"}
                        {assign var="thumbIndex" value=$thumbnr-1}
                        {assign var="thumbwidth" value=$thumbsizes[$thumbIndex][0]}
                        {assign var="thumbheight" value=$thumbsizes[$thumbIndex][1]}
                        {/if}

                        <div id="filecontainer">
                            {if $onlyimages ne 1}
                            <ul>
                                {else}
                                {/if}
                                {foreach item="file" from=$files}
                                {if $onlyimages ne 1}
                                <li>
                                    {else}
                                    {/if}
                                    <a href="#" onclick="mediaAttach.find.selectItem({$file.fileid})" onkeypress="mediaAttach.find.selectItem({$file.fileid})">
                                        {if $onlyimages ne 1}
                                        {zimg src="formats/`$file.format`" modname="MediaAttach" alt=$file.extension style="padding-right: 5px"}
                                        {$file.title} ({$file.extension}{if $file.extension ne "extvid"}, {mafilesize size=$file.filesize}{/if})
                                        {else}
                                        {zmodfunc modname="MediaAttach" type="user" func="download" thumb=1 thumbnr=$thumbnr fileid=$file.fileid assign="previewfile"}
                                        <img id="maimg{$file.fileid}" src="{$previewfile}" width="{$thumbwidth}" height="{$thumbheight}" title="{$file.title}" __alt="" class="previmg" />
                                        {/if}
                                    </a>
                                    {if $onlyimages eq 1}
                                    <input type="hidden" id="imgpreview{$file.fileid}" value="{$previewfile|pnvarprepfordisplay}" />
                                    {/if}
                                    <input type="hidden" id="imgtitle{$file.fileid}" value="{$file.title|pnvarprepfordisplay}" />
                                    <input type="hidden" id="imgdesc{$file.fileid}" value="{$file.desc|pnvarprephtmldisplay|strip_tags}" />
                                    {if $onlyimages ne 1}
                                </li>
                                {else}
                                {/if}
                                {foreachelse}
                                {if $onlyimages ne 1}
                                <li>
                                    {else}
                                    {/if}
                                    {gt text="no uploads found" domain="module_mediaattach"}
                                    {if $onlyimages ne 1}
                                </li>
                                {else}
                                {/if}
                                {/foreach}
                                {if $onlyimages ne 1}
                            </ul>
                            {else}
                            {/if}
                        </div>
                        {pager show="page" rowcount=$pager.numitems limit=$pager.itemsperpage posvar=startnum template="pagercss.tpll" maxpages="10"}
                    </div>

                    <div class="z-formrow">
                        <label for="MediaAttach_sortby">{gt text="Sort by" domain="module_mediaattach"}</label>
                        <div>
                            <select id="MediaAttach_sortby" name="sortby" onchange="mediaAttach.find.onParamChanged()">
                                <option value="date"{if $sortby eq "date"} selected="selected"{/if}>{gt text="date" domain="module_mediaattach"}</option>
                                <option value="title"{if $sortby eq "title"} selected="selected"{/if}>{gt text="title" domain="module_mediaattach"}</option>
                                <option value="module"{if $sortby eq "module"} selected="selected"{/if}>{gt text="module" domain="module_mediaattach"}</option>
                                <option value="username"{if $sortby eq "username"} selected="selected"{/if}>{gt text="username" domain="module_mediaattach"}</option>
                                <option value="filename"{if $sortby eq "filename"} selected="selected"{/if}>{gt text="filename" domain="module_mediaattach"}</option>
                                <option value="filetype"{if $sortby eq "filetype"} selected="selected"{/if}>{gt text="filetype" domain="module_mediaattach"}</option>
                                <option value="filesize"{if $sortby eq "filesize"} selected="selected"{/if}>{gt text="filesize" domain="module_mediaattach"}</option>
                            </select>
                            <select id="MediaAttach_sortdir" name="sortdir" onchange="mediaAttach.find.onParamChanged()">
                                <option value="asc"{if $sortdir eq "asc"} selected="selected"{/if}>{gt text="ascending" domain="module_mediaattach"}</option>
                                <option value="desc"{if $sortdir eq "desc"} selected="selected"{/if}>{gt text="descending" domain="module_mediaattach"}</option>
                            </select>
                        </div>
                    </div>

                    <div class="z-formrow">
                        <label for="MediaAttach_perpage">{gt text="Entries per page" domain="module_mediaattach"}</label>
                        <select id="MediaAttach_perpage" name="itemsperpage" style="width: 50px; text-align: right" onchange="mediaAttach.find.onParamChanged()">
                            <option value="5"{if $itemsperpage eq 5} selected="selected"{/if}>5</option>
                            <option value="10"{if $itemsperpage eq 10} selected="selected"{/if}>10</option>
                            <option value="15"{if $itemsperpage eq 15} selected="selected"{/if}>15</option>
                            <option value="20"{if $itemsperpage eq 20} selected="selected"{/if}>20</option>
                            <option value="30"{if $itemsperpage eq 30} selected="selected"{/if}>30</option>
                            <option value="50"{if $itemsperpage eq 50} selected="selected"{/if}>50</option>
                            <option value="100"{if $itemsperpage eq 100} selected="selected"{/if}>100</option>
                        </select>
                    </div>

                    <div class="z-formrow">
                        <label for="MediaAttach_filterby">{gt text="Filter by" domain="module_mediaattach"}</label>
                        <div>
                            <input type="text" id="MediaAttach_filterby" name="searchfor" />
                            <input type="button" id="MediaAttach_gosearch" name="gosearch" value="{gt text="Filter" domain="module_mediaattach"}" onclick="mediaAttach.find.onParamChanged()" onkeypress="mediaAttach.find.onParamChanged()" />
                        </div>
                    </div>

                    <div class="z-formbutton">
                        <input type="button" name="cancelButton" value="{gt text="Cancel" domain="module_mediaattach"}" onclick="mediaAttach.find.handleCancel()" />
                    </div>
                </fieldset>
            </div>
        </form>

        <div class="z-form">
            <fieldset>
                {zmodfunc modname="MediaAttach" type="user" func="viewupload"}
            </fieldset>
        </div>

        {/if}

    </body>
</html>