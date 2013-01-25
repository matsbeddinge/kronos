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
 */
$kronos->config['routing'] = array(
  'install' => array('enabled' => true, 'url' => 'index/index'),
  'about-me' => array('enabled' => true, 'url' => 'page/view/14'),
);


/**
 * Define menus.
 *
 * Create hardcoded menus and map them to a theme region through $kronos->config['theme'].
 */
$kronos->config['menus'] = array(
  'my-navbar' => array(
    'about' => array('label'=>'About Me', 'url'=>'about-me'),
    'blog' => array('label'=>'My Blog', 'url'=>'blog'),
  ),
);


// Add static entries for use in the template file.
$kronos->config['theme']['data'] = array(
    'sitetitle' => 'SimlplyBlogg:',
	'logo' => 'logga.png',
    'footer' => '<p>Kronos &copy; by Mats Svensson</p>',
  );