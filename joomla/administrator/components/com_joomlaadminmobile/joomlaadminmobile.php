<?php

/**
 * @package             Joomla Admin Mobile
 * @copyright (C) 2009-2011 by Covert Apps - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport("joomla.html.parameter.element");
jimport('joomla.utilities.simplexml');
if(!file_exists(JPATH_SITE.DS."libraries".DS."phpxmlrpc".DS."xmlrpc.php"))
{
	require(JPATH_SITE.DS."components".DS."com_joomlaadminmobile".DS."phpxmlrpc".DS."xmlrpc.php");
	require(JPATH_SITE.DS."components".DS."com_joomlaadminmobile".DS."phpxmlrpc".DS."xmlrpcs.php");
}

$document = JFactory::getDocument();
$document->addStyleSheet("components/com_joomlaadminmobile/joomlaadminmobile.css");

JToolBarHelper::title(JText::_('Joomla! Admin Mobile' ), 'joomlaadminmobile');
JToolBarHelper::preferences('com_joomlaadminmobile', '500');

?>

<div style="float: left">
This component is used by the Joomla Admin Mobile mobile application to allow users to access and update their sites.
<br /><br />

Use the Parameters button in the top right corner to change the parameters for this component.
<br /><br />

<b>Download</b> the app for your <b>iPhone, iPad, and iPod Touch</b> here:<br />
<a target="_blank" href="http://click.linksynergy.com/fs-bin/click?id=MfhTU1GSoZI&offerid=146261.745923920&type=10&subid=">Joomla Admin Mobile! for iPhone</a><br />
<a target="_blank" href="http://click.linksynergy.com/fs-bin/click?id=MfhTU1GSoZI&offerid=146261.786519671&type=10&subid=">Joomla Admin Mobile! Lite for iPhone</a><br />
<br />

<b>Download</b> the app for your <b>Android phone or tablet</b> here:<br />
<a target="_blank" href="http://market.android.com/details?id=com.covertapps.joomlaadminmobilefull">Joomla Admin Mobile! for Android</a><br />
<a target="_blank" href="http://market.android.com/details?id=com.covertapps.joomlaadminmobilelite">Joomla Admin Mobile! Lite for Android</a><br />
<br />

If you are looking for <b>information</b> about the JAM applications or components, start here: <a target="_blank" href="http://www.covertapps.com/jam">JAM Page</a><br />
A <b>Get Started Guide</b> with instructions for installing, configuring, and connecting the JAM application to the JAM component can be found here: <a target="_blank" href="http://www.covertapps.com/get-started-with-j-admin-mobile">Get Started Guide</a><br />
<br />

Visit our UserVoice page to <b>sugguest features</b> here: <a target="_blank" href="http://jadminmobile.uservoice.com/">Customer Feedback</a><br />
Visit our <b>Forum</b> here: <a target="_blank" href="http://www.covertapps.com/forum/forum?id=45">JAM Forum</a><br />
<br />

<b>Review Us...</b><br />
...On the <b>JED</b>: <a target="_blank" href="http://extensions.joomla.org/extensions/mobile/mobile-apps/8008">Joomla Extensions Directory</a><br />
...On <b>iTunes</b>: <a target="_blank" href="http://click.linksynergy.com/fs-bin/click?id=MfhTU1GSoZI&offerid=146261.745923920&type=10&subid=">Joomla Admin Mobile! for iPhone</a><br />
...On <b>Android Market</b>: <a target="_blank" href="http://market.android.com/details?id=com.covertapps.joomlaadminmobilefull">Joomla Admin Mobile! for Android</a><br />
<br />

Follow us on <b>Twitter</b> here: <a target="_blank" href="http://twitter.com/covertapps">CovertApps Twitter</a><br />
Like us on <b>Facebook</b> here: <a target="_blank" href="http://www.facebook.com/pages/CovertAppscom/155245831190242">CovertApps Facebook</a><br />
<br />

Thank you for your support!
<br /><br />

</div>

<div style="float:right">
<?php
        include_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'assets'.DS.'cmsmarketconnect'.DS.'cmsmarketconnect.php');
        $CMSMarket = new CMSMarketConnect();
        $CMSMarket->display('com_joomlaadminmobile');
?>
</div>

<div style="clear: both"></div>

