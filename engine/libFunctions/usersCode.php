<?php


function getInviteCodeData($account_ID) {
	$data = array();
	$account_ID = sanitize($account_ID);
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1)  {
		unset($func_get_args[0]);
		
		$fields = '`'. implode('`, `', $func_get_args) .'`';
		return doSelectSingleDB("SELECT $fields FROM `usersCode` WHERE `account_ID` = '".$account_ID."' LIMIT 1;");
	} else return false;
}

function isExisitInviteCode($code) {
	$code = sanitize($code);

	$data = doSelectSingleDB("SELECT `id` FROM `usersCode` WHERE `code`='".$code."';");

	return ($data !== false) ? true : false;
}


function getInviteCodeAccount($code) {
	$code = sanitize($code);

	$data = doSelectSingleDB("SELECT `account_id` FROM `usersCode` WHERE `code`='".$code."';");

	return ($data !== false) ? $data['account_id'] : false;
}


function getInviteCodeUser($user_ID) {
    $column = 'code'; 
	$data = getInviteCodeData($user_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}



?>