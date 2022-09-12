<?php

function getQueriesData($query_ID) {
	$data = array();
	$query_ID = sanitize($query_ID);
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1)  {
		unset($func_get_args[0]);
		
		$fields = '`'. implode('`, `', $func_get_args) .'`';
		return doSelectSingleDB("SELECT $fields FROM `queries` WHERE `id` = '".$query_ID."' LIMIT 1;");
	} else 
	return false;
}

function isQueryExist($query_ID) {
	$query_ID = sanitize($query_ID);
	
	$data = doSelectSingleDB("SELECT `id` FROM `queries` WHERE `id`='$query_ID';");
	return ($data !== false) ? true : false;
}


function getQueryUserID($query_ID) {
	$column = "user_id";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getQueryType($query_ID) {
	$column = "type";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getQueryValue($query_ID, $value = 1) {
	if ($value == 1) 
		$column = "value01";
	else
		$column = "value02";

	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getQueryCreditType($query_ID) {
	$column = "pay_type";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}


function getQueryDate($query_ID) {
	$column = "date";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getQueryTime($query_ID) {
	$column = "time";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getQueryIP($query_ID) {
	$column = "ip";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getQueryStatus($query_ID) {
	$column = "status";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getQueryAssigned($query_ID) {
	$column = "assigned";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getQueryAssignedDate($query_ID) {
	$column = "assigned_date";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getQueryAssignedTime($query_ID) {
	$column = "assigned_time";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getQueryAnsweredDate($query_ID) {
	$column = "answered_date";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getQueryAnsweredTime($query_ID) {
	$column = "answered_time";
	$data = getQueriesData($query_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function doAddQuery($data) {
    doInsertDB("INSERT INTO `queries` (`user_id`, `type`, `value01`, `value02`, `pay_type`, `date`, `time`, `ip`, `status`) VALUES ('".$data['user_id']."', '".$data['type']."', '".$data['value01']."', '".$data['value02']."', '".$data['pay_type']."', '".$data['date']."', '".$data['time']."', '".$data['ip']."', '".$data['status']."')");
	$lastID = getLastInsertDB();
	doSendWarningQueries(getUserCompleteName($data['user_id']), $lastID);
}

function doDeleteQuery($query_ID) {
	doDeleteDB("DELETE FROM `queries` WHERE `id`='$query_ID' limit 1;");
}

/*
$register_data =  array(
    'type' 			=> 1,
    'value01' 		=> 1,
    'value02' 		=> 1,
    'pay_type' 		=> 1,
    'date' 			=> 1,
    'time' 			=> 1,
    'ip' 			=> 1,
    'status' 		=> 1,
    'assigned' 		=> 1,
    'assigned_date' => 1,
    'assigned_time' => 1
);
 */
function doUpdateQuery($register_data) {

	$import_data_query = array(
		'type' 			=> (!empty($register_data['type'])) ? $register_data['type'] : NULL,
		'value01' 		=> (!empty($register_data['value01'])) ? $register_data['value01'] : NULL,
		'value02' 		=> (!empty($register_data['value02'])) ? $register_data['value02'] : NULL,
		'pay_type' 		=> (!empty($register_data['pay_type'])) ? $register_data['pay_type'] : NULL,
		'date' 			=> (!empty($register_data['date'])) ? $register_data['date'] : NULL,
		'time' 			=> (!empty($register_data['time'])) ? $register_data['time'] : NULL,
		'ip' 			=> (!empty($register_data['ip'])) ? $register_data['ip'] : NULL,
		'status' 		=> (!empty($register_data['status'])) ? $register_data['status'] : NULL,
		'assigned' 		=> (!empty($register_data['assigned'])) ? $register_data['assigned'] : NULL,
		'assigned_date' => (!empty($register_data['assigned_date'])) ? $register_data['assigned_date'] : NULL,
		'assigned_time' => (!empty($register_data['assigned_time'])) ? $register_data['assigned_time'] : NULL
	);
	
	foreach($import_data_query as $key => $value) {	
		if($value === NULL) {
			unset($import_data_query[$key]);
		}
	}

	$query_sql = doConvertUpdateSQLFormat($import_data_query);

	doUpdateDB("UPDATE `queries` SET $query_sql WHERE `id`='".$register_data['query_ID']."';");
}


function getQueriesUser($user_ID, $ppage, $rowsPerPage) {
//	$order = ORDER by `data_agendamento` ".getOrder($_GET['order']).";
	$order = '';

	return doSelectMultiDB("SELECT `id` FROM `queries` where `user_id`='".$user_ID."' ORDER BY `queries`.`date` DESC, `queries`.`time` DESC LIMIT $ppage, $rowsPerPage;");
}

function getAllQueries($ppage, $rowsPerPage, $search = false, $order = false, $orderType = false) {
	if($order !== false)
		$order = "ORDER by `".$orderType."` ".getOrder($orderType)."";
	else
		$order = "ORDER BY `queries`.`date` DESC, `queries`.`time` DESC";

	if($search === false) 
		$search = '';
	else
		$search = "WHERE `id` LIKE '%".$search."%' or `value01` LIKE '%".$search."%' or `value02` LIKE '%".$search."%' or `date` LIKE '%".$search."%' or `time` LIKE '%".$search."%' or `assigned` LIKE '%".$search."%' or `assigned_date` LIKE '%".$search."%' or `assigned_time` LIKE '%".$search."%'";
	

	return doSelectMultiDB("SELECT `id` FROM `queries` $search $order LIMIT $ppage, $rowsPerPage;");
}



	#########################################
	## FUNÇÕES QUERIES LOGS
	#########################################

	function doAddQueryLogs($data) {
		doInsertDB("INSERT INTO `queries_logs` (`id`, `user_id`, `type`, `value01`, `value02`, `pay_type`, `date`, `time`, `ip`, `status`, `assigned`, `assigned_date`, `assigned_time`, `queryEnd_user_id`,  `queryEnd_date`, `queryEnd_time`) VALUES ('".$data['id']."','".$data['user_id']."', '".$data['type']."', '".$data['value01']."', '".$data['value02']."', '".$data['pay_type']."', '".$data['date']."', '".$data['time']."', '".$data['ip']."', '".$data['status']."', '".$data['assigned']."', '".$data['assigned_date']."', '".$data['assigned_time']."', '".$data['queryEnd_user_id']."', '".$data['queryEnd_date']."', '".$data['queryEnd_time']."')");
	}

		
	function getQueriesLogsUser($user_ID, $ppage, $rowsPerPage) {
		//	$order = ORDER by `data_agendamento` ".getOrder($_GET['order']).";
			$order = '';
		
			return doSelectMultiDB("SELECT `id` FROM `queries_logs` where `user_id`='".$user_ID."' ORDER BY `queries_logs`.`date` DESC, `queries_logs`.`time` DESC LIMIT $ppage, $rowsPerPage;");
		}
	
		

	function getQueriesLogsData($query_ID) {
		$data = array();
		$query_ID = sanitize($query_ID);
		
		$func_num_args = func_num_args();
		$func_get_args = func_get_args();
		
		if ($func_num_args > 1)  {
			unset($func_get_args[0]);
			
			$fields = '`'. implode('`, `', $func_get_args) .'`';
			return doSelectSingleDB("SELECT $fields FROM `queries_logs` WHERE `id` = '".$query_ID."' LIMIT 1;");
		} else 
		return false;
	}

	function isQueryLogsExist($query_ID) {
		$query_ID = sanitize($query_ID);
		
		$data = doSelectSingleDB("SELECT `id` FROM `queries_logs` WHERE `id`='$query_ID';");
		return ($data !== false) ? true : false;
	}


	function getQueryLogsUserID($query_ID) {
		$column = "user_id";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsType($query_ID) {
		$column = "type";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsValue($query_ID, $value = 1) {
		if ($value == 1) 
			$column = "value01";
		else
			$column = "value02";

		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsCreditType($query_ID) {
		$column = "pay_type";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}


	function getQueryLogsDate($query_ID) {
		$column = "date";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsTime($query_ID) {
		$column = "time";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsIP($query_ID) {
		$column = "ip";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsStatus($query_ID) {
		$column = "status";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsAssigned($query_ID) {
		$column = "assigned";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsAssignedDate($query_ID) {
		$column = "assigned_date";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsAssignedTime($query_ID) {
		$column = "assigned_time";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsFinishedDate($query_ID) {
		$column = "queryEnd_date";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsFinishedTime($query_ID) {
		$column = "queryEnd_time";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}

	function getQueryLogsFinishedUserId($query_ID) {
		$column = "queryEnd_user_id";
		$data = getQueriesLogsData($query_ID, $column);

		return ($data !== false) ? $data[$column] : false;
	}


	function doDeleteQueryLogs($query_ID) {
		doDeleteDB("DELETE FROM `queries_logs` WHERE `id`='$query_ID' limit 1;");
	}

	/*
	$register_data =  array(
		'type' 			=> 1,
		'value01' 		=> 1,
		'value02' 		=> 1,
		'pay_type' 		=> 1,
		'date' 			=> 1,
		'time' 			=> 1,
		'ip' 			=> 1,
		'status' 		=> 1,
		'assigned' 		=> 1,
		'assigned_date' => 1,
		'assigned_time' => 1
	);
	*/
	function doUpdateQueryLogs($register_data) {

		$import_data_query = array(
			'type' 			=> (!empty($register_data['type'])) ? $register_data['type'] : NULL,
			'value01' 		=> (!empty($register_data['value01'])) ? $register_data['value01'] : NULL,
			'value02' 		=> (!empty($register_data['value02'])) ? $register_data['value02'] : NULL,
			'pay_type' 		=> (!empty($register_data['pay_type'])) ? $register_data['pay_type'] : NULL,
			'date' 			=> (!empty($register_data['date'])) ? $register_data['date'] : NULL,
			'time' 			=> (!empty($register_data['time'])) ? $register_data['time'] : NULL,
			'ip' 			=> (!empty($register_data['ip'])) ? $register_data['ip'] : NULL,
			'status' 		=> (!empty($register_data['status'])) ? $register_data['status'] : NULL,
			'assigned' 		=> (!empty($register_data['assigned'])) ? $register_data['assigned'] : NULL,
			'assigned_date' => (!empty($register_data['assigned_date'])) ? $register_data['assigned_date'] : NULL,
			'assigned_time' => (!empty($register_data['assigned_time'])) ? $register_data['assigned_time'] : NULL
		);
		
		foreach($import_data_query as $key => $value) {	
			if($value === NULL) {
				unset($import_data_query[$key]);
			}
		}

		$query_sql = doConvertUpdateSQLFormat($import_data_query);

		doUpdateDB("UPDATE `queries_logs` SET $query_sql WHERE `id`='".$register_data['query_ID']."';");
	}

	function getAllQueriesLogs($ppage, $rowsPerPage, $search = false, $order = false, $orderType = false) {
		if($order !== false)
			$order = "ORDER by `".$orderType."` ".getOrder($orderType)."";
		else
			$order = "ORDER BY `queries_logs`.`date` DESC, `queries_logs`.`time` DESC";

		if($search === false) 
			$search = '';
		else
			$search = "WHERE `id` LIKE '%".$search."%' or `value01` LIKE '%".$search."%' or `value02` LIKE '%".$search."%' or `date` LIKE '%".$search."%' or `time` LIKE '%".$search."%' or `assigned` LIKE '%".$search."%' or `assigned_date` LIKE '%".$search."%' or `assigned_time` LIKE '%".$search."%'";
			
			return doSelectMultiDB("SELECT `id` FROM `queries_logs` $search $order LIMIT $ppage, $rowsPerPage;");
	}
?>