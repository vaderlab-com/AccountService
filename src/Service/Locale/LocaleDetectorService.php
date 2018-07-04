<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 04.07.18
 * Time: 22:11
 */

namespace App\Service\Locale;


use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LocaleDetectorService {

	const LOCALE_RU = 'ru';
	const LOCALE_EN = 'en';

	private $defaultLocale;

	// AA - localhost and docker ( if locale is invalid )
	const RELATIONS = [
		'ru'    => [
			'RU', 'BY', 'UA', 'KZ', 'AA'
		],
		'en'    => [

		]
	];

	public function __construct( string $defaultLocale = self::LOCALE_EN ) {
		$this->defaultLocale = $defaultLocale;
	}

	public function detectLocale(
		?Request $request = null,
		?UserInterface $user = null
	) {

		if( $request ) {
			$locale = $this->detectLocaleByRequest( $request );
		}

		if( !$locale ) {
			$locale = $this->defaultLocale;
		}

		return $locale;
	}

	public function detectLocaleByRequest( Request $request )
	{
		$lkey = '_locale';
		$locale = $request->attributes->get($lkey);
		if( $locale ) {
			return $locale;
		}

		$session = $request->getSession();
		$emptySessionLocale = true;
		if( $locale = $session->get($lkey) ) {
			$emptySessionLocale = false;
		}

		$ip = $request->getClientIp();
		if( !$locale && $ip ) {
			return $this->detectLocaleByIp( $ip );
		}

		if( !$locale ) {
			$locale =  $this->defaultLocale;
		}

		if( $emptySessionLocale ) {
			$session->set( $lkey, $locale );
		}

		return $locale;
	}

	public function detectLocaleByIp( string $ip )
	{
		$country = \TabGeo\country( $ip );

		return $this->detectLocaleByCountry( $country );
	}

	public function detectLocaleByCountry( string $countryCode )
	{
		$locale = $this->defaultLocale;

		foreach ( self::RELATIONS as $tmp_locale => $countries ) {
			if( in_array( mb_strtoupper( $countryCode ), $countries ) ) {
				$locale =  $tmp_locale;

				break;
			}
		}

		return $locale;
	}
}
