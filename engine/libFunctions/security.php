<?php
function getLoggedIn() {
	return (getSession('user_id') !== false) ? true : false;
}


function something() {
	// Make acc data compatible:
	$ip = getIPLong();
}

function getToken($token) {
	return ((isset($_SESSION[$token]) && isset($_POST['token'])) && ($_SESSION[$token] == $_POST['token'])) ? true : false;
}

function addToken($token) {
	return $_SESSION[$token];
}

function setToken($token) {
	$_SESSION[$token] = generateRandomString(true, false, true, 10);
}

function destroyToken($token) {
	unset($_SESSION[$token]);
}

function doProtect() {
	if (getLoggedIn() === false) {
		header('Location: index.php');
		exit();
	}
}

function doAccountActiveRedirect($account_ID, $status = false) {
	$account_ID = sanitize($account_ID);
	$email = config('accountConfirm')['email'];
	$phone = config('accountConfirm')['phone'];

	if($status === true) {
		if((getAccountEmailActive($account_ID) === false && $email === true) || (getAccountPhoneActive($account_ID) === false && $phone === true)) {
			header('Location: accountValidation.php');
			exit();
		}
	} else {
		if((getAccountEmailActive($account_ID) === true && $email === true) && (getAccountPhoneActive($account_ID) === true && $phone === true)) {
				header('Location: index.php');
			exit();
		} 
		elseif((getAccountEmailActive($account_ID) === true && $email === true) && (getAccountPhoneActive($account_ID) === false && $phone === false)) {
				header('Location: index.php');
			exit();
		} 
		elseif((getAccountEmailActive($account_ID) === false && $email === false) && (getAccountPhoneActive($account_ID) === true && $phone === true)) {
				header('Location: index.php');
			exit();
		}
	}
}

function setSession($key, $data) {
	global $sessionPrefix;
//	$_SESSION['cooldownSession'] = time();
	$_SESSION[$sessionPrefix.$key] = $data;
}

function getSession($key) {
	global $sessionPrefix;
	getTimeSession();
	return (isset($_SESSION[$sessionPrefix.$key])) ? $_SESSION[$sessionPrefix.$key] : false;
}

function getTimeSession() {
	if (isset($_SESSION['cooldownSession']) && (time() - $_SESSION['cooldownSession'] > config('timeLogout'))) { 
		header('Location: index.php');
		session_destroy();
	}
}

function doLoginRedirect() {
	if (getLoggedIn() === true) {
		header('Location: myaccount.php');
	}
}

function getAdminAccess() {
	doProtect();

	if (isAdmin(getSession('user_id')) === false) {
		header('Location: index.php');
		exit();
	}
}


function getManagerAccess() {
	doProtect();

	if (isManager(getSession('user_id')) === false) {
		header('Location: index.php');
		exit();
	}
}



function getAttendantAccess() {
	doProtect();

	if (isAttendant(getSession('user_id')) === false) {
		header('Location: index.php');
		exit();
	}
}



function validate_ip($ip) {
	$ipL = safeIp2Long($ip);
	$ipR = long2ip($ipL);

	if ($ip === $ipR) {
		return true;
	} elseif ($ip=='::1')  {
		return true;
	} else {
		return false;
	}
}

function getIP() {

	$IP = '';
	if (getenv('HTTP_CLIENT_IP')) {
	  $IP =getenv('HTTP_CLIENT_IP');
	} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
	  $IP =getenv('HTTP_X_FORWARDED_FOR');
	} elseif (getenv('HTTP_X_FORWARDED')) {
	  $IP =getenv('HTTP_X_FORWARDED');
	} elseif (getenv('HTTP_FORWARDED_FOR')) {
	  $IP =getenv('HTTP_FORWARDED_FOR');
	} elseif (getenv('HTTP_FORWARDED')) {
	  $IP = getenv('HTTP_FORWARDED');
	} else {
		// VERIFICA SE CLOUNDFLARE ESTÁ ATIVO
	  $IP = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];
	} 
  return $IP;
  }
  
  function safeIp2Long($ip) {
	  return sprintf('%u', ip2long($ip));
  }
  
  // Gets you the actual IP address even from users in long type
  function getIPLong() {
	  return safeIp2Long(getIP());
  }
  


?>