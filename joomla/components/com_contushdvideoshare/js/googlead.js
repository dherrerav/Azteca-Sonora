/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        googlead.js
 * @location    /components/com_contushdvideosahre/js/googlead.js
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   googlead displaying position 
 */

var pagearray=new Array();
var timerout1 ;
var timerout;
var timerout2;
var timerout3;
pageno =0 ;

//postadd
setTimeout('onplayerloaded()',100);
pagearray[0]="index.php?option=com_contushdvideoshare&view=googlead";


function getFlashMovie(movieName)
{
    var isIE = navigator.appName.indexOf("Microsoft") != -1;
    return (isIE) ? window[movieName] : document[movieName];
}

function googleclose()
{
  
    if(document.all)
    {
        document.all.IFrameName.src="";
    }
    else
    {
        frames['IFrameName'].location.href="";
    }
    document.getElementById('lightm').style.display="none";
    clearTimeout();

    setTimeout('bindpage(0)', ropen);
}

function onplayerloaded()
{
    pageno=1;
    timerout1 =window.setTimeout('bindpage(0)', 1000);

}

function findPosX(obj)
{
    var curleft = 0;
    if(obj.offsetParent)
        while(1)
        {
            curleft += obj.offsetLeft;
            if(!obj.offsetParent)
                break;
            obj = obj.offsetParent;
        }
    else if(obj.x)
        curleft += obj.x;
    return curleft;
}

function findPosY(obj)
{
    var curtop = 0;
    if(obj.offsetParent)
        while(1)
        {
            curtop += obj.offsetTop;
            if(!obj.offsetParent)
                break;
            obj = obj.offsetParent;
        }
    else if(obj.y)
        curtop += obj.y;
    return curtop;
}

function closediv()
{

    document.getElementById('lightm').style.display="none";
    clearTimeout();
    if( ropen!=''){
        setTimeout('bindpage(0)', ropen);
    }
}

function bindpage(pageno)
{
    if(document.all)
    {
        document.all.IFrameName.src=pagearray[0];
    }
    else
    {
        frames['IFrameName'].location.href=pagearray[pageno];
    }

    document.getElementById('closeimgm').style.display="block";
    document.getElementById('lightm').style.display="block";
    if(closeadd !='') setTimeout('closediv()', closeadd);
}
