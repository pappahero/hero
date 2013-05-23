<?PHP
//
// PHASE: BOOTSTRAP
// Grunderna f�r varje f�rfr�gan definieras
define('HERO_INSTALL_PATH', dirname(__FILE__));
// = http://www.student.bth.se/~hero10/herolydia dirname ger parentdir of index.php
define('HERO_SITE_PATH', HERO_INSTALL_PATH . '/site');
// = http://www.student.bth.se/~hero10/herolydia/site

require(HERO_INSTALL_PATH.'/src/CHero/bootstrap.php');

$he = CHero::Instance();
// Globalt objekt som �r k�rnan i ramverket

//
// PHASE: FRONTCONTROLLER ROUTE
// Tolkar ut kontroller- och metodanrop
$he->FrontControllerRoute();

//
// PHASE: THEME ENGINE RENDER
// Skapar webbsidan via templatefiler
$he->ThemeEngineRender();

?>