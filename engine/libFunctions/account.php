<?php

function getAccountData($account_ID) {
	$data = array();
	$account_ID = sanitize($account_ID);
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1)  {
		unset($func_get_args[0]);
		
		$fields = '`'. implode('`, `', $func_get_args) .'`';
		return doSelectSingleDB("SELECT $fields FROM `accounts` WHERE `id` = '".$account_ID."' LIMIT 1;");
	} else 
	return false;
}

function getAccountUsername($account_ID) {
	
	$data = getAccountData($account_ID, 'username');

	return ($data !== false) ? $data['username'] : false;
}

function getAccountPhone($account_ID) {
	
	$data = getAccountData($account_ID, 'phone');

	return ($data !== false) ? $data['phone'] : false;
}


function getAccountPassword($account_ID) {
	
	$data = getAccountData($account_ID, 'password');

	return ($data !== false) ? $data['password'] : false;
}


function getAccountIDPerEmail($email) {
	$email = sanitize($email);
	$data = doSelectSingleDB("SELECT `id` FROM `accounts` WHERE `email`='$email' LIMIT 1;");

	return ($data !== false) ? $data['id'] : false;
}

function getAccountIDPerFPhone($FPhone) {
	$FPhone = str_replace(' ', '', (sanitizeString($FPhone)));
	$data = doSelectSingleDB("SELECT `id` FROM `accounts` WHERE `phone`='$FPhone' LIMIT 1;");
	
	return ($data !== false) ? $data['id'] : false;
}

function getAccountEmail($account_ID) {
	
	$data = getAccountData($account_ID, 'email');

	return ($data !== false) ? $data['email'] : false;
}

function getAccountDateCreated($account_ID) {
	
	$data = getAccountData($account_ID, 'created');

	return ($data !== false) ? doDateConvert($data['created']) : false;
}

function getAccountIPCreated($account_ID) {
	
	$data = getAccountData($account_ID, 'ip');

	return ($data !== false) ? $data['ip'] : false;
}

function getAccountGroup($account_ID) {
	
	$data = getAccountData($account_ID, 'group');

	return ($data !== false) ? $data['group'] : false;
}


function getLoginValidation($username, $password) {
	$username = sanitize($username);
	$password = sha1($password);
	
	$data = doSelectSingleDB("SELECT `id` FROM `accounts` WHERE `username`='$username' AND `password`='$password';");
	
	return ($data !== false) ? $data['id'] : false;
}

function getAccountID($user_ID) {
	$query = doSelectSingleDB("select `accounts`.`id` from `accounts` INNER JOIN `usuarios` ON  `usuarios`.`conta_id` = `accounts`.`id` where `usuarios`.`id`='".$user_ID."';");	

	return ($query !== false) ? $query['id'] : false;
}

function getAccountEmailActive($account_ID) {
	
	$data = getAccountData($account_ID, 'emailActive');

	return ($data['emailActive'] != 0) ? true : false;
}

function getAccountEmailCode($account_ID) {
	
	$data = getAccountData($account_ID, 'emailCode');

	return ($data !== false) ? $data['emailCode'] : false;
}


function getAccountPhoneActive($account_ID) {
	
	$data = getAccountData($account_ID, 'phoneActive');

	return ($data['phoneActive'] != 0) ? true : false;
}

function setAccountNewCodeEmail($account_ID, $user_ID) {
	$key = generateRandomString(true, false, false, 6);
	$keyDate = date("Y-m-d").' '.doSetTime(date("H:i:s"), config('accountValidation'));

	$bodyMail = "Por favor ative a sua conta pelo código abaixo: <b>".$key."</b>";

	
	doUpdateDB("UPDATE `accounts` SET `emailCode`='".$key."', `emailActive`='0', `emailCodeDate`='".$keyDate."' WHERE `id`='".$account_ID."';");
	$accountData = getAccountData($account_ID, 'email');
	$userData = getUserData($account_ID, 'first_name');

	doSendMail($accountData['email'], $userData['first_name'], "Automatico Email", "Ativação de Conta", $bodyMail);
}


function setAccountNewCodePhone($account_ID, $user_ID) {
	$key = generateRandomString(true, false, false, 6);
	$keyDate = date("Y-m-d").' '.doSetTime(date("H:i:s"), config('accountValidation'));

	$bodyMail = "Por favor ative a sua conta pelo código abaixo: <b>".$key."</b>";

	
	doUpdateDB("UPDATE `accounts` SET `phoneCode`='".$key."', `phoneActive`='0', `phoneCodeDate`='".$keyDate."' WHERE `id`='".$account_ID."';");
	$accountData = getAccountData($account_ID, 'phone');

	$bodyPhone = "Seu código de verificação é: ".$key;
	doSendSMS($accountData['phone'], $bodyPhone);
}


function getAccountEmailCodeDate($account_ID) {
	
	$data = getAccountData($account_ID, 'emailCodeDate');

	return ($data['emailCodeDate'] != 0) ? $data['emailCodeDate'] : false;
}


function getAccountPhoneCode($account_ID) {
	
	$data = getAccountData($account_ID, 'phoneCode');

	return ($data !== false) ? $data['phoneCode'] : false;
}


function getAccountPhoneCodeDate($account_ID) {
	
	$data = getAccountData($account_ID, 'phoneCodeDate');

	return ($data['phoneCodeDate'] != 0) ? $data['phoneCodeDate'] : false;
}


function doActiveEmail($account_ID) {

	return (isAccountExist($account_ID)) ? doUpdateDB("UPDATE `accounts` SET `emailActive`='1' WHERE `id`='".$account_ID."';") : false;
}

function doActivePhone($account_ID) {

	return (isAccountExist($account_ID)) ? doUpdateDB("UPDATE `accounts` SET `phoneActive`='1' WHERE `id`='".$account_ID."';") : false;
}


function isAccountExist($account_ID) {
	$account_ID = sanitize($account_ID);
	
	$account = doSelectSingleDB("SELECT `id` FROM `accounts` WHERE `id`='$account_ID';");
	return ($account !== false) ? true : false;
}

function isAccountLoginExist($login) {
	$login = sanitize($login);
	
	$query = doSelectSingleDB("SELECT `id` FROM `accounts` WHERE `username`='$login';");
	return ($query !== false) ? true : false;
}

function isAccountPasswordExist($password) {
	$query = sanitize($password);
	
	$query = doSelectSingleDB("SELECT `id` FROM `accounts` WHERE `senha`='$password';");
	return ($query !== false) ? true : false;
}
function getAccountStatus($account_ID) {
	
	$data = getAccountData($account_ID, 'status');

	return ($data !== false) ? $data['status'] : false;
}

function isBlockedAccount($account_ID) {
	$id = sanitize($account_ID);

	return (getAccountStatus($account_ID) !== false && getAccountStatus($account_ID) == 0) ? true : false;
}

function doAccountConvertStatusInString($account_ID) {
	$data = getAccountData($account_ID, 'status');

	if($data !== false) {
		if($data['status'] == 0) 
			return 'DESATIVADO';
		elseif($data['status'] == 1)
			return 'ATIVADO';
	}
}


function getAccountIDUser($account_id) {
	$account_id = sanitize($account_id);
	$data = doSelectSingleDB("SELECT `id` FROM `users` WHERE `account_id`='$account_id' LIMIT 1;");
	
	return ($data !== false) ? $data['id'] : false;
}
/*
    $account_data =  array(
        'account_ID' 	    => $_POST['account_ID'],
        'username' 	    	=> getQueryUserID($_POST['query_ID']),
        'password' 			=> getQueryType($_POST['query_ID']),
        'phone' 		    => getQueryValue($_POST['query_ID'], 1),
        'phone_02' 		    => getQueryValue($_POST['query_ID'], 2),
        'email' 	    	=> getQueryCreditType($_POST['query_ID']),
        'created' 			=> getQueryDate($_POST['query_ID']),
        'ip' 			    => getQueryTime($_POST['query_ID']),
        'group' 			=> getQueryIP($_POST['query_ID']),
        'emailActive' 		=> $_POST['selectQStatus'],
        'emailCode' 		=> $_POST['selectAssigned'],
        'phoneActive'       => date("Y-m-d"),
        'phoneCode'         => date("H:i:s"),
        'status'            => $userData['id'],
        'phoneCodeDate'     => date("Y-m-d"),
        'emailCodeDate'     => date("H:i:s")
    );
*/
function doUpdateAccount($register_data) {

	$import_data_query = array(
		'username ' 			=> (!empty($register_data['username '])) ? $register_data['username '] : NULL,
		'password' 		=> (!empty($register_data['password'])) ? sha1($register_data['password']) : NULL,
		'phone' 		=> (!empty($register_data['phone'])) ? $register_data['phone'] : NULL,
		'phone_02' 		=> (!empty($register_data['phone_02'])) ? $register_data['phone_02'] : NULL,
		'email' 			=> (!empty($register_data['email'])) ? $register_data['email'] : NULL,
		'created' 			=> (!empty($register_data['created'])) ? $register_data['created'] : NULL,
		'ip' 			=> (!empty($register_data['ip'])) ? $register_data['ip'] : NULL,
		'group' 		=> (!empty($register_data['group'])) ? $register_data['group'] : NULL,
		'emailActive' 		=> (!empty($register_data['emailActive'])) ? $register_data['emailActive'] : NULL,
		'emailCode' => (!empty($register_data['emailCode'])) ? $register_data['emailCode'] : NULL,
		'phoneActive' => (!empty($register_data['phoneActive'])) ? $register_data['phoneActive'] : NULL,
		'phoneCode' => (!empty($register_data['phoneCode'])) ? $register_data['phoneCode'] : NULL,
		'status' => (!empty($register_data['status'])) ? $register_data['status'] : NULL,
		'phoneCodeDate' => (!empty($register_data['phoneCodeDate'])) ? $register_data['phoneCodeDate'] : NULL,
		'emailCodeDate' => (!empty($register_data['emailCodeDate'])) ? $register_data['emailCodeDate'] : NULL
	);
		
	foreach($import_data_query as $key => $value) {	
		if($value === NULL) {
			unset($import_data_query[$key]);
		}
	}

	$query_sql = doConvertUpdateSQLFormat($import_data_query);

	doUpdateDB("UPDATE `accounts` SET $query_sql WHERE `id`='".$register_data['account_ID']."';");
}
?>