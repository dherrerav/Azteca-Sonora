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

//this is only to run the first time the layout is called.
if (!isset($commentList)) { $commentList = $helper->getCommentList($comment_url); $i = 1; }

$class = (isset($isChild)) ? 'childLayer' : 'parentLayer';
echo '<ul class="'.$class.'">';
foreach ($commentList as $comment)
{
	//reset depth when we hit a parent level thing
	if ($comment->parent_id == 0) { $depth = 1; }
	
	//setup if we're now running child items.
	$isChild = $comment->child;
	
	//get LI wrapper class
	$liClass = ($i % 2 == 0) ? 'even' : 'odd';
	
	//wrapping li
	echo '<li id="comment'.$comment->id.'" class="'.$liClass.'">';
	
		echo '<div class="commentDetails">';
			//output user avatar
			echo $helper->getAvatar($comment->email);
	
			//commenter name (link if applicable)
			if ($comment->url) {
				echo '<p class="commentName"><a href="'.((stristr($comment->url,'http')) ? $comment->url : 'http://'.$comment->url).'" target="_blank" title="'.$comment->full_name.'">'.$comment->full_name.'</a></p>';
			} else {
				echo '<p class="commentName">'.$comment->name.'</p>';
			}
	
			//comment date
			echo '<p class="commentDate">'.JText::_('MOD_UDJACOMMENTS_POSTED_AT') . ' ' . $comment->time_added.'</p>';
	
			//comment content
			echo '<p class="commentContent">'.nl2br($comment->content).'</p>';
	
			//ability to reply to posts
			if ($helper->getReplyEnabled() && $helper->getReplyDepth() >= $depth)
			{
				echo '<p class="commentReply"><a href="#" class="commentReplyLink" id="'.$comment->id.'" title="'.JText::_('MOD_UDJACOMMENTS_REPLY_TEXT').'">'.JText::_('MOD_UDJACOMMENTS_REPLY_TEXT').'</a></p>';;
			}
		echo '</div>';
		
		
		//incrementer for odd/even classes.
		$i++;
	
		//output child replies
		if (count($comment->replies) > 0)
		{
			$depth++;
			$commentList = $comment->replies;
			require JModuleHelper::getLayoutPath('mod_udjacomments', 'default_list');
			$depth--;
		}
	
	echo '</li>';
}
echo '</ul>';