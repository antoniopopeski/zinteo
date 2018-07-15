<?php
defined('BASE') or exit('Access Denied!');

/*
| -------------------------------------------------------------------
| MODULE AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which MODULE file should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default.This file lets
| you globally define which systems you would like loaded with every
| request to current module.
|
| Prototype:  ./application/config/autoload.php
|
| Merge Mode   : Merge module autoload variables to application.
| Replace Mode : Replace module autoload variables and override to application.
| 
*/
$autoload['mode']       = 'merge'; // merge | replace

$autoload['helper']     = array('ob/view' => '', 'ob/html' => '', 'ob/url' => '');
$autoload['lib']        = array();
$autoload['config']     = array();
$autoload['lang']       = array();
$autoload['model']      = array();


/* End of file autoload.php */
/* Location: ./modules/default/config/autoload.php */