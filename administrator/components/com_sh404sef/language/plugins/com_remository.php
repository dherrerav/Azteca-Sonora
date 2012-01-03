<?php
/**
 * SEF extension for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_remository.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');
  
  // français
  $sh_LANG['fr']['_SH404SEF_REMO_DOC_DOWNLOAD'] = 'Télécharger';
  $sh_LANG['fr']['_SH404SEF_REMO_DOC_SELECT'] = 'Choisir';
  $sh_LANG['fr']['_SH404SEF_REMO_DOC_ADD'] = 'Envoyer'; 
  $sh_LANG['fr']['_SH404SEF_REMO_SEARCH_DOC'] = 'Rechercher';
  $sh_LANG['fr']['_SH404SEF_REMO_DOC_ADD_MANY'] = 'Envoi multiple';
  $sh_LANG['fr']['_SH404SEF_REMO_DOC_DETAILS'] = 'Voir details'; 
  $sh_LANG['fr']['_SH404SEF_REMO_THUMB_UPDATE'] = 'Modifier vignette';
  $sh_LANG['fr']['_SH404SEF_REMO_USER_UPDATE'] = 'Modifier details';
  $sh_LANG['fr']['_SH404SEF_REMO_RSS'] = 'Lien RSS';
  $sh_LANG['fr']['_SH404SEF_REMO_DOC_START_DOWNLOAD'] = 'Demarrer telechargement';
    
  // english
  $sh_LANG['en']['_SH404SEF_REMO_DOC_DOWNLOAD'] = 'Download';
  $sh_LANG['en']['_SH404SEF_REMO_DOC_SELECT'] = 'Select';
  $sh_LANG['en']['_SH404SEF_REMO_DOC_ADD'] = 'Upload'; 
  $sh_LANG['en']['_SH404SEF_REMO_SEARCH_DOC'] = 'Search';
  $sh_LANG['en']['_SH404SEF_REMO_DOC_ADD_MANY'] = 'Upload many';
  $sh_LANG['en']['_SH404SEF_REMO_DOC_DETAILS'] = 'View details'; 
  $sh_LANG['en']['_SH404SEF_REMO_THUMB_UPDATE'] = 'Update thumb';
  $sh_LANG['en']['_SH404SEF_REMO_USER_UPDATE'] = 'Update file';
  $sh_LANG['en']['_SH404SEF_REMO_RSS'] = 'RSS feed';
  $sh_LANG['en']['_SH404SEF_REMO_DOC_START_DOWNLOAD'] = 'Start download';

  // spanish
  $sh_LANG['es']['_SH404SEF_REMO_DOC_DOWNLOAD'] = 'Descargar';
  $sh_LANG['es']['_SH404SEF_REMO_DOC_SELECT'] = 'elegir';
  $sh_LANG['es']['_SH404SEF_REMO_DOC_ADD'] = 'Upload'; 
  $sh_LANG['es']['_SH404SEF_REMO_SEARCH_DOC'] = 'Buscar';
  $sh_LANG['es']['_SH404SEF_REMO_DOC_ADD_MANY'] = 'Upload multiple';
  $sh_LANG['es']['_SH404SEF_REMO_DOC_DETAILS'] = 'Ver detalles'; 
  $sh_LANG['es']['_SH404SEF_REMO_THUMB_UPDATE'] = 'Update thumb';
  $sh_LANG['es']['_SH404SEF_REMO_USER_UPDATE'] = 'Update archivo';
  $sh_LANG['es']['_SH404SEF_REMO_RSS'] = 'RSS feed';
  $sh_LANG['es']['_SH404SEF_REMO_DOC_START_DOWNLOAD'] = 'Empezar descargamiento'; 
  
  // german
  $sh_LANG['de']['_SH404SEF_REMO_DOC_DOWNLOAD'] = 'Download';
  $sh_LANG['de']['_SH404SEF_REMO_DOC_SELECT'] = 'Select';
  $sh_LANG['de']['_SH404SEF_REMO_DOC_ADD'] = 'Upload'; 
  $sh_LANG['de']['_SH404SEF_REMO_SEARCH_DOC'] = 'Search';
  $sh_LANG['de']['_SH404SEF_REMO_DOC_ADD_MANY'] = 'upload many';
  $sh_LANG['de']['_SH404SEF_REMO_DOC_DETAILS'] = 'View details'; 
  $sh_LANG['de']['_SH404SEF_REMO_THUMB_UPDATE'] = 'Update thumb';
  $sh_LANG['de']['_SH404SEF_REMO_USER_UPDATE'] = 'Update file';
  $sh_LANG['de']['_SH404SEF_REMO_RSS'] = 'RSS feed';
  $sh_LANG['de']['_SH404SEF_REMO_DOC_START_DOWNLOAD'] = 'Start download';  
  
  // hungarian : translation by Jozsef Tamas Herczeg 2007-08-15
  $sh_LANG['hu']['_SH404SEF_REMO_DOC_DOWNLOAD'] = 'Letöltés';
  $sh_LANG['hu']['_SH404SEF_REMO_DOC_SELECT'] = 'Választás';
  $sh_LANG['hu']['_SH404SEF_REMO_DOC_ADD'] = 'Feltöltés'; 
  $sh_LANG['hu']['_SH404SEF_REMO_SEARCH_DOC'] = 'Keresés';
  $sh_LANG['hu']['_SH404SEF_REMO_DOC_ADD_MANY'] = 'Tömeges feltöltés';
  $sh_LANG['hu']['_SH404SEF_REMO_DOC_DETAILS'] = 'Részletek megtekintése'; 
  $sh_LANG['hu']['_SH404SEF_REMO_THUMB_UPDATE'] = 'Bélyegkép frissítése';
  $sh_LANG['hu']['_SH404SEF_REMO_USER_UPDATE'] = 'Fájl frissítése';
  $sh_LANG['hu']['_SH404SEF_REMO_RSS'] = 'RSS-csatorna';
  $sh_LANG['hu']['_SH404SEF_REMO_DOC_START_DOWNLOAD'] = 'Letöltés indítása';
  
  // italiano
  $sh_LANG['it']['_SH404SEF_REMO_DOC_DOWNLOAD'] = 'Download';
  $sh_LANG['it']['_SH404SEF_REMO_DOC_SELECT'] = 'Select';
  $sh_LANG['it']['_SH404SEF_REMO_DOC_ADD'] = 'Upload'; 
  $sh_LANG['it']['_SH404SEF_REMO_SEARCH_DOC'] = 'Search';
  $sh_LANG['it']['_SH404SEF_REMO_DOC_ADD_MANY'] = 'upload many';
  $sh_LANG['it']['_SH404SEF_REMO_DOC_DETAILS'] = 'View details'; 
  $sh_LANG['it']['_SH404SEF_REMO_THUMB_UPDATE'] = 'Update thumb';
  $sh_LANG['it']['_SH404SEF_REMO_USER_UPDATE'] = 'Update file';
  $sh_LANG['it']['_SH404SEF_REMO_RSS'] = 'RSS feed';
  $sh_LANG['it']['_SH404SEF_REMO_DOC_START_DOWNLOAD'] = 'Start download';
  
  // dutch
  $sh_LANG['nl']['_SH404SEF_REMO_DOC_DOWNLOAD'] = 'Download';
  $sh_LANG['nl']['_SH404SEF_REMO_DOC_SELECT'] = 'Selecteer';
  $sh_LANG['nl']['_SH404SEF_REMO_DOC_ADD'] = 'Upload'; 
  $sh_LANG['nl']['_SH404SEF_REMO_SEARCH_DOC'] = 'Zoek';
  $sh_LANG['nl']['_SH404SEF_REMO_DOC_ADD_MANY'] = 'Upload meerdere';
  $sh_LANG['nl']['_SH404SEF_REMO_DOC_DETAILS'] = 'Bekijk eigenschappen'; 
  $sh_LANG['nl']['_SH404SEF_REMO_THUMB_UPDATE'] = 'Update thumbnail';
  $sh_LANG['nl']['_SH404SEF_REMO_USER_UPDATE'] = 'Update bestand';
  $sh_LANG['nl']['_SH404SEF_REMO_RSS'] = 'RSS feed';
  $sh_LANG['nl']['_SH404SEF_REMO_DOC_START_DOWNLOAD'] = 'Start download';
  
  // romanian
  $sh_LANG['ro']['_SH404SEF_REMO_DOC_DOWNLOAD'] = 'Descarca';
  $sh_LANG['ro']['_SH404SEF_REMO_DOC_SELECT'] = 'Selecteaza';
  $sh_LANG['ro']['_SH404SEF_REMO_DOC_ADD'] = 'Incarca'; 
  $sh_LANG['ro']['_SH404SEF_REMO_SEARCH_DOC'] = 'Cauta';
  $sh_LANG['ro']['_SH404SEF_REMO_DOC_ADD_MANY'] = 'Incarca mai multe';
  $sh_LANG['ro']['_SH404SEF_REMO_DOC_DETAILS'] = 'Vezi detalii'; 
  $sh_LANG['ro']['_SH404SEF_REMO_THUMB_UPDATE'] = 'Actualizeaza thumb';
  $sh_LANG['ro']['_SH404SEF_REMO_USER_UPDATE'] = 'Actualizeaza fisier';
  $sh_LANG['ro']['_SH404SEF_REMO_RSS'] = 'Flux RSS';
  $sh_LANG['ro']['_SH404SEF_REMO_DOC_START_DOWNLOAD'] = 'Porneste descarcarea';

?>
