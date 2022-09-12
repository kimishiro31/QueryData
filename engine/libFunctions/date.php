<?php


function getOfAge($date) {
    $date1 = new DateTime(date("Y-m-d"));
    $date2 = new DateTime($date);

    $r = $date1->diff( $date2 );

    return ($r->y >= 18) ? true : false;
}

function doDateConvert($date, $dateTime = false) {

	if($dateTime) {
		$result = date('d/m/Y H:i:s', strtotime($date));
	} else {
		$result = date('d/m/Y', strtotime($date));
	}

	return ($date !== '' && $date !== NULL) ? $result : '';
}


function doDateConvertMonthToString($month) {
	$dateObj   = DateTime::createFromFormat('!m', $month);

	return utf8_encode(ucfirst(strftime( '%B', $dateObj -> getTimestamp())));
	
}

function doSetTime($Hours, $increment) {
	
	$addHours = date("H:i:s", strtotime($increment, strtotime($Hours)));
	$Hours = date("H:i:s", strtotime($addHours));

	return $Hours;
}

function doSetDay($date, $increment) {
	
	$addDate = date("Y-m-d", strtotime($increment, strtotime($date)));
	$date = date("Y-m-d", strtotime($addDate));

	return $date;
}

function doSetDateTime($dateTime, $increment) {
	$addDateTime = date("Y-m-d H:i:s", strtotime($increment, strtotime($dateTime)));
	$dateTime = date("Y-m-d H:i:s", strtotime($addDateTime));

	
	return $dateTime;
}

function doTimeConvert($time, $addTime = false, $format = false) {
	$format = ($format !== false) ? 'H:i:s' : 'H:i';

	$addHours = date($format, strtotime($addTime, strtotime($time)));
	$Hours = date($format, strtotime($time));

	return ($addTime !== false) ? $addHours : $Hours;
}

function isTimeValidation($time) {

	if($time) {
		$start = new DateTime('00:00');
		$end = new DateTime('23:59');
		$now = new DateTime($time);
	}
	return ($time > 0 && ($start <= $now && $now <= $end)) ? true : false;
}

?>