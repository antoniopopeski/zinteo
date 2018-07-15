<?php
defined('BASE') or exit('Access Denied!');

/*
| -------------------------------------------------------------------
| SUBMODULE AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which MODULE file should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default.This file lets
| you globally define which systems you would like loaded with every
| request to current module.
|
| Prototype:  ./modules/sub.module/config/autoload.php
|
| Merge Mode   : Merge module autoload variables to application.
| Replace Mode : Replace module autoload variables and override to application.
|
| NOTE: if you want to run independent module autoload files you 
| should use replace mode ( Recommended for HMVC Modules ).
|
*/

$autoload['mode']       = 'replace'; // merge | replace

$autoload['helper']     = array('ob/url' => '', 'ob/view' => '', 'ob/form' => '', 'ob/captcha' => '');
$autoload['lib']        = array();
$autoload['config']     = array();
$autoload['lang']       = array();
$autoload['model']      = array();


/* End of file autoload.php */
/* Location: ./modules/sub.backend/config/autoload.php */