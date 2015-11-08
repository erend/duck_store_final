<?php

namespace App\Controller;

class Pager
{
	private $items;
	private $max_on_page;
	
	function __construct($items)
	{
		$this->items = $items;		
	}

	public function paging($max_on_page)
	{
		if (!isset($_GET['page'])) {
			$_GET['page'] = 1;
		}
		$pages = ceil(count($this->items)/$max_on_page);
		for ($i=1; $i <= $pages ; $i++) { 
			$page['numbers'][] = $i;
		}
		$page['start'] = $max_on_page * $_GET['page'] - $max_on_page;
		$page['lenght'] = $max_on_page;
		$page['current'] = $_GET['page'];

		return $page;
	}
}
