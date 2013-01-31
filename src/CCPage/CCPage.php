<?php
/**
 * A page controller to display a page, for example an about-page, displays content labelled as "page".
 *
 * @package KronosCore
 */
class CCPage extends CObject implements IController {


  /**
	 * Constructor
	 */
  public function __construct() {
    parent::__construct();
	
  }


  /**
	 * Display an empty page.
	 */
  public function Index() {
    $content = new CMContent();
    $this->views->SetTitle($this->config['theme']['data']['sitetitle']);
    $this->views->AddInclude(dirname(__FILE__) . '/index.tpl.php', array(
                  'content' => null,
				  'hasRoleAdmin'=>$this->user['hasRoleAdmin'],
                ));
  }


  /**
 	 * Display a page.
	 *
	 * @param $id integer the id of the page.
	 */
  public function View($id=null) {
    $content = new CMContent($id);
	$this->session->SetNextRedirect($this->request->request);
    $this->views->SetTitle($this->config['theme']['data']['sitetitle'].' '.htmlEnt($content['title']));
    $this->views->AddInclude(dirname(__FILE__) . '/index.tpl.php', array(
                  'content' => $content,
				  'hasRoleAdmin'=>$this->user['hasRoleAdmin'],
                ));
  }


} 