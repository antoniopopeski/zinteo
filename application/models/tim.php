<?php
class tim extends MY_Model
{
	protected static $tabela = "timovi";
	protected static $indeks = "id";
	
	function __construct()
	{
		parent::__construct();
	}
}