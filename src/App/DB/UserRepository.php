<?php

namespace App\DB;

class UserRepository
{
	private $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection->getConnection();
	}

	public function getUserByUsername($username)
	{
		$sql = 'SELECT * FROM `users` WHERE `username` = :username';
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(['username' => $username]);
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function saveUser($username, $password)
	{
		$sql = 'INSERT INTO `users` (`username`, `password`)
		 VALUES (:username, :password)';
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([
			'username' => $username,
			'password' => $password
		]);	
	}
}