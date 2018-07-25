<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 25.07.18
 * Time: 15:49
 */

namespace App\Entity;


use App\Model\DynamicModelTrait;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Resource
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="resource")
 */
class Resource {

	use DynamicModelTrait;

	private const F_NAME = 'name';

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var User
	 * @ORM\ManyToOne( targetEntity="App\Entity\User", inversedBy="resources" )
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
	 */
	private $user;

	/**
	 * @return int|null
	 */
	public function getId(): ?int
	{
		return $this->id;
	}

	/**
	 * @return User
	 */
	public function getUser(): ?User
	{
		return $this->user;
	}

	/**
	 * @param User $user
	 *
	 * @return Resource
	 */
	public function setUser( User $user ): Resource
	{
		$this->user = $user;

		return $this;
	}

	public function getName(): string
	{
		return $this->__getData( self::F_NAME, '' );
	}

	/**
	 * @param null|string $name
	 *
	 * @return Resource
	 */
	public function setName( ?string $name): Resource
	{
		return $this->__setData( self::F_NAME, $name );
	}

}
