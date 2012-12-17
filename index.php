<?php
// BOOTSTRAP
//
define('KRONOS_INSTALL_PATH', dirname(__FILE__));
define('KRONOS_APPLICATION_PATH', KRONOS_INSTALL_PATH . '/application');

require(KRONOS_INSTALL_PATH.'/src/bootstrap.php');

$kronos = CKronos::Instance();


// FRONTCONTROLLER ROUTE
$kronos->FrontControllerRoute();


// THEME ENGINE RENDER
$kronos->ThemeEngineRender();