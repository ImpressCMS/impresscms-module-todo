<?php
/*
// 內容管理
*/
require_once 'header.php';

$todo_handler = icms_getmodulehandler('list');




/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';

$clean_op = isset($_REQUEST['op'])  ? $_REQUEST['op'] : 'list';
if (isset ( $_GET ['op'] ))
	$clean_op = htmlentities ( $_GET ['op'] );
if (isset ( $_POST ['op'] ))
	$clean_op = htmlentities ( $_POST ['op'] );






/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('add', 'create', 'list', 'load', '');

icms_loadLanguageFile('system', 'admin');

if (in_array ( $clean_op, $valid_op, true )) {










switch($clean_op)
{


		case 'create' :
			icms_cp_header();
			$menu_handler->render(2);

	//$menu_handler->render($currentoption = 1, $return = false)
	/*
	icms_admin_menu(_MD_AD_ACTION_BOX, $op_url, _MD_AD_MAINTENANCE_BOX, icmsMainAction());
	*/
			$load_jquery = true;
			$gui_url = $myurl;

			$icmsTpl->assign('load_jquery', $load_jquery);	// From header.php
			$icmsTpl->assign('gui_url', $gui_url);					// From header.php
			$icmsTpl->assign('tpl_path', MOD_TPL_PATH);			// From header.php
			$icmsTpl->assign('myurl', $myurl);							// From header.php

			$icmsTpl->display('file:'.MOD_TPL_PATH.'/todo_add.html');
		break;


	case 'list':
	case 'load':
			icms_cp_header();
			//$menu_handler->render(1);

		$load_jquery = true;
		$gui_url = $myurl;


			$icmsTpl->assign('load_jquery', $load_jquery);	// From header.php
			$icmsTpl->assign('gui_url', $gui_url);					// From header.php
			$icmsTpl->assign('tpl_path', MOD_TPL_PATH);			// From header.php
			$icmsTpl->assign('myurl', $myurl);							// From header.php
		
		$kwd = isset($_REQUEST['kwd']) ? trim($myts->stripSlashesGPC($_REQUEST['kwd'])) : '';
		$compl = isset($_REQUEST['compl']) ? trim($myts->stripSlashesGPC($_REQUEST['compl'])) : '0';
		
		$criteria = array();
		
		if (!empty($kwd))
		{
			$search_column = array('tag', 'title', 'note');
			$search_sql = '(';
			foreach ($search_column as $column)
			{
				$search_sql .= $column.' LIKE '.$xoopsDB->quoteString('%'.$kwd.'%').' OR ';
			}
			$search_sql = substr($search_sql, 0, -4);
			$search_sql .= ')';
			$criteria[] = $search_sql; 
		}
		if ($compl != 'all')
		{
			$criteria[] = 'complete = '.$xoopsDB->quoteString($compl);
		}
		
		$task_count = $todo_handler->getCount($criteria);
		$icmsTpl->assign('task_count', $task_count);
		
		$task_obj = $todo_handler->getObjects($criteria);

		//if (is_rb_version()) echo 'YES';
		foreach (array_keys($task_obj) as $t)
		{
			$task['id'] = $task_obj[$t]->getVar('id');
			$task['tag'] = $task_obj[$t]->getVar('tag');
			$task['title'] = $task_obj[$t]->getVar('title');
			$task['note'] = $task_obj[$t]->getVar('note');
			$priority = $task_obj[$t]->getVar('priority');
			if ($priority > 0)
			{
				$task['prio_class'] = 'prio-pos';
				$task['priority'] = '+'.$priority;
			}
			elseif ($priority < 0)
			{
				$task['prio_class'] = 'prio-neg';
				$task['priority'] = $priority;
			}
			else
			{
				$task['prio_class'] = 'prio-o';
				$task['priority'] = '';
			}
			$task['complete'] = $task_obj[$t]->getVar('complete');
			$task['published'] = $task_obj[$t]->getVar('published');
			$icmsTpl->append('task', $task);
		}
		$icmsTpl->assign('xoops_pagetitle', _AM_TODO_TASK_LIST);
				
		$tag_arr =  explode('|', $xoopsModuleConfig['todo_tag']);
		$tag_list = array();
		foreach ($tag_arr as $tag)
		{
			$tag_list[] = array('name' => trim($tag));
		}
		$icmsTpl->assign('tag_list', $tag_list);
				
		$icmsTpl->display('file:'.MOD_TPL_PATH.'/todo_list.html');
		break;
/*
		default :
			icms_cp_header();
	    icms_admin_menu(
				_MD_AD_ACTION_BOX, $op_url,
				_MD_AD_MAINTENANCE_BOX, icmsMainAction()
			);
	    $menu_handler->render(0);

			$load_jquery = true;
			$gui_url = $myurl;

			$icmsTpl->assign('load_jquery', $load_jquery);	// From header.php
			$icmsTpl->assign('gui_url', $gui_url);					// From header.php
			$icmsTpl->assign('tpl_path', MOD_TPL_PATH);			// From header.php
			$icmsTpl->assign('myurl', $myurl);							// From header.php

			$icmsTpl->display('file:'.MOD_TPL_PATH.'/todo_index.html');
		break;
*/




}
	icms_cp_footer();

}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */
?>