<?php
class sport extends MY_Model
{
	protected static $tabela = "sportovi";
	protected static $indeks = "id";
	
	function __construct()
	{
		parent::__construct();
	}
}