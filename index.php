<?PHP
//
// PHASE: BOOTSTRAP
// Grunderna för varje förfrågan definieras
define('LYDIA_INSTALL_PATH', dirname(__FILE__));
// = http://www.student.bth.se/~hero10/herolydia dirname ger parentdir of index.php
define('LYDIA_SITE_PATH', LYDIA_INSTALL_PATH . '/site');
// = http://www.student.bth.se/~hero10/herolydia/site

require(LYDIA_INSTALL_PATH.'/src/CLydia/bootstrap.php');

$ly = CLydia::Instance();
// Globalt objekt som är kärnan i ramverket

//
// PHASE: FRONTCONTROLLER ROUTE
// Tolkar ut kontroller- och metodanrop
$ly->FrontControllerRoute();

//
// PHASE: THEME ENGINE RENDER
// Skapar webbsidan via templatefiler
$ly->ThemeEngineRender();

?>