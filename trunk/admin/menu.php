<?php
$m = 0;
$adminmenu[$m]['title'] = _AM_TODO_NOT_COMPLETED;
$adminmenu[$m]['link'] = 'admin/index.php';
$m++;
$adminmenu[$m]['title'] = _AM_TODO_COMPLETED;
$adminmenu[$m]['link'] = 'admin/index.php?compl=1';
global $xoopsModuleConfig;
$tag_arr =  explode('|', $xoopsModuleConfig['todo_tag']);
foreach ($tag_arr as $tag) {
$m++;
$adminmenu[$m]['title'] = $tag;
$adminmenu[$m]['link'] = 'admin/index.php?compl=all&kwd='.trim($tag);
}
?>