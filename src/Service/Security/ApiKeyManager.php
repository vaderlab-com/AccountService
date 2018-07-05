<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 05.07.18
 * Time: 13:38
 */

namespace App\Service\Security;


use App\Service\Entity\EntityService;
use App\Entity\Api\ApiKey;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ApiKeyManager extends EntityService
{
	/**
	 * @var UserInterface
	 */
	private $user;

	/**
	 * ApiKeyManager constructor.
	 * @param EntityManagerInterface $manager
	 * @param TokenStorageInterface|null $tokenStorage
	 */
	public function __construct(EntityManagerInterface $manager, TokenStorageInterface $tokenStorage = null)
	{
		parent::__construct($manager, ApiKey::class);

		$token = $tokenStorage->getToken();
		if(!$token) {
			return;
		}

		$user = $token->getUser();
		if(!$user || !($user instanceof UserInterface)) {
			return;
		}

		$this->setUser($user);
	}

	/**
	 * @param UserInterface $user
	 * @return $this
	 */
	public function setUser(UserInterface $user)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * @return UserInterface
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param string $key
	 * @return null|ApiKey
	 */
	public function findKey(string $key): ?ApiKey
	{
		return $this->getRepository()->findOneBy(['apiKey' => $key]);
	}

	/**
	 * @return ApiKey
	 * @throws \Exception
	 */
	public function createEntityInstance()
	{
		/** @var ApiKey $apiKey */
		$apiKey = parent::createEntityInstance();

		$apiKey->setApiKey( $this->generateApiKey() );
		$apiKey->setUser($this->getUser());

		return $apiKey;
	}

	/**
	 * @return \Doctrine\Common\Persistence\ObjectRepository
	 */
	public function getRepository()
	{
		return $this->getEntityManager()->getRepository($this->getEntityClassName());
	}

	/**
	 * @return string
	 */
	protected function generateApiKey()
	{
		$akv = [];
		for( $i = 0; $i < 2; ++$i ) {
			$akv[] = uniqid(rand(1000000, 9999999),1);
		}

		return implode('-', $akv);
	}
}
