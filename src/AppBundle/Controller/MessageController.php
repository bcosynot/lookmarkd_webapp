<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends Controller {
	
	/**
	 * @Route("/messages/", name="message_inbox")
	 */
	public function inboxAction() {
		$provider = $this->get ( 'fos_message.provider' );
		$threadsOriginal = $provider->getInboxThreads ();
		$threads = array ();
		if (null != $threadsOriginal && sizeof ( $threadsOriginal ) > 0) {
			foreach ( $threadsOriginal as $threadOriginal ) {
				$thread = array (
						'id' => $threadOriginal->getId () 
				);
				$associatedUser = null;
				$threadOriginal->getMetadata ()->initialize();
				foreach ( $threadOriginal->getMetadata () as $metadata) {
					$participant = $metadata->getParticipant();
					if ($participant != $this->getUser ()) {
						$associatedUser = $participant;
						break;
					}
				}
				$thread ['associatedUser'] = $associatedUser->getUsername ();
				$threads [] = $thread;
			}
		}
		$model = array ();
		$model ['threads'] = $threads;
		$model ['totalThreads'] = sizeof ( $threads );
		return $this->render ( 'controller/message/inbox.html.twig', $model );
	}
	
	/**
	 * @Route("/messages/recipients/list/{userNameLike}", name="message_get_recipients_list", defaults={"userNameLike"=null})
	 * 
	 * @param null|string $userNameLike        	
	 */
	public function getRecpientsListAction($userNameLike) {
		$recipients = $this->get ( 'user_service' )->getPossibleRecipientsForUser ( $this->getUser (), $userNameLike );
		return new JsonResponse ( $recipients );
	}
	
	/**
	 * @Route("/messages/welcome/user", name="send_welcome_message")
	 */
	public function sendWelcomeMessageAction() {
		$sender = $this->get ( 'user_service' )->getUser ( 'lookmarkd' );
		$threadBuilder = $this->get ( 'fos_message.composer' )->newThread ();
		$threadBuilder->addRecipient ( $this->getUser () )->setSender ( $sender )->setSubject ( 'Welcome!' )->setBody ( 'Hey there! Thanks for trying us out. If you have any thoughts, questions or concerns, please feel free to reply to this message.' );
		$senderService = $this->get ( 'fos_message.sender' );
		$senderService->send ( $threadBuilder->getMessage () );
		return new JsonResponse ( array (
				'success' => true 
		) );
	}
}