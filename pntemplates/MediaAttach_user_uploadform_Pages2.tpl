{* $Id: $ *}
{* Purpose of this template: SWFUpload form *}

{zajaxheader modname="MediaAttach" filename=MediaAttach.js}

<br id="files" />
{insert name="getstatusmsg"}<br /><br />
{if $definition.state eq 1}
    {zmodfunc modname="MediaAttach" type="user" func="showfilelist" objectid=$objectid}
    {if $allowadd}
        {if $usequota eq 0 || $usequota eq 1 && $usedquota < $allowedquota}
            {zpageaddvar name="javascript" value="modules/MediaAttach/pnincludes/SWFUpload/SWFUpload.js"}
            {zpageaddvar name="javascript" value="modules/MediaAttach/pnincludes/SWFUpload/callbacks.js"}
            {zpageaddvar name="stylesheet" value="modules/MediaAttach/pnincludes/SWFUpload/swfstyle.css"}

            <div id="SWFUploadTarget">
                <form id="myuploadform" action="{zmodurl modname="MediaAttach" type="user" func="createuploadflash"}" method="post" enctype="multipart/form-data">
                    <div>
                        <label id="labelfile" for="Filedata">{gt text="File"}:</label>
                        <input id="Filedata" name="Filedata" type="file" /><br />

                        <input type="submit" value="{gt text="Upload"}" />
                    </div>
                </form>
            </div>

            <h4 id="queueinfo">{gt text="Queue is empty"}</h4>
            <div id="SWFUploadFileListingFiles"></div>
            <br style="clear: both" />

            <a class="swfuploadbtn" id="cancelqueuebtn" href="javascript:cancelQueue();">{gt text="Cancel queue"}</a>

            {zmodcallhooks hookobject=item hookaction=new module=MediaAttach}

            <script type="text/javascript" language="javascript">
            /* <![CDATA[ */
                var allowedExtensions = new Array({foreach name="formatloop" item="currentformat" from=$definition.formats}".{$currentformat.extension}"{if !$smarty.foreach.formatloop.last}, {/if}{/foreach});
                var errorAllowedFilenum         = "{gt text="You are not allowed to upload more than %s files at once." tag1=$definition.numfiles}";
                var errorAlreadySelected        = "{gt text="This file has already been selected."}";
                var errorExtensionNotAllowed    = "{gt text="The filetype of this file is not allowed."}";
                var errorNoFilesSelected        = "{gt text="No file has been chosen yet."}";
                var errorAlreadyRunning         = "{gt text="There is already a file being uploaded."}";

                var msgCallbackFileQueue        = "{gt text="File queue"}";
                var msgCallbackFileSelected     = "{gt text="cancelled"}";
                var msgCallbackFilesQueued      = "{gt text="files queued"}";
                var msgCallbackUploadingFile    = "{gt text="Uploading file"}";
                var msgCallbackUploadingOf      = "{gt text="of"}";
                var msgCallbackAllFilesUploaded = "{gt text="All files uploaded..."}";

                var maxFilesAtOnce = {$definition.numfiles};

                var swfu;

                function initSWFUpload() {{
                    // Max settings
                    swfu = new SWFUpload({{
                        upload_script                   : '{zmodurl modname="MediaAttach" type="user" func="createuploadflash" parentmodule=$modname objectid=$objectid redirect=$redirect}',
                        target                          : 'SWFUploadTarget',
                        flash_path                      : 'modules/MediaAttach/pnincludes/SWFUpload/SWFUpload.swf',
                        allowed_filesize                : {$definition.maxsize},
                        allowed_filetypes               : '{foreach name="formatloop" item="currentformat" from=$definition.formats}*.{$currentformat.extension}{if !$smarty.foreach.formatloop.last};{/if}{/foreach}',
                        allowed_filetypes_description   : '{gt text="MediaAttach files..."}',
                        browse_link_innerhtml           : '{gt text="Browse files"}',
                        upload_link_innerhtml           : '{gt text="Upload files"}',
                        browse_link_class               : 'swfuploadbtn browsebtn',
                        upload_link_class               : 'swfuploadbtn uploadbtn',
                        flash_loaded_callback           : 'swfu.flashLoaded',
                        upload_file_queued_callback     : 'fileQueued',
                        upload_file_start_callback      : 'uploadFileStart',
                        upload_progress_callback        : 'uploadProgress',
                        upload_file_complete_callback   : 'uploadFileComplete',
                        upload_file_cancel_callback     : 'uploadFileCancelled',
                        upload_queue_complete_callback  : 'uploadQueueComplete',
                        upload_error_callback           : 'uploadError',
                        upload_cancel_callback          : 'uploadCancel',
                        auto_upload                     : false
                    }});

                }}

                Event.observe(window, 'load', initSWFUpload);
            /* ]]> */
            </script>

        {else}
            <p>{gt text="You have no more memory for uploads available"}</p>
        {/if}
{*    {else}
        <p>{gt text="Sorry, you have no permission for uploading files"}</p> *}
    {/if}
{/if}