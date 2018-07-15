<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paginate
{
	public $current_page;
	public $per_page;
	public $total_count;
	
	
	public function initialize($page = 0, $per_page = 0, $total_count = 0)
	{
		$this->current_page = ((int) $page)? $page : 1;
		$this->per_page = ((int) $per_page)? $per_page : 4;
		$this->total_count = ((int) $total_count)? $total_count : 0;
	}
	
	public function offset()
	{
		return ($this->current_page - 1) * $this->per_page;
	}
	
	public function total_pages()
	{
		return ceil($this->total_count/$this->per_page);
	}
	
	public function prev_page()
	{
		return $this->current_page - 1;
	}
  
	public function next_page()
	{
		return $this->current_page + 1;
	}

	public function has_previous()
	{
		return $this->prev_page() >= 1 ? TRUE : FALSE;
	}

	public function has_next()
	{
		return $this->next_page() <= $this->total_pages() ? TRUE : FALSE;
	}
}