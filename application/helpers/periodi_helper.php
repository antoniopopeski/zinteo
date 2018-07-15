<?php
function getWeek($weekNumber, $year, $tz = 'GMT', $sz = 'GMT') {
	$orgTimezone = date_default_timezone_get ();
	date_default_timezone_set ( $sz );
	$tzTarget = new DateTimeZone ( $tz );
	$time = strtotime ( $year . '0104 +' . ($weekNumber - 1) . ' weeks' );
	$mondayTime = strtotime ( '-' . (date ( 'w', $time ) - 1) . ' days', $time );
	$dayTimes = array ();
	$temp = strtotime ( '+0 days', $mondayTime );
	$oTime = new DateTime ( "@$temp" );
	$oTime->setTimezone ( $tzTarget );
	$dayTimes [] = $oTime;
	$temp = strtotime ( '+7 days', $mondayTime );
	$oTime = new DateTime ( "@$temp" );
	$oTime->modify ( '-1 seconds' );
	$oTime->setTimezone ( $tzTarget );
	$dayTimes [] = $oTime;
	date_default_timezone_set ( $orgTimezone );
	return $dayTimes;
}
function getMonth($month, $year, $tz = 'GMT', $sz = 'GMT') {
	$dayTimes = array ();
	$dateString = $year . "-" . $month . "-01 00:00:00";
	$oTime = DateTime::createFromFormat ("Y-n-j H:i:s", $dateString, new DateTimeZone ( $sz ) );
	$oTime->setTimezone ( new DateTimeZone ( $tz ) );
	$dayTimes [] = $oTime;
	$oTime = DateTime::createFromFormat ("Y-n-j H:i:s", $dateString, new DateTimeZone ( $sz ) );
	$oTime->modify ( '+1 month' );
	$oTime->modify ( '-1 second' );
	$oTime->setTimezone ( new DateTimeZone ( $tz ) );
	$dayTimes [] = $oTime;
	return $dayTimes;
}
function getYear($year, $tz = 'GMT', $sz = 'GMT') {
	$dayTimes = array ();
	$dateString = $year . "-01-01 00:00:00";
	$oTime = DateTime::createFromFormat ("Y-n-j H:i:s", $dateString, new DateTimeZone ( $sz ) );
	$oTime->setTimezone ( new DateTimeZone ( $tz ) );
	$dayTimes [] = $oTime;
	$dateString = ($year + 1) . "-01-01 00:00:00";
	$oTime = DateTime::createFromFormat ("Y-n-j H:i:s", $dateString, new DateTimeZone ( $sz ) );
	$oTime->modify ( '-1 second' );
	$oTime->setTimezone ( new DateTimeZone ( $tz ) );
	$dayTimes [] = $oTime;
	return $dayTimes;
}
function getWeeksInYear($year) {
	$date = new DateTime ();
	$date->setISODate ( $year, 53 );
	return ($date->format ( "W" ) === "53" ? 53 : 52);
}