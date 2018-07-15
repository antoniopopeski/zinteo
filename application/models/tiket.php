<?php
class tiket extends MY_Model
{
	protected static $tabela = "tiketi";
	protected static $indeks = "id";
	
	function __construct()
	{
		parent::__construct();
	}
}