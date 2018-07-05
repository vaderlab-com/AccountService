<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 05.07.18
 * Time: 13:33
 */

namespace App\Security;

use App\Entity\Api\ApiKey;
use App\Service\Security\ApiKeyManager;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface
{
	private $apiKeyManager;

	public function __construct(ApiKeyManager $apiKeyManager)
	{
		$this->apiKeyManager = $apiKeyManager;
	}

	public function createToken(Request $request, $providerKey)
	{
		$apiKey = $request->query->get('api_key', $request->headers->get('api_key', ''));
		$request->query->remove('api_key');

		$key = $this->authentificateApiKeyUser($apiKey, $request);


		return new PreAuthenticatedToken(
			'anon.',
			$key,
			$providerKey
		);
	}

	protected function authentificateApiKeyUser(string $apiKey = '', Request $request)
	{
		if(!$apiKey) {
			return null;
		}

		$key = $this->apiKeyManager->findKey($apiKey);
		if(!$key) {
			return null;
			// throw new AccessDeniedHttpException(sprintf('Authentification by key "%s" failure', $apiKey));
		}

		$allowedIps   = $key->getAllowIps();
		$allowedHosts = $key->getAllowUrls();

		$this->_checkAccessByIps($allowedIps, $request->getClientIp());
		$this->_checkAccessByUris($allowedHosts, $request->headers->get('origin') . '/');

		return $key;
	}

	protected function _checkAccessByIps(array $allowed, ?string $origin = '')
	{
		$hasAccess = count($allowed) === 0 || IpUtils::checkIp($origin, $allowed);

		if(!$hasAccess) {
			throw new AccessDeniedHttpException(sprintf('Access denied. Not allowed from "%s". ', $origin));
		}
	}

	/**
	 * @param array $allowedIps
	 * @param null|string $currentIp
	 */
	protected function _checkAccessByUris(array $allowed, ?string $origin = '')
	{
		if(!$origin) {
			$origin = '';
		}

		$hasAccess = count($allowed) === 0;

		foreach ($allowed as $host) {

			if(fnmatch($host, $origin)) {
				$hasAccess = true;
				break;
			}
		}

		if(!$hasAccess) {
			throw new AccessDeniedHttpException(sprintf('Access denied. Not allowed from "%s". ', $origin));
		}
	}

	public function supportsToken(TokenInterface $token, $providerKey)
	{
		return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
	}

	public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
	{
		if (!$userProvider instanceof ApiKeyUserProviderInterface) {
			throw new \InvalidArgumentException(
				sprintf(
					'The user provider must be an instance of ApiKeyUserProviderInterface (%s was given).',
					get_class($userProvider)
				)
			);
		}

		/** @var ApiKey|null $apiKey */
		$apiKey = $token->getCredentials();

		if(!$apiKey) {
			return $token;
		}

		$user = $apiKey->getUser();
		if (!$user) {
			return $token;
		}

		return new PreAuthentificatedApiKeyToken(
			$user,
			$apiKey,
			$providerKey,
			$user->getRoles()
		);
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		return new Response(
			strtr($exception->getMessageKey(), $exception->getMessageData()),
			401
		);
	}
}
