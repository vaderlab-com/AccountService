<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 25.07.18
 * Time: 16:07
 */

namespace App\EventSubscriber\User;

use App\Entity\Resource;
use App\Entity\User;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;


class UserCreateSubscriber implements EventSubscriberInterface {

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'prePersist' => 'prePersist',
			FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
		];
	}

	/**
	 * @param FormEvent $event
	 */
	public function onRegistrationSuccess( FormEvent $event )
	{
		$user = $event->getForm()->getData();
		if( !$user || ! ( $user instanceof User) ) {
			return;
		}

		$this->createUserResource( $user );
	}

	/**
	 * @param LifecycleEventArgs $args
	 */
	public function prePersist( LifecycleEventArgs $args )
	{
		$entity = $args->getObject();

		if( !( $entity instanceof User ) ) {
			return;
		}

		$this->createUserResource( $entity );
	}

	/**
	 * @param User $user
	 */
	protected function createUserResource( User $user )
	{
		if( $user->getId() !== null || $user->getResources()->count() ) {
			return;
		}

		$resource = new Resource();
		$resource->setName( $user->getEmail() );

		$resource->setUser( $user );
		$user->addResource( $resource );
	}
}
