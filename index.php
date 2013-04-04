<?PHP
//
// PHASE: BOOTSTRAP
// Initieringsfasen för det som kommer behövas i varje förfrågan
define('LYDIA_INSTALL_PATH', dirname(__FILE__));
define('LYDIA_SITE_PATH', LYDIA_INSTALL_PATH . '/site');

require(LYDIA_INSTALL_PATH.'/src/CLydia/bootstrap.php');

$ly = CLydia::Instance();


//
// PHASE: FRONTCONTROLLER ROUTE
// Tolkar vilken kontroller och metod som ska anropas. Sedan sker bearbetning i 
// kontrollern
$ly->FrontControllerRoute();

//
// PHASE: THEME ENGINE RENDER
// Skapar webbsidan. m h a template-filer överförs innehållet till html-filer
$ly->ThemeEngineRender();

?>