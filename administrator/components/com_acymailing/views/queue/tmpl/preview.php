<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
	<h1><?php echo $this->mail->subject ?></h1>
	<div class="newsletter_body" >
	<?php echo $this->mail->sendHTML ? $this->mail->body : nl2br($this->mail->altbody); ?>
	</div>