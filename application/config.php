<?php
/**
 * Application configuration, this file is changed by user per application.
 *
 */

require('config-core.php');
 

/**
 * Set database(s).
 */
$kronos->config['database'][0]['dsn'] = 'sqlite:' . KRONOS_APPLICATION_PATH . '/data/.ht.sqlite';


/**
 * Set a base_url to use another than the default calculated
 */
$kronos->config['base_url'] = null;


/**
 * Define default server timezone when displaying date and times to the user. All internals are still UTC.
 */
$kronos->config['timezone'] = 'Europe/Stockholm';



/**
 * Define language
 */
$kronos->config['language'] = 'en';



/**
 * Define a routing table for urls.
 *
 * Route custom urls to a defined controller/method/arguments
 * To create additional routing you add new line like:
 * 'home' => array('enabled' => true, 'url' => 'page/view/10'),
 * The number 10 above is the id number of the page.
 */
$kronos->config['routing'] = array(
	'about-me' => array('enabled' => true, 'url' => 'page/view/1'), //copy this line and paste below to create a routing for a new page, edit with your data.
	
);


/**
 * Define menus.
 *
 * Create hardcoded menus and map them to a theme region through $kronos->config['theme'].
 * To change the link text shown in the navbar you edit 'label'=>'Here you write what to be shown as link text'
 * To create additional links to your menu you add new line like:
 * 'homepage' => array('label'=>'Home', 'url'=>'page/view/10'),
 * The number 10 above is the id number of the page.
 * If you use a routing described above you change the url to what you defined in your routing table above i.e
 * 'homepage' => array('label'=>'Home', 'url'=>'home'),
 */
$kronos->config['menus'] = array(
  'my-navbar' => array(
    'blog' => array('label'=>'My Blog', 'url'=>'blog'),
	'about' => array('label'=>'About Me', 'url'=>'about-me'), //copy this line and paste below to create a new link in your menu, edit with your data.
    
  ),
);


// Add static entries for use in the template file.
$kronos->config['theme']['data'] = array(
    'sitetitle' => 'SimlplyBlog:',
	'logo' => 'logga.png',
    'footer' => '<p>2013 &copy; SimplyBlog</p>',
  );