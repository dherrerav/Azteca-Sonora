/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        popup.js
 * @location    /components/com_contushdvideosahre/js/popup.js
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   popup window scrtipt code
 */

var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
    if(popUpWin)
    {
        if(!popUpWin.closed) popUpWin.close();
    }
    popUpWin = open(URLStr, 'popUpWin', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=yes, width='+width+', height='+height+', left='+left+', top='+top+', screenX='+left+', screenY='+top+'');
}