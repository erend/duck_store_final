<?php

namespace App\DB;

class ProductRepository
{
	private $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection->getConnection();
	}

	public function getProducts()
	{
		$stmt = $this->connection->prepare(
			"SELECT * FROM `products` AS p 
				INNER JOIN `item_img` AS i 
					ON p.`id` = i.`product_id` 
			ORDER BY p.created_at DESC LIMIT 6"
		);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getProduct($id) {
	    $stmt = $this->connection->prepare(
          "SELECT p.id, p.title, p.description, p.price, p.category_id, c.title AS c_title, i.img_path AS img_path
              FROM `products` AS p
              INNER JOIN `categories` AS c
                  ON p.`category_id` = c.`id`
              INNER JOIN `item_img` AS i
                  ON p.`id` = i.`product_id`
              WHERE p.`id` = :id"
	    );
		$stmt->bindParam(":id", $id);
		$stmt->execute();	
		$product = $stmt->fetch(\PDO::FETCH_ASSOC);
		return($product);
	}

		public function getProductsAdmin()
	{
		$stmt = $this->connection->prepare(
			"SELECT * FROM `products`"
		);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function changeProduct($changes)
	{
		$stmt = $this->connection->prepare(
			"UPDATE `products` 
			SET  `title` = :title,
				 `description` = :description,
				 `price` = :price,
				 `category_id` = :category_id
			WHERE `id` = :id"
		);
		$stmt->execute($changes);
	}

		public function deleteProduct($id)
	{
		$stmt = $this->connection->prepare(
			"DELETE FROM `products` WHERE id = :id"
		);
		$stmt->bindParam(":id", $id);
		$stmt->execute($changes);
	}

	public function addProduct($product)
	{
		$stmt = $this->connection->prepare(
			"INSERT INTO `products` (`title`, `description`, `price`, `category_id`)
			 VALUES (:title, :description, :price, :category_id)"
		);
		$stmt->execute($product);
	}

}