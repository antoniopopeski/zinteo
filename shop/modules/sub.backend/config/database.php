<?php
defined('BASE') or exit('Access Denied!');

/*
|--------------------------------------------------------------------------
| SUBMODULE Database Settings
|--------------------------------------------------------------------------
| Put your database configurations here and decide your db variable
| name.
| 
| $config['database']['db']['option']  db variable name ( default db )
| 
*/

$database['db']['hostname']  = "localhost";
$database['db']['username']  = "root";
$database['db']['password']  = "";
$database['db']['database']  = "";
$database['db']['dbdriver']  = "mysql";
$database['db']['dbprefix']  = '';
$database['db']['swap_pre']  = '';
$database['db']['dbh_port']  = "";
$database['db']['char_set']  = "utf8";
$database['db']['dsn']       = "";
$database['db']['options']   = array();