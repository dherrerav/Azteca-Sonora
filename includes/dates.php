<?php

date_default_timezone_set('America/Hermosillo');
include_once 'Zend/Date.php';

function dateDifference($time1, $time2, $precission = 6) {
	if (!is_int($time1)) {
		$time1 = strtotime($time1);
	}
	if (!is_int($time2)) {
		$time2 = strtotime($time2);
	}
	$date1 = new Zend_Date($time1);
	$date2 = new Zend_Date($time2);
	$difference = $date2->sub($date1);
	$days = $difference->toString(Zend_Date::DAY);
	$hours = $difference->toString(Zend_Date::HOUR);
	$minutes = $difference->toString(Zend_Date::MINUTE);
	$seconds = $difference->toString(Zend_Date::SECOND);
	return sprintf('%s:%s:%s:%s', $days, $hours, $minutes, $seconds);
	if ($time1 > $time2) {
		$ttime = $time1;
		$time1 = $time2;
		$time2 = $ttime;
	}
	
	$intervals = array(
		'year',
		'month',
		'day',
		'hour',
		'minute',
		'second',
	);
	$differences = array();
	foreach ($intervals as $interval) {
		$differences[$interval] = 0;
		$ttime = strtotime('+1' . $interval, $time1);
		while ($time2 >= $ttime) {
			$time1 = $ttime;
			$differences[$interval]++;
			$ttime = strtotime('+1' . $interval, $time1);
		}
	}
	$count = 0;
	$times = array();
	foreach ($differences as $interval => $value) {
		if ($count >= $precission) {
			break;
		}
		if ($value > 0) {
			if ($value != 1) {
				$interval .= 's';
			}
			$times[] = str_pad($value, 2, '0', STR_PAD_LEFT);
			$count++;
		}
	}
	return implode(':', $times);
}