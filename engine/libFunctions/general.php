<?php

function doCPFValidation($cpf) {
	$crescent = 2; // contador inicial
	$spd = 0; // soma do primeiro digito
	$ssd = 0; // soma do segundo digito

	// Valida se a string é numero | se tem 11 caracteres | verifica se a sequencia é de mesmo numero
	if(is_numeric($cpf) === false || strlen($cpf) < 1 || strlen($cpf) > 11 || isSameCharacter($cpf))
		return false;

	// faz a soma necessária para os calculos
	for($cn = 8; $cn >= 0; --$cn, ++$crescent) {
		$spd += ($crescent * $cpf[$cn]);
		$ssd += (($crescent+1) * $cpf[$cn]);
	}
	
	// verifica quais as numeração do primeiro e segundo digito
	$pd = ($spd % 11 < 2) ? 0 : (11 - ($spd % 11));
	$sd = (($ssd + ($pd * 2)) % 11 < 2) ? 0 : (11 - (($ssd + ($pd * 2)) % 11));

	// valida se é igual ao informado
	for($cn = 9; $cn <= 10; ++$cn) {
		if ((int)$cpf[9] !== $pd || (int)$cpf[10] !== $sd)
			return false;
	}
	
	return true;
}

function getOrder($order) {
	return ($order === 'asc') ? 'desc' : 'asc';
}

function getSystemWindows() {
	$SO = stristr(php_uname('s'), 'Windows');
	return (strpos($SO, 'Windows') !== false) ? true : false;
}

function getSystemLinux() {
	$SO = stristr(php_uname('s'), 'Linux');
	
	return (strpos($SO, 'Linux') !== false) ? true : false;
}

function doCreateUserFolder($cpf) {
	$cpf = md5($cpf);

	if (getSystemWindows()) 
		$dir = 'engine/users/images/';
	else 
		$dir = '/var/www/html/engine/users/images/';
	
	if (is_dir($dir.'/'.$cpf) === false)
		mkdir($dir.'/'.$cpf, 0777, true);
}

function getUserFolder($cpf) {
	$cpf = md5($cpf);
	
	if (getSystemWindows()) 
		$dir = 'engine/users/images';
	else 
		$dir = '/var/www/html/engine/users/images';
	
	$dirFiles = $dir.'/'.$cpf;
	return (is_dir($dirFiles)) ? $dirFiles : false;
}


function getUserFolderForIMG($cpf) {
	$cpf = md5($cpf);
	
	if (getSystemWindows()) 
		$dir = 'engine/users/images';
	else 
		$dir = '/engine/users/images';
	
	$dirFiles = $dir.'/'.$cpf;
	
	return $dirFiles;
}

function getSystemFolder() {
	
	if (getSystemWindows()) 
		$dir = 'web';
	else 
		$dir = '/var/www/html/web';
	
	return (is_dir($dir)) ? $dir : false;
}

function getSizeString($string, $min, $max) {
	$string = (string)$string;
	return (strlen($string) < $min || strlen($string) > $max) ? false : true;
}

function getWordCount($p, $value) {
	return ($value >= str_word_count($p) === true) ? true : false;
}

function sanitizeString($str) {
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    $str = preg_replace('/[,.\/(),;:|!"#$%&=?~^><ªº-]/', '', $str);
//    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
	$str = str_replace(' ', '', $str);
	$str = preg_replace('/[+*-]+/', '', $str);
	
    return $str;
}
function getStringAZ($string) {
    return !!preg_match('|^[\pL\s]+$|u', $string);
}

function isSameCharacter($string) {

	if(empty($string) !== true) {
		$firstCharacter = $string[1];

		for($count = 0; $count < strlen($string); ++$count) {
			if($string[$count] !== $firstCharacter) 
				return false;
		}
	
		return true;
	}

}

function doFormatCPF($cpf) {
 	$cpf = preg_replace("/[^0-9]/", "", $cpf);
	$qtd = strlen($cpf);

	if($qtd >= 11) {
		if($qtd === 11 ) {
			$cpf = 			substr($cpf, 0, 3) . '.' .
							substr($cpf, 3, 3) . '.' .
							substr($cpf, 6, 3) . '/' .
							substr($cpf, 9, 2);
		}

		return $cpf;

	}
}

function doSliceName($name, $type = 0) {
    $name = sanitizeString($name);
    $explode = explode(' ', $name);
    $sobName = array();

    for($c = 1; $c < count($explode); ++$c) {
        $sobName[] = $explode[$c];
    }

    $name = implode(" ", $sobName);

    return ($type == 0) ? $explode[0] : $name;
}

function doDeleteFolder($dir) { 

	if(is_dir($dir)) {
		$files = array_diff(scandir($dir), array('.','..')); 

		foreach ($files as $file) { 
		  (is_dir("$dir/$file")) ? doDeleteFolder("$dir/$file") : unlink("$dir/$file"); 
		} 
		return rmdir($dir); 	
	}

	return false;
  }

function data_dump($print = false, $var = false, $title = false) {
	if ($title !== false) echo "<pre><font color='red' size='5'>$title</font><br>";
	else echo '<pre>';
	if ($print !== false) {
		echo 'Print: - ';
		print_r($print);
		echo "<br>";
	}
	if ($var !== false) {
		echo 'Var_dump: - ';
		var_dump($var);
	}
	echo '</pre><br>';
}

function url($path = false) {
	$folder   = dirname($_SERVER['SCRIPT_NAME']);
	return config('site_url') . '/' . $path;
}


function config($value) {
	global $config;
	return $config[$value];
}

function fullConfig() {
	global $config;
	return $config;
}

function array_sanitize(&$item) {
	$item = htmlentities(strip_tags(doEscapeSstringDB($item)));
}

function sanitize($data) {
	return htmlentities(strip_tags(doEscapeSstringDB($data)));
}

function doConvertUpdateSQLFormat($data) {
	$sqlformat = "";
	foreach($data as $column => $data) {
		$sqlformat = $sqlformat."`".$column."`='".$data."'";
	}
	$sqlformat = str_replace("'`", "', `", $sqlformat);
	return $sqlformat;
}


function generateRandomString($numbers = false, $specials = false, $letters = false, $length = 16) {

	if($numbers || ($numbers === false && $specials === false && $letters === false))
		$result[] = '123456789';

	if($letters || ($numbers === false && $specials === false && $letters === false))
		$result[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	
	if($specials || ($numbers === false && $specials === false && $letters === false))
		$result[] = '!@#$%&*';
	
	$characters = implode('', $result);

	$charactersLength = strlen($characters);

	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}


function getTypeQuery($query_ID) {
	return (array_key_exists($query_ID, config('configQueries'))) ? config('configQueries')[$query_ID]['name'] : false;
}

function getConfigQueryCost($query_ID) {
	return (array_key_exists($query_ID, config('configQueries'))) ? config('configQueries')[$query_ID]['cost'] : false;
}

function getConfigQueryDescription($query_ID) {
	return (array_key_exists($query_ID, config('configQueries'))) ? config('configQueries')[$query_ID]['description'] : false;
}

function getTypeCreditName($payment_ID) {
	
	return (array_key_exists($payment_ID, config('typeCredits'))) ? config('typeCredits')[$payment_ID]['name'] : false;
}

function getTypeCreditTime($payment_ID) {
	
	return (array_key_exists($payment_ID, config('typeCredits'))) ? config('typeCredits')[$payment_ID]['time'] : false;
}

function getStatusQuery($status_ID) {
	
	return (array_key_exists($status_ID, config('statusQuery'))) ? config('statusQuery')[$status_ID] : false;
}

function doTransformCode($n) {
	return str_pad($n, 5, '0', STR_PAD_LEFT);
}

function getPercentProgressBar($start, $end) {
	$dI = strtotime($start);
	$dA = strtotime(date("Y-m-d H:i:s"));
	$dF = strtotime($end);
	
	$intervalo = $dA - $dI;
	$final = $dF - $dI;


	if($final != 0)
		$calc = ($intervalo / $final) * 100;
	else
		$calc = 100;

	if($calc > 100)
		$calc = 100;

	return ceil($calc);
}

function getPercentProgressBarStopped($start, $finished, $end) {
	$dI = strtotime($start);
	$dA = strtotime($finished);
	$dF = strtotime($end);
	
	$intervalo = $dA - $dI;
	$final = $dF - $dI;


	if($final != 0)
		$calc = ($intervalo / $final) * 100;
	else
		$calc = 100;

	if($calc > 100)
		$calc = 100;

	return ceil($calc);
}

function doListQueriesConsult() {
	$apage = isset($_GET['page']) ? $_GET['page'] : 1;
    $rowsPerPage = config('rowsPerPage');
    $ppage = ($apage * $rowsPerPage) - $rowsPerPage;

    if(!isset($_GET['order'])) $_GET['order'] = 'desc';

    $result = doSelectMultiDB("SELECT * FROM `queries`");
    
    if($result !== false) {
        $total = count($result);
        $countLink = ceil($total / $rowsPerPage);
        echo '<center>';
        for ($i = $apage - 3; $i <= $countLink; ++$i) {
            
            if($i < 1) $i = 1;
            
            $type = (isset($_GET['type'])) ? '&type='.$_GET['type'] : '';
            $order = (isset($_GET['order'])) ? '&order='.$_GET['order'] : '';

            if($i == $apage)
                echo ' ['. $i . '] ';
            else
                echo '<a href="?page='.$i.$type.$order.'">[ '.$i.' ]</a> ';
        }
        echo '</center>';
    }

	$r = array(
		'rowsPerPage' => $rowsPerPage,
		'ppage' => $ppage,
	);

	return $r;
}


function getStatus($status_ID) {
	
	return (array_key_exists($status_ID, config('status'))) ? config('status')[$status_ID] : false;
}

function getStatusVerify($status_ID) {
	
	return (array_key_exists($status_ID, config('statusVerify'))) ? config('statusVerify')[$status_ID] : false;
}



function doLiberationPayment($user_ID) {
    
	$query = doSelectMultiDB("SELECT 'id', 'purchase_uid' FROM `credits_sold` where `status` = 'EM ANALISE';");

	foreach($query as $key) {
		$collection_ID = "1307862750";
		$accessToken = config('marketConfig')['accessToken']; 
		
			$curl = curl_init();
		  
				curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://api.mercadopago.com/v1/payments/'.$collection_ID,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => TRUE,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => ARRAY(
					'Authorization: Bearer '.$accessToken
				),
				));
				
			$payment_info = json_decode(curl_exec($curl), true);
			curl_close($curl);
	
			$dateUpdate = explode('T', $payment_info['date_last_updated']);
			$hourUpdate = explode('.', $dateUpdate[1]);

		if($payment_info['status_detail'] === 'approved') {
			$register_data = array(
				'credit_sold_ID' 			=> $key['id'],
				'status' 			        => 'APROVADO',
				'status_dateTime' 			=> $dateUpdate[0].' '.$hourUpdate[0]
			);	
			doUpdateCreditSold($register_data, $user_ID);
			doAddUserCredit($user_ID, getCreditQuantity(getCreditSoldCreditID($payment_info['additional_info']['items'][0]['id'])));
		}
	}
	
};










        /*********************************************************
        **
        ** VALIDAÇÃO REGISTRADOR DE VISITAS
        **
        **********************************************************/


function getUserVisit() {
	$visit =  doSelectSingleDB("SELECT count(`id`) as visit_total FROM `siteVisits`;");

	return $visit['visit_total'];
}

function addUserVisit($ip, $date, $time, $limiter) {
	$visit = doSelectSingleDB("SELECT * FROM `siteVisits` WHERE `ip` = '".$ip."' and `date`='".$date."' order by `id` desc;");

	if($visit === false) {
		doInsertDB("INSERT INTO `siteVisits` (`ip`, `date`, `time`) VALUES ('".$ip."', '".$date."', '".$time."');");
	} else {
		if(date("H:i:s") >= doSetTime($visit['time'], $limiter)) {
			doInsertDB("INSERT INTO `siteVisits` (`ip`, `date`, `time`) VALUES ('".$ip."', '".$date."', '".$time."');");
		} else {
			return true;
		}
	}
}


?>