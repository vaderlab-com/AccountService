<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 05.07.18
 * Time: 13:45
 */

namespace App\Entity\Api;
use App\Model\DynamicModelTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="api_key")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="default")
 */
class ApiKey {

	private const
		FIELD_ALLOW_IPS     = 'i',
		FIELD_ALLOW_URLS    = 'u',
		FIELD_TITLE         = 't'
	;

	use DynamicModelTrait;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="api_key", type="string", length=255, unique=true)
	 * @Assert\NotBlank()
	 */
	private $apiKey;

	/**
	 * @var UserInterface
	 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="default")
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
	 * @Assert\NotNull()
	 */
	private $user;
	/**
	 * @return mixed
	 */
	public function getId() : ?int {
		return $this->id;
	}

	/**
	 * @return array
	 * @Assert\All(
	 *     @Assert\Ip(
	 *         message="The IP {{ value }} is not a valid IP"
	 *     )
	 * )
	 */
	public function getAllowIps(): array
	{
		return $this->__getData(self::FIELD_ALLOW_IPS, []);
	}

	/**
	 * @param array $ips
	 * @return $this
	 */
	public function setAllowIps(array $ips) : ApiKey
	{
		$this->__setData(self::FIELD_ALLOW_IPS, $ips);

		return $this;
	}

	/**
	 * @return array
	 * @Assert\All(
	 *     @Assert\Url(
	 *         protocols = {"http", "https"},
	 *         message="The url {{ value }} is not a valid url"
	 *     )
	 * )
	 */
	public function getAllowUrls(): array
	{
		return $this->__getData( self::FIELD_ALLOW_URLS, [] );
	}

	/**
	 * @param array $urls
	 * @return $this
	 */
	public function setAllowUrls(array $urls) : ApiKey
	{
		$this->__setData( self::FIELD_ALLOW_URLS, $urls );

		return $this;
	}

	/**
	 * @return UserInterface
	 */
	public function getUser(): UserInterface {
		return $this->user;
	}

	/**
	 * @param UserInterface $user
	 *
	 * @return ApiKey
	 */
	public function setUser( UserInterface $user ): Apikey {
		$this->user = $user;

		return $this;
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 * @return ApiKey
	 */
	public function setTitle($title)
	{
		$this->__setData(self::FIELD_TITLE, $title);

		return $this;
	}

	/**
	 * Get title
	 *
	 * @Assert\NotBlank( message="Please enter the title" )
	 * @return string
	 */
	public function getTitle() : string
	{
		return $this->__getData(self::FIELD_TITLE, '');
	}

	/**
	 * Set apiKey
	 *
	 * @param string $apiKey
	 *
	 * @return ApiKey
	 */
	public function setApiKey($apiKey) : ApiKey
	{
		$this->apiKey = $apiKey;

		return $this;
	}

	/**
	 * Get apiKey
	 *
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->apiKey;
	}
}
