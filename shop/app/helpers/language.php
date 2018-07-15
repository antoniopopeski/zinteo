<?php
function set_language() {
	$ob = this (); // access to the config class
	
	if (sess_get ( 'lang' )) {
		$s = sess_get ( 'lang' );
	} else {
		$s = $ob->config->item ( 'default_language' );
	}

	loader::lang ( 'app/' . $s, 'language' );
}
function get_language() {
	echo sess_get ( 'lang' );
}