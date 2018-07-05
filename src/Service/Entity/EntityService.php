<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 05.07.18
 * Time: 14:54
 */

namespace App\Service\Entity;


use Doctrine\ORM\EntityManager;

class EntityService {

	private $manager;
	private $entityClass;

	public function __construct( EntityManager $manager, string $entityClass )
	{
		$this->manager = $manager;
		$this->entityClass = $entityClass;
	}

	public function getEntityClassName() : string
	{
		return $this->entityClass;
	}

	public function createEntityInstance()
	{
		return new $this->entityClass;
	}

	protected function getEntityManager(): EntityManager
	{
		return $this->manager;
	}
}
