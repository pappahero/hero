<?php
    /**
    * A controller för a peopledatabase to test building my own application
    * using the MVC-pattern. 
    *
    * @package LydiaCore
    */
    class CCMedEmobBook extends CObject implements IController{

       private $medEmobBook;
       
       /**
       * Constructor
       */
       public function __construct() {
       	       parent::__construct();
       	       $this->medEmobBook = new CMMedEmobBook();
       }
       
       /**
       * Implementing interface IController. All controllers must have an 
       * index action. Show a standard frontpage for the peopledatabase.
       *
       */
       public function Index() {
       	       $this->views->SetTitle('MedEmobBoken');
       	       $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
    	    'entries'=>$this->medEmobBook->ReadAll(),
    	    'form_action'=>$this->request->CreateUrl('', 'handler')
    	    ));
       }
       
       /**
       * Handle posts from the form and take appropriate action.
       */
       public function Handler() {
       	       if(isset($_POST['doAdd'])) {
       	       	       $this->medEmobBook->Add($_POST['name'], $_POST['telNr'], $_POST['mail']);
       	       	       // tar bort strip_tags för att få det att fungera
       	       }
       	       elseif(isset($_POST['doClear'])) {
       	       	       $this->medEmobBook->DeleteAll();
       	       }
       	       elseif(isset($_POST['doCreate'])) {
       	       	       $this->medEmobBook->Manage('install');
       	       }
       	       $this->RedirectTo($this->request->CreateUrl($this->request->controller));
       }
     
    } // end of class
