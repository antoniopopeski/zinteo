<?php

function is_logged() {
	
	
	
	if (isset( $_SESSION['user']) )
		return true;
	
	return false;
	
}

function is_admin_logged() {
	
	if (isset($_SESSION['admin'])) 
		return true;
		
	redirect("/admin/login");

}
