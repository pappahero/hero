<?PHP
//
// PHASE: BOOTSTRAP
define('HERO_INSTALL_PATH', dirname(__FILE__));
define('HERO_SITE_PATH', HERO_INSTALL_PATH . '/site');

require(HERO_INSTALL_PATH.'/src/CHero/bootstrap.php');

$he = CHero::Instance();

//
// PHASE: FRONTCONTROLLER ROUTE
// Tolkar ut kontroller- och metodanrop
$he->FrontControllerRoute();

//
// PHASE: THEME ENGINE RENDER
// Skapar webbsidan via templatefiler
$he->ThemeEngineRender();

?>