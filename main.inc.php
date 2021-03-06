<?php
/*
Plugin Name: SupervisorAlbum
Version: 1.2
Description: Plugin pour ajouter un supervisor à un album.
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=883
Author: Teatek
Author URI: https://github.com/Teatek/
*/

//Vérifiez si nous sommes bien inclus par Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

if (basename(dirname(__FILE__)) != 'SupervisorAlbum')
{
  add_event_handler('init', 'supervisor_error');

  function supervisor_error()
  {
    global $page;
    $page['errors'][] = 'SupervisorAlbum folder name is incorrect, uninstall the plugin and rename it to "SupervisorAlbum"';
  }
  return;
}

// +-----------------------------------------------------------------------+
// | Define plugin constants                                               |
// +-----------------------------------------------------------------------+
global $prefixeTable, $conf;

define('SUPERVISOR_ID',      basename(dirname(__FILE__)));
// Defini le chemin de notre plugin.
define('SUPERVISOR_PATH', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
define('SUPERVISOR_TABLE' , $prefixeTable . 'supervisor');
define('SUPERVISOR_ADMIN',   get_root_url() . 'admin.php?page=plugin-' . SUPERVISOR_ID);
define('SUPERVISOR_PUBLIC',  get_root_url() . 'index.php');
define('SUPERVISOR_DIR',     PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'supervisor/');


// +-----------------------------------------------------------------------+
// | Add event handlers                                                    |
// +-----------------------------------------------------------------------+
// init the plugin
add_event_handler('init', 'supervisor_init');

// trigger pour afficher la page d'administration.
add_event_handler('get_admin_plugin_menu_links', 'supervisor_admin_menu');


// Ajout un menu admin du plugin
function supervisor_admin_menu($menu) {
 array_push(
   $menu,
   array(
     'NAME'  => 'SupervisorAlbum',
     'URL'   => get_admin_plugin_menu_link(dirname(__FILE__)).'/admin/admin.php'
   )
 );
 return $menu;
}

add_event_handler('loc_end_section_init', 'supervisor_end_section_init');


function supervisor_end_section_init()
{
   global $page;

   if(isset($page['category']['id']) && isset($page['comment']))
   {
     $idCategorie = $page['category']['id'];

     $query = '
  SELECT champs FROM '.SUPERVISOR_TABLE.
  ' s INNER JOIN '.CATEGORIES_TABLE.' c on c.id_supervisor = s.id'.
  ' WHERE c.id='.$idCategorie;

    $supervisor = query2array($query);
    foreach ($supervisor as $key => $valeur)
    {
      if(isset($page['comment']))
      {
        $page['comment'] = $page['comment'].'</div><div class="additional_info">'.$valeur['champs'];
      }
    }
   }
}


function Supervisor_init()
{
  global $conf;


  // prepare plugin configuration
  $conf['supervisor'] = safe_unserialize($conf['supervisor']);
}
