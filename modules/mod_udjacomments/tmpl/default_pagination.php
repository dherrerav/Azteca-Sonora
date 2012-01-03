<?php
/**
 * @author Andy Sharman
 * @copyright Andy Sharman (www.udjamaflip.com)
 * @link http://www.udjamaflip.com
 * @license GNU/GPL V2+
 * @version 1.0rc1
 * @package mod_udjacomments
**/ 

// no direct access
defined('_JEXEC') or die;

$pageCount		= $helper->getPageCount($comment_url);
$currentPage	= (JRequest::getInt('pageNumber')) ? JRequest::getInt('pageNumber') : 0;

//only display pagination if there is pages.
if ($pageCount > 0)
{
	echo '<ul class="commentPagination">';
	
	$urlJoin = (stristr($currentUrl,'?')) ? '&amp;' : '?';
	
	//previous page
	if ($currentPage > 0)
	{
		echo '<li class="prev"><a href="'. $currentUrl . $urlJoin .'pageNumber='.($currentPage-1).'#udjaCommentsWrapper" title="'.JText::_('MOD_UDJACOMMENTS_PREVIOUSPAGE').'">'.JText::_('MOD_UDJACOMMENTS_PREVIOUSPAGE').'</a></li>';
	}
	
	//loop through	
	for ($i = 0; $i < $pageCount; $i++)
	{
		if ($currentPage == $i)
		{
			echo '<li>'.($i+1).'</li>';
		}
		else
		{
			echo '<li><a href="'.$currentUrl . $urlJoin.'pageNumber='.$i.'#udjaCommentsWrapper" title="'.($i+1).'">'.($i+1).'</a></li>';
		}
	}	
	
	//next page
	if (($currentPage+1) < $pageCount)
	{
		echo '<li class="next"><a href="'.$currentUrl . $urlJoin.'pageNumber='.($currentPage+1).'#udjaCommentsWrapper" title="'.JText::_('MOD_UDJACOMMENTS_NEXTPAGE').'">'.JText::_('MOD_UDJACOMMENTS_NEXTPAGE').'</a></li>';
	}
	
	echo '</ul>';
}