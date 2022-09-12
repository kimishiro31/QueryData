<?php 
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
ini_set('memory_limit', '-1');

$l_time = microtime();
$l_time = explode(' ', $l_time);
$l_time = $l_time[1] + $l_time[0];
$l_start = $l_time;


if(isset($_REQUEST['sub']))
	$sub = (string) $_REQUEST['sub'];
else
	$sub = '';


function elapsedTime($l_start = false, $l_time = false) {
	if ($l_start === false) global $l_start;
	if ($l_time === false) global $l_time;

	$l_time = explode(' ', microtime());
	$l_finish = $l_time[1] + $l_time[0];
	return round(($l_finish - $l_start), 4);
}

$time = time();
$aacQueries = 0;
$accQueriesData = array();
$url_atual = $_SERVER["REQUEST_URI"];

session_start();
ob_start();
require_once 'config.php';

/*************************
**
** BIBLIOTECA DE FUNÇÕES
**
**************************/
require_once 'libEx/PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
require_once 'libEx/PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once 'libEx/PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once 'libEx/PHPMailer/vendor/autoload.php';


require_once 'libFunctions/sql.php';
require_once 'libFunctions/admin.php';
require_once 'libFunctions/general.php';
require_once 'libFunctions/account.php';
require_once 'libFunctions/date.php';
require_once 'libFunctions/popups.php';
require_once 'libFunctions/security.php';
require_once 'libFunctions/strftime.php';
require_once 'libFunctions/users.php';
require_once 'libFunctions/mail.php';
require_once 'libFunctions/queries.php';
require_once 'libFunctions/credits.php';
require_once 'libFunctions/usersCode.php';
require_once 'libFunctions/group.php';
require_once 'libFunctions/sms.php';
require_once 'libFunctions/mercadoPago.php';
include_once 'libEx/mercadoPago/vendor/autoload.php';
include_once 'libEx/zenvia/autoload.php';

use function PHP81_BC\strftime;

addUserVisit(getIP(), date("Y-m-d"), date("H:i:s"), config('timeNewVisit'));

if (getLoggedIn() === true) {
	$session_user_id = getSession('user_id');
	$accountData = getAccountData($session_user_id, 'id', 'username', 'password', 'email');
	$userData = getUserData(getAccountIDUser($accountData['id']), 'id', 'first_name', 'last_name');
}

$contact = $config['contacts'];
$mvv = $config['ConfigMVV'];
$dhEnabled = $config['siteDHEnabled'];
$errors = array();


?>
