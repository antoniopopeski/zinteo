<?php
class oblog extends MY_Model
{
	protected static $tabela = "oblozi";
	protected static $indeks = "id";
	
	function __construct()
	{
		parent::__construct();
	}
}