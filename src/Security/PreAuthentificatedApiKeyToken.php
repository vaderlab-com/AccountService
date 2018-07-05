<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 05.07.18
 * Time: 15:12
 */

namespace App\Security;


use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;

class PreAuthentificatedApiKeyToken extends PreAuthenticatedToken
{
}
