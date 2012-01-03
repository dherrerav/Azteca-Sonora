/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        autoheight.js
 * @location    /components/com_contushdvideosahre/js/autoheight.js
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   adjusting auto height on front page videos
 */



function addEvent(obj, evType, fn){
    if(obj.addEventListener)
    {
        obj.addEventListener(evType, fn,false);
        return true;
    } else if (obj.attachEvent){
        var r = obj.attachEvent("on"+evType, fn);
        return r;
    } else {
        return false;
    }
}

if (document.getElementById && document.createTextNode){
    addEvent(window,'load', doIframe);
}

function doIframe(){
    o = document.getElementsByTagName('iframe');
    for(i=0;i<o.length;i++){
        alert('sdfjalsdjfl');
        if (/\bautoHeight\b/.test(o[i].className)){
            setHeight(o[i]);

            addEvent(o[i],'load', doIframe);
        }
    }
}

function setHeight(e){
    e.height=e.contentWindow.document.body.scrollHeight;
}
