<?php
/**
 * A user controller to manage comments.
 *
 * @package KronosCore
 */
class CCComment extends CObject implements IController {


  /**
	 * Constructor
	 */
  public function __construct() { parent::__construct(); }


  /**
	 * Show a listing of all comments.
	 */
  public function Index() {
    $comment = new CMComment();
    $this->views->SetTitle('Comment Controller');
    $this->views->AddInclude(dirname(__FILE__) . '/index.tpl.php', array(
                  'comments' => $comment->ListAll(),
                ));
  }
  

  /**
	 * Edit a selected content, or prepare to create new content if argument is missing.
	 *
	 * @param id integer the id of the comment.
	 */
  public function Edit($id=null) {
    $comment = new CMComment($id);
    $form = new CFormComment($comment);
		$redirect = $this->session->GetNextRedirect();
		$this->session->SetNextRedirect($redirect);
    $status = $form->Check();
    if($status === false) {
      $this->AddMessage('notice', 'The form could not be processed.');
      $this->RedirectToController('edit', $id);
    } else if($status === true) {
			$this->RedirectTo($redirect);
    }
    
    $title = isset($id) ? 'Edit' : 'Create';
    $this->views->SetTitle("$title comment: $id");
    $this->views->AddInclude(dirname(__FILE__) . '/edit.tpl.php', array(
                  'user'=>$this->user,
									'isAuthenticated'=>$this->user['isAuthenticated'],
                  'comment'=>$comment,
                  'form'=>$form,
                ));
  }
  

  /**
	 * Create new comment.
	 *
	 * @param idContent integer the id of the content the comment relates to.
	 */
  public function Create($idContent) {
		if(!$this->user['isAuthenticated']){
			$this->AddMessage('notice', 'You need to login.');
			$this->session->SetRedirectWithLogin($this->session->GetNextRedirect()); //remember where to redirect after creating comment, including a login process.
			$this->session->SetNextRedirect($this->request->request); //remember where to redirect after login process.
			$this->RedirectTo('user', 'login');
		}
		$comment = new CMComment();
		$comment['idContent'] = $idContent;
    $form = new CFormComment($comment);
		$redirect = $this->session->GetNextRedirect();
		$this->session->SetNextRedirect($redirect);
    $status = $form->Check();
    if($status === false) {
      $this->AddMessage('notice', 'The form could not be processed.');
      $this->RedirectToController('create', $idContent);
    } else if($status === true) {
			$redirectWithLogin = $this->session->GetRedirectWithLogin(); //check if the redirect included a login process
			if ($redirectWithLogin != null) {
				$redirect = $redirectWithLogin;
				$this->session->UnsetRedirectWithLogin();
			}
			$this->RedirectTo($redirect);
    }
    
    $this->views->SetTitle("Create comment");
    $this->views->AddInclude(dirname(__FILE__) . '/edit.tpl.php', array(
                  'user'=>$this->user,
									'isAuthenticated'=>$this->user['isAuthenticated'],
                  'comment'=>$comment,
                  'form'=>$form,
                ));
  }

	
	/**
	 * Put selected comment in wastebasket.
	 *
	 * @param id integer the id of the comment.
	 */
  public function Delete($id) {
    $comment = new CMComment();
		$redirect = $this->session->GetNextRedirect();
		$this->session->SetNextRedirect($redirect);
		$status = $comment->Delete($id);
    if($status === false) {
      $this->AddMessage('notice', 'The delete action was not successful.');
      $this->RedirectToController();
    } else if($status === true) {
			$this->RedirectTo($redirect);
    }
  }
  

	/**
	 * 
	 */
  public function Show($i) {
    $comment = new CMComment();
	$this->views->AddInclude(dirname(__FILE__) . '/index.tpl.php', array(
		'comments' => $comment->ListComments($i),
	));
  }
  

} 