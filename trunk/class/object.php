<?php

if( ! defined( 'ICMS_ROOT_PATH' ) ) die('root path not defined');
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

include_once ICMS_ROOT_PATH.'/class/xoopsobject.php';
include_once ICMS_ROOT_PATH.'/modules/'.$mydirname.'/include/config.php';
include_once ICMS_ROOT_PATH.'/modules/'.$mydirname.'/include/functions.php';

// ╕№дJ╗yие└╔
$config_handler =& xoops_gethandler('config');
$xoopsConfig =& $config_handler->getConfigsByCat(XOOPS_CONF);
if ( file_exists(ICMS_ROOT_PATH.'/modules/'.$mydirname.'/language/'.$xoopsConfig['language'].'/admin.php') ) {
	include_once ICMS_ROOT_PATH.'/modules/'.$mydirname.'/language/'.$xoopsConfig['language'].'/admin.php';
} else {
	include_once ICMS_ROOT_PATH.'/modules/'.$mydirname.'/language/tchinese_utf8/admin.php';
}

?>