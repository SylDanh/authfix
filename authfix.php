<?php
class authfix extends Plugins {
  public function enableAction (&$context, &$error) {
    if(!parent::_checkRights(LEVEL_ADMINLODEL)) { return; }
  }

  public function disableAction (&$context, &$error) {
    if(!parent::_checkRights(LEVEL_ADMINLODEL)) { return; }
  }

  public function preview (&$context)	{
    // Bloquer l'export du modèle éditorial pour les utilisateurs non adminlodel
    if(!C::get('adminlodel', 'lodeluser') && (C::get('do') == 'backupmodel' || C::get('do') == 'backupxmlmodel')) {
      trigger_error("ERROR: you don't have the right to access this feature", E_USER_ERROR);
    }
  }

  public function postview (&$context)	{
    // trigger_error dans preview() ne suffit pas pour bloquer l'affichage :-/
    if(!C::get('adminlodel', 'lodeluser') && (C::get('do') == 'backupmodel' || C::get('do') == 'backupxmlmodel')) {
      View::$page = "";
      return;
    }
    // Supprimer les liens dans l'admin d'export du ME dans l'admin
    if(!defined('backoffice-admin') || C::get('adminlodel', 'lodeluser')) { return; }
    View::$page = preg_replace('/<li><a href="index\.php\?do=backup(xml)?model.*<\/li>/im',
    '', View::$page);
  }
}
?>