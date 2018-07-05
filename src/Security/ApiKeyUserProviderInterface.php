<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 05.07.18
 * Time: 13:35
 */

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

interface ApiKeyUserProviderInterface {
	/**
	 * @param string $apiKey
	 *
	 * @return UserInterface
	 */
	public function loadUserByApiKey(string $apiKey = '');
}
