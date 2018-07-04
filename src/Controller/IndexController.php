<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 04.07.18
 * Time: 18:34
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller {
	/**
	* @Route("/")
	*/
	public function index()
	{
		$user = $this->getUser();
		$route = 'fos_user_profile_show';
		$parameters = [];
		if( !$user ) {
			$route = 'fos_user_security_login';
			$parameters = [];
		}

		return $this->redirectToRoute( $route, $parameters );
	}
}
