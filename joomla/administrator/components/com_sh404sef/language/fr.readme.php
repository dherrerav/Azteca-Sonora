<?php

/* @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: fr.readme.php 2050 2011-06-30 13:52:38Z silianacom-svn $
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

<h1>sh404SEF en bref</h1>
<h2>Site de support</h2>
<br />
Vous trouverez des informations à jour sur 
	<a target="_blank" href="http://anything-digital.com/sh404sef/seo-analytics-and-security-for-joomla.html">anything-digital.com/sh404sef/seo-analytics-and-security-for-joomla.html</a>.
Veuillez aussi consulter <a target="_blank" href="http://anything-digital.com/forum/extension/sh404sef/">notre forum de support</a>.
Veuillez également consulter notre <a target="_blank" href="http://anything-digital.com/sh404sef/faqs.html">Foire Aux Questions</a>,
 probablement le meilleur endroit pour commencer si quelque chose ne fonctionne pas comme prévu.<br />
<br />
<h2>Sommaire</h2>
<p><span class=h5>Permet d'afficher des URL conviviales  pour les moteurs de recherche (pour Apache, et probablement pour IIS, bien que non supporté officiellement)</span>. 
Vous pouvez aussi configurer vos propres URL personnalisées, si vous n'aimez pas celles qui sont automatiquement intégrés. Construire le titre de la page et les  balises meta, 
et les insérer dans la page. Titre et balises peuvent être ainsi réglés manuellement. Fournit des fonctions de sécurité, 
en vérifiant le contenu de l'URL et l'IP du  visiteur contre diverses listes de contrôle de sécurité, plus un système anti-débordement.</p>

<p>Il possède un système de cache, afin de réduire les requêtes vers la base de données et ainsi améliorer le temps de chargement des pages lorsque vous utilisez la réécriture d'URL.</p>
<p>sh404SEF peut fonctionner <span class=h5>avec ou sans mod_rewrite</span>
(c'est à dire avec ou sans .htaccess file - sous Apache). Les URL sont les mêmes, sauf qu'il est un ajouté /index.php/  dans le cas de non utilisation d'.htaccess. 
C'est maintenant le paramètre par défaut, car il est beaucoup plus facile à utiliser. Lorsque vous utilisez ce mode, vous pouvez ajuster votre document d'erreur 404, 
les erreurs ne seront plus traitées par Joomla! lors de l'utilisation sans  fichier .htaccess, ce qui vous empêchera d'utiliser la fonctionnalité avancée des erreurs de page sh404SEF.</p>
<p>L'outil intégré gère la réécriture de vos balises META Titre, Description, Mots clés, Robots et les  balises meta langue à votre convenance, sur n'importe quelle page de votre site. 
Il a un système de plugin pour accueillir un composant, et des plugins pour Virtuemart et pour le contenu régulier sont prévus pour générer automatiquement ces balises, 
le cas échéant à partir de SEO. De plus, vous serez en mesure de définir manuellement les balises à votre convenance page par page (une page est identifiée par son URL). 
Vous serez en mesure de fixer le titre contenu dans les balises h1, et d'enlever les balises générées par Joomla!, plus un tas d'autres changements SEO utiles.</p>
<p>Il n'y a pas de modification de Joomla!, juste un plugin standard, installé automatiquement avec sh404SEF.</p>
<p>Un grand merci à tous les contributeurs des précédentes versions 404SEF et 404SEFx</p>
<h2>Documentation</h2>

<h4>IMPORTANT : si vous prévoyez d'utiliser mod_rewrite (. htaccess) en réécriture :</h4>
<span class=h5>AVANT</span> d'activer ce composant  et d'utiliser ses fonctions de réécriture d'URL, 
<span class=h5>votre installation de Joomla devrait déjà être compatible avec la réécriture d'URL.</span>
Ce n'est pas nécessaire si vous  sélectionnez  dans les paramètres avancés de SH404SEF sans .htaccess (mais ce mode ne fonctionne pas toujours, cela dépend des paramètres de votre serveur).<br />
<br />
Rappelez-vous : si vous rencontrez des difficultés, il est peu probable que cela provienne de problème Joomla!, mais très probablement liée à la 
configuration de votre serveur. Par exemple, plusieurs fois, vous serez confronté à des erreurs 404 ou des erreurs 500 de serveur interne. 
Ceci indique qu'il y a dans votre fichier. htaccess quelque chose qui n'est pas compatible avec la configuration de votre serveur web.<br />
<br />
Si vous obtenez ce type d'erreur nous vous suggérons de contacter le service d'assistance de votre hébergeur. <br />
Si votre htaccess n'est pas compatible avec votre serveur web, ou avec l'hébergeur, il est inutile d'essayer d'utiliser sh404SEF (au moins la partie URL SEF de sh404SEF)
 - ou tout autre composant similaire - car vous serez simplement confrontés au même problème. Vous devez d'abord modifier votre installation, 
 en accordant une attention particulière à l'existence et le contenu de votre fichier .htaccess. 
 Toutefois, l'une des premières choses à contrôler, si vous utilisez le serveur web Apache : vérifier que le mod_rewrite est chargé par PHP. Pour ce faire, 
 dans le backend de Joomla, allez au menu Aide, puis Informations système. Sous l'onglet PHP information, il suffit d'exécuter une recherche avec le mot «rewrite». 
 Si vous ne trouvez rien, alors le mod_rewrite n'est pas chargé et rien ne marchera. Vous devez changer votre fichier httpd.conf  du serveur web Apache, 
 ou contactez votre administrateur système ou votre hébergeur pour le faire pour vous. D'autres serveurs Web tels que Microsoft IIS, nginx, LightHTTPD, 
 fournissent des fonctions similaires de réécriture d'URL, qui doivent aussi donc être activées dans la configuration du serveur web (elles seront par défaut activées pour la plupart d'entre eux)
<br /><br />

<p>Des conseils sur les .htaccess, une question très délicate apparue à plusieurs reprises, peuvent être trouvés en ligne <a target="_blank" href="http://anything-digital.com/sh404sef/faqs.html">dans notre FAQ</a>. En quelques mots :</p>
<ul>
	<li>Le .htaccess standard de Joomla! est très <span class=h5>BIEN</span>. Il fonctionne avec la plupart des hébergeurs. Il peut être utilisé sans modification, 
	au moins pour commencer. Rappelez-vous que le fichier htaccess.txt, doit être <span class=h5>renommé</span> en .htaccess avant toute utilisation.</li>
	<li>Si vous obtenez l'erreur 404 ou une erreur interne 500, ou similaire, en cliquant sur une URL réécrite, alors vous devriez essayer d'ajouter 
	un autre # au début de cette ligne (vers le début du fichier htaccess.) : <br />
	<br />
	Options FollowSymLinks <br />
	<br />
	de sorte qu'il ressemble à : <br />
	<br />
	#Options FollowSymLinks <br />
	<br />
	</li>
	<li>Si cela ne fonctionne pas, et si votre site Joomla est dans un sous-répertoire, vous devez chercher la ligne qui ressemble à : <br />
	#RewriteBase /<br />
	et la remplacer par : <br />RewriteBase /sous_dossier_de_votre_site_joomla<br />
	</li>
	<li>Sur certains serveurs, même si votre site n'est pas dans un sous-répertoire, vous pouvez essayer de remplacer : <br />
	#RewriteBase /<br />
	par <br />
	RewriteBase /<br />
	</li>
	<li>Un petit conseil : essayez de changer une seule chose à la fois, et vérifier le résultat avant de passer à l'étape suivante</li>
</ul>
<ol style="list-style-type: upper-roman;">
	<li>
	<h3>Introduction</h3>
	<p>Voici les principales informations requises pour utiliser sh404SEF. Vous pouvez consulter cette documentation à nouveau en sélectionnant le bouton 'Documentation sh404SEF' 
	à partir du panneau de contrôle sh404SEF.</p>
	<p>Veuillez noter qu'en aucune façon nous ne fournissons un support pour l'installation avec IIS. sh404SEF fonctionnera en général sur de telles machines, 
	en utilisant le mode 'sans htaccess' (/index.php/), mais les mêmes restrictions d'avoir les paramètres du serveur approprié s'applique, 
	tout comme lors de l'utilisation d'Apache ou d'autres serveurs Web. Les versions récentes d'IIS (7.x +) intègrent la réécriture des URL, mais nécessitent une configuration appropriée.</p>
	</li>
	<li>
	<h3>Installation et configuration</h3>
	<p>Vous pouvez consulter les instructions d'installation ci-dessous en cliquant sur la flèche appropriée.</p>
	<ol style="list-style-type: decimal;" id="collapsibleList">
		<li><script type="text/javascript">
					document.writeln('<img id="imgInstall" src="components/com_sh404sef/images/up.png" width="15" height="8" alt="Open list" onClick="toggle(\'imgInstall\',\'install\');">');
				</script> <span class="h4">Installation et configuration</span><br />
		<ul id="install" style="list-style: none;">
			<li>
			<ol>
				<li>Téléchargez le fichier zip en utilisant comme d'habitude l'installateur de composant de Joomla!</li>
				<li>Pour Apache, le fichier htaccess. livré avec Joomla doit normalement fonctionner! Cependant, vous pourriez devoir ajuster son contenu. Veuillez relire le premier paragraphe de cette documentation<br />
				</li>
				<li>Pour IIS, voir Configuration IIS</li>
				<li>Dans le backend de Joomla!, allez à Composants/sh404SEF/panneau de contrôle</li>
				<li>En utilisant l'onglet 'Démarrage', rubrique 'Activer l'optimisation des URL', cochez Oui, puis appuyez sur le bouton 'Démarrer' situé en dessous</li>
			</ol>
			</li>
		</ul>
		</li>
		<li><script type="text/javascript">document.writeln('<img id="imgIIS" src="components/com_sh404sef/images/up.png" width="15" height="8" alt="Open list" onClick="toggle(\'imgIIS\',\'iis\');">');
				</script> <span class="h4">Configuration IIS</span><br />
		<br />

		<ul id="iis" style="list-style: none">
			<li><span class=h5>IMPORTANT</span> : Nous ne fournissons pas de support pour IIS. Un certain nombre d'utilisateurs ont réalisé l'opération avec succès sur ce type de serveur web, 
			et donc si vous recherchez des informations ou si vous avez réussi la configuration de sh404SEF avec IIS et que vous souhaitez partager, 
			l'emplacement est <a target="_blank" href="http://anything-digital.com/forum/extension/sh404sef/">le forum</a>.
			Veuillez noter que de bons résultats ont été rapportés en utilisant le mode de fonctionnement de sh404SEF 'sans .htaccess' (/index.php/) au lieu d'essayer d'installer un moteur de réécriture dans IIS. 
			Si vous utilisez ce mode de fonctionnement, vous n'avez besoin que de sh404SEF. Cependant, encore une fois, 
			IIS peut avoir été configuré d'une manière où même ce mode ne peut pas travailler, donc veuillez vous reporter au  support/forum de sh404SEF, 
			ou au forum Joomla!  pour vous aider à la mise en place.<br />
			<br />
			</li>
		</ul>
		</li>
		<li><script type="text/javascript">document.writeln('<img id="imgUninstall" src="components/com_sh404sef/images/up.png" width="15" height="8" alt="Open list" onClick="toggle(\'imgUninstall\',\'uninstall\');">');
				</script> <span class="h4">Désinstallation</span><br />
		<ul id="uninstall" style="list-style: none;">
			<li>
			<ol>
				<li>Désinstaller le composant en utilisant comme d'habitude le désinstalleur de composant de Joomla!</li>
			</ol>
			</li>
		</ul>
		</li>
		
		<li><script type="text/javascript">document.writeln('<img id="imgUpgrading" src="components/com_sh404sef/images/up.png" width="15" height="8" alt="Open list" onClick="toggle(\'imgUpgrading\',\'upgrading\');">');
        </script> <span class="h4">Mise à jour</span><br />
    <ul id="upgrading" style="list-style: none;">
      <li>
      <ol>
        <li>Installez la nouvelle version que vous avez téléchargé depuis notre site web sur l'actuel, en utilisant l'installateur de Joomla! Tous les paramètres, les URL personnalisées ou automatiques, les titres, les balises meta 
        et les alias sont conservés lors de la mise à niveau, à moins que vous  ayez configuré sh404SEF à ne pas conserver tout ou partie de ces données 
        (voir panneau de contrôle/configuration/onglet Avancé).<br />
        </li>
      </ol>
      </li>
    </ul>
    </li>
    
	</ol>
	</li>
	<li>
	<h3>Conseils utiles pour l'utilisation de sh404SEF</h3>
	<ul style="list-style: none;">
		<li>
		<h4>Configuration</h4>

		<p>La configuration de sh404SEF est assez simple dans la plupart des cas. Pour plus d'informations sur chaque élément pointer votre souris sur les images en bleues (i) lorsque vous êtes dans l'écran de configuration.</p>
		<p>Lorsque vous enregistrez la configuration  vous devrez  peut-être supprimer toutes vos URL de la base de données, de sorte qu'elles soient par la suite recréées, 
		en tenant compte des nouveaux paramètres. <br/>
		La purge des URL s'effectue avec le bouton 'Purge' dans la barre d'outils du gestionnaire d'URL. 
		<strong>La suppression des URL est nécessaire uniquement si vous avez changé les paramètres affectant la manière de construire les URL</strong>, 
		comme le changement de suffixe .htm .html par exemple. Si vous avez un site à fort trafic, il peut être judicieux de le mettre hors ligne avant de purger la base de données.
		<span class=h5>Après avoir fait cela, vous devriez utiliser un outil <strong>en ligne</strong>
		de génération de plan de site ("sitemap"). </span>. Le générateur de sitemap va parcourir la totalité de votre site, 
		et donc tous vos liens, de sorte qu'ils seront tous automatiquement placé dans le cache, ce qui accélère l'accès pour les prochains visiteurs.<br>
		Le système de cache de sh404SEF est transparent, et sera automatiquement reconstruit sur une base régulière. L'utilisation du cache accélère considérablement le temps de chargement d'une page, 
		en réduisant considérablement le nombre de requêtes vers la base de données. 
		Attention, la mise en cache des URL utilise beaucoup de mémoire. Sa taille peut être limitée en utilisant le paramètre approprié, et il peut également être désactivée complètement.
		</p>
		<p>Si vous avez un site multilingue, vous pouvez activer ou désactiver la traduction URL. Normalement, les URL seront traduites dans la langue de l'utilisateur. 
		Toutefois, il est parfois préférable de ne pas traduire, comme par exemple lorsque vous utilisez dans la langue des caractères non-latin. 
		En de telles occasions, la langue par défaut du site sera toujours utilisée</p>
		<p></p>

		<p>Vous voudrez peut-être purger le journal des erreurs 404 avant de créer des URL nouvelles.</p>
		</li>
		<li>
		<h4>Modification des URL</h4>
		<p>Vous pouvez modifier les URL à votre convenance. Allez dans le Panneau de contrôle de sh404SEF, dans l'onglet URL. Sélectionnez l'URL que vous souhaitez modifier, changez son URL SEF et cliquez sur Enregistrer. Les URL qui ont été modifiés dans la version créée par 
		sh404SEF sont marqués dans la liste avec une icône de verrouillage. Elles ne seront pas supprimées lorsque vous effectuez une purge globale, mais seulement si vous les supprimer explicitement.
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
Compléments traduction française Jacky Bondoux alias socrates et Philippe Véron alias vezid<br/>
Distributed under the terms of the GNU General Public License.</div>
</div>
