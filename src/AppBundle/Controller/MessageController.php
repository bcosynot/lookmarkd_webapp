<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MessageController extends Controller {
	
	/**
	 * @Route("/messages/", name="message_inbox")
	 */
	public function inboxAction() {
		$provider = $this->get ( 'fos_message.provider' );
		$threads = $threads = $provider->getInboxThreads ();
		$model = array ();
		$model ['threads'] = $threads;
		$model ['totalThreads'] = sizeof ( $threads );
		return $this->render ( 'controller/message/inbox.html.twig', $model );
	}
}