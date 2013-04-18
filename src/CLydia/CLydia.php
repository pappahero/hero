<?php
/**
 * Main class for Lydia, holds everything.
 *
 * @package LydiaCore
 */
class CLydia implements ISingleton {

  private static $instance = null;
  public $config = null;
  public $request = null;
  public $data = null;
  public $db = null;
  public $views;
  public $session;
  public $timer = array();

  /**
   * Constructor
   */
  protected function __construct() {
  	  // time page generation
  	  $this->timer['first'] = microtime(true); 
  	  
    // &this s� at $ly kan skickas som referens och anv�ndas i config.php
    $ly = &$this;
    require(LYDIA_SITE_PATH.'/config.php');
    
    // Start a named session
    session_name($this->config['session_name']);
    session_start();
    $this->session = new CSession($this->config['session_key']);
    $this->session->PopulateFromSession();

    // Set default date/time-zone
    date_default_timezone_set($this->config['timezone']);
    
    // Create a database object.
   if(isset($this->config['database'][0]['dsn'])) {
   $this->db = new CMDatabase($this->config['database'][0]['dsn']);
   
  }
  
     // Create a container for all views and theme data
     $this->views = new CViewContainer();
}  
  
  /**
   * Singleton pattern. Get the instance of the latest created object or create a new one. 
   * @return CLydia The instance of this class.
   */
  public static function Instance() {
    /*if(self::$instance == null) {
      self::$instance = new CLydia();
    }*/
	if( ! (self::$instance instanceof self) ) {
		self::$instance = new self();
		}
		return self::$instance;
	}
	// Mer genrell, kan anv�ndas vid andra singleton patterns ocks�
   
   // Frontcontroller, check url and route to controllers.
  public function FrontControllerRoute() {
    // Dela in url i controller, method, argument och lagra i variabler
    $this->request = new CRequest($this->config['url_type']);
    $this->request->Init($this->config['base_url']);
    $controller = $this->request->controller;
    $method     = $this->request->method;
    // $formattedMethod = str_replace(array('_', '-'), '', $method);
    $arguments  = $this->request->arguments;
    
    // Is the controller enabled in config.php?
    $controllerExists   = isset($this->config['controllers'][$controller]);
    $controllerEnabled   = false;
    $className          = false;
    $classExists         = false;

    if($controllerExists) {
      $controllerEnabled   = ($this->config['controllers'][$controller]['enabled'] == true);
      $className          = $this->config['controllers'][$controller]['class'];
      $classExists         = class_exists($className);
    }
    
    // Kolla om kontrollern har en metod, anropa den i så fall
    if($controllerExists && $controllerEnabled && $classExists) {
      $rc = new ReflectionClass($className);
      if($rc->implementsInterface('IController')) 
      {
	$formattedMethod = str_replace(array('_', '-'), '', $method);      	      
        if($rc->hasMethod($formattedMethod)) 
        {
          $controllerObj = $rc->newInstance();
          $methodObj = $rc->getMethod($formattedMethod);
          if($methodObj->isPublic()) {
          $methodObj->invokeArgs($controllerObj, $arguments);
          }
        } 
        else 
        {
          die("404. " . get_class() . ' error: Controller does not contain method.');
        }
      } 
      else 
      {
        die('404. ' . get_class() . ' error: Controller does not implement interface IController.');
      }
    } 
    else 
    { 
      die('404. Page is not found.');
    }
  }
  
   /**
    * ThemeEngineRender, renders the reply of the request.
    */
  public function ThemeEngineRender() {
    // Is theme enabled?
    if(!isset($this->config['theme'])) {
      return;
    }
  	  
    // Get the paths and settings for the theme
    // Tema = css, bilder, functions och templatefiler
    $themeName    = $this->config['theme']['name'];
    $themePath    = LYDIA_INSTALL_PATH . "/themes/{$themeName}";
    $themeUrl	 = $this->request->base_url . "themes/{$themeName}";
    // base_url för att länkar på webbplatsen ska funka så som bilder
    // stylesheets etc oberoende vart på sidan man är
    
    // Add stylesheet path to the $ly->data array
    $this->data['stylesheet'] = "{$themeUrl}/style.css";

    // Include the global functions.php and the functions.php that are part of the theme
    $ly = &$this;
	include(LYDIA_INSTALL_PATH . '/themes/functions.php');
    $functionsPath = "{$themePath}/functions.php";
    if(is_file($functionsPath)) {
      include $functionsPath;
    }

    // Extract $ly->data to own variables and handover to the template file
    extract($this->data);
    extract($this->views->GetData());  
    include("{$themePath}/default.tpl.php");
  }
} 
?>