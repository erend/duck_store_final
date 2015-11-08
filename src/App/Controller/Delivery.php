<?php

namespace App\Controller;

use Silex\Application;

class Delivery
{
	private $app;

	function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function page()
	{
		return $this->render(); 
	}

	protected function render()
	{
        return $this->app['twig']->render('delivery/page.twig');
	}
}