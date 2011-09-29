<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) die('root path not defined');

function is_rb_version()
{
	if (strstr(XOOPS_VERSION , 'RB')) {
		return true;
	} else {
		return false;
	}
}


?>