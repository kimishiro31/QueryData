<?php

$time = time();
if (!function_exists("elapsedTime")) {
	function elapsedTime($l_start = false, $l_time = false) {
		if ($l_start === false) global $l_start;
		if ($l_time === false) global $l_time;

		$l_time = explode(' ', microtime());
		$l_finish = $l_time[1] + $l_time[0];
		return round(($l_finish - $l_start), 4);
	}
}

// Faz a conexão com o banco de dados
$connect = new mysqli($config['sqlHost'], $config['sqlUser'], $config['sqlPassword'], $config['sqlDatabase']);

/*
// Verifica se a conexão falhou, se falhar ele manda para a página de instalação para refazer.
if ($connect->connect_errno) {
	header('Location: ../install/index.php');
}*/

function doCreateTableDB($table) {
	global $connect;
	mysqli_query($connect, 'create table if not exists '.$table.' (any varchar(255));') or die(var_dump($table)."<br>(query - <font color='red'>SQL error</font>) <br><br><br>".mysqli_error($connect));
}

function doTruncateTableDB($table) {
	global $connect;
	mysqli_query($connect, 'TRUNCATE '.$table.';') or die(var_dump($table)."<br>(query - <font color='red'>SQL error</font>) <br><br><br>".mysqli_error($connect));
}

function doEscapeSstringDB($escapestr) {
	global $connect;
	return mysqli_real_escape_string($connect, $escapestr);
}

function doInsertMultiDB($query) {
	global $connect;
	mysqli_multi_query($connect, $query) or die(var_dump($query)."<br>(query - <font color='red'>SQL error</font>) <br><br><br>".mysqli_error($connect));
}

function getLastInsertDB() {

	global $connect;
	global $aacQueries;
	$aacQueries++;
	global $accQueriesData;
	
	$query = "SELECT  LAST_INSERT_ID();";

	$accQueriesData[] = "[" . elapsedTime() . "] " . $query;
	$result = mysqli_query($connect,$query) or die(var_dump($query)."<br>(query - <font color='red'>SQL error</font>) <br>Type: <b>select_single</b> (select single row from database)<br><br>".mysqli_error($connect));
	$row = mysqli_fetch_assoc($result);


	return ($row != 0) ? $row['LAST_INSERT_ID()'] : false;
}

function doSelectSingleDB($query) {
	global $connect;
	global $aacQueries;
	$aacQueries++;

	global $accQueriesData;
	$accQueriesData[] = "[" . elapsedTime() . "] " . $query;
	$result = mysqli_query($connect,$query) or die(var_dump($query)."<br>(query - <font color='red'>SQL error</font>) <br>Type: <b>select_single</b> (select single row from database)<br><br>".mysqli_error($connect));
	$row = mysqli_fetch_assoc($result);
	return !empty($row) ? $row : false;
}

function doSelectMultiDB($query){
	global $connect;
	global $aacQueries;
	$aacQueries++;
	global $accQueriesData;
	$accQueriesData[] = "[" . elapsedTime() . "] " . $query;
	$array = array();
	$results = mysqli_query($connect,$query) or die(var_dump($query)."<br>(query - <font color='red'>SQL error</font>) <br>Type: <b>select_multi</b> (select multiple rows from database)<br><br>".mysqli_error($connect));
	while($row = mysqli_fetch_assoc($results)) {
		$array[] = $row;
	}
	return !empty($array) ? $array : false;
}

function doResetDB() {
doUpdateDB("SET foreign_key_checks = 0;");
doCreateTableDB('accounts');
doTruncateTableDB('accounts');
doUpdateDB("SET foreign_key_checks = 1;");
doInsertDB("INSERT INTO `accounts` (`id`, `name`, `password`, `salt`, `premdays`, `lastday`, `email`, `old_email`, `key`, `blocked`, `warnings`, `group_id`, `premium_points`, `created`, `create_ip`, `flag`, `active`, `activekey`) VALUES (1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '', '1500', '0', 'admin@admin.com.br', '', '1', '0', '0', '6', '10000', NULL, '0', '1', '1', '0');");
}

function doUpdateDB($query){ voidQuery($query); }

function doInsertDB($query){ voidQuery($query); }

function doDeleteDB($query){ voidQuery($query); }

// Send a void query
function voidQuery($query) {
	global $connect;
	global $aacQueries;
	$aacQueries++;
	global $accQueriesData;
	$accQueriesData[] = "[" . elapsedTime() . "] " . $query;
	mysqli_query($connect,$query) or die(var_dump($query)."<br>(query - <font color='red'>SQL error</font>) <br>Type: <b>voidQuery</b> (voidQuery is used for update, insert or delete from database)<br><br>".mysqli_error($connect));
}
?>
