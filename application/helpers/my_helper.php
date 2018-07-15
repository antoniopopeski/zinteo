<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function is_ajax()
{
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']))
	{
		if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
		{
			return TRUE;
		}
	}
	return FALSE;
}

function output_session($key)
{
	if(isset($_SESSION[$key]))
	{
		if($key == 'warning')
		{
			echo '<span class="warning">'.$_SESSION[$key].'</span>';
		}
		else if($key == 'success')
		{
			echo '<span class="notice">'.$_SESSION[$key].'</span>';
		}
		else
		{
			echo $_SESSION[$key];
		}
		unset($_SESSION[$key]);
	}
}

function output_success()
{
	if(isset($_SESSION['success']))
	{
		echo '<p class="info" id="success"><span class="info_inner">'.$_SESSION['success'].'</span></p>';
		unset($_SESSION['success']);
	}
}

function login_error()
{
	if(isset($_SESSION['login_error']))
	{
		echo $_SESSION['login_error'];
		unset($_SESSION['login_error']);
	}
}

function output_warning()
{
	if(isset($_SESSION['warning']))
	{
		echo $_SESSION['warning'];
		unset($_SESSION['warning']);
	}
}
function output_notice()
{
	if(isset($_SESSION['notice']))
	{
		echo '<p class="info" id="notice"><span class="info_inner">'.$_SESSION['notice'].'</span></p>';
		unset($_SESSION['notice']);
	}
}

function safe_output($val)
{
	if(function_exists('mb_convert_encoding'))
	{
		$val = mb_convert_encoding($val, 'UTF-8', 'UTF-8');
	}
	$val = htmlentities($val, ENT_QUOTES, 'UTF-8');
	return $val;
}

//Use this when getting input from textareas.
function input_html($str)
{
	return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

//Use this when outputting stuff that has been encoded to htmlentities
function output_html($str)
{
	return html_entity_decode($str, ENT_QUOTES, 'UTF-8');
}

function prepare_category($name)
{
	$str = '';
	$name = explode(' ', $name);
	$i = 0;
	foreach($name as $val)
	{
		$name[$i] = strtolower($val);
		$i++;
	}
	$str = implode('-', $name);
	return $str;
}

function clean_input($str)
{
	if(is_array($str))
	{
		foreach($str as $key => $val)
		{
			$str[$key] = clean_input($val);
		}
		return $str;
	}
	$str = strip_tags($str);
	$str = clean_xss($str);
	return $str;
}

function clean_xss($str)
{
	$str = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $str);
	$str = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $str);
	$str = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $str);
	$str = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
	$str = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $str);
	$str = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $str);
	$str = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $str);
	$str = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $str);
	$str = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $str);
	$str = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $str);
	$str = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $str);
	$str = preg_replace('#</*\w+:\w[^>]*+>#i', '', $str);
	do
	{
		$old = $str;
		$str = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $str);
	}
	while ($old !== $str);
	return $str;
}

function is_email($email)
{
	return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
}

function valid_login($str)
{
	return (!preg_match("/^([-a-z0-9_-]){4,15}$/i", $str)) ? FALSE : TRUE;
}

function format_mkd_str($mkd_name)
{
	$mkd_name = htmlentities($mkd_name, ENT_QUOTES, 'UTF-8');
	
	$search = array(
		'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Ѓ', 'ѓ', 'Ж', 'ж', 'З', 'з', 'Ѕ', 'ѕ', 'И', 'и', 'Л', 'л', 'Љ', 'љ', 'Н', 'н', 'Њ', 'њ', 'П', 'п', 'Р', 'р', 'С', 'с', 'Ќ', 'ќ', 'У', 'у', 'Ф', 'ф', 'Х', 'х', 'Ц', 'ц', 'Ч', 'ч', 'Џ', 'џ', 'Ш', 'ш', 'А', 'а', 'Е', 'е', 'Ј', 'ј', 'К', 'к', 'М', 'м', 'О', 'о', 'Т', 'т'
	);
	
	$replace = array(
		'B', 'b', 'V', 'v', 'G', 'g', 'D', 'd', 'Gj', 'gj', 'Zh', 'zh', 'Z', 'z', 'Dz', 'dz', 'I', 'i', 'L', 'l', 'Lj', 'lj', 'N', 'n', 'Nj', 'nj', 'P', 'p', 'R', 'r', 'S', 's', 'Kj', 'kj', 'U', 'u', 'F', 'f', 'H', 'h', 'C', 'c', 'Ch', 'ch', 'Dj', 'dj', 'Sh', 'sh', 'A', 'a', 'E', 'e', 'J', 'j', 'K', 'k', 'M', 'm', 'O', 'o', 'T', 't'
	);
	
	$clean_name = str_replace($search, $replace, $mkd_name);
	return $clean_name;
}

function create_seo_link($name)
{
	$name = format_mkd_str($name);
	$search = array('(', ')');
	$replace = array('', '');
	$name = str_replace($search, $replace, $name);
	$replace_param = '/[^a-zA-Z0-9\.-]/';
	$name = preg_replace($replace_param,'-',$name); 
	return strtolower($name);
}


function seo_url($name, $type, $section)
{
	return base_url().$section.'/'.$type.'/'.$name;
}


function shorten_str($str, $max=350)
{
	$s = substr($str, 0, $max);
	return substr($s, 0, strrpos($s, ' '));


	/*$s_String = html_entity_decode(htmlentities($str." ", ENT_COMPAT, 'UTF-8'));
    $k = substr($s_String, 0, strlen($s_String)-1);
	return $k;*/
	// original return substr($str, 0, $max);
	//return substr($k, 0, strlen($k)-1);
	//function substru($str,$from,$len){
    //return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'. $k .'}'.'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'. $max .'}).*#s','$1', $k);

}

function calc_img_height($imgPath, $new_width=204)
{
	list($current_width, $current_height, $type, $attr) = getimagesize($imgPath);
	$ratio = $new_width / $current_width;
	$height = $current_height * $ratio;
	return floor($height);
}
