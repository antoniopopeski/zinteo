<?php
defined('BASE') or exit('Access Denied!');

/*
|--------------------------------------------------------------------------
| SUBMODULE CONFIG FILE:
|--------------------------------------------------------------------------
| When the application works Obullo will merge application config
| variables with your MODULE config variables.
|
| Prototype:
|
|	$config['item'] = 'mixed value';
*/
$config['sub_item']               = 'Submodule test item works !';

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
|    0 = Disables logging, Error logging TURNED OFF
|    1 = Error Messages (including PHP errors)
|    2 = Debug Messages
|    3 = Informational Messages
|    4 = All Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold']         = 2;

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_cookie_name'    = the name you want for the cookie
| 'sess_encrypt_cookie' = TRUE/FALSE (boolean).  Whether to encrypt the cookie
| 'sess_expiration'     = the number of SECONDS you want the session to last.
| 'sess_die_cookie'     = If set TRUE all sessions  will destroy when the browser closed.
|  by default sessions last 7200 seconds (two hours).  Set to zero for no expiration.
| 'time_to_update'      = how many seconds between Obullo refreshing Session Information
| 'sess_db_var'         = normally Obullo use standart '$this->db' variable for session database
|                         crud operations, you can change it like db2, db3 .. 
|
*/
$config['sess_cookie_name']      = 'ob_backend_session';
$config['sess_expiration']       = 7200;
$config['sess_die_cookie']       = FALSE;
$config['sess_encrypt_cookie']   = TRUE;
$config['sess_driver']           = 'native';  // cookie | database
$config['sess_db_var']           = 'db';            
$config['sess_table_name']       = 'ob_backend_sessions';
$config['sess_match_ip']         = FALSE;
$config['sess_match_useragent']  = TRUE;
$config['sess_time_to_update']   = 300;


/* End of file config.php */
/* Location: .modules/default/config/config.php */