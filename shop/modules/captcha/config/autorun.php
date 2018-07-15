<?php
defined('BASE') or exit('Access Denied!');

/*
| -------------------------------------------------------------------
| AUTO-RUN
| -------------------------------------------------------------------
| This file specifies which functions should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default.This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Prototype
| -------------------------------------------------------------------
| 
| $autorun['function']['function_name'] = array('arg1', 'arg2'); 
|
| Merge Mode   : Merge module autorun variables to application.
| Replace Mode : Replace module autorun variables and override to application.
|
| NOTE: if you want to run independent module autorun functions you 
| should use replace mode.
|
*/

$autorun['mode']      = 'replace';       // merge | replace
$autorun['function']  = array();
