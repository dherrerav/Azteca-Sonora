/**
* @Copyright Copyright (C) 2010-2011 Contus Support Interactive Private Limited
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html,
**/
var uploadqueue = [];
var uploadmessage = '';
function addQueue(whichForm)
{ 
    uploadqueue.push(whichForm);
    if (uploadqueue.length ==1)
        processQueue();
    else
        holdQueue();
}
function processQueue()
{
    if (uploadqueue.length > 0)
    {
        form_handler = uploadqueue[0];
        setStatus(form_handler,'Uploading');
        submitUploadForm(form_handler);
    }
}
function holdQueue()
{
    form_handler = uploadqueue[uploadqueue.length-1];
    setStatus(form_handler,'Queued');
}
function updateQueue(statuscode,statusmessage,outfile)
{

    uploadmessage = statusmessage;
    form_handler = uploadqueue[0];
    if (statuscode == 0)
        document.getElementById(form_handler+"-value").value = outfile;
    
    setStatus(form_handler,statuscode);
    uploadqueue.shift();
    processQueue();

}
function submitUploadForm(form_handle)
{
    document.forms[form_handle].target = "uploadvideo_target";
    documentBasePath = document.location.href;

    if (documentBasePath.indexOf('?') != -1)
        documentBasePath = documentBasePath.substring(0, documentBasePath.indexOf('?'));
    if (documentBasePath.indexOf('administrator') == -1){
        baseURL = documentBasePath+"/administrator";
    } else {
        if (documentBasePath.lastIndexOf('administrator/') == -1) {
            baseURL = documentBasePath;
        } else {
            documentBasePath = documentBasePath.substring(0, documentBasePath.lastIndexOf('/'));
            baseURL = documentBasePath;
        }
    } 
    document.forms[form_handle].action = baseURL+"/components/com_contushdvideoshare/upload.php?processing=1";
    document.forms[form_handle].submit();
}
function setStatus(form_handle,status)
{
    switch(form_handle)
    {
        case "normalvideoform":
            divprefix = 'f1';
            break;
        case "hdvideoform":
            divprefix = 'f2';
            break;
        case "thumbimageform":
            divprefix = 'f3';
            break;
        case "previewimageform":
            divprefix = 'f4';
            break;
        case "ffmpegform":
            divprefix = 'f5';
            break;
        case "rollform":
            divprefix = 'f6';
            break;
    }
    switch(status)
    {
        case "Queued":
            document.getElementById(divprefix + "-upload-form").style.display = "none";
            document.getElementById(divprefix + "-upload-progress").style.display = "";
            document.getElementById(divprefix + "-upload-status").innerHTML = "Queued";
            document.getElementById(divprefix + "-upload-message").style.display = "none";
            document.getElementById(divprefix + "-upload-filename").innerHTML = document.forms[form_handle].myfile.value;
            document.getElementById(divprefix + "-upload-image").src = 'components/com_contushdvideoshare/images/empty.gif';
            break;

        case "Uploading":
            document.getElementById(divprefix + "-upload-form").style.display = "none";
            document.getElementById(divprefix + "-upload-progress").style.display = "";
            document.getElementById(divprefix + "-upload-status").innerHTML = "Uploading";
            document.getElementById(divprefix + "-upload-message").style.display = "none";
            document.getElementById(divprefix + "-upload-filename").innerHTML = document.forms[form_handle].myfile.value;
            document.getElementById(divprefix + "-upload-image").src = 'components/com_contushdvideoshare/images/loader.gif';
            break;
        case "Retry":
        case "Cancelled":
            document.getElementById(divprefix + "-upload-form").style.display = "";
            document.getElementById(divprefix + "-upload-progress").style.display = "none";
            document.forms[form_handle].myfile.value = '';
            enableUpload(form_handle);
            break;
        case 0:
            document.getElementById(divprefix + "-upload-image").src = 'components/com_contushdvideoshare/images/success.gif';
            document.getElementById(divprefix + "-upload-status").innerHTML = "";
            document.getElementById(divprefix + "-upload-message").style.display = "";
            document.getElementById(divprefix + "-upload-message").innerHTML = uploadmessage;
            document.getElementById(divprefix + "-upload-cancel").innerHTML = '';
            break;


        default:
            document.getElementById(divprefix + "-upload-image").src = 'components/com_contushdvideoshare/images/error.gif';
            document.getElementById(divprefix + "-upload-status").innerHTML = "";
            document.getElementById(divprefix + "-upload-message").style.display = "";
            document.getElementById(divprefix + "-upload-message").innerHTML = uploadmessage + " <a href=javascript:setStatus('" + form_handle + "','Retry')>Retry</a>";
            document.getElementById(divprefix + "-upload-cancel").innerHTML = '';
            break;
    }
 
  
}

function enableUpload(whichForm)
{
    if (document.forms[whichForm].myfile.value != '')
        document.forms[whichForm].uploadBtn.disabled = "";
    else
        document.forms[whichForm].uploadBtn.disabled = "disabled";
}

function cancelUpload(whichForm)
{
    document.getElementById('uploadvideo_target').src = '';
    setStatus(whichForm,'Cancelled');
    pos = uploadqueue.lastIndexOf(whichForm);
    if (pos == 0)
    {
        if (uploadqueue.length > 1)
        {
            uploadqueue.shift();
            processQueue();
        }
    }
    else
    {
        uploadqueue.splice(pos,1);
    }

}
    
