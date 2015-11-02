<?php

namespace App\DB;

class Connection
{
	
	protected $connection;

	function __construct()
	{
		$this->connection = $this -> connect('root','');
	}

	public function getConnection()
	{
		return $this->connection;
	}

	private function connect($username, $password)
	{
		try {
		    $db = new \PDO(
				'mysql:host=localhost;dbname=duck_store_final;charset=utf8;', $username, $password
			);
			$db->setAttribute(
				\PDO::ATTR_ERRMODE, 
				\PDO::ERRMODE_EXCEPTION
			);
		} catch(\PDOException $e) {
		    echo 'ERROR: ' . $e->getMessage();
		    die();
		}
		return $db;
	}
}