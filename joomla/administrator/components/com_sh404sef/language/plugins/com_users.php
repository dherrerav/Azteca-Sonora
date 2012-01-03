<?php
/**
 * SEF extension for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_users.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');
  
  // français
  $sh_LANG['fr']['COM_SH404SEF_REGISTRATION'] = '';
  $sh_LANG['fr']['COM_SH404SEF_LOST_PASSWORD'] = 'Mot de passe oublie';
  $sh_LANG['fr']['COM_SH404SEF_REGISTER'] = 'Creer un compte';
  $sh_LANG['fr']['COM_SH404SEF_LOGIN'] = 'S identifier';
  $sh_LANG['fr']['COM_SH404SEF_ACTIVATE'] = 'Activer compte';
  $sh_LANG['fr']['COM_SH404SEF_VIEW_DETAILS'] = 'Voir vos infos utilisateur';
  $sh_LANG['fr']['COM_SH404SEF_EDIT_DETAILS'] = 'Modifier infos utilisateur';
  $sh_LANG['fr']['COM_SH404SEF_REMIND_USER_NAME'] = 'Nom oublie';
  $sh_LANG['fr']['COM_SH404SEF_LOGOUT'] = 'Se deconnecter';
  
  // english
  $sh_LANG['en']['COM_SH404SEF_REGISTRATION'] = '';
  $sh_LANG['en']['COM_SH404SEF_LOST_PASSWORD'] = 'Lost password';
  $sh_LANG['en']['COM_SH404SEF_REGISTER'] = 'Create an account';
  $sh_LANG['en']['COM_SH404SEF_LOGIN'] = 'Log in';
  $sh_LANG['en']['COM_SH404SEF_ACTIVATE'] = 'Activate account';
  $sh_LANG['en']['COM_SH404SEF_VIEW_DETAILS'] = 'View your user details';
  $sh_LANG['en']['COM_SH404SEF_EDIT_DETAILS'] = 'Edit user details';
  $sh_LANG['en']['COM_SH404SEF_REMIND_USER_NAME'] = 'Lost user name';
  $sh_LANG['en']['COM_SH404SEF_LOGOUT'] = 'Logout';
  
  // spanish
  $sh_LANG['es']['COM_SH404SEF_REGISTRATION'] = '';
  $sh_LANG['es']['COM_SH404SEF_LOST_PASSWORD'] = 'Contraseña perdida';
  $sh_LANG['es']['COM_SH404SEF_REGISTER'] = 'Crear una cuenta';
  $sh_LANG['es']['COM_SH404SEF_LOGIN'] = 'Entrar';
  $sh_LANG['es']['COM_SH404SEF_ACTIVATE'] = 'Validacion cuenta';
  $sh_LANG['es']['COM_SH404SEF_VIEW_DETAILS'] = 'View your user details';
  $sh_LANG['es']['COM_SH404SEF_EDIT_DETAILS'] = 'Edit user details';
  $sh_LANG['es']['COM_SH404SEF_REMIND_USER_NAME'] = 'Lost user name';
  $sh_LANG['es']['COM_SH404SEF_LOGOUT'] = 'Logout';
  
  // german
  $sh_LANG['de']['COM_SH404SEF_REGISTRATION'] = '';
  $sh_LANG['de']['COM_SH404SEF_LOST_PASSWORD'] = 'Passwort vergessen';
  $sh_LANG['de']['COM_SH404SEF_REGISTER'] = 'Neuen Account anlegen';
  $sh_LANG['de']['COM_SH404SEF_LOGIN'] = 'Anmelden';
  $sh_LANG['de']['COM_SH404SEF_ACTIVATE'] = 'Activate account';
  $sh_LANG['de']['COM_SH404SEF_VIEW_DETAILS'] = 'View your user details';
  $sh_LANG['de']['COM_SH404SEF_EDIT_DETAILS'] = 'Edit user details';
  $sh_LANG['de']['COM_SH404SEF_REMIND_USER_NAME'] = 'Lost user name';
  $sh_LANG['de']['COM_SH404SEF_LOGOUT'] = 'Logout';
  
  // hungarian : translation by Jozsef Tamas Herczeg 2007-05-25
  $sh_LANG['hu']['COM_SH404SEF_REGISTRATION'] = '';
  $sh_LANG['hu']['COM_SH404SEF_LOST_PASSWORD'] = 'Elfelejtett jelszó';
  $sh_LANG['hu']['COM_SH404SEF_REGISTER'] = 'Fiók létrehozása';
  $sh_LANG['hu']['COM_SH404SEF_LOGIN'] = 'belépés';
  $sh_LANG['hu']['COM_SH404SEF_ACTIVATE'] = 'Fiók aktiválása';
  $sh_LANG['hu']['COM_SH404SEF_VIEW_DETAILS'] = 'Adatok megtekintese';
  $sh_LANG['hu']['COM_SH404SEF_EDIT_DETAILS'] = 'Edit user details';
  $sh_LANG['hu']['COM_SH404SEF_REMIND_USER_NAME'] = 'Lost user name';
  $sh_LANG['hu']['COM_SH404SEF_LOGOUT'] = 'Logout';
  
  // italiano
  $sh_LANG['it']['COM_SH404SEF_REGISTRATION'] = '';
  $sh_LANG['it']['COM_SH404SEF_LOST_PASSWORD'] = 'Password dimenticata';
  $sh_LANG['it']['COM_SH404SEF_REGISTER'] = 'Registrati';
  $sh_LANG['it']['COM_SH404SEF_LOGIN'] = 'Entra';
  $sh_LANG['it']['COM_SH404SEF_ACTIVATE'] = 'Activate account';
  $sh_LANG['it']['COM_SH404SEF_VIEW_DETAILS'] = 'View your user details';
  $sh_LANG['it']['COM_SH404SEF_EDIT_DETAILS'] = 'Edit user details';
  $sh_LANG['it']['COM_SH404SEF_REMIND_USER_NAME'] = 'Lost user name';
  $sh_LANG['it']['COM_SH404SEF_LOGOUT'] = 'Logout';
  
  // dutch
  $sh_LANG['nl']['COM_SH404SEF_REGISTRATION'] = '';
  $sh_LANG['nl']['COM_SH404SEF_LOST_PASSWORD'] = 'Wachtwoord vergeten';
  $sh_LANG['nl']['COM_SH404SEF_REGISTER'] = 'Maak een account';
  $sh_LANG['nl']['COM_SH404SEF_LOGIN'] = 'Log-in';
  $sh_LANG['nl']['COM_SH404SEF_ACTIVATE'] = 'Activeer account';
  $sh_LANG['nl']['COM_SH404SEF_VIEW_DETAILS'] = 'Bekijk uw gebruikers eigenschappen';
  $sh_LANG['nl']['COM_SH404SEF_EDIT_DETAILS'] = 'Edit user details';
  $sh_LANG['nl']['COM_SH404SEF_REMIND_USER_NAME'] = 'Lost user name';
  $sh_LANG['nl']['COM_SH404SEF_LOGOUT'] = 'Logout';
  
  // romanian
  $sh_LANG['ro']['COM_SH404SEF_REGISTRATION'] = '';
  $sh_LANG['ro']['COM_SH404SEF_LOST_PASSWORD'] = 'Am pierdut parola';
  $sh_LANG['ro']['COM_SH404SEF_REGISTER'] = 'Creaza cont nou';
  $sh_LANG['ro']['COM_SH404SEF_LOGIN'] = 'Autentificare';
  $sh_LANG['ro']['COM_SH404SEF_ACTIVATE'] = 'Activeaza cont';
  $sh_LANG['ro']['COM_SH404SEF_VIEW_DETAILS'] = 'Vezi detaliile user-ului tau';
  $sh_LANG['ro']['COM_SH404SEF_EDIT_DETAILS'] = 'Edit user details';
  $sh_LANG['ro']['COM_SH404SEF_REMIND_USER_NAME'] = 'Am pierdut username';
  $sh_LANG['ro']['COM_SH404SEF_LOGOUT'] = 'Logout';
?>
