<?php
/**
 * Main class for Lydia, holds everything.
 *
 * @package LydiaCore
 */
class CLydia implements ISingleton {

  private static $instance = null;

  /**
   * Constructor
   */
  protected function __construct() {
    // &this s� at $ly kan skickas som referens och anv�ndas i config.php
    $ly = &$this;
    require(LYDIA_SITE_PATH.'/config.php');
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
    $this->request = new CRequest();
	$this->request->Init($this->config['base_url']);
    $controller = $this->request->controller;
    $method     = $this->request->method;
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
        if($rc->hasMethod($method)) 
        {
          $controllerObj = $rc->newInstance();
          $methodObj = $rc->getMethod($method);
          $methodObj->invokeArgs($controllerObj, $arguments);
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
    include("{$themePath}/default.tpl.php");
  }
} 
?>