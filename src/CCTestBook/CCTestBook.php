<?php
/**
 * A user controller to manage content.
 * 
 * @package LydiaCore
 */
class CCTestBook extends CObject implements IController {


  /**
   * Constructor
   */
  public function __construct() { parent::__construct(); }


  /**
   * Edit a selected content, or prepare to create new content if argument is missing.
   *
   * @param id integer the id of the content.
   */
  public function Index($id=null) {
    $content = new CMTestBook($id);
    $form = new CFormTestBook($content);
    $status = $form->Check();
    if($status === false) {
      $this->AddMessage('notice', 'The form could not be processed.');
      $this->RedirectToController('index', $id);
    } else if($status === true) {
      $this->RedirectToController('index', $content['id']);
    }

    $this->views->SetTitle("Contactbook: ".htmlEnt($content['title']))
                ->AddInclude(__DIR__ . '/index.tpl.php', array( 
                  'content'=>$content, 
                  'form'=>$form,
                  'contents' => $content->ListAll(),
                ));
  }
  
  /**
   * Create new content.
   */
  public function Create() {
    $this->Index();
  }


  /**
   * Init the content database.
   */
  public function Init() {
    $content = new CMTestBook();
    $content->Init();
    $this->RedirectToController();
  }
  

} 
