<?php
/**
 * Controller for development and testing purpose, helpful methods for the developer.
 *
 * @package KronosCore
 */
class CCTest extends CObject implements IController {
	
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Implementing interface IController. All controllers must have an index action.
	 */
	public function Index() {  
		$this->Menu();
	}
	
	/**
	 * Display all items of the CObject.
	 */
	public function DisplayObject() {	
		$this->Menu();

		$this->data['main'] .= <<<EOD
<h2>Content of CTest</h2>
<p>Here is the content of the controller, including properties from CObject which holds access to common resources in CKronos.</p>
EOD;
		$this->data['main'] .= '<pre>' . htmlent(print_r($this, true)) . '</pre>';
	}

	/**
	 * Create a list of links in the supported ways.
	 */
	public function Links() {  
		$this->Menu();
    
		$url = 'test/links';
		$currentLink = $this->request->CreateUrl($url);

		$this->request->cleanUrl = false;
		$this->request->querystringUrl = false;    
		$defaultLink = $this->request->CreateUrl($url);
    
		$this->request->cleanUrl = true;
		$cleanLink = $this->request->CreateUrl($url);    
    
		$this->request->cleanUrl = false;
		$this->request->querystringUrl = true;    
		$querystringLink = $this->request->CreateUrl($url);
    
		$this->data['main'] .= <<<EOD
<h2>CRequest::CreateUrl()</h2>
<p>List of urls with various settings, directing to same page.</p>
<ul>
<li><a href='{$currentLink}'>Current setting</a>
<li><a href='{$defaultLink}'>Default url</a>
<li><a href='{$cleanLink}'>Clean url</a>
<li><a href='{$querystringLink}'>Querystring url</a>
</ul>
EOD;
  }


	
	/**
	 * Create a method that shows the menu, same for all methods
	 */
	private function Menu() {  
	$menu = array('test', 'test/index', 'test/links', 'test/displayobject');
    
	$html = null;
	foreach($menu as $val) {
		$html .= "<li><a href='" . $this->request->CreateUrl($val) . "'>{$val}</a>";  
	}
    
	$this->data['title'] = "Test Controller";
	$this->data['main'] = <<<EOD
<h1>Test Controller</h1>
<ul>
{$html}
</ul>
EOD;
	}

}