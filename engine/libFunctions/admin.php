<?php


function getListAdmin($group) {
	$data = doSelectMultiDB("SELECT `accounts`.`id` as 'account_ID', `users`.`id` as 'user_ID' FROM `users` INNER JOIN `accounts` ON `users`.`account_id` = `accounts`.`id` and `accounts`.`group` >= $group;");

	return ($data !== false) ? $data : false;
}

?>