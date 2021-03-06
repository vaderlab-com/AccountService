<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 04.07.18
 * Time: 22:04
 */

namespace App\EventSubscriber\System;


use App\Service\Locale\LocaleDetectorService;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class LocaleDetectorSubscriber implements EventSubscriberInterface {

	private $localeDetector;

	public function __construct( LocaleDetectorService $localeDetector )
	{
		$this->localeDetector = $localeDetector;
	}

	/**
	 * @param GetResponseEvent $event
	 */
	public function onKernelRequest(GetResponseEvent $event)
	{
		$request = $event->getRequest();
		if (!$request->hasPreviousSession()) {
			return;
		}

		$request->setLocale( $this->localeDetector->detectLocale( $request ) );
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			KernelEvents::REQUEST => [ [ 'onKernelRequest', 20 ] ],
		];
	}
}
