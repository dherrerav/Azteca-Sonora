<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

$user = &JFactory::getUser();
$templatetheme = $user->getParam('templateTheme');
$options = array(''       => JText::_("My Theme"),
                 'theme1' => JText::_("iPad App"),
                 'theme2' => JText::_("Notepad"),
                 'theme3' => JText::_("Book"),
                 'theme4' => JText::_("Chalkboard"),
                 'theme5' => JText::_("Dark App"),
                 'theme6' => JText::_("Teal"),
                 'theme7' => JText::_("Blue"),
                 'theme8' => JText::_("Purple"),
                 'theme9' => JText::_("Pink"),
                 'theme10' => JText::_("Red"),
                 'theme11' => JText::_("Maroon"),
                 'theme12' => JText::_("Orange"),
                 'theme13' => JText::_("Yellow"),
                 'theme14' => JText::_("Olive"),
                 'theme15' => JText::_("Green"),
                 'theme16' => JText::_("Brown"),
                 'theme17' => JText::_("Black") );
?>
<form id="adminpad_theme" name="adminpad_theme" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
    <select name="templateTheme" id="templateTheme" onchange="document.adminpad_theme.submit()">
        <?php foreach($options AS $v => $l)
        {
           $ps = "";
           if($templatetheme == $v) { $ps = ' selected="selected"'; }
           echo "<option value='$v'$ps>$l</option>";
        }
        ?>
    </select>
</form>
