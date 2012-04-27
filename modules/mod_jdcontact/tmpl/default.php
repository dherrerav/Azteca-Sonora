<?php

/*------------------------------------------------------------------------
# J DContact
# ------------------------------------------------------------------------
# author                Md. Shaon Bahadur
# copyright             Copyright (C) 2012 j-download.com. All Rights Reserved.
# @license -            http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites:             http://www.j-download.com
# Technical Support:    http://www.j-download.com/request-for-quotation.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');

$showdepartment  	     =        $params->get( 'showdepartment', '1' );
$showsendcopy            =        $params->get( 'showsendcopy', '1' );
$humantestpram           =        $params->get( 'humantestpram', '1' );
$sales_address           =        $params->get( 'sales_address', 'sales@yourdomain.com' );
$support_address         =        $params->get( 'support_address', 'support@yourdomain.com' );
$billing_address         =        $params->get( 'billing_address', 'billing@yourdomain.com' );
$backgroundcolor         =        $params->get( 'backgroundcolor', '#FFEFD5' );
$wrp_width               =        $params->get( 'wrp_width', '320px' );
$inputfield_width        =        $params->get( 'inputfield_width', '300px' );
$inputfield_border       =        $params->get( 'inputfield_border', '#CCCCCC' );

    $result='';
    $name='';
    $email='';
    $phno='';
    $subject='';
    $msg='';
    $selfcopy='';
    $sucs='';

//$language= JFactory::getLanguage(); //get the current language
//print_r($language);
//$language->load( 'mod_jdcontact', JPATH_SITE.DS.'modules'.DS.'mod_jdcontact' );


if($_POST)
{
    $javascript_enabled         =       trim($_REQUEST['browser_check']);
    $department                 =       trim($_REQUEST['dept']);
    $name                       =       trim($_REQUEST['name']);
    $email                      =       trim($_REQUEST['email']);
    $phno                       =       trim($_REQUEST['phno']);
    $subject                    =       trim($_REQUEST['subject']);
    $msg                        =       trim($_REQUEST['msg']);
    $selfcopy                   =       isset($_REQUEST['selfcopy']) ? $_REQUEST['selfcopy'] : "";
    $humantest                  =       $_REQUEST['human_test'];
    $sum_test                   =       $_REQUEST['sum_test'];

    $headers  = 'MIME-Version: 1.0rn';
    $headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
    $headers .= 'From: '.$name.' <'.$email.'>'."\r\n";


    $message = "Contact name: $name\nContact Email: $email\nContact Phone: $phno\n\nMessage: $msg";

	if ( $department == "sales")        $to     =   $sales_address;
	elseif ( $department == "support")  $to     =   $support_address;
	elseif ( $department == "billing")  $to     =   $billing_address;
    else                                $to     =   $sales_address;

	if ( $name == "" )
	{
		$result = "".JText::_('MOD_JDCONTACT_VLDNAME')."";
	}
	elseif (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email))
	{
		$result = "".JText::_('MOD_JDCONTACT_VALIDEMAIL')."";
	}
	else if($phno=="")
	{
		$result = "".JText::_('MOD_JDCONTACT_PHONENUMB')."";
	}
	elseif ( $subject == "" )
	{
		$result = "".JText::_('MOD_JDCONTACT_MSGSUBJECT')."";
	}
	elseif ( strlen($msg) < 10 )
	{
		$result = "".JText::_('MOD_JDCONTACT_MORETENWRD')."";
	}
    else if($humantestpram=='1' && $humantest!=$sum_test){
	    $result = "".JText::_('MOD_JDCONTACT_CORRECTNUM')."";
    }
	else
	{
	    if(@mail($to, $subject, $message, $headers)){
            $sucs=1;
	    }
		if( $selfcopy == "yes" ){
		    @mail($email, $subject, $message, $headers);
        }
        if($sucs==1){
		    $result = "".JText::_('MOD_JDCONTACT_SUCCESSMSG')."";
        }
        else{
            $result = "".JText::_('MOD_JDCONTACT_MAILSERVPROB')."";
        }
	}

	if($javascript_enabled == "true") {
		echo $result;
		die();
	}
}
    $varone= rand(5, 15);
    $vartwo=rand(5, 15);
    $sum_rand=$varone+$vartwo;

?>
    <link rel="stylesheet" href="modules/mod_jdcontact/tmpl/lib/contact.css" media="screen" />
    <script src="modules/mod_jdcontact/tmpl/lib/jquery-1.4.4.js"></script>
    <div id="contactform" style="background: <?php echo $backgroundcolor; ?>;width: <?php echo $wrp_width; ?>;border:1px solid <?php echo $inputfield_border; ?>;">
        <form name="contactform" id="form" method="post" action="<?php $_SERVER['PHP_SELF']?>">
            <div id="result"><?php if($result) echo "<div class='message'>".$result."</div>"; ?></div>
            <?php if($showdepartment=='1') : ?>
              <label><?php echo JText::_('MOD_JDCONTACT_DEPARTMENT'); ?></label><br />
              <select style="width: <?php echo $inputfield_width; ?>;border:1px solid <?php echo $inputfield_border; ?>;" name="dept" class="text">
              	<option value="sales"><?php echo JText::_('MOD_JDCONTACT_SALES'); ?></option>
              	<option value="support"><?php echo JText::_('MOD_JDCONTACT_SUPPORT'); ?></option>
              	<option value="billing"><?php echo JText::_('MOD_JDCONTACT_BILLING'); ?></option>
              </select><br />
            <?php endif; ?>
            <label class="name"><?php echo JText::_('MOD_JDCONTACT_NAME'); ?><br /><input style="width: <?php echo $inputfield_width; ?>;border:1px solid <?php echo $inputfield_border; ?>;" class="text" name="name" type="text" value="<?php echo $name; ?>" /><br /></label>
            <label class="email"><?php echo JText::_('MOD_JDCONTACT_EMAIL'); ?><br /><input style="width: <?php echo $inputfield_width; ?>;border:1px solid <?php echo $inputfield_border; ?>;" class="text" name="email" type="text" value="<?php echo $email; ?>" /><br /></label>
            <label class="phno"><?php echo JText::_('MOD_JDCONTACT_TELEPHONE'); ?><br /><input style="width: <?php echo $inputfield_width; ?>;border:1px solid <?php echo $inputfield_border; ?>;" class="text" name="phno" type="text" value="<?php echo $phno; ?>" /><br /></label>
            <label class="subject"><?php echo JText::_('MOD_JDCONTACT_SUBJECT'); ?><br /><input style="width: <?php echo $inputfield_width; ?>;border:1px solid <?php echo $inputfield_border; ?>;" class="text" name="subject" type="text" value="<?php echo $subject; ?>" /><br /></label>
            <label class="msg"><?php echo JText::_('MOD_JDCONTACT_MESSAGE'); ?><br /><textarea style="width: <?php echo $inputfield_width; ?>;border:1px solid <?php echo $inputfield_border; ?>;" class="text" name="msg"><?php echo $msg; ?></textarea><br /></label>
            <?php if($showsendcopy=='1') : ?>
                <input type="checkbox" name="selfcopy" <?php if($selfcopy == "yes") echo "checked='checked'"; ?> value="yes" />
                <label><?php echo JText::_('MOD_JDCONTACT_SELFCOPY'); ?></label><br /><br />
            <?php endif; ?>
            <?php if($humantestpram=='1') : ?>
            <div style="border-bottom: 1px solid <?php echo $inputfield_border; ?>;border-top: 1px solid <?php echo $inputfield_border; ?>;padding-bottom: 2px;padding-top: 10px;">
                <label for='message'><?php echo JText::_('MOD_JDCONTACT_HUMANTEST'); ?></label>
                <?php echo '<b>'.$varone.'+'.$vartwo.'=</b>'; ?>
                <input id="human_test" name="human_test" size="3" type="text" class="text" style="border:1px solid <?php echo $inputfield_border; ?>;"><br>
                <input type="hidden" id="sum_test" name="sum_test" value="<?php echo $sum_rand; ?>" />
            </div>
            <?php endif; ?>
            <br />
            <input type="hidden" name="browser_check" value="false" />
            <input type="submit" name="submit" value="<?php echo JText::_('MOD_JDCONTACT_SUBMIT'); ?>" id="submit" />
        </form>

        <script type="text/javascript">
	    document.contactform.browser_check.value = "true";
	    $("#submit").click(function(){

		$('#result').html('<img src="modules/mod_jdcontact/tmpl/images/loader.gif" class="loading-img" alt="loader image">').fadeIn();
		var input_data = $('#form').serialize();
				$.ajax({
				   type: "POST",
				   url:  "<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
				   data: input_data,
				   success: function(msg){
					   $('.loading-img').remove(); //Removing the loader image because the validation is finished
					   $('<div class="message">').html(msg).appendTo('div#result').hide().fadeIn('slow'); //Appending the output of the php validation in the html div

                        if(msg=='<?php echo JText::_("MOD_JDCONTACT_SUCCESSMSG"); ?>'){
                            document.contactform.dept.selectedIndex='0';
                            document.contactform.name.value='';
                            document.contactform.email.value='';
                            document.contactform.phno.value='';
                            document.contactform.subject.value='';
                            document.contactform.human_test.value='';
                            document.contactform.msg.value='';
                       }

				   }
				});

			return false;
	    });
	    </script>
    </div>