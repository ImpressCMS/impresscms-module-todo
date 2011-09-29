<?php
/*
// 內容管理
*/
require_once 'header.php';

$op = isset($_REQUEST['op'])  ? $_REQUEST['op'] : 'load';
$todo_handler =& xoops_getmodulehandler('list');

switch($op) {
	// 
	case 'load':
		$kwd = isset($_POST['kwd']) ? $_POST['kwd'] : '';
		$compl = isset($_POST['compl']) ? $_POST['compl'] : '0';
		
		$criteria = array();
		
		if (!empty($kwd)) {
			$criteria[] = '(tag LIKE "%'.$kwd.'%" OR title LIKE "%'.$kwd.'%" OR note LIKE "%'.$kwd.'%")'; 
		}
		if ($compl != 'all') {
			$criteria[] = 'complete = '.$compl;
		}
		$task_count = $todo_handler->getCount($criteria);
		
		$task_obj = $todo_handler->getObjects($criteria);
		$arr = array(
			'total' => $task_count,
			'list' => ''
		);
				
		foreach (array_keys($task_obj) as $t) {
			$task_arr = $todo_handler->getArray($task_obj[$t]->getVar('id'));
			$arr['list'][] = $task_arr;
		}
		echo json_encode($arr);
		break;
		
	// 新增
	case 'add':
		$weight = 1 + $todo_handler->getMaxWeight();
		$tag = isset($_POST['tag'])  ? $_POST['tag'] : '';
		$title = isset($_POST['title'])  ? $_POST['title'] : '';
		
		$arr = array();
		$arr['total'] = 0;
	
		$task_obj = $todo_handler->create();
		$task_obj->setVar('tag',         $tag);
		$task_obj->setVar('title',       $title);
		$task_obj->setVar('note',        '');
		$task_obj->setVar('priority',    0);
		$task_obj->setVar('complete',    0);
		$task_obj->setVar('published',   strftime("%Y-%m-%d %H:%M:%S"));
		$task_obj->setVar('weight',      $weight);
		if ($todo_handler->insert($task_obj)) {
			$task_arr = $todo_handler->getArray($task_obj->getVar('id'));
			$arr['list'][] = $task_arr;
			$arr['message'] = _AM_TODO_MSG_ADD_OK;
			$arr['total'] = 1;
		} else {
			$arr['message'] = _AM_TODO_MSG_ADD_ERR;
		}
		echo json_encode($arr);
		break;
	
	// 編輯
	case 'save':
		$id = isset($_POST['id'])  ? $_POST['id'] : 0;
		$tag = isset($_POST['tag'])  ? $_POST['tag'] : '';
		$title = isset($_POST['title'])  ? $_POST['title'] : '';
		$note = isset($_POST['note'])  ? $_POST['note'] : '';
		$priority = isset($_POST['priority'])  ? $_POST['priority'] : '';
		
		$arr = array();
		$arr['total'] = 0;
		
		$task_obj = $todo_handler->get($id);
		$task_obj->setVar('tag',        $tag);
		$task_obj->setVar('title',      $title);
		$task_obj->setVar('note',       $note);
		$task_obj->setVar('priority',   $priority);
		if ($todo_handler->insert($task_obj)) {
			$task_arr = $todo_handler->getArray($id);
			$arr['list'][] = $task_arr;
			$arr['message'] = _AM_TODO_MSG_UPDATED_OK;
			$arr['total'] = 1;
		} else {
			$arr['message'] = _AM_TODO_MSG_UPDATED_ERR;
		}
		echo json_encode($arr); 
		break;
	
	// 餵送 json	
	case 'get_task':
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$arr = array();
		$arr['total'] = 0;
		$task_arr = $todo_handler->getArray($id);
		$arr['message'] = _AM_TODO_MSG_GET_ERR;
		if(is_array($arr)) {
			$arr['list'][] = $task_arr;
			$arr['total'] = 1;
			$arr['message'] = _AM_TODO_MSG_GET_OK;
		}
		echo json_encode($arr); 
		break;
	
	// 刪除
	case 'delete':
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$arr = array();
		if (!$todo_handler->isExists($id)) {
			$arr['message'] = _AM_TODO_TASK_NOT_FIND;
			exit();
		}
		$task_obj = $todo_handler->get($id);
		if ($todo_handler->delete($task_obj)) {
			$arr['message'] = _AM_TODO_MSG_DEL_OK;
		} else {
			$arr['message'] = _AM_TODO_MSG_DEL_ERR;
		}
		echo json_encode($arr);
		break;
	
	// 完成變更
	case 'complete':
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$compl = isset($_POST['compl']) ? intval($_POST['compl']) : 0;
		$arr = array();
		$arr['total'] = 0;
		$task_obj = $todo_handler->get($id);
		$task_obj->setVar('complete', $compl);
		if ($todo_handler->insert($task_obj)) {
			$arr['list'][] = array(
				'id' => $task_obj->getVar('id'),
				'title' => $task_obj->getVar('title'),
				'note' => $task_obj->getVar('note'),
				'priority' => $task_obj->getVar('priority'),
				'complete' => $task_obj->getVar('complete'),
				'published' => $task_obj->getVar('published'),
				'weight' => $task_obj->getVar('weight')
			);
			$arr['message'] = _AM_TODO_MSG_UPDATED_OK;
			$arr['total'] = 1;
		} else {
			$arr['message'] = _AM_TODO_MSG_UPDATED_ERR;
		}
		echo json_encode($arr); 
		break;
		
	// 更新排序
	case 'change_sort':
		$order = $_REQUEST['taskrow']; 
		$order = array_reverse($order);
		foreach ($order as $weight => $id) {
			$sql = 'UPDATE '.$xoopsDB->prefix(DB_TODO).' SET weight = '.$weight.' WHERE id = '.$id;
			$result = $xoopsDB->queryF($sql);
			$arr['debug'][] = $sql;
		}
		echo json_encode($arr); 
		break;
}
?>