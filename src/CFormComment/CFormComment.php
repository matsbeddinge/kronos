<?php
/**
 * A form to manage comment.
 *
 * @package KronosCore
 */
class CFormComment extends CForm {

  /**
	 * Properties
	 */
  private $comment;

  /**
	 * Constructor
	 */
  public function __construct($comment) {
    parent::__construct();
    $this->comment = $comment;
    $save = isset($comment['id']) ? 'save' : 'create';
    $this->AddElement(new CFormElementHidden('id', array('value'=>$comment['id'])))
        ->AddElement(new CFormElementTextarea('data', array('label'=>'Comment:', 'value'=>$comment['data'])))
        ->AddElement(new CFormElementHidden('filter', array('value'=>'plain')))
				->AddElement(new CFormElementText('idContent', array('value'=>$comment['idContent'], 'readonly'=>'readonly')))
        ->AddElement(new CFormElementSubmit($save, array('callback'=>array($this, 'DoSave'), 'callback-args'=>array($comment))));

    $this->SetValidation('data', array('not_empty'));
  }
  

  /**
	 * Callback to save the form comment to database.
	 */
  public function DoSave($form, $comment) {
    $comment['id'] = $form['id']['value'];
    $comment['data'] = $form['data']['value'];
    $comment['filter'] = $form['filter']['value'];
		$comment['idContent'] = $form['idContent']['value'];
    $comment->Save();
		return true;
	//CKronos::Instance()->RedirectTo('comment');
  }
  
  
}