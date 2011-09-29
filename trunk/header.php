<?php
//include_once '../../mainfile.php';
// for PHP5
$current_path = str_replace('\\', '/', dirname( dirname( dirname(__FILE__) ) ));
include_once $current_path.'/mainfile.php';

$myts =& MyTextSanitizer::getInstance();
$mydirname = basename( dirname( __FILE__ ) ) ;
$myurl = ICMS_URL.'/modules/'.$mydirname;
$myroot = ICMS_ROOT_PATH.'/modules/'.$mydirname;


// include files
include_once ICMS_ROOT_PATH.'/modules/'.$mydirname.'/include/config.php';
include_once ICMS_ROOT_PATH.'/modules/'.$mydirname.'/include/functions.php';
//include_once ICMS_ROOT_PATH.'/modules/'.$mydirname.'/include/javascript.php';


?>