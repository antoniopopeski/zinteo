<?php

class Translation extends CI_Model{
   function lang($label,$strip=false,$lang=1){
	   @session_start();
	   if(@$_GET['lang']){
		   @$_SESSION['lang']=@$_GET['lang'];
	   }
	   if(@$_SESSION['lang']){
	   	   $current_language=@$_SESSION['lang'];
	   }
	   else{
	   	   $current_language=$lang;
	   }
	   
   		$sql="SELECT text FROM `translations` 
WHERE label='".$label."'
AND lang=".$current_language."
LIMIT 1";
	$records=$this->db->query($sql)->result_array();
	if(count($records)){
		$str=$records[0]['text'];
		if($strip){
			return strip_tags($str);
		}
		else{
			return $str;
		}
	}
	else{
		return $label;
	}

   } 	
	
}

