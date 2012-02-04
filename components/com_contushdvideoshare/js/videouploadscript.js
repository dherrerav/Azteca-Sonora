
    function resetcategory()
    {
        document.getElementById('tagname').value='';
    }
function catselect(categ)
{
    var r=document.getElementById('selcat').value=categ;
    if(document.getElementById('tagname').value=='')
        {
          document.getElementById('tagname').value=r;
        }
        else
        {

          document.getElementById('tagname').value=  r;
        }
}

//change upload link page when i select option btn
function filetypeshow(obj)
{
    if(obj.value==0 || obj==0)
        {
    document.getElementById("typefile").style.display="none";
    document.getElementById("typeff").style.display="none";
    document.getElementById("typeurl").style.display="block";
    document.getElementById('seltype').value=0;
document.getElementById("ffmpeg").style.display="none";
 document.getElementById("normalvideoformval").style.display="none";
// document.getElementById("typefile1").style.display="block";
        }
        if(obj.value==1 || obj==1)
        {
      document.getElementById("typefile").style.display="block";
       document.getElementById("typeurl").style.display="none";
       document.getElementById("typeff").style.display="none";

       document.getElementById("imagepath").style.display="none";

       document.getElementById('seltype').value=1;
       document.getElementById("ffmpeg").style.display="none";
        document.getElementById("normalvideoformval").style.display="block";
//        document.getElementById("typefile1").style.display="block";
        }
        if(obj.value==2 || obj==2)
        {
    document.getElementById("typefile").style.display="none";
       document.getElementById("typeurl").style.display="none";
       document.getElementById("typeff").style.display="block";
       document.getElementById("ffmpeg").style.display="block";
       document.getElementById('seltype').value=2;
       document.getElementById("normalvideoformval").style.display="none";
//       document.getElementById("typefile1").style.display="none";
        }

}
document.getElementById("ffmpeg").style.display="none";
//document.getElementById("normalvideoform").style.display="none";
document.getElementById("typeff").style.display="none";


function bindvideo()
{
if(document.getElementById('Youtubeurl').value!='')
{
document.getElementById('videourl').value=0;
}
}


function assignurl(str)
{
   if(str=="")
       return false;
//    match_exp = new RegExp('regex = /http\:\/\/www\.youtube\.com\/watch\?v=(\w{11})/');
 var match_exp = /http\:\/\/www\.youtube\.com\/watch\?v=[^&]+/;

    if(str.match(match_exp)==null){
//var blib=/http:\/\/(.*?)blip\.tv\/file\/[0-9]+/;
////var breaktv=/http:\/\/(.*?)break\.com\/(.*?)\/(.*?)\.html/;
var metacafe=/http:\/\/www\.metacafe\.com\/watch\/(.*?)\/(.*?)\//;
//var google=/http:\/\/video\.google\.com\/videoplay\?docid=[^&]+/;
////var vimeo=/http:\/\/(.*?)vimeo\.com\/[0-9]+/;
if(str.match(metacafe)!=null)
   {
 document.upload1111.url1.value=document.getElementById('url').value;
   document.getElementById('generate').style.display="block";
     return false;

   }
   else
       {
             alert("Enter Video URL");
             document.getElementById('url').focus();
             document.upload1111.url.value="1";
             return false;
       }


}
    else
    {
        document.getElementById('generate').style.display="block";
        document.upload1111.flv.value=document.getElementById('url').value;
        document.upload1111.url1.value="1";
        return false;
    }

}
function membervalue(memid)
    {
      document.getElementById('memberidvalue').value=memid;
      document.memberidform.submit();
    }

    function fileformate_check(thumburl)
{


//var athumburl=thumb.value;
//alert(o.value);
if((thumburl.value.length > 0))
{

if(thumburl.value.substring(thumburl.value.length-3) == 'gif' || thumburl.value.substring(thumburl.value.length-3) == 'jpg' || thumburl.value.substring(thumburl.value.length-3) == 'png')
{}
else {
alert("Invalid file formate select only jpg/gif/png");
}
}
}