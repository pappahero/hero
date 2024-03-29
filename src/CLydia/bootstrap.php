<?php
/**
* Bootstrapping, setting up and loading the core.
*
* @package LydiaCore
*/

/**
* Enable auto-load of class declarations.
Laddar in en fil/class n�r man skapar ett objekt med new, s� slipper man g�ra require*/
// Den letar f�rst src och sedan i site/src
function autoload($aClassName) {
  $classFile = "/src/{$aClassName}/{$aClassName}.php";
   $file1 = LYDIA_INSTALL_PATH . $classFile;
   $file2 = LYDIA_SITE_PATH . $classFile;
     if(is_file($file1)) {
    require_once($file1);
  } elseif(is_file($file2)) {
    require_once($file2);
  }
}

spl_autoload_register('autoload');

/**
* Helper, wrap html_entites with correct character encoding
*/
function htmlent($str, $flags = ENT_COMPAT) {
  return htmlentities($str, $flags, CLydia::Instance()->config['character_encoding']);
}

?>