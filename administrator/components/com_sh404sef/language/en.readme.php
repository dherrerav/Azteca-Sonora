<?php

/* @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: en.readme.php 2050 2011-06-30 13:52:38Z silianacom-svn $
*/ 

if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');
?>
<style type="text/css">
div.docs,div.docs p,div.docs ul li,div.docs ol li {
	text-align: left;
	font-weight: lighter;
	font-family: Tahoma, Arial, Verdana;
}

div.docs h1 {
	text-align: center;
}

div.docs h4,span.h4 {
	color: #CC0000;
}

div.docs p {
	padding-left: 3em;
	font-weight: lighter;
}

div.docs .small {
	color: #666666;
	font-size: 90%;
}

div.docs h5,span.h5 {
	font-weight: bold;
}
</style>
<div class="docs">

<h1>sh404SEF brief</h1>
<h2>Support site</h2>
<br />
You will find up to date information at
	<a target="_blank" href="http://anything-digital.com/sh404sef/seo-analytics-and-security-for-joomla.html">anything-digital.com/sh404sef/seo-analytics-and-security-for-joomla.html</a>.
Please also check <a target="_blank" href="http://anything-digital.com/forum/extension/sh404sef/">our support forum</a>.
Please read also our <a target="_blank" href="http://anything-digital.com/sh404sef/faqs.html">Frequently Asked Question</a>, probably the best place
to start with if something does not work as expected<br />
<br />
<h2>Summary</h2>
<p><span class=h5>Allows Search Engine Friendly URLs for Apache (and
probably but not officially supported, IIS)</span>. You can also setup your own, custom URLs
if you don't like those automatically built. Builds page title and meta
tags, and insert them into page. Title and tags can be manually set as
well. Provides security functions, by checking the content of URL and
visitor IP against various security check lists, plus an anti-flooding
system.</p>

<p>It has a caching system, to reduce database queries and enhance page
loading time when using URL rewriting.</p>
<p>sh404SEF can operate <span class=h5>with or without mod_rewrite</span>
(that is with or without .htaccess file). Urls are the same, except there
is an added /index.php/ bit in them when not using .htaccess. This is
now the default setting, as it is much easier to use. When using this mode, you may want to
adjust your ErrorDocument as 404 errors will no longer be processed by
Joomla when operating without a .htaccess file, which will prevent you
from using the advanced error page feature of sh404sef.</p>
<p>The integrated tool to manage your META tags will rewrite Title,
Description, Keywords, Robots and Language meta tags to your liking, on
any page of your site. It has a plugin system to accomodate any
component, and plugins for Virtuemart and for regular
content are provided to automatically generate these tags when appropriate from a SEO standpoint. Plus, you'll
be able to manually set any tags you like on a page by page basis (a
page is identified by its URL). Plus you'll be able to set content title
within h1 tags, and remove Generator = Joomla tags, plus a whole lot of
other SEO useful changes.</p>
<p>There is no hack of Joomla, just a standard plugin, installed
automatically with sh404SEF.</p>
<p>Many thanks to all previous contributors to 404SEF and 404SEFx</p>
<h2>Documentation</h2>


<h4>IMPORTANT : if you plan to use mod_rewrite (.htaccess) rewriting :</h4>
<span class=h5>BEFORE</span> making any attempt to activate this
component and use its URL rewriting functions, <span class=h5>your
Joomla installation should already be compatible with URL rewriting</span>.
This is not required if you select no .htaccess rewrite mode in sh404SEF
advanced parameters (but this mode may not always work as well,
depending on your server settings). <br />
<br />
Remember : if you are having difficulties with this, it is unlikely to
be a joomla problem, but most likely something related to your server
setup. For instance, many times, you will be faced with 404 errors or
Internal server errors 500 display. This indicates that there is
something in your .htacces file that is not compatible with your web
server setup.<br />
<br />
If you face this kind of errors, I will suggest you contact your hosting
company for assistance. <br />
If your .htaccess is not compatible with your web server, or hosting
company, there is no point in trying to use sh404SEF (at least the SEF url part of sh404SEF) - or any other
similar component as they 
will simply face the same problem. You will have first to fix your installation,
paying particular attention to the existence and the content of your
.htaccess file. However, one of the first thing to control, if you use the Apache web server : verify that
mod_rewrite is loaded by PHP. To do this, in Joomla backend, go to
Help menu, then System info. On the PHP Information tab, just run a search
for the word 'rewrite'. If you don't find anything, then mod_rewrite is
not loaded and nothing will work. You need to change your Apache web
server httpd.conf file, or contact your system administrator or shared
host company to do this for you.
Other web servers such as Microsoft IIS, NGinx, Lighthttpd, provides similar url rewriting features, which therefore
must be activated as well in the web server setup (they will be by default for most of them)
<br /><br />

<p>More advice on .htaccess, a very tricky issue on many occasions, can
be found online <a target="_blank" href="http://anything-digital.com/sh404sef/faqs.html">in our FAQ</a>. In a few words :</p>
<ul>
	<li>Joomla standard .htaccess is very <span class=h5>FINE</span>. It
	will work with most hosting companies. You should use it unmodified, at
	least to start with. Just remember it comes named as htaccess.txt, so
	you need to <span class=h5>rename</span> it to .htaccess before
	anything.</li>
	<li>If you get 404 errors or Internal error 500, or similar, when
	clicking on a rewritten URL, then you should try adding another # at
	the beginning of this line (near the top of the .htaccess file): <br />
	<br />
	Options FollowSymLinks <br />
	<br />
	so that it looks like: <br />
	<br />
	#Options FollowSymLinks <br />
	<br />
	</li>
	<li>If that does not work, and if your Joomla site is in a
	sub-directory, you should look for the line that looks like: <br />
	#RewriteBase /<br />
	and replace it with : RewriteBase /sub_directory_of_your_joomla_install<br />
	</li>
	<li>On some servers, even if your site is not in a sub-directory, you
	may want to try replacing<br />
	#RewriteBase /<br />
	with <br />
	RewriteBase /<br />
	</li>
	<li>One little thing more : try changing only one thing at a time, and
	check the result before moving to next step</li>
</ul>
<ol style="list-style-type: upper-roman;">
	<li>
	<h3>Introduction</h3>
	<p>Here are the main information bits required to use sh404SEF. You can
	view this documentation again by selecting the 'sh404SEF Documentation'
	button from the sh404SEF Control Panel.</p>
	<p>Please note that we cannot support IIS installation in any way.
	sh404SEF will usually work on such machines, using the "no htaccess (/index.php/)" mode but same restrictions 
	about having appropriate server settings apply, just like when using Apache or other web servers. Recent versions of IIS (7.x+) have url rewriting built in, but require appropriate configuration</p>
	</li>
	<li>
	<h3>Installation and setup</h3>
	<p>You can view installation instructions below by clicking the
	appropriate arrow.</p>
	<ol style="list-style-type: decimal;" id="collapsibleList">
		<li><script type="text/javascript">
					document.writeln('<img id="imgInstall" src="components/com_sh404sef/images/up.png" width="15" height="8" alt="Open list" onClick="toggle(\'imgInstall\',\'install\');">');
				</script> <span class="h4">Installation and setup</span><br />
		<ul id="install" style="list-style: none;">
			<li>
			<ol>
				<li>Upload the zip file to Joomla using the component installer in
				the usual way.</li>
				<li>For apache, the .htaccess file that comes with Joomla is FINE!! However, you may have to adjust it's content. Please read again the first paragraph of this documentation<br />
				</li>
				<li>For IIS, see Configuring IIS..</li>
				<li>Go to sh404sef main control panel, from the "Components" menu of Joomla's backend</li>
				<li>Using the "Quick start" tab, set the "Enable URL optimization" field to Yes, then press on the Go! button next to it</li>
			</ol>
			</li>
		</ul>
		</li>
		<li><script type="text/javascript">document.writeln('<img id="imgIIS" src="components/com_sh404sef/images/up.png" width="15" height="8" alt="Open list" onClick="toggle(\'imgIIS\',\'iis\');">');
				</script> <span class="h4">Configuring IIS</span><br />
		<br />

		<ul id="iis" style="list-style: none">
			<li><span class=h5>IMPORTANT</span> : We do not provide support for IIS.
			A number of users do operate successfully under this web server, and
			therefore whether you are looking for information or have
			successfully setup sh404sef and IIS and want to share,  
			the place to be is <a target="_blank" href="http://anything-digital.com/forum/extension/sh404sef/">the support forum</a>.
			Please note that good results have been reported using the "no
			.htaccess (/index.php/)" operating mode of sh404SEF instead of trying
			to setup a rewriting engine in IIS. If you use this operating mode,
			you don"t need anything than just sh404SEF. However, again, IIS may
			have been configured in a way where even this mode cannot work, so
			please report to sh404SEF support forum, or to Joomla Forum for
			assistance in setting this up.<br />
			<br />
			</li>
		</ul>
		</li>
		<li><script type="text/javascript">document.writeln('<img id="imgUninstall" src="components/com_sh404sef/images/up.png" width="15" height="8" alt="Open list" onClick="toggle(\'imgUninstall\',\'uninstall\');">');
				</script> <span class="h4">Uninstall</span><br />
		<ul id="uninstall" style="list-style: none;">
			<li>
			<ol>
				<li>Uninstall the component using Joomla's component uninstaller in the
				usual way.</li>
			</ol>
			</li>
		</ul>
		</li>
		
		<li><script type="text/javascript">document.writeln('<img id="imgUpgrading" src="components/com_sh404sef/images/up.png" width="15" height="8" alt="Open list" onClick="toggle(\'imgUpgrading\',\'upgrading\');">');
        </script> <span class="h4">Upgrading</span><br />
    <ul id="upgrading" style="list-style: none;">
      <li>
      <ol>
        <li>Install the new version that you downloaded from our web site over the current one, using Joomla's installer. All settings,
        custom or automatic urls, titles and meta tags, aliases and such are
        preserved upon upgrading, unless you specifically configured sh404sef
        to "forget" some or all of this data, using the Advanced tab of
        its configuration panel.<br />
        </li>
      </ol>
      </li>
    </ul>
    </li>
    
	</ol>
	</li>
	<li>
	<h3>Useful Tips For Using sh404SEF</h3>
	<ul style="list-style: none;">
		<li>
		<h4>Configuration</h4>

		<p>Using sh404SEF configuration is fairly straightforward for most of
		it. For more information on each item hover your mouse over the blue
		(i) images when you are in the configuration screen.</p>
		<p>When you save configuration you may need to remove all
		your URL's from the database, so that they are later on recreated,
		taking into account the new parameters. <br/>
		Purging urls is done with the "Purge" button found in the toolbar
		of the URL manager. <strong>Deleting urls is required only if you have
		changed parameters affecting the way URL are built</strong>, such as changing
		suffix from .htm to .html for instance. If you have a high traffic
		site it may be wise to put it offline before purging the database.
		<span class=h5>After doing that, you should use an <strong>online</strong>
		tool to build automatically a sitemap</span>. The sitemap generator
		will go through all of your site, and therefore all of your links, so
		they will be all automatically placed in the cache, thus speeding
		access for your next visitors.<br>
		The caching system of sh404SEF is transparent, and will be rebuilt
		automatically on a regular basis. Using the cache will vastly speed up
		the page load time, by dramatically reducing the number of database
		queries. Beware that URL caching uses up a lot of memory though. Its
		size can be limited using the appropriate parameter, and it can also
		be turned off completely.
		
		</p>
		<p>If you have a multi-lingual site, you can turn on or off URL
		translation. Normally, URL elements will be translated into the user
		language. However, it sometimes better not to translate, such as when
		using non-latin characters based languages. On such occasions, default
		site language will always be used</p>
		<p></p>

		<p>You may want to purge the 404 log before creating fresh urls.</p>
		</li>
		<li>
		<h4>Modifying URL's</h4>
		<p>You can modify URL's to your liking. Go into sh404SEF Control Panel
		and click 'URL Manager'. Select the URL you wish to modify, change 
		its SEF url and click on Save. Urls that have been modified from the
		version created by sh404sef are marked in the list with a lock icon.
		They will not be removed when you do a global purge, but only
		if you explicitely remove them.
		</li>
	</ul>
</ol>

<br />

<script type="text/javascript">
		document.getElementById('collapsibleList').style.listStyle="none"; // remove list markers
		document.getElementById('install').style.display="none"; // collapse list
		document.getElementById('iis').style.display="none"; // collapse list
		document.getElementById('uninstall').style.display="none"; // collapse list
		document.getElementById('upgrading').style.display="none"; // collapse list
		// this function toggles the status of a list
		function toggle(image,list){
			var listElementStyle=document.getElementById(list).style;
			if (listElementStyle.display=="none"){
				listElementStyle.display="block"; document.getElementById(image).src="components/com_sh404sef/images/down.png";
				document.getElementById(image).alt="Close list";
			}
			else{
				listElementStyle.display="none";
				document.getElementById(image).src="components/com_sh404sef/images/up.png";
				document.getElementById(image).alt="Open list";
			}
		}
	</script>
<div class="small" style="text-align: center;">Copyright &copy;
2006-<?php echo date('Y');?> Yannick Gaultier - Anything Digital<br />
Distributed under the terms of the GNU General Public License.</div>
</div>
