<?php
/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
// no direct access

defined('_JEXEC') or die('Restricted access');
ob_clean();
if (JRequest::getvar('mode', '', 'get', 'string'))
   {
?>
    <script type="text/javascript">
        window.onload=function()
        {
            window.opener.location.reload();
            window.close();
        }
    </script>
<?php exit;
    } ?>
<div class="componentheading">
    Login</div>
<form action="<?php echo JURI::base(); ?>index.php?option=com_user" method="post" name="com-login" id="com-form-login">
    <table class="contentpane" width="100%" align="center" border="0" cellpadding="4" cellspacing="0">
        <tbody><tr>
                <td colspan="2">
                </td>
            </tr>
        </tbody></table>
    <fieldset class="input">
        <p id="com-form-login-username">
            <label for="username">Username</label><br>
            <input name="username" id="username" class="inputbox" alt="username" size="18" type="text">
        </p>
        <p id="com-form-login-password">
            <label for="passwd">Password</label><br>
            <input id="passwd" name="passwd" class="inputbox" size="18" alt="password" type="password">
        </p>
        <input name="Submit" class="button" value="Login" type="submit">
    </fieldset>
    <input name="option" value="com_user" type="hidden">
    <input name="task" value="login" type="hidden">
    <?php if (JRequest::getvar('mode', '', 'get', 'string'))
            {
                $player_path =  base64_encode('index.php?option=com_contushdvideoshare&view=player');
            }
           else
            {
                 $player_path = base64_encode('index.php?option=com_contushdvideoshare&view=commentlogin&mode=close');
            } ?>
    <input name="return" value="<?php echo $player_path; ?>" type="hidden">
<?php echo JHTML::_('form.token'); ?>
</form>
<?php
exit;
?>