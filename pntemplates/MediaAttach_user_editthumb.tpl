{* $Id: MediaAttach_user_edit.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Upload editing *}

{zajaxheader modname="MediaAttach" filename=MediaAttach.js}
{zpageaddvar name="javascript" value="modules/MediaAttach/pnincludes/cropper/cropper.js"}

{assign var="imgDimension" value=""}
{if $file.fileInfo && $file.fileInfo.video && $file.fileInfo.video.resolution_x && $file.fileInfo.video.resolution_y}
    {assign var="imgDimension" value=" width=\"`$file.fileInfo.video.resolution_x`\" height=\"`$file.fileInfo.video.resolution_y`\""}
{/if}

<form id="cropform" action="{zmodurl modname="MediaAttach" type="user" func="updatethumb"}" method="post" class="maform">
{if $cropsizemode ne 2}
    <fieldset style="float: right; width: 42%">
        <legend>{gt text="Preview"}</legend>

        <div id="previewWrap"></div>
    </fieldset>
{/if}
    <fieldset style="float: left; width: 42%">
        <legend>{gt text="Action"}</legend>

<h2>{gt text="Crop thumbnail"}</h2>
<p>{gt text="Choose your desired preview image."} {if $cropsizemode eq 0}{gt text="The selection window size is not changeable."}{elseif $cropsizemode eq 1}{gt text="The selection window size is changeable, the aspect ratio will be kept."}{else}{gt text="The selection window size and the aspect ratio are changeable."}{/if}</p>

        <input type="hidden" name="authid" value="{$authid}" />
        <input type="hidden" id="fileid" name="fileid" value="{$file.fileid}" />
        <input type="hidden" name="backurl" value="{$backurl}" />
        <input type="hidden" name="thumbnr" value="{$thumbnr}" />

        <input type="hidden" name="x1" id="x1" size="4" />
        <input type="hidden" name="y1" id="y1" size="4" />
        <input type="hidden" name="x2" id="x2" size="4" />
        <input type="hidden" name="y2" id="y2" size="4" />
        <input type="hidden" name="width" id="width" size="4" />
        <input type="hidden" name="height" id="height" size="4" />

        <ul style="list-style-type: none">
            <li><a href="#" id="saveThumb" title="{gt text="Save"}">{zimg src="cropthumb.png" modname="MediaAttach"} {gt text="Save"}</a></li>
            <li><a href="{$backurl|@base64_decode|pnvarprepfordisplay}" title="{gt text="Cancel item edits."}">{zimg src="button_cancel.gif" modname="core" set="icons/extrasmall"} {gt text="Cancel"}</a></li>
        </ul>
    </fieldset>
    <br style="clear: both" />
</form>

<p><img src="{zmodurl modname="MediaAttach" type="user" func="download" fileid=$file.fileid inline=1}" alt="{$file.title|pnvarprepfordisplay}" id="macropimg"{$imgDimension} /></p>

{zmodgetvar module="MediaAttach" name="thumbsizes" assign="thumbsizes"}
{assign var="thumbIndex" value=$thumbnr-1}
{assign var="thumbwidth" value=$thumbsizes[$thumbIndex][0]}
{assign var="thumbheight" value=$thumbsizes[$thumbIndex][1]}

<script type="text/javascript" language="javascript">
/* <![CDATA[ */
    Event.observe( window, 'load', function() {{
        new Cropper.{*Img*}ImgWithPreview(
            'macropimg',
            {{
{if $cropsizemode ne 2}
                ratioDim: {{
                    x: {$thumbwidth},
                    y: {$thumbheight}
                }},
{/if}
                minWidth: {$thumbwidth},
                minHeight: {$thumbheight},
{if $cropsizemode eq 0}
                maxWidth: {$thumbwidth},
                maxHeight: {$thumbheight},
{/if}
{if $cropsizemode ne 2}
                previewWrap: 'previewWrap',
{/if}
                captureKeys: false,         // disable keyboard capturing, as this can cause some problems at the moment
                onEndCrop: maOnEndCrop      // callback function to provide the crop details to on end of a crop
            }}
        );
    }} );

    $('saveThumb').observe('click', maStartThumbUpdate);
    $('saveThumb').observe('keyup', maStartThumbUpdate);

    function maStartThumbUpdate() {{
        $('cropform').submit();
    }}

    /*
     * Callback function to capture the crop co-ordinates
     */
    function maOnEndCrop(coords, dimensions) {{
        $('x1').value = coords.x1;
        $('y1').value = coords.y1;
        $('x2').value = coords.x2;
        $('y2').value = coords.y2;
        $('width').value = dimensions.width;
        $('height').value = dimensions.height;
    }}
/* ]]> */
</script>
<noscript><p>{gt text="This function requires JavaScript."}</p></noscript>