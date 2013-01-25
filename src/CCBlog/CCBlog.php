<?php
/**
 * A blog controller to display a blog-like list of all content labelled as "post".
 *
 * @package KronosCore
 */
class CCBlog extends CObject implements IController {


  /**
	 * Constructor
	 */
  public function __construct() {
    parent::__construct();
  }


  /**
	 * Display all content of the type "post".
	 */
  public function Index() {
    $this->session->SetNextRedirect($this->request->request);
	$content = new CMContent();
    $this->views->SetTitle($this->config['theme']['data']['sitetitle'].' All Blog posts');
    $this->views->AddInclude(dirname(__FILE__) . '/index.tpl.php', array(
			'contents' => $content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),
			'hasRoleAdmin'=>$this->user['hasRoleAdmin'],
			'hasRoleUser'=>$this->user['hasRoleUser'],
		),'primary');
	if ($this->user['hasRoleAdmin'] || $this->user['hasRoleUser']){
		//$url = $this-CreateUrl('content/create/post');
		$this->views->AddString("<h3><a href='{$this->CreateUrl('content/create/post')}'>Make a new blog post >></a></h3>", array(), 'sidebar');
	}
	$this->views->AddString("To be implementet:<br>Info about blogger and statistics.", array(), 'sidebar');
  }
  
  
  /**
	 * Display blog post and the related comments.
	 */
  public function Comments($id) {
    $this->session->SetNextRedirect($this->request->request);
		$content = new CMContent($id); 
		$comment = new CMComment();
		$this->views->SetTitle($this->config['theme']['data']['sitetitle'].' '.$content['key']);
    $this->views->AddInclude(dirname(__FILE__) . '/comments.tpl.php', array(
			'content' => $content,
			'comments' => $comment->ListComments($id),
			'hasRoleAdmin'=>$this->user['hasRoleAdmin'],
			'hasRoleUser'=>$this->user['hasRoleUser'],
		),'primary');
	$this->views->AddString("To be implementet:<br>Info about blogger.", array(), 'sidebar');
  }


} 