<?php

/* @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: fr.postinstall.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

if (file_exists(JPATH_ROOT.DS.'plugins'.DS.'system'.DS. 'sh404sef'.DS.'sh404sef.php')) :

?>
  <div style="text-align: justify;">
  <h1>sh404SEF a été installé avec succès! merci de lire ce qui suit :</h1>
  
  Cette extension
  <ul>
  <li>re-écrit les URL de Joomla! pour améliorer l'ergonomie et le référencement</li>
  <li>apporte de nombreuses améliorations à Joomla! au niveau référencement</li>
  <li>ajoute des fonctions de sécurité</li>
  <li>insère un code Google Analytics dans les pages, et affiche des rapports Analytics dans son panneau de contrôle</li>
  </ul>

  <br />
  
  Si c'est la première fois que vous installez sh404SEF, il a bien été installé, mais la plupart de ses fonctions sont <strong>désactivées</strong> pour l'instant.
   Vous devez aller sur le panneau de contrôle (depuis le menu <a href="index.php?option=com_sh404sef" >Composants / sh404SEF</a> de Joomla!),
    <strong>activer ce que vous souhaitez utiliser et valider</strong> avant que sh404SEF ne soit activé. 
    Avant que vous ne fassiez cela, merci de lire les quelques paragraphes qui suivent, dans lesquels se trouvent des informations importantes.
   Si vous effectuez une mise à jour depuis une version précédente de sh404SEF, 
    alors tous vos réglages ont été préservés, le composant est actif et vous pouvez recommencer à naviguer sur votre site normalement.
  <br /><br />
  <strong><font color="red">IMPORTANT</font></strong> : la partie "URL" de sh404SEF peut fonctionner suivant deux modes : 
  <strong><font color="red">AVEC</font></strong> ou <strong><font color="red">SANS fichier .htaccess</font></strong>. 
  Le réglage par défaut est maintenant <strong>sans fichier .htaccess</strong>. Je vous recommende ce réglage si vous n'êtes pas très familier
  avec le fait de régler un serveur web, 
  dans la mesure où il peut quelquefois être difficile de trouver le contenu approprié pour un fichier .htaccess.
  <br /><br />
  <strong>Sans fichier .htaccess</strong> : Utilisez <strong>Activer l'optimisation d'URL</strong> sur le panneau de contrôle de sh404SEF pour l'activer. 
  Vous devriez passer en revue les différents réglages disponibles sur l'onglet <strong>Configuration</strong>, 
  mais ce n'est pas absolument nécessaire, car les réglages par défaut ont été soigneusement choisis pour donner les meilleurs résultats dans la plupart des cas
  sans modification.
  Si vous deviez les modifier, assurez-vous de bien les lire les bulles d'aide en face de chaque réglage. Vous pouvez dés à présent naviguer sur la page
  d'accueil de votre site pour générer les URL SEF. 
  <br />
  <strong>Avec .htaccess</strong> : vous devez choisir ce mode spécifiquement. Sur le panneau de contrôle de sh404SEF, vous verrez pour cela une liste de sélection pour changer le <strong>Mode de re-écriture</strong>. 
  Vous pourrez ensuite activer l'optimisation des URL comme décrit ci-dessus. 
  Néanmoins, avant de faire cela, vous devez préparez un fichier .htaccess. Le contenu de ce fichier dépend de votre serveur web, 
  et il n'est donc pas possible de vous dire exactement ce qu'il doit contenir. 
  Joomla! propose un fichier .htaccess très générique. Il fonctionnera probablement immédiatement sur votre serveur, mais peut quelquefois requérir des ajustements. 
  Le fichier de Joomla! est par défaut appelé htaccess.txt, se situe à la racine de votre site, et doit être renommé en .htaccess pour qu'il prenne effet. 
  Vous trouverez des informations supplémentaires en Anglais sur les fichiers .htaccess à l'adresse <a target="_blank" href="http://anything-digital.com/sh404sef/faqs.html">anything-digital.com/sh404sef/faqs.html</a>.<br /><br />
  <strong><font color="red">IMPORTANT</font></strong>: sh404SEF peut produire des URL SEF pour beaucoup de composants Joomla!. 
  Il utilise pour cela un système de <strong>"plugin"</strong> (ou greffon), et est livré avec un plugin pour chacun des composants standards de Joomla! (Contact, Weblinks, Newsfeed, Articles,...). 
  Il dispose également de plugins pour des composants courants comme Community Builder, JomSocial, Kunena, Virtuemart, Sobi2,... 
  sh404SEF peut également automatiquement utiliser les plugins conçus pour le système SEF de Joomla: les fichiers router.php. 
  La plupart du temps, les plugins sont installés automatiquement quand vous installez une extension. 
  Veuillez noter que lorsque vous utilisez l'un de ces plugins non "natif", le fonctionnement peut être dégradé.
  <br />
  Malgré tout, Joomla! disposant de plusieurs milliers d'extensions, il n'est pas possible d'avoir des plugins pour chacune d'entre elles, et dans une telle situation, 
  sh404SEF se rabattra vers une URL simplifiée du type: monsite.fr/component/option,com_sample/task,view/id,23/Itemid,45/. 
  C'est normal et ne peut être amélioré que si un plugin pour l'extension en questione est créé. 
  Merci de poster sur le forum si jamais vous souhaitez mettre à disposition un plugin que vous avez créé.<br />
  <br />
  Vous trouverez d'autres informations sur <a target="_blank" href="http://anything-digital.com/sh404sef/user-manual.html">notre site</a>
  <br />

  <p class="message">Merci <strong>de lire la documentation</strong> accessible par <a href="index.php?option=com_sh404sef&task=info" >le panneau de contrôle de sh404SEF</a></p>
  </div>

<?php
 
  else :
    
?>
    
  <strong><font color="red">Désolé, une erreur s'est produite pendant l'installation de sh404SEF sur votre site.</font></strong> 
  Essayez dans un premier temps de désinstaller l'extension, vérifier que les permissions d'accès aux fichiers permettent l'écriture, en particulier ue Joomla! puisse écrire dans le dossier /plugins. 
  Ou bien contacter votre administrateur technique pour de l'aide. <br>Vous pouvez vous rendre également sur notre site et décrire votre problème, en Anglais, sur notre site, <a target="_blank" href="http://anything-digital.com/forum/extension/sh404sef/" >sur le forum de support spécifique</a>

<?php

  endif;

