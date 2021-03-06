<?php
/**
 * Application configuration, this file is changed by user per application.
 *
 */

/**
 * Set level of error reporting
 */
error_reporting(-1);
ini_set('display_errors', 1);


/**
 * Set what to show as debug or developer information in the get_debug() theme helper.
 */
$kronos->config['debug']['kronos'] = false;
$kronos->config['debug']['session'] = true;
$kronos->config['debug']['timer'] = true;
$kronos->config['debug']['db-num-queries'] = true;
$kronos->config['debug']['db-queries'] = true;

/**
 * Set database(s).
 */
$kronos->config['database'][0]['dsn'] = 'sqlite:' . KRONOS_APPLICATION_PATH . '/data/.ht.sqlite';


/**
 * What type of urls should be used?
 *
 * default = 0 => index.php/controller/method/arg1/arg2/arg3
 * clean = 1 => controller/method/arg1/arg2/arg3
 * querystring = 2 => index.php?q=controller/method/arg1/arg2/arg3
 */
$kronos->config['url_type'] = 1;


/**
 * Set a base_url to use another than the default calculated
 */
$kronos->config['base_url'] = null;


/**
 * How to hash password of new users, choose from: plain, md5salt, md5, sha1salt, sha1.
 */
$kronos->config['hashing_algorithm'] = 'sha1salt';


/**
 * Allow or disallow creation of new user accounts.
 */
$kronos->config['create_new_users'] = true;


/**
 * Define session name
 */
$kronos->config['session_name'] = preg_replace('/[:\.\/-_]/', '', $_SERVER["SERVER_NAME"]);
$kronos->config['session_key'] = 'kronos';


/**
 * Define default server timezone when displaying date and times to the user. All internals are still UTC.
 */
$kronos->config['timezone'] = 'Europe/Stockholm';


/**
 * Define internal character encoding
 */
$kronos->config['character_encoding'] = 'UTF-8';


/**
 * Define language
 */
$kronos->config['language'] = 'en';


/**
 * Define the controllers, their classname and enable/disable them.
 *
 * The array-key is matched against the url, for example:
 * the url 'developer/dump' would instantiate the controller with the key "developer", that is
 * CCDeveloper and call the method "dump" in that class. This process is managed in:
 * $kronos->FrontControllerRoute();
 * which is called in the frontcontroller phase from index.php.
 */
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
	'module'   => array('enabled' => true,'class' => 'CCModules'),
	'my'        => array('enabled' => true,'class' => 'CCMyController'),
	'comment'	=> array('enabled' => true,'class' => 'CCComment'),
);


/**
 * Define a routing table for urls.
 *
 * Route custom urls to a defined controller/method/arguments
 */
$kronos->config['routing'] = array(
  'home' => array('enabled' => true, 'url' => 'index/index'),
);


/**
 * Define menus.
 *
 * Create hardcoded menus and map them to a theme region through $kronos->config['theme'].
 */
$kronos->config['menus'] = array(
  'navbar' => array(
    'home' => array('label'=>'Home', 'url'=>'home'),
    'modules' => array('label'=>'Modules', 'url'=>'module'),
    'content' => array('label'=>'Content', 'url'=>'content'),
    'guestbook' => array('label'=>'Guestbook', 'url'=>'guestbook'),
    'blog' => array('label'=>'Blog', 'url'=>'blog'),
  ),
  'my-navbar' => array(
    'about' => array('label'=>'About Me', 'url'=>'page/view/5'),
    'blog' => array('label'=>'My Blog', 'url'=>'blog'),
  ),
);



/**
 * Settings for the theme. The theme may have a parent theme.
 *
 * When a parent theme is used the parent's functions.php will be included before the current
 * theme's functions.php. The parent stylesheet can be included in the current stylesheet
 * by an @import clause. See application/themes/mytheme for an example of a child/parent theme.
 * Template files can reside in the parent or current theme, the CKronos::ThemeEngineRender()
 * looks for the template-file in the current theme first, then it looks in the parent theme.
 *
 * There are two useful theme helpers defined in themes/functions.php.
 * theme_url($url): Prepends the current theme url to $url to make an absolute url.
 * theme_parent_url($url): Prepends the parent theme url to $url to make an absolute url.
 *
 * path: Path to current theme, relativly Kronos_INSTALL_PATH, for example themes/grid or application/themes/mytheme.
 * parent: Path to parent theme, same structure as 'path'. Can be left out or set to null.
 * stylesheet: The stylesheet to include, always part of the current theme, use @import to include the parent stylesheet.
 * template_file: Set the default template file, defaults to default.tpl.php.
 * regions: Array with all regions that the theme supports.
 * menu_to_region: Array mapping menus to regions.
 * data: Array with data that is made available to the template file as variables.
 *
 * The name of the stylesheet is also appended to the data-array, as 'stylesheet' and made
 * available to the template files. 
 */
$kronos->config['theme'] = array(
  'path' => 'application/themes/mySimplyBlogg',
  //'path' => 'themes/grid',
  'parent' => 'themes/simplyBlogg',
  'stylesheet'  => 'style.css',   // Main stylesheet to include in template files
	'template_file'   => 'index.tpl.php',   // Default template file, else use default.tpl.php
	'regions' => array('navbar', 'flash','featured-first','featured-middle','featured-last',
    'primary','sidebar','triptych-first','triptych-middle','triptych-last',
    'footer-column-one','footer-column-two','footer-column-three','footer-column-four',
    'footer',
  ),
  'menu_to_region' => array('my-navbar'=>'navbar'),
	// Add static entries for use in the template file.
  'data' => array(
    'logo' => 'logga.png',
    'logo_width' => 200,
    'logo_height' => 60,
    'footer' => '<p>Kronos &copy; by Mats Svensson (student@bth)</p>',
  ),
);
