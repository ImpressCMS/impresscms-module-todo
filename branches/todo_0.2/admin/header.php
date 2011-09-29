<?php
/*
// 函式載入
*/
// include_once '../../../include/cp_header.php';
// for PHP5 
$current_path = str_replace('\\', '/', dirname( dirname( dirname( dirname(__FILE__) ) ) ));
include_once $current_path.'/include/cp_header.php';

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
$myurl = XOOPS_URL.'/modules/'.$mydirname ;
$myroot = XOOPS_ROOT_PATH.'/modules/'.$mydirname;
$myts =& MyTextSanitizer::getInstance();

include_once XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/include/config.php'; // 組態
include_once XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/include/functions.php'; // 涵式
include_once XOOPS_ROOT_PATH.'/class/template.php'; // 樣板
$xoopsTpl = new IcmsTpl();



?>