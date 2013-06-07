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
	  $this->he       = &$he;
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
		$this->he->RedirectTo($urlOrController, $method, $arguments);
    	}


	/**
	 * Wrapper for same method in CHero. See there for documentation.
	 */
	protected function RedirectToController($method=null, $arguments=null) {
    $this->he->RedirectToController($method, $arguments);
  }


	/**
	 * Wrapper for same method in CHero. See there for documentation.
	 */
	protected function RedirectToControllerMethod($controller=null, $method=null, $arguments=null) {
    $this->he->RedirectToControllerMethod($controller, $method, $arguments);
  }


	/**
	 * Wrapper for same method in CHero. See there for documentation.
	 */
  protected function AddMessage($type, $message, $alternative=null) {
    return $this->he->AddMessage($type, $message, $alternative);
  }


	/**
	 * Wrapper for same method in CHero. See there for documentation.
	 */
	 protected function CreateUrl($urlOrController=null, $method=null, $arguments=null) {
		return $this->he->CreateUrl($urlOrController, $method, $arguments);
  }


}
