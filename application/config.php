<?php
//	CONFIGURATION OF APPLICATION: USER SPECIFIC
//	@PACKAGE KRONOS CORE
//

//	Set level of error reporting
error_reporting(-1);
ini_set('display_errors', 1);

//	Set databases
$kronos->config['database'][0]['dsn'] = 'sqlite:' . KRONOS_APPLICATION_PATH . '/data/.ht.sqlite';

//	Debug enabler for get_debug() theme helper
$kronos->config['debug']['kronos'] = false;
$kronos->config['debug']['session'] = false;
$kronos->config['debug']['timer'] = true;
$kronos->config['debug']['db-num-queries'] = true;
$kronos->config['debug']['db-queries'] = true;

//	Define session name
$kronos->config['session_name'] = preg_replace('/[:\.\/-_]/', '', $_SERVER["SERVER_NAME"]);
$kronos->config['session_key'] = 'kronos';

//	Define server timezone
$kronos->config['timezone'] = 'Europe/Stockholm';

//	Define internal character encoding
$kronos->config['character_encoding'] = 'UTF-8';

//	Define language
$kronos->config['language'] = 'en';

//	Set a base_url to use another than the default calculated
$kronos->config['base_url'] = null;

/**
* How to hash password of new users, choose from: plain, md5salt, md5, sha1salt, sha1.
*/
$kronos->config['hashing_algorithm'] = 'sha1salt';

/**
* Allow or disallow creation of new user accounts.
*/
$kronos->config['create_new_users'] = true;

//	What type of urls should be used?
//	default      = 0      => index.php/controller/method/arg1/arg2/arg3
//	clean        = 1      => controller/method/arg1/arg2/arg3
//	querystring  = 2      => index.php?q=controller/method/arg1/arg2/arg3
$kronos->config['url_type'] = 1;

//	Define the controllers, their classname and enable/disable them.
//	The array-key is matched against the url, for example:
//	the url 'developer/dump' would instantiate the controller with the key "developer", that is
//	CCDeveloper and call the method "dump" in that class. This process is managed in:
//	$kronos->FrontControllerRoute();
//	which is called in the frontcontroller phase from index.php.
$kronos->config['controllers'] = array(
	'index'	=> array('enabled' => true,'class' => 'CCIndex'),
	'test'	=> array('enabled' => true,'class' => 'CCTest'),
	'guestbook'	=> array('enabled' => true,'class' => 'CCGuestbook'),
	'user'	=> array('enabled' => true,'class' => 'CCUser'),
	'content'	=> array('enabled' => true,'class' => 'CCContent'),
	'blog'	=> array('enabled' => true,'class' => 'CCBlog'),
	'page'	=> array('enabled' => true,'class' => 'CCPage'),
	'theme'     => array('enabled' => true,'class' => 'CCTheme'),
	'admin' => array('enabled' => true,'class' => 'CCAdminControlPanel', 'access' => 'admin'),
);

//	Settings for theme
$kronos->config['theme'] = array(
  // The name of the theme in the theme directory
  'name'    => 'grid',
  'stylesheet'  => 'style.php',   // Main stylesheet to include in template files
	'template_file'   => 'index.tpl.php',   // Default template file, else use default.tpl.php
	'regions' => array('flash','featured-first','featured-middle','featured-last',
    'primary','sidebar','triptych-first','triptych-middle','triptych-last',
    'footer-column-one','footer-column-two','footer-column-three','footer-column-four',
    'footer',
  ),
	// Add static entries for use in the template file.
  'data' => array(
    'logo' => 'logga.png',
    'logo_width' => 200,
    'logo_height' => 60,
    'footer' => '<p>Kronos &copy; by Mats Svensson (student@bth)</p>',
  ),
);
