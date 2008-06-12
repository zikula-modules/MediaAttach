
function fileQueued(file, queuelength) {
    //check for maximum number of files allowed
    if (queuelength > maxFilesAtOnce) {
        alert(errorAllowedFilenum);
        return;
    }

    var fileName = file.name;
    //check if extension of selected file is allowed
    var extensionAllowed = false;
    while (fileName.indexOf("\\") != -1) {
        fileName = fileName.slice(fileName.indexOf("\\") + 1);
    }
    fileName = fileName.toLowerCase();
    allowedExtensions.each(function(entry) {
        if (fileName.lastIndexOf(entry) != -1) {
            extensionAllowed = true;
        }
    });

    if (extensionAllowed == false) {
        alert(errorExtensionNotAllowed);
        return;
    }


    var listingfiles = $('SWFUploadFileListingFiles');

    if(!listingfiles.getElementsByTagName('ul')[0]) {
        // create queue if this is the first file we are adding

        var info = document.createElement('h4');
        info.appendChild(document.createTextNode(msgCallbackFileQueue));

        listingfiles.appendChild(info);

        var ul = document.createElement('ul')
        listingfiles.appendChild(ul);
    }

    listingfiles = listingfiles.getElementsByTagName('ul')[0];              // queue list

    var li = document.createElement('li');                                  // new file entry
    li.id = file.id;
    li.className = 'SWFUploadFileItem';
    li.update(file.name + ' <span class="progressBar" id="' + file.id + 'progress"></span>'
                        + '<a id="' + file.id + 'deletebtn" class="cancelbtn" href="javascript:swfu.cancelFile(\'' + file.id + '\');"><!-- IE --></a>');

    listingfiles.appendChild(li);                                           // add it to the queue

    $('queueinfo').update(queuelength + ' ' + msgCallbackFilesQueued);
    $(swfu.movieName + 'UploadBtn').style.display = 'block';
    $('cancelqueuebtn').style.display = 'block';
}

function uploadFileCancelled(file, queuelength) {
    var li = $(file.id);
    li.update(file.name + ' - ' + msgCallbackFileSelected);
    li.className = 'SWFUploadFileItem uploadCancelled';
    $('queueinfo').update(queuelength + ' ' + msgCallbackFilesQueued);
}

function uploadFileStart(file, position, queuelength) {
    $('queueinfo').update(msgCallbackUploadingFile + ' ' + position + ' ' + msgCallbackUploadingOf + ' ' + queuelength);

    var li = $(file.id);
    li.className += ' fileUploading';
}

function uploadProgress(file, bytesLoaded) {
    var progress = $(file.id + 'progress');
    var percent = Math.ceil((bytesLoaded / file.size) * 200)
    progress.style.background = "#f0f0f0 url(modules/pnUpper/pnincludes/SWFUpload/images/progressbar.png) no-repeat -" + (200 - percent) + "px 0";
}

function uploadError(errno) {
    alert('An error occured: ' + errno);
    //SWFUpload.debug(errno);
/*
    *  -10: HTTP error, also returns the http error code (404 etc)
    * -20: Custom error code if no backend file is specified
    * -30: IO-error
    * -40: Security error
    * -50: Filesize exceeds limit

The error always contains one of these codes and the file object that caused the error.
*/
}

function uploadFileComplete(file) {
    $(file.id).className = 'SWFUploadFileItem uploadCompleted';
}

function cancelQueue() {
    swfu.cancelQueue();
    $(swfu.movieName + 'UploadBtn').style.display = 'none';
    $('cancelqueuebtn').style.display = 'none';
}

function uploadQueueComplete(file) {
    $('queueinfo').update(msgCallbackAllFilesUploaded);
    $('cancelqueuebtn').style.display = 'none';
    window.location.refresh();
}
