<?php
/**
 * A user controller to manage content.
 *
 * @package KronosCore
 */
class CCContent extends CObject implements IController {

	/**
	 * Properties
	 */
  private $type = null;

  /**
	 * Constructor
	 */
  public function __construct() { parent::__construct(); }


  /**
	 * Show a listing of all content.
	 */
  public function Index() {
    $content = new CMContent();
    $this->views->SetTitle('Content Controller');
    $this->views->AddInclude(dirname(__FILE__) . '/index.tpl.php', array(
                  'contents' => $content->ListAll(),
                ));
  }
  

  /**
	 * Edit a selected content, or prepare to create new content if argument is missing.
	 *
	 * @param id integer the id of the content.
	 */
  public function Edit($id=null) {
    $content = new CMContent($id);
		if($this->type != null){$content['type'] = $this->type;}
    $form = new CFormContent($content);
		$redirect = $this->session->GetNextRedirect();
		$this->session->SetNextRedirect($redirect);
    $status = $form->Check();
    if($status === false) {
      $this->AddMessage('notice', 'The form could not be processed.');
      $this->RedirectToController('edit', $id);
    } else if($status === true) {
      //$this->RedirectToController('edit', $content['id']);
			$this->RedirectTo($redirect);
    }
    
    $title = isset($id) ? 'Edit' : 'Create';
    $this->views->SetTitle("$title content: $id");
    $this->views->AddInclude(dirname(__FILE__) . '/edit.tpl.php', array(
                  'user'=>$this->user,
                  'content'=>$content,
                  'form'=>$form,
                ));
  }
  

  /**
	 * Create new content.
	 */
  public function Create($type=null) {
		$this->type = $type;
    $this->Edit();
  }

	
	/**
	 * Put selected content in wastebasket.
	 *
	 * @param id integer the id of the content.
	 */
  public function Delete($id) {
    $content = new CMContent();
	$status = $content->Delete($id);
    if($status === false) {
      $this->AddMessage('notice', 'The delete action was not successful.');
      $this->RedirectToController();
    } else if($status === true) {
      $this->RedirectToController();
    }
  }
  

  /**
	 * Init the content database.
	 */
  public function Init() {
    $content = new CMContent();
    $content->Init();
    $this->RedirectToController('Guestbook');
  }
  

} 