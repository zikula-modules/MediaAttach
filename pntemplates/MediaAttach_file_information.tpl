{* $Id: MediaAttach_file_information.tpl 155 2006-09-11 20:11:19Z weckamc $ *}
{* Purpose of this template: Shows the file information *}

{*
{if $file.fileInfo.error[0] ne ""}
    {if $file.fileInfo.error[0] ne "unable to determine file format"}
        Error: {$file.fileInfo.error[0]}<br />
    {/if}
{/if}

{if $file.fileInfo.warning[0] ne ""}
        Notice: {$file.fileInfo.warning[0]}<br />
{/if}
*}

<dl>
<dt style="font-weight: 1.2; font-weight: 700">{gt text="General information"}</dt>
    <dd>{gt text="Filetype:"}
        {if $file.fileInfo.fileformat ne ""}{$file.fileInfo.fileformat}
        {else}{$file.extension}{/if}
    </dd>
    <dd>{gt text="Filesize:"}
        {if $file.fileInfo.filesize ne ""}{mafilesize size=$file.fileInfo.filesize}
        {else}{mafilesize size=$file.filesize}{/if}
    </dd>
    <dd>{gt text="Mimetype:"}
        {if $file.fileInfo.mime_type ne ""}
            {if $file.fileInfo.mime_type ne $file.mimetype}
                {$file.fileInfo.mime_type} ({$file.mimetype})
            {else}
                {$file.fileInfo.mime_type}
            {/if}
        {else}
            {$file.mimetype}
        {/if}
    </dd>
{if $file.fileInfo.encoding ne ""}
    <dd>{gt text="Encoding:"} {$file.fileInfo.encoding}</dd>
{/if}

{if $file.fileInfo.bitrate ne ""}
    <dd>{gt text="Average bitrate:"} {math equation="x/1000" x=$file.fileInfo.bitrate format="%.0f"} {gt text="kbps"}</dd>
{/if}
{if $file.fileInfo.playtime_seconds ne "" || $file.fileInfo.playtime_string ne ""}
    <dd>{gt text="Playtime:"}
        {if $file.fileInfo.playtime_string ne ""}
            {$file.fileInfo.playtime_string}
            {if $file.fileInfo.playtime_seconds ne ""}
                ({$file.fileInfo.playtime_seconds} {gt text="sec."})
            {/if}
        {else}
            {$file.fileInfo.playtime_seconds} {gt text="sec."}
        {/if}
    </dd>
{/if}


<dt style="font-weight: 1.2; font-weight: 700">{gt text="Hash information"}</dt>
{if $file.fileInfo.md5_file ne ""}
    <dd>{gt text="md5 entire file:"} {$file.fileInfo.md5_file}</dd>
{/if}
{if $file.fileInfo.md5_data_source ne ""}
  {if $file.fileInfo.md5_data ne ""}
    <dd>{gt text="md5 compressed raw data:"} {$file.fileInfo.md5_data}</dd>
  {/if}
    <dd>{gt text="md5 uncompressed raw data:"} {$file.fileInfo.md5_data_source}</dd>
{else}
  {if $file.fileInfo.md5_data ne ""}
    <dd>{gt text="md5 raw data:"} {$file.fileInfo.md5_data}</dd>
  {/if}
{/if}
{if $file.fileInfo.sha1_file ne ""}
    <dd>{gt text="sha1 entire file:"} {$file.fileInfo.sha1_file}</dd>
{/if}
{if $file.fileInfo.sha1_data ne ""}
    <dd>{gt text="sha1 raw data:"} {$file.fileInfo.sha1_data}</dd>
{/if}


{if $file.fileInfo.audio}
  <dt style="font-weight: 1.2; font-weight: 700">{gt text="Audio information"}</dt>

  {if $file.fileInfo.audio.bitrate ne ""}
    <dd>{gt text="Average bitrate:"} {math equation="x/1000" x=$file.fileInfo.audio.bitrate format="%.0f"} {gt text="kbps"}</dd>
  {/if}
  {if $file.fileInfo.audio.bitrate_mode ne ""}
    <dd>{gt text="Bitrate mode:"}
      {if $file.fileInfo.audio.bitrate_mode eq "cbr"} {gt text="CBR (Constant Bit Rate)"}
      {elseif $file.fileInfo.audio.bitrate_mode eq "vbr"} {gt text="VBR (Variable Bit Rate)"}
      {else}{$file.fileInfo.audio.bitrate_mode}
      {/if}
    </dd>
  {/if}
  {if $file.fileInfo.audio.sample_rate ne ""}
    <dd>{gt text="Sample rate:"} {$file.fileInfo.audio.sample_rate} {gt text="Hertz"}</dd>
  {/if}
  {if $file.fileInfo.audio.bits_per_sample ne ""}
    <dd>{gt text="Bits per sample:"} {$file.fileInfo.audio.bits_per_sample}</dd>
  {/if}

  {if $file.fileInfo.audio.channelmode ne ""}
    <dd>{gt text="Channelmode:"} {$file.fileInfo.audio.channelmode}</dd>
  {/if}
  {if $file.fileInfo.audio.channels ne ""}
    <dd>{gt text="No. of channels:"} {$file.fileInfo.audio.channels}</dd>
  {/if}
  {if $file.fileInfo.audio.codec ne ""}
    <dd>{gt text="Audio compression codec:"} {$file.fileInfo.audio.codec}</dd>
  {/if}
  {if $file.fileInfo.audio.encoder ne ""}
    <dd>{gt text="Encoder:"} {$file.fileInfo.audio.encoder}</dd>
  {/if}
  {if $file.fileInfo.audio.compression_ratio ne ""}
    <dd>{gt text="Compression ratio:"} {$file.fileInfo.audio.compression_ratio}</dd>
  {/if}
  {if $file.fileInfo.audio.lossless}
    <dd>{gt text="Lossless:"} {if $file.fileInfo.audio.lossless}{gt text="lossless compression"}{else}{gt text="lossy compression"}{/if}</dd>
  {/if}
{/if}


{if $file.fileInfo.video}
  {splitvar var=$file.mimetype delim="/" assign="mimearr"}
  {if $mimearr[0] eq "image"}
    <dt style="font-weight: 1.2; font-weight: 700">{gt text="Image information"}</dt>
  {else}
    <dt style="font-weight: 1.2; font-weight: 700">{gt text="Video information"}</dt>
  {/if}

  {if $file.fileInfo.video.bitrate ne ""}
    <dd>{gt text="Average bitrate:"} {math equation="x/1000" x=$file.fileInfo.video.bitrate format="%.0f"} {gt text="kbps"}</dd>
  {/if}
  {if $file.fileInfo.video.bitrate_mode ne ""}
    <dd>{gt text="Bitrate mode:"}
      {if $file.fileInfo.video.bitrate_mode eq "cbr"} {gt text="CBR (Constant Bit Rate)"}
      {elseif $file.fileInfo.video.bitrate_mode eq "vbr"} {gt text="VBR (Variable Bit Rate)"}
      {else}{$file.fileInfo.video.bitrate_mode}
      {/if}
    </dd>
  {/if}
  {if $file.fileInfo.video.bits_per_sample ne ""}
    <dd>{gt text="Bits per sample:"} {$file.fileInfo.video.bits_per_sample}</dd>
  {/if}
  {if $file.fileInfo.video.frame_rate ne ""}
    <dd>{gt text="Frame rate:"} {$file.fileInfo.video.frame_rate} {gt text="fps"}</dd>
  {/if}

  {if $file.fileInfo.video.resolution_x ne "" && $file.fileInfo.video.resolution_y ne ""}
    <dd>{gt text="Size:"} {$file.fileInfo.video.resolution_x} x {$file.fileInfo.video.resolution_y} {gt text="pixels"}</dd>
  {else}
    {if $file.fileInfo.video.resolution_x ne ""}
    <dd>{gt text="Width:"} {$file.fileInfo.video.resolution_x} {gt text="pixels"}</dd>
    {/if}
    {if $file.fileInfo.video.resolution_y ne ""}
    <dd>{gt text="Height:"} {$file.fileInfo.video.resolution_y} {gt text="pixels"}</dd>
    {/if}
  {/if}
  {if $file.fileInfo.video.pixel_aspect_ratio ne ""}
    <dd>{gt text="Pixel display aspect ratio:"} {$file.fileInfo.video.pixel_aspect_ratio}</dd>
  {/if}
  {if $file.fileInfo.video.codec ne ""}
    <dd>{gt text="Video compression codec:"} {$file.fileInfo.video.codec}</dd>
  {/if}
  {if $file.fileInfo.video.encoder ne ""}
    <dd>{gt text="Encoder:"} {$file.fileInfo.video.encoder}</dd>
  {/if}
  {if $file.fileInfo.video.compression_ratio ne ""}
    <dd>{gt text="Compression ratio:"} {$file.fileInfo.video.compression_ratio}</dd>
  {/if}
  {if $file.fileInfo.video.lossless}
    <dd>{gt text="Lossless:"} {if $file.fileInfo.video.lossless}{gt text="lossless compression"}{else}{gt text="lossy compression"}{/if}</dd>
  {/if}

  {if $file.fileInfo.swf && $file.fileInfo.swf.bgcolor}
    <dd>{gt text="Background colour:"} {$file.fileInfo.swf.bgcolor}</dd>
  {/if}
{/if}

{if $file.fileInfo.jpg && $file.fileInfo.jpg.exif}
  <dt style="font-weight: 1.2; font-weight: 700">{gt text="EXIF information"}</dt>

  {foreach key="exifGroupname" item="exifGroup" from=$file.fileInfo.jpg.exif}
    {if $exifGroupname ne "MAKERNOTE"}{* left out because of binary and unneeded big content *}
        <dd>{$exifGroupname|pnvarprepfordisplay}</dd>
        {foreach key="exifEntry" item="exifValue" from=$exifGroup}
          {if $exifEntry ne "MakerNote" && $exifEntry ne "ComponentsConfiguration" && $exifEntry ne "FileSource" && $exifEntry ne "UserComment"}{* left out because of binary content *}
            <dd style="padding-left: 30px">{$exifEntry|pnvarprepfordisplay}: {if is_array($exifValue)}{foreach name="valLoop" item="exifVal" from=$exifValue}{$exifVal}{if !$smarty.foreach.valLoop.last}, {/if}{/foreach}{else}{$exifValue|pnvarprepfordisplay}{/if}</dd>
          {/if}
        {/foreach}
    {/if}
  {/foreach}
{/if}

{if $file.fileInfo.comments_html}
  <dt style="font-weight: 1.2; font-weight: 700">{gt text="Tag information"}</dt>

  {foreach key="currentKey" item="currentValue" from=$file.fileInfo.comments_html}
    <dd>{$currentKey|pnvarprepfordisplay}: {foreach name="valLoop" item="currentElem" from=$currentValue}{$currentElem|pnvarprepfordisplay}{if $smarty.foreach.valLoop.last ne true}, {/if}{/foreach}</dd>
  {/foreach}
{/if}

</dl>