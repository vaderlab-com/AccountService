<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 04.07.18
 * Time: 13:26
 */

namespace App\Entity;

use App\Model\DynamicModelTrait;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @todo: constraint
 */
class User  extends BaseUser {

    const
        FIELD_FNAME = 'firstName',
        FIELD_LNAME = 'lastName'
    ;

    use DynamicModelTrait;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

    /**
     * @var array
     * @ORM\Column(name="user_data", type="array", nullable=false)
     */
	protected $entityDynamicData;

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
     * @return mixed|null
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
        return $this->__setData( self::FIELD_FNAME, $name );
    }

    /**
     * @return mixed|null
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
}
