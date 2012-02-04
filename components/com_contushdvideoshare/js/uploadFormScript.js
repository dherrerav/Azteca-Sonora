/*
 * Contushdvideoshare - 1.3
 * Author        : Contus Support - http://www.contussupport.com
 * Creation Date : 21 - Oct - 2010
 * File Path     : components/com_contushdvideoshare/js/uploadFormScript.js
 * Created By    : Contus Support
 * Copyright (c) 2010 Contus Support - support@contussupport.com
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
var uploadqueue = [];
var uploadmessage = '';


function addQueue(whichForm,myfile)
{
    var  extn = extension(myfile);
    if( whichForm == 'normalvideoform' || whichForm == 'hdvideoform' || whichForm == 'ffmpeg' )
    {
        if(extn != 'flv' && extn != 'FLV' && extn != 'mp4' && extn != 'MP4' && extn != 'm4v' && extn != 'M4V' && extn != 'mp4v' && extn != 'Mp4v' && extn != 'm4a' && extn != 'M4A' && extn != 'mov' && extn != 'MOV' && extn != 'f4v' && extn != 'F4V')
        {
            alert(extn+" is not a valid Video Extension");
            return false;
        }
    }
    else
    {
        if(extn != 'jpg' && extn != 'png' && extn!='jpeg')
        {
            alert(extn+" is not a valid Image Extension");
            return false;
        }
    }
    uploadqueue.push(whichForm);
    if (uploadqueue.length == 1)
    {

        processQueue();
    }
    else
    {

        holdQueue();
    }


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


    if(form_handler=='normalvideoform' || form_handler=='hdvideoform' || form_handler=='thumbimageform' || form_handler=='previewimageform' )
    {

        form_handlers=form_handler+"val";
        document.getElementById(form_handlers).value = outfile;
    }
    else
    {
        document.getElementById(form_handler).value = outfile;
    }
    setStatus(form_handler,statuscode);
    uploadqueue.shift();
    processQueue();

}

function submitUploadForm(form_handle)
{
    document.forms[form_handle].target = "uploadvideo_target";
    document.forms[form_handle].action = document.getElementById("videouploadformurl").value+"administrator/components/com_contushdvideoshare/upload.php?processing=1&clientupload=true";
document.forms[form_handle].submit();
}
function setStatus(form_handle,status)
{
    switch(form_handle)
    {
        case "ffmpeg":
            divprefix = 'f11';
            break;
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
    }
    var uploadformurl=document.getElementById("videouploadformurl").value;
    switch(status)
    {
            
        case "Queued":
            document.getElementById(divprefix + "-upload-form").style.display = "none";
            document.getElementById(divprefix + "-uploadProgress").style.display = "block";
            document.getElementById(divprefix + "-upload-status").innerHTML = "Queued";
            document.getElementById(divprefix + "-upload-message").style.display = "none";
            document.getElementById(divprefix + "-upload-filename").innerHTML = document.forms[form_handle].myfile.value;
            document.getElementById(divprefix + "-upload-image").src = uploadformurl+'components/com_contushdvideoshare/images/empty.gif';
            document.getElementById(divprefix + "-upload-cancel").innerHTML = '<a style="float:right;padding-right:10px;" href=javascript:cancelUpload("'+form_handle+'") name="submitcancel">Cancel</a>';
            break;

        case "Uploading":
            document.getElementById(divprefix + "-upload-form").style.display = "none";
            document.getElementById(divprefix + "-uploadProgress").style.display = "block";
            document.getElementById(divprefix + "-upload-status").innerHTML = "Uploading";
            document.getElementById(divprefix + "-upload-message").style.display = "none";
            document.getElementById(divprefix + "-upload-filename").innerHTML = document.forms[form_handle].myfile.value;
            document.getElementById(divprefix + "-upload-image").src = uploadformurl+'components/com_contushdvideoshare/images/loader.gif';
            document.getElementById(divprefix + "-upload-cancel").innerHTML = '<a style="float:right;padding-right:10px;" href=javascript:cancelUpload("'+form_handle+'") name="submitcancel">Cancel</a>';
            break;
        case "Retry":
        case "Cancelled":
            //uploadqueue = [];
            document.getElementById(divprefix + "-upload-form").style.display = "block";
            document.getElementById(divprefix + "-uploadProgress").style.display = "none";
            document.forms[form_handle].myfile.value = '';
            enableUpload(form_handle);
            break;
        case 0:
            document.getElementById(divprefix + "-upload-image").src =uploadformurl+ 'components/com_contushdvideoshare/images/success.gif';
            document.getElementById(divprefix + "-upload-status").innerHTML = "";
            document.getElementById(divprefix + "-upload-message").style.display = "block";
            document.getElementById(divprefix + "-upload-message").style.backgroundColor = "#CEEEB2";
            document.getElementById(divprefix + "-upload-message").innerHTML = uploadmessage;
            document.getElementById(divprefix + "-upload-cancel").innerHTML = '';
            break;


        default:
            document.getElementById(divprefix + "-upload-image").src = uploadformurl+'components/com_contushdvideoshare/images/error.gif';
            document.getElementById(divprefix + "-upload-status").innerHTML = " ";
            document.getElementById(divprefix + "-upload-message").style.display = "block";
            document.getElementById(divprefix + "-upload-message").innerHTML = uploadmessage + " <a href=javascript:setStatus('" + form_handle + "','Retry')>Retry</a>";
            document.getElementById(divprefix + "-upload-cancel").innerHTML = '';
            break;
    }



}

function enableUpload(whichForm,myfile)
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
        if (uploadqueue.length >= 1)
        {
            uploadqueue.shift();
            processQueue();
        }
        else
        {
            uploadqueue.splice(pos,1);
        }
    }
    else
    {
        uploadqueue.splice(pos,1);
    }

}
   
function extension(fname)
{
    var pos = fname.lastIndexOf(".");

    var strlen = fname.length;

    if(pos != -1 && strlen != pos+1)
    {
        var ext = fname.split(".");
        var len = ext.length;
        var extension = ext[len-1].toLowerCase();
    }
    else
    {

        extension = "No extension found";

    }

    return extension;

}
