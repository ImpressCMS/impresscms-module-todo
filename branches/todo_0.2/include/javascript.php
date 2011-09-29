<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) die('root path not defined');

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
$myurl = XOOPS_URL.'/modules/'.$mydirname;

// Module CSS
function todo_css()
{
	global $myurl;
	$ret = '
	<!-- shop css -->
	<link rel="stylesheet" type="text/css" href="'.$myurl.'/style.css" media="all" />';
	return $ret;
}


?>