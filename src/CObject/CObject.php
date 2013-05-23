<?php
/**
 * Holding a instance of CHero to enable use of $this in subclasses and provide some helpers.
 *
 * @package LydiaCore
 */
class CObject {

	/**
	 * Members
	 */
	protected $he;
	protected $config;
	protected $request;
	protected $data;
	protected $db;
	protected $views;
	protected $session;
	protected $user;


	/**
	 * Constructor, can be instantiated by sending in the $he reference.
	 */
	protected function __construct($he=null) {
	  if(!$he) {
	    $he = CHero::Instance();
	  }
	  $this->ly       = &$he;
    $this->config   = &$he->config;
    $this->request  = &$he->request;
    $this->data     = &$he->data;
    $this->db       = &$he->db;
    $this->views    = &$he->views;
    $this->session  = &$he->session;
    $this->user     = &$he->user;
	}


	/**
	 * Wrapper for same method in CHero. See there for documentation.
	 */
	protected function RedirectTo($urlOrController=null, $method=null, $arguments=null) {
    $this->ly->RedirectTo($urlOrController, $method, $arguments);
  }


	/**
	 * Wrapper for same method in CHero. See there for documentation.
	 */
	protected function RedirectToController($method=null, $arguments=null) {
    $this->ly->RedirectToController($method, $arguments);
  }


	/**
	 * Wrapper for same method in CHero. See there for documentation.
	 */
	protected function RedirectToControllerMethod($controller=null, $method=null, $arguments=null) {
    $this->ly->RedirectToControllerMethod($controller, $method, $arguments);
  }


	/**
	 * Wrapper for same method in CHero. See there for documentation.
	 */
  protected function AddMessage($type, $message, $alternative=null) {
    return $this->ly->AddMessage($type, $message, $alternative);
  }


	/**
	 * Wrapper for same method in CHero. See there for documentation.
	 */
	protected function CreateUrl($urlOrController=null, $method=null, $arguments=null) {
    return $this->ly->CreateUrl($urlOrController, $method, $arguments);
  }


}
