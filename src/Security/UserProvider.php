<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 05.07.18
 * Time: 13:37
 */

namespace App\Security;


use App\Entity\Api\ApiKey;
use App\Service\Security\ApiKeyManager;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Security\UserProvider AS FOSUserProvider;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;


class UserProvider extends FOSUserProvider implements ApiKeyUserProviderInterface
{
	protected $stateless = false;
	protected $apiKeyManager;

	public function __construct(UserManagerInterface $userManager, ApiKeyManager $apiKeyManager)
	{
		parent::__construct($userManager);

		$this->apiKeyManager = $apiKeyManager;
	}

	/**
	 * @param string $apiKey
	 * @return null|SecurityUserInterface
	 */
	public function loadUserByApiKey(?string $apiKey = '') : ?SecurityUserInterface
	{
		$this->stateless = true;

		if(!$apiKey) {
			return null;
		}
		/** @var ApiKey $key */
		$key = $this->apiKeyManager->findKey($apiKey);

		if(!$key) {
			return null;
		}

		return $key->getUser();
	}

	/**
	 * @param SecurityUserInterface $user
	 *
	 * @return SecurityUserInterface
	 * @throws UnsupportedUserException
	 */
	public function refreshUser(SecurityUserInterface $user)
	{
		if ($this->stateless) {
			throw new UnsupportedUserException();
		}

		return parent::refreshUser($user);
	}
}
