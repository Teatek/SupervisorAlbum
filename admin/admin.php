<?php
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

//Va chercher le modèle.
global $template;

// Ajout du template dans le template globale
$template->set_filenames(
 array(
   'plugin_admin_content' => dirname(__FILE__).'/admin.tpl'
 )
);

// Assign the template contents to ADMIN_CONTENT
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
?>
