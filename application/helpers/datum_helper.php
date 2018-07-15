<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function format_date($mysql_timestamp)
{
	$unix_time = strtotime($mysql_timestamp);
	return date('d.m.Y', $unix_time);
}

function format_hour($mysql_timestamp)
{
	$unix_time = strtotime($mysql_timestamp);
	return date('G:i', $unix_time);
}

function single_date($mysql_timestamp)
{
	$unix_time = strtotime($mysql_timestamp);
	return date('m/d/Y', $unix_time);
}

function output_hour($mysql_timestamp)
{
	$unix_time = strtotime($mysql_timestamp);
	return date('G', $unix_time);
}

function output_minute($mysql_timestamp)
{
	$unix_time = strtotime($mysql_timestamp);
	return date('i', $unix_time);
}

function input_date($date, $hour, $minute)
{
	$date_arr = explode('/', $date);
	return $date_arr[2].'-'.$date_arr[0].'-'.$date_arr[1].' '.$hour.':'.$minute.':00';
}