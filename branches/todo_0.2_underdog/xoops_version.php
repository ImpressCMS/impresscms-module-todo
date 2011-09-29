<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) die('root path not defined');

$mydirname = basename( dirname( __FILE__ ) ) ;

$modversion['name'] = _MI_TODO_NAME;
$modversion['version'] = '0.2';
$modversion['description'] = _MI_TODO_DESC;
$modversion['credits'] = '';
$modversion['author'] = 'UnderDog, Full credits to RB Lin (xtheme@gmail.com)';
$modversion['license'] = 'Business License';
$modversion['image'] = 'images/'.$mydirname.'_slogo.png';
$modversion['dirname'] = $mydirname;

//--------------------------------------------------------------------

// Sql file
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file (without prefix!)
$t=1; // 廣告區塊
$modversion['tables'][$t] = $mydirname.'_todo_list';

//--------------------------------------------------------------------

// Admin backend
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

//--------------------------------------------------------------------

// Templates
$modversion['use_smarty'] = 1;

//--------------------------------------------------------------------
/*
// Blocks
$b=1; // 商品分類
$modversion['blocks'][$b]['file']        = $mydirname.'_b_category.php';
$modversion['blocks'][$b]['name']        = _MI_STREET_BNAME1;
$modversion['blocks'][$b]['description'] = '';
$modversion['blocks'][$b]['show_func']   = $mydirname.'_b_category';
$modversion['blocks'][$b]['options']     = $mydirname.'|0|0|1'; // 模組目錄 | 顯示模式 | 顯示商品數量 | 自動隱藏子類別
$modversion['blocks'][$b]['edit_func']   = $mydirname.'_b_category_set';
$modversion['blocks'][$b]['template']    = $mydirname.'_b_category.html';
$modversion['blocks'][$b]['can_clone']   = false ;
$b++; // 品牌專區
$modversion['blocks'][$b]['file']        = $mydirname.'_b_brand.php';
$modversion['blocks'][$b]['name']        = _MI_STREET_BNAME2;
$modversion['blocks'][$b]['description'] = '';
$modversion['blocks'][$b]['show_func']   = $mydirname.'_b_brand';
$modversion['blocks'][$b]['options']     = $mydirname.'|0|0'; // 模組目錄 | 顯示模式 | 顯示商品數量
$modversion['blocks'][$b]['edit_func']   = $mydirname.'_b_brand_set';
$modversion['blocks'][$b]['template']    = $mydirname.'_b_brand.html';
$modversion['blocks'][$b]['can_clone']   = false ;
*/
//--------------------------------------------------------------------

// Menu & Sub Menu
$modversion['hasMain'] = 1;

// Search
$modversion['hasSearch'] = 0;


// Comment
$modversion['hasComments'] = 0;

// Config Settings
$modversion['hasconfig'] = 1;
$i=1;
$modversion['config'][$i]['name'] = 'todo_tag';
$modversion['config'][$i]['title'] = '_MI_TODO_CON_TAG';
$modversion['config'][$i]['description'] = '_MI_TODO_CON_TAG_DESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'tag1|tag2';

?>