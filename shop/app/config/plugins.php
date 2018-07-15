<?php
defined('BASE') or exit('Access Denied!'); 

/*
| -------------------------------------------------------------------
| SET PLUGINS
| -------------------------------------------------------------------
| This file contains arrays of your "Js" or "Css" type files.  It is used by the
| View helper functions to help set heag tag variables js, css data.
| The array keys are used to identify the plugin name
| and the array values are used to set the actual filename and path of the public items.
|
| prototype:
|
| $config['plugin_name'] = array(
|                                'js/plugin_name/a.js',
|                                'js/plugin_name/a_subfolder/b.js',
|                                'css/plugin_name/a.css'
|                               );
| Initialize to Plugins
| 
| view_var('head', plugin('plugin_name'));
|
*/

$config['plugin_name'] = array();


/* End of file plugins.php */
/* Location: .app/config/plugins.php */