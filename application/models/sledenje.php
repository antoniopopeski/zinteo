<?php
class sledenje extends MY_Model
{
	protected static $tabela = "sledenje";
	protected static $indeks = "id";
	
	function __construct()
	{
		parent::__construct();
	}
}