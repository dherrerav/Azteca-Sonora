<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        default.php
 * @location    /components/com_contushdvideosahre/views/commentlogin/tmpl/default.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   Comment login layouts
 */

// No Direct access
defined('_JEXEC') or die('Restricted access');
ob_clean();
if (JRequest::getvar('mode', '', 'get', 'string')) {
?>
    <script type="text/javascript">
        window.onload=function()
        {
            window.opener.location.reload();
            window.close();
        }


    </script>
<?php
    exit;
}
JHtml::_('behavior.keepalive');
?>
<form action=<?php echo JRoute::_("index.php?option=com_users&task=user.login"); ?> method="post">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend>Login</legend>
            <table class="adminlist">
                <tfoot>
                    <tr>
                        <td colspan="2">&#160;
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>
                            <label id="username-lbl" for="username" class=" required">User Name<span class="star">&#160;*</span></label>
                        </td>

                        <td><input type="text" name="username" id="username" class="validate-username required" size="25"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label id="password-lbl" for="password" class=" required">Password<span class="star">&#160;*</span></label>
                        </td>
                        <td>
                            <input type="password" name="password" id="password" class="validate-password required" size="25"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <button type="submit" class="button">Log in</button>
                        </td>
                    </tr>
                <input name="option" value="com_users" type="hidden">
                <input name="task" value="user.login" type="hidden">
                <input name="return" value="<?php if (JRequest::getvar('mode', '', 'get', 'string')) { echo base64_encode(JRoute::_(JURI::base() . 'index.php?option=com_contushdvideoshare&view=player')); } else { echo base64_encode(JRoute::_(JURI::base() . 'index.php?option=com_contushdvideoshare&view=commentlogin&mode=close')); } ?>" type="hidden">
                <?php echo JHTML::_('form.token'); ?>
                </tbody>
            </table>
        </fieldset>
    </div>
</form>
<?php exit; ?>