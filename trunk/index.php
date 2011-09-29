<?php
include_once 'header.php';

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'list';
$todo_handler =& xoops_getmodulehandler('list');

switch($op) {	
		
	case 'list':
		include_once ICMS_ROOT_PATH.'/header.php';
		if (is_rb_version()) {
			$load_jquery = false;
			$gui_url = ICMS_URL.'/modules/system/gui';
		} else {
			$load_jquery = true;
			$gui_url = $myurl;
		}
		$xoopsTpl->assign('load_jquery', $load_jquery);
		$xoopsTpl->assign('gui_url', $gui_url);
		$xoopsTpl->assign('tpl_path', MOD_TPL_PATH);
		$xoopsTpl->assign('myurl', $myurl);
		
		$kwd = isset($_REQUEST['kwd']) ? trim($myts->stripSlashesGPC($_REQUEST['kwd'])) : '';
		$compl = isset($_REQUEST['compl']) ? trim($myts->stripSlashesGPC($_REQUEST['compl'])) : '0';
		
		$criteria = array();
		
		if (!empty($kwd)) {
			$search_column = array('tag', 'title', 'note');
			$search_sql = '(';
			foreach ($search_column as $column) {
				$search_sql .= $column.' LIKE '.$xoopsDB->quoteString('%'.$kwd.'%').' OR ';
			}
			$search_sql = substr($search_sql, 0, -4);
			$search_sql .= ')';
			$criteria[] = $search_sql; 
		}
		if ($compl != 'all') {
			$criteria[] = 'complete = '.$xoopsDB->quoteString($compl);
		}
		
		$task_count = $todo_handler->getCount($criteria);
		$xoopsTpl->assign('task_count', $task_count);
		
		$task_obj = $todo_handler->getObjects($criteria);
		foreach (array_keys($task_obj) as $t) {
			$task['id'] = $task_obj[$t]->getVar('id');
			$task['tag'] = $task_obj[$t]->getVar('tag');
			$task['title'] = $task_obj[$t]->getVar('title');
			$task['note'] = $task_obj[$t]->getVar('note');
			$priority = $task_obj[$t]->getVar('priority');
			if ($priority > 0) {
				$task['prio_class'] = 'prio-pos';
				$task['priority'] = '+'.$priority;
			} elseif ($priority < 0) {
				$task['prio_class'] = 'prio-neg';
				$task['priority'] = $priority;
			} else {
				$task['prio_class'] = 'prio-o';
				$task['priority'] = '';
			}
			$task['complete'] = $task_obj[$t]->getVar('complete');
			$task['published'] = $task_obj[$t]->getVar('published');
			$xoopsTpl->append('task', $task);
		}
		
		$tag_arr =  explode('|', $xoopsModuleConfig['todo_tag']);
		$tag_list = array();
		foreach ($tag_arr as $tag) {
			$tag_list[] = array('name' => trim($tag));
		}
		$xoopsTpl->assign('tag_list', $tag_list);
		
		$admin = false;
		if ($xoopsUser) {
			if ( $xoopsUser->isAdmin(-1) ) {
				$admin = true;
			}
		}
		if ($admin) {
			$xoopsTpl->display(MOD_TPL_PATH.'/todo_list.html');
		} else {
			$xoopsTpl->display(MOD_TPL_PATH.'/todo_list_read.html');
		}
		include_once ICMS_ROOT_PATH.'/footer.php';
		break;
}

?>