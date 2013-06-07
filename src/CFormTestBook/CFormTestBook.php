<?php
/**
 * A form to manage content.
 * 
 * @package LydiaCore
 */
class CFormTestBook extends CForm {

  /**
   * Properties
   */
  private $content;

  /**
   * Constructor
   */
  public function __construct($content) {
    parent::__construct();
    $this->content = $content;
    $this->AddElement(new CFormElementHidden('id', array('value'=>$content['id'])))
         ->AddElement(new CFormElementText('name', array('value'=>$content['name'])))
         ->AddElement(new CFormElementText('telNr', array('value'=>$content['telNr'])))
         ->AddElement(new CFormElementText('mail', array('value'=>$content['mail'])))
         ->AddElement(new CFormElementText('filter', array('value'=>$content['filter'])))
         ->AddElement(new CFormElementSubmit('create', array('callback'=>array($this, 'DoSave'), 'callback-args'=>array($content))))
         ->AddElement(new CFormElementSubmit('delete', array('callback'=>array($this, 'DoDelete'), 'callback-args'=>array($content))));

    $this->SetValidation('name', array('not_empty'))
         ->SetValidation('telNr', array('not_empty'))
         ->SetValidation('mail', array('not_empty'))
         ->SetValidation('filter', array('not_empty'));
  }
  

  /**
   * Callback to save the form content to database.
   */
  public function DoSave($form, $content) {
    $content['id']     = $form['id']['value'];
    $content['name']     = $form['name']['value'];
    $content['telNr']  = $form['telNr']['value'];
    $content['mail']    = $form['mail']['value'];
    $content['filter'] = $form['filter']['value'];
    return $content->Save();
  }
    
  /**
   * Callback to delete the content.
   */
  public function DoDelete($form, $content) {
    $content['id'] = $form['id']['value'];
    $content->Delete();
    CHero::Instance()->RedirectTo('testbook');
  }
  
  
}
