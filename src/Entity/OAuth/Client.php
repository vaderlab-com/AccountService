<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 04.07.18
 * Time: 18:17
 */

namespace App\Entity\OAuth;

use App\Model\DynamicModelTrait;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @todo: constrints
 *
 * @ORM\Entity
 */
class Client extends BaseClient
{
    const FIELD_IS_INTERNAL = 'isInternal';

    use DynamicModelTrait;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
	protected $user;

	/**
     * @param UserInterface $user
     * @return Client
     */
	public function setUser( UserInterface $user ) : Client
    {
        $this->user = $user;
    }

    /**
     * @return UserInterface
     */
    public function getUser() : ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param bool|null $isInternal
     * @return Client
     */
    public function setIsInternal( ?bool $isInternal): Client
    {
        return $this->__setData( self::FIELD_IS_INTERNAL, (boolean) $isInternal );
    }

    /**
     * @return boolean
     */
    public function isInternal() : bool
    {
        return $this->__getData( self::FIELD_IS_INTERNAL, false );
    }
}
