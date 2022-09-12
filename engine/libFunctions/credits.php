<?php

	#########################################
	## FUNÇÕES HISTORICO DE CRÉDITOS
	#########################################

function doListCreditSold($user_ID, $ppage, $rowsPerPage) {
//	$order = ORDER by `data_agendamento` ".getOrder($_GET['order']).";
	$order = '';

	return doSelectMultiDB("SELECT `id` FROM `credits_sold` where `user_id`='".$user_ID."' ORDER BY `credits_sold`.`created_dateTime` DESC LIMIT $ppage, $rowsPerPage;");
}

function getCreditSoldData($credit_ID) {
	$data = array();
	$credit_ID = sanitize($credit_ID);
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1)  {
		unset($func_get_args[0]);
		
		$fields = '`'. implode('`, `', $func_get_args) .'`';
		return doSelectSingleDB("SELECT $fields FROM `credits_sold` WHERE `id` = '".$credit_ID."' LIMIT 1;");
	} else 
	return false;
}


function isCreditSoldExist($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	
	$data = doSelectSingleDB("SELECT `id` FROM `credits_sold` WHERE `id`='$credit_ID';");
	return ($data !== false) ? true : false;
}

function isCreditSoldPurchaseUIDExist($purchase_UID) {
	$purchase_UID = sanitize($purchase_UID);
	
	$data = doSelectSingleDB("SELECT `id` FROM `credits_sold` WHERE `purchase_uid`='$purchase_UID';");
	return ($data !== false) ? true : false;
}

function getCreditSoldCreditID($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "credit_id";
	$data = getCreditSoldData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditSoldUserID($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "user_id";
	$data = getCreditSoldData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}
function getCreditSoldPurchaseUID($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "purchase_uid";
	$data = getCreditSoldData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditSoldMethodPayment($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "method_payment";
	$data = getCreditSoldData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditSoldCreated($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "created_dateTime";
	$data = getCreditSoldData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditSoldStatus($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "status";
	$data = getCreditSoldData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}
function getCreditSoldStatusDate($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "status_dateTime";
	$data = getCreditSoldData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}
function getCreditSoldExpirationDate($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "status_dateTimeExpiration";
	$data = getCreditSoldData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditSoldIp($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "ip_address";
	$data = getCreditSoldData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}


function doAddCreditSold($register_data) {
    array_walk($register_data, 'array_sanitize');

	$query_sql = "`".implode("`, `", array_keys($register_data))."`";
	$value_sql = "'".implode("', '", array_values($register_data))."'";
    doInsertDB("INSERT INTO `credits_sold` ($query_sql) VALUES ($value_sql)");
}

function doUpdateCreditSold($register_data, $user_ID) {

    $import_data_query = array(
        'credit_id ' 			    => (!empty($register_data['credit_id '])) ? $register_data['credit_id '] : NULL,
        'user_id' 		            => (!empty($register_data['user_id'])) ? $register_data['user_id'] : NULL,
        'purchase_uid' 	        	=> (!empty($register_data['purchase_uid'])) ? $register_data['purchase_uid'] : NULL,
        'method_payment' 	    	=> (!empty($register_data['method_payment'])) ? $register_data['method_payment'] : NULL,
        'created_dateTime' 			=> (!empty($register_data['created_dateTime'])) ? $register_data['created_dateTime'] : NULL,
        'status' 			        => (!empty($register_data['status'])) ? $register_data['status'] : NULL,
        'status_dateTime' 			=> (!empty($register_data['status_dateTime'])) ? $register_data['status_dateTime'] : NULL,
        'status_dateTimeExpiration' => (!empty($register_data['status_dateTimeExpiration'])) ? $register_data['status_dateTimeExpiration'] : NULL,
        'ip_address' 		        => (!empty($register_data['ip_address'])) ? $register_data['ip_address'] : NULL
    );
    
    foreach($import_data_query as $key => $value) {	
        if($value === NULL) {
            unset($import_data_query[$key]);
        }
    }

    $query_sql = doConvertUpdateSQLFormat($import_data_query);

    doUpdateDB("UPDATE `credits_sold` SET $query_sql WHERE `id`='".$register_data['credit_sold_ID']."' and `user_id`='".$user_ID."';");
}

	#########################################
	## FUNÇÕES PACK CRÉDITs
	#########################################


function doListCredits() {
    $data = doSelectMultiDB("SELECT `id` FROM `credits`;");
    
    return ($data !== false) ? $data : false;
}

function getCreditData($credit_ID) {
	$data = array();
	$credit_ID = sanitize($credit_ID);
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1)  {
		unset($func_get_args[0]);
		
		$fields = '`'. implode('`, `', $func_get_args) .'`';
		return doSelectSingleDB("SELECT $fields FROM `credits` WHERE `id` = '".$credit_ID."' LIMIT 1;");
	} else 
	return false;
}

function isCreditExist($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	
	$data = doSelectSingleDB("SELECT `id` FROM `credits` WHERE `id`='$credit_ID';");
	return ($data !== false) ? true : false;
}

function getCreditName($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "name";
	$data = getCreditData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditDescription($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "description";
	$data = getCreditData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditQuantity($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "quantity";
	$data = getCreditData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditCost($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "cost";
	$data = getCreditData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditDiscount($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "discount";
	$data = getCreditData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditDiscountDateStart($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "discount_dateStart";
	$data = getCreditData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditDiscountTimeStart($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "discount_timeStart";
	$data = getCreditData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditDiscountDateEnd($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "discount_dateEnd";
	$data = getCreditData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditDiscountTimeEnd($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	$column = "discount_timeEnd";
	$data = getCreditData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}


	#########################################
	## FUNÇÕES User CRÉDITO
	#########################################

function getCreditUserData($credit_ID) {
	$data = array();
	$credit_ID = sanitize($credit_ID);
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1)  {
		unset($func_get_args[0]);
		
		$fields = '`'. implode('`, `', $func_get_args) .'`';
		return doSelectSingleDB("SELECT $fields FROM `users_credit` WHERE `id` = '".$credit_ID."' LIMIT 1;");
	} else 
	return false;
}

function isCreditUserExist($credit_ID) {
	$credit_ID = sanitize($credit_ID);
	
	$data = doSelectSingleDB("SELECT `id` FROM `users_credit` WHERE `id`='$credit_ID';");
	return ($data !== false) ? true : false;
}

function getCreditUser($user_ID) {
	$user_ID = sanitize($user_ID);
	$data = doSelectSingleDB("SELECT `id` FROM `users_credit` WHERE `user_id`='$user_ID';");

	return ($data !== false) ? $data['id'] : false;
}

function getCreditUserValue($credit_ID) {
	$column = "value";
	$data = getCreditUserData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function getCreditUserStatus($credit_ID) {
	$column = "status";
	$data = getCreditUserData($credit_ID, $column);

	return ($data !== false) ? $data[$column] : false;
}

function doAddUserCredit($user_ID, $increment) {
    $credit_ID = getCreditUser($user_ID);
    $creditValue = getCreditUserValue($credit_ID);

    if($creditValue <= 0) 
        $creditValue = 0;

    if($increment <= 0) 
        $increment = 1;
    
    $som = $creditValue + $increment;

    if(isCreditUserExist($credit_ID))
    	doUpdateDB("UPDATE `users_credit` SET `value`='".$som."' WHERE `user_id`='".$user_ID."';");
    else
        doInsertDB("INSERT INTO `users_credit` (`user_id`, `value`, `status`) VALUES ('".$user_ID."', '".$increment."', '1')");
}

function doRemoveUserCredit($user_ID, $decrease) {
    $credit_ID = getCreditUser($user_ID);
    $creditValue = getCreditUserValue($credit_ID);

    if($creditValue <= 0) 
        $creditValue = 0;

    if($decrease <= 0) 
        $decrease = 1;
    
    $som = $creditValue - $decrease;

    if($som <= 0)
        $som = 0;

    if(isCreditUserExist($credit_ID))
    	doUpdateDB("UPDATE `users_credit` SET `value`='".$som."' WHERE `user_id`='".$user_ID."';");
}


	#########################################
	## FUNÇÕES PACOTES
	#########################################

function doListPackages() {
	return doSelectMultiDB("SELECT `id` FROM `packages`;");
}

function getPackageData($package_ID) {
    $data = array();
    $package_ID = sanitize($package_ID);
            
    $func_num_args = func_num_args();
    $func_get_args = func_get_args();
            
    if ($func_num_args > 1)  {
        unset($func_get_args[0]);
                
        $fields = '`'. implode('`, `', $func_get_args) .'`';
        return doSelectSingleDB("SELECT $fields FROM `packages` WHERE `id` = '".$package_ID."' LIMIT 1;");
    } else 
        return false;
}
        
function isPackageExist($package_ID) {
    $package_ID = sanitize($package_ID);
            
    $data = doSelectSingleDB("SELECT `id` FROM `packages` WHERE `id`='$package_ID';");
    return ($data !== false) ? true : false;
}

function getPackageName($package_ID) {
    $column = "name";
    $data = getPackageData($package_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}

function getPackageDescription($package_ID) {
    $column = "description";
    $data = getPackageData($package_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}
            
function getPackageValue($package_ID) {
    $column = "reward_value";
    $data = getPackageData($package_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}

function getPackageCost($package_ID) {
    $column = "cost";
    $data = getPackageData($package_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}
    
	#########################################
	## FUNÇÕES PACOTES CONTRATADOS
	#########################################

function getPackData($pack_ID) {
    $data = array();
    $pack_ID = sanitize($pack_ID);
        
    $func_num_args = func_num_args();
    $func_get_args = func_get_args();
        
    if ($func_num_args > 1)  {
        unset($func_get_args[0]);
            
        $fields = '`'. implode('`, `', $func_get_args) .'`';
        return doSelectSingleDB("SELECT $fields FROM `contracted_pack` WHERE `id` = '".$pack_ID."' LIMIT 1;");
    } else 
        return false;
}
    
function isPackExist($user_ID) {
    $user_ID = sanitize($user_ID);
        
    $data = doSelectSingleDB("SELECT `id` FROM `contracted_pack` WHERE `user_id` = '".$user_ID."';");
    return ($data !== false) ? true : false;
}
        
function getUserPack($user_ID) {
    $user_ID = sanitize($user_ID);
    $data = doSelectSingleDB("SELECT `id` FROM `contracted_pack` WHERE `user_id`='$user_ID';");

    return ($data !== false) ? $data['id'] : false;
}

function isPackContracted($user_ID) {
    $user_ID = sanitize($user_ID);
        
    $data = doSelectSingleDB("SELECT `pack_id` FROM `contracted_pack` WHERE `user_id` = '".$user_ID."';");

    return ($data !== false) ? $data['pack_id'] : false;
}
        

function getPackValue($pack_ID) {
    $column = "value";
    $data = getPackData($pack_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}

function getPackCost($pack_ID) {
    $column = "cost";
    $data = getPackData($pack_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}

function getPackCostRL($pack_ID) {
    $column = "cost_real";
    $data = getPackData($pack_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}

function getPackDiscountApplied($pack_ID) {
    $column = "discount_applied";
    $data = getPackData($pack_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}


function getPackDateStart($pack_ID) {
    $column = "start_date";
    $data = getPackData($pack_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}

function getPackTimeStart($pack_ID) {
    $column = "start_time";
    $data = getPackData($pack_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}


function getPackDateEnd($pack_ID) {
    $column = "end_date";
    $data = getPackData($pack_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}

function getPackTimeEnd($pack_ID) {
    $column = "end_time";
    $data = getPackData($pack_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}

function getPackIp($pack_ID) {
    $column = "ip";
    $data = getPackData($pack_ID, $column);

    return ($data !== false) ? $data[$column] : false;
}



function doAddUserVouncher($user_ID, $increment, $pack_ID, $cost, $ip) {
    $userPackValue = getPackValue(getUserPack($user_ID));
    $packValue = getPackageValue($pack_ID);
    $costRL = getPackageCost($pack_ID);
    $discountApp = ($costRL - $cost); 
    $sDate = date("Y-m-d"); 
    $sTime = date("H:i:s");
    $eDate = doSetDay($sDate, getPackageValue($pack_ID).' days');
    $eTime = date("H:i:s");

    if($packValue <= 0) 
        $packValue = 0;

    if($increment <= 0) 
        $increment = 1;

    doInsertDB("INSERT INTO `contracted_pack` (`user_id`, `pack_id`, `value`, `cost`, `cost_real`, `discount_applied`, `start_date`, `start_time`, `end_date`, `end_time`, `ip`) VALUES ('".$user_ID."', '".$pack_ID."', '".$increment."', '".$cost."', '".$costRL."', '".$discountApp."', '".$sDate."', '".$sTime."', '".$eDate."', '".$eTime."', '".$ip."')");
}


function doUpdateUserVouncherValue($user_ID, $increment, $pack_ID) {
    $userPackValue = getPackValue(getUserPack($user_ID));
    $packValue = getPackageValue($pack_ID);

    if($packValue <= 0) 
        $packValue = 0;

    if($increment <= 0) 
        $increment = 1;

    $som = $userPackValue + $increment;

    doUpdateDB("UPDATE `contracted_pack` SET `value`='".$som."' WHERE `user_id`='".$user_ID."' and `pack_id`='".$pack_ID."';");
}

function doRemoveUserVouncher($user_ID, $decrease, $pack_ID) {
    $userPackValue = getPackValue(getUserPack($user_ID));
    $packValue = getPackageValue($pack_ID);

    if($userPackValue <= 0) 
        $userPackValue = 0;

    if($packValue <= 0) 
        $packValue = 0;

    if($decrease <= 0) 
        $decrease = 1;

    $som = $userPackValue - $decrease;

    if($som <= 0) 
        $som = 0;

    if($som == 0) {
        doInsertDB("INSERT INTO `contracted_pack_logs` (`user_id`, `pack_id`, `value`, `cost`, `cost_real`, `discount_applied`, `start_date`, `start_time`, `end_date`, `end_time`, `ip`) VALUES ('".$user_ID."', '".$pack_ID."', '".getPackValue(getUserPack($user_ID))."', '".getPackCost(getUserPack($user_ID))."', '".getPackCostRL(getUserPack($user_ID))."', '".getPackDiscountApplied(getUserPack($user_ID))."', '".getPackDateStart(getUserPack($user_ID))."', '".getPackTimeStart(getUserPack($user_ID))."', '".getPackDateEnd(getUserPack($user_ID))."', '".getPackTimeEnd(getUserPack($user_ID))."', '".getPackIp(getUserPack($user_ID))."')");
        doDeleteDB("DELETE FROM `contracted_pack` WHERE `user_id`='$user_ID' and `pack_id`='$pack_ID' limit 1;");
    }
    else
        doUpdateDB("UPDATE `contracted_pack` SET `value`='".$som."' WHERE `user_id`='".$user_ID."' and `pack_id`='".$pack_ID."';");
}

function getUserPackValue($user_ID, $pack_ID) {
    $user_ID = sanitize($user_ID);
    $pack_ID = sanitize($pack_ID);

    $data = doSelectSingleDB("SELECT SUM(`value`) as total FROM `contracted_pack` WHERE `user_ID` = '".$user_ID."' and `pack_ID` = '".$pack_ID."' LIMIT 1;");
    
    if(empty($data['total']))
        $data['total'] = 0;

    return ($data !== false) ? $data['total'] : false;
}
?>