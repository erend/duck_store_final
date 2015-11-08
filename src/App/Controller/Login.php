<?php

namespace App\Controller;

use App\DB\UserRepository;
use Silex\Application;

class Login
{	
	private $UserRepository;
	private $app;

	function __construct(UserRepository $UserRepository, Application $app)
	{
		$this->UserRepository = $UserRepository;
		$this->app = $app;
	}

	public function validate()
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$user = $this->UserRepository->getUserByUsername($username);
		if ($username === $user['username'] && password_verify($password, $user['password'])) {
			$_SESSION['username'] = $user['username'];
			return true;
		} else {
			return false;
		}
	}

	public function page($state)
	{
			return $this->render($state);
	}

	protected function render($state)
	{ 
	    return $this->app['twig']->render('login/page.twig', [
			'state' => $state
    	]);
	}
}