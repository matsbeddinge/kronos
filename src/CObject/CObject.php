<?php
/**
* Holding a instance of CKronos to enable use of $this in subclasses and provide some helpers.
*
* @package KronosCore
*/
class CObject {

	/**
	 * Members
	 */
	protected $kronos;
	protected $config;
	protected $request;
	protected $data;
	protected $db;
	protected $views;
	protected $session;
	protected $user;

	/**
	 * Constructor, can be instantiated by sending in the $kronos reference.
	 */
	protected function __construct($kronos=null) {
		if(!$kronos) {
			$kronos = CKronos::Instance();
		}
		$this->kronos = &$kronos;
			$this->config = &$kronos->config;
			$this->request = &$kronos->request;
			$this->data = &$kronos->data;
			$this->db = &$kronos->db;
			$this->views = &$kronos->views;
			$this->session = &$kronos->session;
			$this->user = &$kronos->user;
	}

	/**
	 * Wrapper for same method in CKronos. See there for documentation.
	 */
	protected function RedirectTo($urlOrController=null, $method=null, $arguments=null) {
			$this->kronos->RedirectTo($urlOrController, $method, $arguments);
		}


	/**
	 * Wrapper for same method in CKronos. See there for documentation.
	 */
	protected function RedirectToController($method=null, $arguments=null) {
			$this->kronos->RedirectToController($method, $arguments);
		}


	/**
	 * Wrapper for same method in CKronos. See there for documentation.
	 */
	protected function RedirectToControllerMethod($controller=null, $method=null, $arguments=null) {
			$this->kronos->RedirectToControllerMethod($controller, $method, $arguments);
		}


	/**
	 * Wrapper for same method in CKronos. See there for documentation.
	 */
		protected function AddMessage($type, $message, $alternative=null) {
			return $this->kronos->AddMessage($type, $message, $alternative);
		}


	/**
	 * Wrapper for same method in CKronos. See there for documentation.
	 */
	protected function CreateUrl($urlOrController=null, $method=null, $arguments=null) {
			return $this->kronos->CreateUrl($urlOrController, $method, $arguments);
		}

}