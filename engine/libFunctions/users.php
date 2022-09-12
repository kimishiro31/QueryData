<?php
function isUserExist($user_ID) {
	$user_ID = sanitize($user_ID);
	
	$user = doSelectSingleDB("SELECT `id` FROM `users` WHERE `id`='$user_ID';");
	return ($user !== false) ? true : false;
}

function getUserData($user_ID) {
	$data = array();
	$user_ID = sanitize($user_ID);
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1)  {
		unset($func_get_args[0]);
		
		$fields = '`'. implode('`, `', $func_get_args) .'`';
		return doSelectSingleDB("SELECT $fields FROM `users` WHERE `id` = '".$user_ID."' LIMIT 1;");
	} else return false;
}

function getUserFirstName($user_ID) {
	$data = getUserData($user_ID, 'first_name');

	return ($data !== false) ? $data['first_name'] : false;
}

function getUserLastName($user_ID) {
	$data = getUserData($user_ID, 'last_name');
	$last = trim($data['last_name']);

	return ($data !== false) ? substr($last, strrpos($last, ' ')) : false;
}

function getUserCompleteName($user_ID) {
	$data = getUserData($user_ID, 'first_name', 'last_name');

	return ($data !== false) ? $data['first_name'].' '.$data['last_name'] : false;
}

function getUserBirthDate($user_ID) {
	$data = getUserData($user_ID, 'birth_date');

	return ($data !== false) ? doDateConvert($data['birth_date']) : false;
}

function getUserIDPerCPF($cpf) {
	$cpf = sanitize($cpf);
	$data = doSelectSingleDB("SELECT `id` FROM `users` WHERE `cpf`='$cpf' LIMIT 1;");
	
	return ($data !== false) ? $data['id'] : false;
}

function getUserAccountID($user_ID) {
	$user_ID = sanitize($user_ID);
	$data = doSelectSingleDB("SELECT `account_id` FROM `users` WHERE `id`='$user_ID' LIMIT 1;");
	
	return ($data !== false) ? $data['account_id'] : false;
}

function getUserCPF($user_ID) {
	$data = getUserData($user_ID, 'cpf');

	return ($data !== false) ? $data['cpf'] : false;
}

function getUserRG($user_ID) {
	$data = getUserData($user_ID, 'rg');

	return ($data !== false) ? $data['rg'] : false;
}

function getUserGender($user_ID) {
	$data = getUserData($user_ID, 'gender');

	return ($data !== false) ? $data['gender'] : false;
}

function getUserAddressStreet($user_ID) {
	$data = getUserData($user_ID, 'street');

	return ($data !== false) ? $data['street'] : false;
}

function getUserAddressComplement($user_ID) {
	$data = getUserData($user_ID, 'complement');

	return ($data !== false) ? $data['complement'] : false;
}

function getUserAddressDistrict($user_ID) {
	$data = getUserData($user_ID, 'district');

	return ($data !== false) ? $data['district'] : false;
}

function getUserAddressNumber($user_ID) {
	$data = getUserData($user_ID, 'number');

	return ($data !== false) ? $data['number'] : false;
}

function getUserAddressCEP($user_ID) {
	$data = getUserData($user_ID, 'cep');

	return ($data !== false) ? $data['cep'] : false;
}

function getUserAddressCity($user_ID) {
	$data = getUserData($user_ID, 'city');

	return ($data !== false) ? $data['city'] : false;
}

function getUserAddressUF($user_ID) {
	$data = getUserData($user_ID, 'uf');

	return ($data !== false) ? $data['uf'] : false;
}

function getUserNacionality($user_ID) {
	$data = getUserData($user_ID, 'nacionality');

	return ($data !== false) ? $data['nacionality'] : false;
}

function getUserProfission($user_ID) {
	$data = getUserData($user_ID, 'profissao');

	return ($data !== false) ? $data['profissao'] : false;
}

function getUserPhotoName($user_ID) {
	$data = getUserData($user_ID, 'foto');

	return ($data !== false) ? $data['foto'] : false;
}

function doCreateUser($register_data) {
	array_walk($register_data, 'array_sanitize');
	$data = $register_data;
	$data['password'] = sha1($register_data['password']);
	$key = generateRandomString(true, false, false, 6);
	$keyPhone = generateRandomString(true, false, false, 6);
	$keyDate = date("Y-m-d").' '.doSetTime(date("H:i:s"), config('accountValidation'));
	$created = date("Y-m-d");
	$ip = getIp();
	$invite = (empty($register_data['cInvite'])) ? NULL : $register_data['cInvite'];
	
	doInsertDB("INSERT INTO `accounts` (`username`, `password`, `phone`, `email`, `created`, `ip`, `emailActive`, `emailCode`, `emailCodeDate`, `phoneActive`, `phoneCode`, `phoneCodeDate`, `inviteCode`) VALUES ('".$data['email']."', '".$data['password']."', '".$data['fPhone']."', '".$register_data['email']."', '".$created."', '".$ip."', '0', '".$key."', '".$keyDate."', '0', '".$keyPhone."', '".$keyDate."', '".$invite."')");
	$lastID = getLastInsertDB();
	
	doInsertDB("INSERT INTO `users` (`account_id`, `first_name`, `last_name`, `birth_date`, `cpf`) VALUES ('".$lastID."', '".$data['fName']."', '".$data['sName']."', '".$data['bDate']."', '".$data['cpf']."')");
	$iCode = $lastID.generateRandomString(true, false, true, 6);

	doInsertDB("INSERT INTO `usersCode` (`account_id`, `code`) VALUES ('".$lastID."', '".$iCode."')");
	doAddUserCredit(getAccountIDUser($lastID), config('startCredits'));
	
	if(!empty($invite)) {
		$userLastID = getLastInsertDB();
		doAddUserCredit($userLastID, 10);
		doAddUserCredit(getInviteCodeAccount($invite), 10);
	}




	$bodyMail = "Por favor ative a sua conta pelo código abaixo: <b>".$key."</b>";
	doSendMail($data['email'], $data['fName'], "Automatico Email", "Ativação de Conta", $bodyMail);

	$bodyPhone = "Seu código de verificação é: ".$keyPhone;
	doSendSMS($data['fPhone'], $bodyPhone);
	
}

	/*
                $user_data =  array(
                    'user_ID' 	        => $_POST['user_ID'],
                    'account_id' 	    => getQueryUserID($_POST['query_ID']),
                    'first_name' 		=> getQueryType($_POST['query_ID']),
                    'last_name' 		=> getQueryValue($_POST['query_ID'], 1),
                    'birth_date' 		=> getQueryValue($_POST['query_ID'], 2),
                    'cpf' 	    	    => getQueryCreditType($_POST['query_ID']),
                    'rg' 			    => getQueryDate($_POST['query_ID']),
                    'gender' 			=> getQueryTime($_POST['query_ID']),
                    'street' 			=> getQueryIP($_POST['query_ID']),
                    'district' 		    => $_POST['selectQStatus'],
                    'number' 		    => $_POST['selectAssigned'],
                    'complement'        => date("Y-m-d"),
                    'cep'               => date("H:i:s"),
                    'city'              => $userData['id'],
                    'uf'                => date("Y-m-d"),
                    'nacionality'       => date("H:i:s")
                );
	*/
function doUpdateUser($register_data) {

	$import_data_query = array(
		'account_id ' 			=> (!empty($register_data['account_id '])) ? $register_data['account_id '] : NULL,
		'first_name' 		=> (!empty($register_data['first_name'])) ? $register_data['first_name'] : NULL,
		'last_name' 		=> (!empty($register_data['last_name'])) ? $register_data['last_name'] : NULL,
		'birth_date' 		=> (!empty($register_data['birth_date'])) ? $register_data['birth_date'] : NULL,
		'cpf' 			=> (!empty($register_data['cpf'])) ? $register_data['cpf'] : NULL,
		'rg' 			=> (!empty($register_data['rg'])) ? $register_data['rg'] : NULL,
		'gender' 			=> (!empty($register_data['gender'])) ? $register_data['gender'] : NULL,
		'street' 		=> (!empty($register_data['street'])) ? $register_data['street'] : NULL,
		'district' 		=> (!empty($register_data['district'])) ? $register_data['district'] : NULL,
		'number' => (!empty($register_data['number'])) ? $register_data['number'] : NULL,
		'complement' => (!empty($register_data['complement'])) ? $register_data['complement'] : NULL,
		'cep' => (!empty($register_data['cep'])) ? $register_data['cep'] : NULL,
		'city' => (!empty($register_data['city'])) ? $register_data['city'] : NULL,
		'uf' => (!empty($register_data['uf'])) ? $register_data['uf'] : NULL,
		'nacionality' => (!empty($register_data['nacionality'])) ? $register_data['nacionality'] : NULL
	);
		
	foreach($import_data_query as $key => $value) {	
		if($value === NULL) {
			unset($import_data_query[$key]);
		}
	}

	$query_sql = doConvertUpdateSQLFormat($import_data_query);

	doUpdateDB("UPDATE `users` SET $query_sql WHERE `id`='".$register_data['user_ID']."';");
}


function doDeleteUser($user_ID) {
	$account_ID = getUserAccountID($user_ID);

	doDeleteDB("SET foreign_key_checks = 0;");
	doDeleteDB("DELETE FROM `accounts` WHERE `id`='$account_ID';");
	doDeleteDB("DELETE FROM `contracted_pack` WHERE `user_id`='$user_ID';");
	doDeleteDB("DELETE FROM `contracted_pack_logs` WHERE `user_id`='$user_ID';");
	doDeleteDB("DELETE FROM `devolution_pack` WHERE `user_id`='$user_ID';");
	doDeleteDB("DELETE FROM `payments` WHERE `user_id`='$user_ID';");
	doDeleteDB("DELETE FROM `queries` WHERE `user_id`='$user_ID';");
	doDeleteDB("DELETE FROM `queries_logs` WHERE `user_id`='$user_ID';");
	doDeleteDB("DELETE FROM `users` WHERE `id`='$user_ID';");
	doDeleteDB("DELETE FROM `users_credit` WHERE `user_id`='$user_ID';");
	doDeleteDB("SET foreign_key_checks = 1;");
}
































function getExistTypePay($id) {
	$id = (int)$id;

	$query = doSelectSingleDB("SELECT `id` FROM `tipos_pagamento` WHERE `id`=$id;");

	return ($query !== false) ? $query['id'] : false;
}

function doTotalUsersCommon() {
	$query = doSelectSingleDB("SELECT COUNT(*) as `total_users` FROM `users` INNER JOIN `contas` ON `users`.`conta_id` = `contas`.`id` where `contas`.`nv_acesso`=0;");
	

	return str_pad($query['total_users'] , 2, '0' , STR_PAD_LEFT);;
}


function getAllUsers($ppage, $rowsPerPage, $search = false, $order = false, $orderType = false) {
	if($order !== false)
		$order = "ORDER by `".$orderType."` ".getOrder($orderType)."";
	else
		$order = "ORDER BY `users`.`id` ASC";

		if($search === false) 
		$search = '';
	else
		$search = "INNER JOIN `accounts`  ON `users`.`account_id` = `accounts`.`id` WHERE `users`.`first_name` LIKE '%".$search."%' or `users`.`last_name` LIKE '%".$search."%' or `users`.`birth_date` LIKE '%".$search."%' or `users`.`cpf` LIKE '%".$search."%' or `users`.`rg` LIKE '%".$search."%' or `users`.`street` LIKE '%".$search."%' or `users`.`district` LIKE '%".$search."%' or `users`.`cep` LIKE '%".$search."%' or `users`.`city` LIKE '%".$search."%' or `users`.`uf` LIKE '%".$search."%' or `users`.`nacionality` LIKE '%".$search."%' or `accounts`.`email` LIKE '%".$search."%' or `accounts`.`phone` LIKE '%".$search."%'";
	
	return doSelectMultiDB("SELECT `users`.id FROM `users` $search $order LIMIT $ppage, $rowsPerPage;");
}

?>
