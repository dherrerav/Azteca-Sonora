/**
* @Copyright Copyright (C) 2010-2011 Contus Support Interactive Private Limited
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html,
**/
function addQueue(whichForm)
{
    uploadqueue.push(whichForm);
    if (uploadqueue.length == 1)
        processQueue();
    else
        holdQueue();
}
