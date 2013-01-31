<?php
/**
 * Standard controller layout.
 *
 * @package KronosCore
 */
class CCIndex extends CObject implements IController {

  /**
	 * Constructor
	 */
  public function __construct() { parent::__construct(); 
	
  }
  

  /**
	 * Implementing interface IController. All controllers must have an index action.
	 */
  public function Index() {	
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Index');
    $this->views->AddInclude(dirname(__FILE__) . '/index.tpl.php', array(), 'primary');
    $this->views->AddInclude(dirname(__FILE__) . '/sidebar.tpl.php', array('controllers'=>$controllers), 'sidebar');
	//$this->RedirectTo('about-me');
  }


} 