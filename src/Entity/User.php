<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 04.07.18
 * Time: 13:26
 */

namespace App\Entity;

use App\Model\DynamicModelTrait;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Rollerworks\Component\PasswordStrength\Validator\Constraints as ConstraintPassword;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser {

	use DynamicModelTrait;

    const
        FIELD_FNAME = 'firstName',
        FIELD_LNAME = 'lastName'
    ;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ConstraintPassword\PasswordStrength(
	 *     minLength=8,
	 *     minStrength=3,
	 *     groups={ "ResetPassword", "Registration", "ChangePassword"}
	 * )
	 */
	protected $plainPassword;

	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany( targetEntity="App\Entity\Resource", mappedBy="user", cascade={"persist"} )
	 */
	protected $resources;

	/**
	 * User constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->resources = new ArrayCollection();
	}

	/**
     * {@inheritdoc}
     */
	public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        $this->setUsername( $email );

        return parent::setEmail($email);
    }

    /**
     * @return string
     * @Assert\NotBlank(
     *     message="Please enter your name",
     *     groups={"Profile", "Registration"}
     *     )
     */
    public function getFirstName()
    {
        return $this->__getData( self::FIELD_FNAME, '' );
    }

    /**
     * @param null|string $name
     * @return User
     */
    public function setFirstName( ?string $name  )
    {
    	if( $name ) {
		    $name = trim($name);
	    }

        return $this->__setData( self::FIELD_FNAME, $name );
    }

    /**
     * @return string
     * @Assert\NotBlank(
     *     message="Please enter your surname",
     *     groups={"Profile", "Registration"}
     *     )
     */
    public function getLastName()
    {
        return $this->__getData( self::FIELD_LNAME, '' );
    }

    /**
     * @param null|string $name
     * @return User
     */
    public function setLastName( ?string $name  )
    {
        return $this->__setData( self::FIELD_LNAME, $name );
    }

	/**
	 * @return ArrayCollection
	 */
	public function getResources(): ArrayCollection
	{
		return $this->resources;
	}

	/**
	 * @param ArrayCollection $resources
	 *
	 * @return User
	 */
	public function setResources( ArrayCollection $resources ): User
	{
		$this->resources = $resources;

		return $this;
	}

	/**
	 * @param Resource $resource
	 *
	 * @return User
	 */
	public function addResource( Resource $resource ): User
	{
		$this->resources->add( $resource );

		return $this;
	}
}
