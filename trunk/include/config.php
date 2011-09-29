<?php

if( ! defined( 'ICMS_ROOT_PATH' ) ) die('root path not defined');

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

if( !defined('TODO_CONSTANTS_DEFINED') ) {
	define('MOD_DIR', $mydirname);
	// DB name define
	define('DB_TODO',             MOD_DIR.'_list');
	// Path define
	define('MOD_URL',             ICMS_URL.'/modules/'.MOD_DIR);
	define('MOD_PATH',            ICMS_ROOT_PATH.'/modules/'.MOD_DIR);
	define('MOD_IMG_URL',         ICMS_URL.'/modules/'.MOD_DIR.'/images');
	define('MOD_IMG_PATH',        ICMS_ROOT_PATH.'/modules/'.MOD_DIR);
	define('MOD_UPLOAD_URL',      ICMS_URL.'/modules/'.MOD_DIR.'/uploads');
	define('MOD_UPLOAD_PATH',     ICMS_ROOT_PATH.'/modules/'.MOD_DIR.'/uploads');
	define('MOD_TPL_PATH',        ICMS_ROOT_PATH.'/modules/'.MOD_DIR.'/templates');
	// check
	define('TODO_CONSTANTS_DEFINED', true);
}

?>