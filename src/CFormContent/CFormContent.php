<?php
/**
 * A form to manage content.
 *
 * @package KronosCore
 */
class CFormContent extends CForm {

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
    $save = isset($content['id']) ? 'save' : 'create';
    $this->AddElement(new CFormElementHidden('id', array('value'=>$content['id'])))
         ->AddElement(new CFormElementText('title', array('value'=>$content['title'], 'required'=>true)))
         ->AddElement(new CFormElementText('key', array('value'=>$content['key'], 'required'=>true)))
         ->AddElement(new CFormElementTextarea('data', array('label'=>'Content:', 'value'=>$content['data'], 'required'=>true)))
         ->AddElement(new CFormElementText('type', array('label'=>'Type(page, post):', 'value'=>$content['type'], 'required'=>true)))
         ->AddElement(new CFormElementText('filter', array('label'=>'Filter(htmlpurify, bbcode, plain):', 'value'=>$content['filter'], 'required'=>true)))
         ->AddElement(new CFormElementSubmit($save, array('callback'=>array($this, 'DoSave'), 'callback-args'=>array($content))));

    $this->SetValidation('title', array('not_empty'))
         ->SetValidation('key', array('not_empty'))
		 ->SetValidation('data', array('not_empty'));
  }
  

  /**
	 * Callback to save the form content to database.
	 */
  public function DoSave($form, $content) {
    $content['id'] = $form['id']['value'];
    $content['title'] = $form['title']['value'];
    $content['key'] = $form['key']['value'];
    $content['data'] = $form['data']['value'];
    $content['type'] = $form['type']['value'];
    $content['filter'] = $form['filter']['value'];
    $content->Save();
		return true;
		//CKronos::Instance()->RedirectTo('content');
  }
  
  
}