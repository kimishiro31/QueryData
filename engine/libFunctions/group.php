<?php

function getGroup($group_ID) {
	
	return (array_key_exists($group_ID, config('adminGroups'))) ? config('adminGroups')[$group_ID] : false;
}

function isDefault($account_ID) {
	return (getAccountGroup($account_ID) <= 0) ? true : false;
}

function isAttendant($account_ID) {
	return (getAccountGroup($account_ID) >= 1) ? true : false;
}

function isManager($account_ID) {
	return (getAccountGroup($account_ID) >= 2) ? true : false;
}

function isAdmin($account_ID) {
	return (getAccountGroup($account_ID) >= 3) ? true : false;
}


?>

