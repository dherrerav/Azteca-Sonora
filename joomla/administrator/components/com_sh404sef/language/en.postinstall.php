<?php

/* @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: en.postinstall.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

if (file_exists(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'sh404sef'.DS.'sh404sef.php')) :

?>
  <div style="text-align: justify;">
  <h1>sh404SEF installed succesfully! Please read the following</h1>
  
  This component 
  <ul>
  <li>rewrites Joomla! URLs to be Search Engine Friendly.</li>
  <li>performs various SEO improvements</li>
  <li>adds security features</li>
  <li>insert Google analytics snippet and create analytics reports in its control panel</li>
  </ul>

  <br />
  If it is the first time you use sh404SEF, it has been installed but most features are <strong>disabled</strong> right now.
   You must first use sh404SEF control panel (from the <a href="index.php?option=com_sh404sef" >sh404SEF Components</a> menu item of Joomla backend),
    <strong>enable whichever part you want to use and save</strong> before it will become active. 
    Before you do so, please read the next paragraphs which have important information for you.  If you are upgrading from a previous version of sh404SEF, 
    then all your settings have been preserved, the component is activated and you can start browsing your site frontpage right away.
  <br /><br />
  <strong><font color="red">IMPORTANT</font></strong> : the SEF urls part of sh404SEF can operate under two modes : 
  <strong><font color="red">WITH</font></strong> or <strong><font color="red">WITHOUT .htaccess</font></strong> file. 
  The default setting is now to work <strong>without .htaccess file</strong>. I recommend you use it if you are not familiar with web servers, 
  as it is generally difficult to find the right content for a .htaccess file.
  <br /><br />
  <strong>Without .htaccess file</strong> : use the <strong>Enable url optimization</strong> on sh404sef main control panel to enable it. 
  You should also review the various parameters found on the <strong>Configuration tab</strong>, 
  but that is not really necessary, as default settings have been carefully chosen to provide best SEO results without any change. 
  If you do change any of them, be sure to read the tool tips next to each setting for help. You can now browse the frontpage of your site to start generating SEF URL.
  <br />
  <strong>With .htaccess</strong> : you must activate separately this operating mode. On sh404sef main control panel, you\'ll see a select list to change <strong>Rewriting mode</strong> to suits your web server setup. 
  When done, you can enable URL optimization just like described above. 
  However, before you do that, you have to setup a .htaccess file. This file content depends on your hosting setup, so it is nearly impossible to tell you what should be in it. 
  Joomla comes with the most generic .htaccess file. It will probably work right away on your system, or may need adjustments. 
  The Joomla supplied file is called htaccess.txt, is located in the root directory of your site, and must be renamed into .htaccess before it will have any effect. You will find additional information about .htaccess at <a target="_blank" href="http://anything-digital.com/sh404sef/faqs.html">anything-digital.com/sh404sef/faqs.html</a>.<br /><br />
  <strong><font color="red">IMPORTANT</font></strong>: sh404SEF can build SEF URL for many Joomla components. 
  It does it through a <strong>"plugin" system</strong>, and comes with a dedicated plugin for each of Joomla standard components (Contact, Weblinks, Newsfeed, Content of course,...). 
  It also comes with native plugins for common components such as Community Builder, JomSocial, Kunena, Virtuemart, Sobi2,... 
  sh404SEF can also automatically make use of plugins designed for Joomla\'s own format, router.php files. 
  Such plugins are often delivered and installed automatically when you install a component. 
  Please note that when using these "foreign" plugins, you may experience compatibility issues.
  <br />
  However, Joomla having several hundreds extensions available, not all of them have a plugin to tell sh404SEF how its URL should be built. 
  When it does not have a plugin for a given component, sh404SEF will switch back to Joomla 1.0.x standard SEF URL, similar to mysite.com/component/option,com_sample/task,view/id,23/Itemid,45/. 
  This is normal, and can\'t be otherwise unless someone writes a plugin for this component (your assistance in doing so is very much welcomed! 
  Please post on the support forum if you have written a plugin for a component).<br />
  <br />
  You will also find more documentation on our <a target="_blank" href="http://anything-digital.com/sh404sef/user-manual.html">web site</a>
  <br />

  <p class="message">Please <strong>read the documentation</strong> : it is available on <a href="index.php?option=com_sh404sef&task=info" >sh404SEF main control panel</a></p>
  </div>

<?php
 
  else :
    
?>
    
  <strong><font color="red">Sorry, something went wrong while installing sh404SEF on your web site.</font></strong> 
  Please try uninstalling first, then check permissions on your file system, and make sure Joomla can write to the /plugin directory. 
  Or contact your site administrator for assistance. <br>You can also report this on our website at <a target="_blank" href="http://anything-digital.com/forum/extension/sh404sef/" >our support forum.</a>

<?php

  endif;

