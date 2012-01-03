<?php
/**
 * @author Andy Sharman
 * @copyright Andy Sharman (www.udjamaflip.com)
 * @link http://www.udjamaflip.com
 * @license GNU/GPL V2+
 * @version 1.0rc1
 * @package mod_UdjaComments
**/ 

jimport( 'joomla.html.html.behavior' );

// no direct access
defined('_JEXEC') or die;

class modUdjaCommentsHelper
{
	private $params, $user;
	
	public function __construct($useCss)
	{
		//add css/js
		$document =& JFactory::getDocument();
		if ($useCss)
		{
			$document->addStyleSheet(JURI::Base(true).'media/mod_udjacomments/css/mod_udjacomments.css','text/css','screen');
		}
		$document->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js');
		$document->addScript(JURI::Base().'media/mod_udjacomments/js/mod_udjacomments.js');
		
		//get component params
		$this->params = JComponentHelper::getParams('com_udjacomments');
		
		//setup default fields if user is logged in
		//get the current user to either locked fields or display unlocked fields.
		$this->user =& JFactory::getUser();

		if (!$this->user->guest)
		{
			JRequest::set(array('txtUdjaName' => $this->user->name, 'txtUdjaEmail' => $this->user->email), 'POST', false);
		}
	}
	
	public function getUser()
	{
		if (!$this->user->guest)
		{
			return $this->user;
		}
		return false;
	}
	
	public function getViewable()
	{
		//if it's content component
		if (JRequest::getString('option') == 'com_content')
		{
			//isn't an article we don't want any comments displaying.
			if (JRequest::getString('view') != 'article') { return false; }
			//if the category filter param is enabled check if this category is allowed.
			if ($this->params->get('enable_catlist',0) && !in_array(JRequest::getInt('catid'), $this->params->get('cat_list'))) { return false; }
		}
		return true;		
	}
	
	public function getRequired($field)
	{
		//fetch required status
		if ($this->params->get('force_'.$field,0) == 1) { return true; }
		
		//if it's email, see if notifications/signup are enabled. If so force required.
		if ($field == 'email')
		{
			if ($this->params->get('enable_notifications',1) || $this->params->get('enable_signup',0)) { return true; }
		}
		return false;
	}
	
	public function getFieldEnabled($field)
	{
		return $this->params->get('enable_' . $field,0);
	}
	
	public function getFormPosition()
	{
		return $this->params->get('form_position','bottom');
	}
	
	private function getValidEmail($email) {
		// Set test to pass
		$valid = true;
		// Find the last @ in the email
		$findats = strrpos($email, "@");
		// Check to see if any @'s were found
		if (is_bool($findats) && !$findats) {
			$valid = false;
		}
		else {
			// Phew, it's still ok, continue...
			// Let's split that domain up.
			$domain = substr($email, $findats+1);
			$local = substr($email, 0, $findats);
			// Find the local and domain lengths
			$locallength = strlen($local);
			$domainlength = strlen($domain);
			// Check local (first part)
			if ($locallength < 1 || $locallength > 64) {
				$valid = false;
			}
			// Better check the domain too
			elseif ($domainlength < 1 || $domainlength > 256) {
				$valid = false;
			}
			// Can't be having dots at the start or end
			elseif ($local[0] == '.' || $local[$locallength-1] == '.') {
				$valid = false;
			}
			// Don't want 2 (or more) dots in the email
			elseif ((preg_match('/\\.\\./', $local)) || (preg_match('/\\.\\./', $domain))) {
				$valid = false;
			}
			// Make sure the domain has valid chars
			elseif (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
				$valid = false;
			}
			// Make sure the local has valid chars, make sure it's quoted right
			elseif (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
				if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
					$valid = false;
				}
			}
			// Whoa, made it this far? Check for domain existance!
			elseif (!(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
				$valid = false;
			}
		}
		
		return $valid;
	}

	public function saveComment()
	{
		$errList = array();
		
		//rite, first let's validate the basics
		if (!$name = JRequest::getString('txtUdjaName')) { $errList[] = JText::_('MOD_UDJACOMMENTS_VALIDATION_TXTNAME'); }
		if ($this->getRequired('email') && (!$email = JRequest::getString('txtUdjaEmail') || !$this->getValidEmail($email))) { $errList[] = JText::_('MOD_UDJACOMMENTS_VALIDATION_TXTEMAIL'); }
		if ($this->getRequired('url') && !$website = JRequest::getString('txtUdjaWebsite')) { $errList[] = JText::_('MOD_UDJACOMMENTS_VALIDATION_TXTWEBSITE'); }
		if (!$comment = JRequest::getString('txtUdjaComment')) { $errList[] = JText::_('MOD_UDJACOMMENTS_VALIDATION_TXTCOMMENT'); }
			
		//stop. re-captcha time.
		if ($this->getRecaptcha())
		{
			require_once('recaptchalib.php');
			$privatekey = $this->params->get('recaptcha_private_key');
			$resp = recaptcha_check_answer ($privatekey,
				$_SERVER["REMOTE_ADDR"],
				$_POST["recaptcha_challenge_field"],
				$_POST["recaptcha_response_field"]);

			if (!$resp->is_valid) {
				// What happens when the CAPTCHA was entered incorrectly
				$errList[] = JText::_('MOD_UDJACOMMENTS_VALIDATION_RECAPTCHA');
			}
		}
		
		if (count($errList))
		{
			$application = JFactory::getApplication();
			foreach ($errList as $error)
			{
				$application->enqueueMessage($error, 'error');
			}
			
			return false;
		}
		
		//now to save the comment! - Or wait, is is spam?
		//run spam checker
		$isSpam = intval($this->isSpam());
		$isPublish = ($isSpam == 1) ? 0 : intval($this->isPublish());

		//check if it's a reply, if so to which id
		$parentId = intval(JRequest::getInt('hdnIsReply'));
		
		//get url - but strip domain so it works the same on different domains.
		$juri = JFactory::getUri();
		$currentUrl	= JURI::Current();
		$currentUrl .= ($juri->getQuery()) ? '?'.$juri->getQuery() : '';
		$comment_url = str_ireplace(JURI::base(),'',$currentUrl);
				
		//now save
		$dbo = JFactory::getDbo();
		$sql = 'INSERT INTO
					`#__udjacomments`
					(
						`full_name`,
						`email`,
						`url`,
						`ip`,
						`content`,
						`parent_id`,
						`comment_url`,
						`is_published`,
						`is_spam`,
						`receive_notifications`,
						`receive_emailers`
					)
				VALUES
					(
						"'.$dbo->getEscaped($name).'",
						"'.$dbo->getEscaped(JRequest::getString('txtUdjaEmail')).'",
						"'.$dbo->getEscaped(JRequest::getString('txtUdjaWebsite')).'",
						"'.$dbo->getEscaped($_SERVER['REMOTE_ADDR']).'",
						"'.$dbo->getEscaped($comment).'",
						'.$dbo->getEscaped($parentId).',
						"'.$dbo->getEscaped($comment_url).'",
						'.$dbo->getEscaped($isPublish).',
						'.$dbo->getEscaped($isSpam).',
						'.((JRequest::getInt('txtUdjaNotifications')) ? 1 : 0).',
						'.((JRequest::getInt('txtUdjaMailer')) ? 1 : 0).'
					)';
		$dbo->setQuery($sql);
		
		if ($dbo->Query())
		{			
			return true;	
		}
		
		if ($err = $dbo->getErrorMsg()) { die($err); }
		
		return false;
	}
	
	public function isSpam()
	{
		//filter out logged in users
		if ($this->getUser()) { return 0; }		
		
		//filters first
		$ipList = explode("\r\n",$this->params->get('ip_list',''));	
		$urlList = explode("\r\n",$this->params->get('url_list',''));	
		$emailList = explode("\r\n",$this->params->get('email_list',''));
		
		if (in_array($_SERVER['REMOTE_ADDR'], $ipList)) { return 1; }
		if (!is_null(JRequest::getString('txtUdjaWebsite')) && in_array(JRequest::getString('txtUdjaWebsite'), $urlList)) { return 1; }
		if (!is_null(JRequest::getString('txtUdjaEmail')) && in_array(JRequest::getString('txtUdjaEmail'), $emailList)) { return 1; }
			
		//OK, filters have passed. What about link count & words
		$wordList = explode("\r\n",$this->params->get('word_list',''));
		if (count($wordList) > 1)
		{
			foreach ($wordList as $word)
			{
				if (stristr(JRequest::getString('txtUdjaComment'), $word)) { return 1; }
			}
		}
		//how many urls - This is a basic form of catching.
		if (substr_count(JRequest::getString('txtUdjaComment'), 'http://') >= $this->params->get('link_count',3))	{ return 1; }
			
		return 0;
	}
	
	public function isPublish()
	{
		return intval($this->params->get('published_default',1));
	}
	
	public function getCommentList($url, $parentId=0)
	{
		$dbo = JFactory::getDbo();		
		$pageStart = (JRequest::getInt('pageNumber')) ? (JRequest::getInt('pageNumber') * $this->params->get('per_page',10)) : 0;
		$limit = ($parentId != 0) ? '' : ' LIMIT '.$pageStart.','.$this->params->get('per_page',10);
		
		$sql = 'SELECT
					*
				FROM
					`#__udjacomments`
				WHERE
					`comment_url`="'.$dbo->getEscaped($url).'"
				AND
					`parent_id`='.$parentId.'
				AND
					`is_published`=1
				ORDER BY
					`time_added` '. $this->params->get('ordering','DESC') . $limit;
		
		$dbo->setQuery($sql);
				
		if ($dbo->Query())
		{
			$fullList = array();
			foreach ($dbo->loadObjectList() as $comment)
			{
				//labels comment as child or not
				if ($comment->parent_id != 0) { $comment->child = true; }
				else { $comment->child = false; }
				//recursively call self to get all children
				$comment->replies = $this->getCommentList($url, $comment->id);
				//add to array
				$fullList[] = $comment;
			}
			return $fullList;
		}
		
		if ($err = $dbo->getErrorMsg()) { die($err); }
		
		return false;
	}
	
	public function getPageCount($commentUrl)
	{
		$dbo = JFactory::getDbo();
		$sql = 'SELECT
					count(`id`) AS commentCount
				FROM
					`#__udjacomments`
				WHERE
					`comment_url`="'.$dbo->getEscaped($commentUrl).'"
				AND
					`is_published`=1
				AND
					`parent_id`=0';
					
		$dbo->setQuery($sql);
		if ($dbo->Query())
		{
			$info = $dbo->loadObject();
			if (($info->commentCount/$this->params->get('per_page',10)) > 1)
			{
				return ceil($info->commentCount/$this->params->get('per_page',10));
			}
		}
		
		if ($err = $dbo->getErrorMsg()) { die($err); }

		return 0;
	}
	
	public function getRecaptcha()
	{
		if ($this->params->get('enable_recaptcha',0) && $privateKey = $this->params->get('recaptcha_private_key') && $publicKey = $this->params->get('recaptcha_public_key'))
		{
			if ($publicKey = $this->params->get('recaptcha_public_key'))
			{
				$recaptcha->publicKey	= $publicKey;
				$recaptcha->privateKey	= $privateKey;
			}
		}
		return false;
	}
	
	public function sendNotifications($commentUrl)
	{
		if ($this->params->get('enable_notifications',1))
		{
			$dbo = JFactory::getDbo();
			$sql = 'SELECT
						`email`,
						`full_name`
					FROM
						`#__udjacomments`
					WHERE
						comment_url="'.$dbo->getEscaped($commentUrl).'"
					AND
						receive_notifications=1';
			$dbo->setQuery($sql);
			if ($dbo->Query())
			{
				//get data for sending mail
				$sentList = array();
				$doc =& JFactory::getDocument();
				$pageTitle = $doc->getTitle();
				$mailer = JFactory::getMailer();
				
				//loop through notification recipients
				foreach ($dbo->loadObjectList() as $notify)
				{
					if (!in_array($notify->email, $sentList) && $notify->email != JRequest::getString('txtUdjaEmail'))
					{
						$mailer->clearAllRecipients();
						$mailer->addRecipient($notify->email);						
						$mailer->setSubject(JText::_('MOD_UDJACOMMENTS_NOTIFICATIONEMAIL_SUBJECT'));
						
						$body = JTEXT::_('MOD_UDJACOMMENTS_NOTIFICATIONEMAIL_BODY') . "\r\n\r\n" . $pageTitle . "\r\n" . JURI::base() . $commentUrl . "\r\n\r\n" . JRequest::getString('txtUdjaComment');
						$mailer->setBody($body);
						
						$mailer->Send();
						
						$sentList[] = $notify->email;	
					}
				}	
			}
			return true;
		}
		return false;
	}
	
	private function getGravatar($email)
	{
		if ($this->params->get('gravatar_enabled',0))
		{
			return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($email)));
		}
		
		return false;
	}
	
	public function getAvatar($email = false)
	{
		$avatar = '';
		if ($this->params->get('avatar_allowed',0))
		{
			if ($this->params->get('avatar_default'))
			{
				$avatar = JURI::base() . $this->params->get('avatar_default');
			}
			else
			{
				$avatar = JURI::base() . 'media/mod_udjacomments/images/default-avatar.png';
			}
			
			if ($email && $gravatar = $this->getGravatar($email))
			{
				$avatar = $gravatar . '?s=40&d='.urlencode($avatar);
			}
			return '<img src="'.$avatar.'" alt="" width="40px" class="commentAvatar" />';;
		}
		
		return false;
	}
	
	public function getReplyEnabled()
	{
		return $this->params->get('reply_allowed',1);
	}
	
	public function getReplyDepth()
	{
		return $this->params->get('reply_depth',3);
	}
}