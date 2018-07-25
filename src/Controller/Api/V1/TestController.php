<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 05.07.18
 * Time: 15:13
 */

namespace App\Controller\Api\V1;


use App\Entity\User;
use App\Service\Security\ApiKeyManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class TestController {

	private $manager;
	private $em;
	private $ts;

	public function __construct( TokenStorageInterface $ts, ApiKeyManager $manager, EntityManagerInterface $em )
	{
		$this->manager = $manager;
		$this->em = $em;
		$this->ts = $ts;
	}

	/**
	 * @Route("/api/v1/test")
	 */
	public function index()
	{
		$token = $this->ts;

		return new JsonResponse([]);
	}


	/**
	 * @Route("/api/v1/array")
	 */
	public function index1()
	{


		$file = dirname( __FILE__ ) . '/../../../../var/cache/tmp.php';

		if( !is_file($file) ) {

			$content = '';

			for($i = 0; $i < 3000; ++$i) {

				$tmp = 'lkjahdsfijhsadlkfjhakjdwhfla kjdsahflkjdsahflkj lkjdsahflkjdsahfdsa';
				$tmpk = '';
				for($b = 0; $b < 100; ++$b) {
					$tmpk .= $tmp;
				}

				$content .= '\'_' . rand(10000, 99999999) . '\' => \'' . $tmpk . '\',' . "\r\n";
			}


			file_put_contents($file, '<?php $asisyas = [ ' . $content . ' ];');
		}


		include $file;

		return new JsonResponse([]);
	}

	/**
	 * @Route("/api/v1/apikey")
	 *
	 */
	public function creatreApiKeytest()
	{
		$user = $this->em->getRepository( User::class )->find(3);

		$this->manager->setUser($user);
		$apiKey = $this->manager->createEntityInstance();
		$apiKey->setTitle('Example title');

		$this->em->persist($apiKey);
		$this->em->flush();

		return new JsonResponse([
			'user_id'   => $user->getId(),
			'api_key'   => $apiKey->getApiKey()
		]);

	}

}
