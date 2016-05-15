<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class MessageController extends Controller {
	
	/**
	 * @Route("/messages/", name="message_inbox")
	 */
	public function inboxAction() {
		$threads = $this->getThreads ();
		$model = array ();
		$model ['threads'] = $threads;
		$model ['totalThreads'] = sizeof ( $threads );
		return $this->render ( 'controller/message/inbox.html.twig', $model );
	}
	private function getThreads() {
		$provider = $this->get ( 'fos_message.provider' );
		$threadsOriginal = $provider->getInboxThreads ();
		$sentThreadsOriginal = $provider->getSentThreads ();
		$allThreadIds = array ();
		$threads = array ();
		$allOriginalThreads = array_merge ( $threadsOriginal, $sentThreadsOriginal );
		if (null != $allOriginalThreads && sizeof ( $allOriginalThreads ) > 0) {
			foreach ( $allOriginalThreads as $threadOriginal ) {
				$threadId = $threadOriginal->getId ();
				if (! in_array ( $threadId, $allThreadIds )) {
					$thread = array (
							'id' => $threadId 
					);
					$allThreadIds [] = $threadId;
					$associatedUser = null;
					$threadOriginal->getMetadata ()->initialize ();
					$userId = $this->getUser ()->getId ();
					foreach ( $threadOriginal->getMetadata () as $metadata ) {
						$participant = $metadata->getParticipant ();
						if ($participant->getId () != $userId) {
							$associatedUser = $participant;
							break;
						}
					}
					$thread ['associatedUser'] = $associatedUser->getUsername ();
					$threadOriginal->getMessages ()->initialize ();
					$unreadCount = 0;
					foreach ( $threadOriginal->getMessages () as $message ) {
						if ($message->getSender ()->getId () !== $userId) {
							$message->getMetadata ()->initialize ();
							foreach ( $message->getMetadata () as $messageMetadata ) {
								if ($messageMetadata->getParticipant ()->getId () === $userId && ! $messageMetadata->getIsRead ()) {
									$unreadCount ++;
								}
							}
						}
					}
					$thread ['unreadCount'] = $unreadCount;
					$threads [] = $thread;
				}
			}
		}
		return $threads;
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
		$sender = $this->get ( 'user_service' )->getUserFromUsername( 'lookmarkd' );
		$existingThreadId = $this->getExistingThreadsForParticipants ( $sender->getId () );
		$threadBuilder = null;
		if (null == $existingThreadId) {
			$threadBuilder = $this->get ( 'fos_message.composer' )->newThread ();
		} else {
			$thread = $this->get ( 'fos_message.provider' )->getThread ( $existingThreadId );
			$threadBuilder = $this->get ( 'fos_message.composer' )->reply ( $thread );
		}
		$recipient = $this->getUser ();
		$messageBody = 'Hey there! Thanks for trying out Lookmarkd! If you have any thoughts, questions or concerns, please feel free to reply to this message.';
		$threadBuilder->addRecipient ( $recipient )->setSender ( $sender )->setSubject ( 'Welcome!' )->setBody ( $messageBody );
		$senderService = $this->get ( 'fos_message.sender' );
		$senderService->send ( $threadBuilder->getMessage () );
		
		return new JsonResponse ( array (
				'success' => true 
		) );
	}
	
	/**
	 * @Route("messages/get/{threadId}", name="messages_get", defaults={"threadId"=null})
	 *
	 * @param int $threadId        	
	 */
	public function getMessagesAction($threadId) {
		
		$provider = $this->get ( 'fos_message.provider' );
		$thread = $provider->getThread ( $threadId );
		$thread->getMessages ()->initialize ();
		$messages = array ();
		
		foreach ( $thread->getMessages () as $message ) {
			$sentOrRecieved = $message->getSender ()->getId () == $this->getUser ()->getId () ? 'sent' : 'recieved';
			$messages [] = array (
					'id' => $message->getId (),
					'sender' => $message->getSender ()->getId (),
					'created' => $message->getCreatedAt (),
					'body' => $message->getBody (),
					'sentOrRecieved' => $sentOrRecieved 
			);
		}
		
		return new JsonResponse ( $messages );
	}
	
	/**
	 * @Route("/messages/send/", name="messages_send")
	 *
	 * @param Request $request        	
	 */
	public function sendMessageAction(Request $request) {
		
		$threadId = $request->request->get ( 'threadId' );
		$message = $request->request->get ( 'message' );
		$provider = $this->get ( 'fos_message.provider' );
		$thread = $provider->getThread ( $threadId );
		
		$user = $this->getUser ();
		$messageBuilder = $this->get ( 'fos_message.composer' )->reply ( $thread )->setSender ( $user )->setBody ( $message );
		$senderService = $this->get ( 'fos_message.sender' );
		$senderService->send ( $messageBuilder->getMessage () );
		
		$recipient = null;
		foreach ( $thread->getMetadata () as $metadata ) {
			$participant = $metadata->getParticipant ();
			if ($participant->getId () != $user->getId()) {
				$recipient = $participant;
				break;
			}
		}
		
		$this->sendEmailNotificationForMessage ($user, $recipient, $message);
						
		return new JsonResponse ( 'success' );
	}
	
	/**
	 * @Route("/messages/new/{threadId}", name="get_new_messages", defaults={"threadId"=null})
	 *
	 * @param int $threadId        	
	 */
	public function getUnreadMessagesForThreadAction($threadId) {
		$provider = $this->get ( 'fos_message.provider' );
		$thread = $provider->getThread ( $threadId );
		$thread->getMessages ()->initialize ();
		$messages = array ();
		foreach ( $thread->getMessages () as $message ) {
			if ($message->getSender ()->getId () != $this->getUser ()->getId ()) {
				$sentOrRecieved = 'recieved';
				$messages [] = array (
						'id' => $message->getId (),
						'sender' => $message->getSender ()->getId (),
						'created' => $message->getCreatedAt (),
						'body' => $message->getBody (),
						'sentOrRecieved' => $sentOrRecieved 
				);
			}
		}
		return new JsonResponse ( $messages );
	}
	
	/**
	 * @Route("/messages/send/new", name="messages_send_new")
	 *
	 * @param Request $request        	
	 */
	public function sendNewMessageAction(Request $request) {
		$recipientUserName = $request->request->get ( 'recipientUserName' );
		$recipient = $this->get ( 'user_service' )->getUserFromUsername( $recipientUserName );
		$sender = $this->getUser ();
		$message = $request->request->get ( 'message' );
		$existingThreadId = $this->getExistingThreadsForParticipants ( $recipient->getId () );
		if (null == $existingThreadId) {
			$messageBuilder = $this->get ( 'fos_message.composer' )->newThread ()->addRecipient ( $recipient )->setSubject ( '' );
		} else {
			$thread = $this->get ( 'fos_message.provider' )->getThread ( $existingThreadId );
			$messageBuilder = $this->get ( 'fos_message.composer' )->reply ( $thread );
		}
		$messageBuilder->setSender ( $sender )->setBody ( $message );
		$senderService = $this->get ( 'fos_message.sender' );
		$senderService->send ( $messageBuilder->getMessage () );
		
		$user = $this->getUser();
		
		$this->sendEmailNotificationForMessage ($user, $recipient, $message);

		
		return new JsonResponse ( 'success' );
	}
	/**
	 * 
	 */
	 private function sendEmailNotificationForMessage(User $user, User $recipient, $message) {
	 	$userPreference = $this->get('user_service')->getUserPreference($recipient, 'email_notification_messages');
	 	if(null === $userPreference || (null!=$userPreference && $userPreference->getValue() == 1)) {
			$email = \Swift_Message::newInstance ()
						->setSubject ( 'New message on Lookmarkd from '.$user->getUsername() )
						->setFrom ( array('hello@lookmarkd.com'=>'Lookmarkd' ))
						->setTo ($recipient->getEmail())
						->setBody ( $this->renderView('email/new-message.html.twig',
								array('message'=>$message,'sender'=>$user->getUsername())), 'text/html' );
			
			$this->get('mailer')->send($email);
	 	}
	}

	private function getExistingThreadsForParticipants($recipientParticipantId) {
		$provider = $this->get ( 'fos_message.provider' );
		$threadsOriginal = $provider->getInboxThreads ();
		$sentThreadsOriginal = $provider->getSentThreads ();
		$allOriginalThreads = array_merge ( $threadsOriginal, $sentThreadsOriginal );
		$threadId = null;
		if (null != $allOriginalThreads && sizeof ( $threadsOriginal ) > 0) {
			foreach ( $threadsOriginal as $threadOriginal ) {
				$threadOriginal->getMetadata ()->initialize ();
				if (sizeof ( $threadOriginal->getMetadata () ) == 2) {
					foreach ( $threadOriginal->getMetadata () as $metadata ) {
						$participantId = $metadata->getParticipant ()->getId ();
						if ($participantId == $recipientParticipantId) {
							$threadId = $threadOriginal->getId ();
							break;
						}
					}
				}
				if (null != $threadId) {
					break;
				}
			}
		}
		return $threadId;
	}
	
	/**
	 * @Route("/messages/is/valid/recieipent/{recipientName}", name="messages_validate_recipient", defaults={"recipientName"=null})
	 *
	 * @param string $recipientName        	
	 */
	public function isValidRecipientAction($recipientName) {
		$possibleRecipients = $this->get ( 'user_service' )->getPossibleRecipientsForUser ( $this->getUser (), null );
		$success = false;
		if (in_array ( $recipientName, $possibleRecipients )) {
			$success = true;
		}
		return new JsonResponse ( array (
				'success' => $success 
		) );
	}
	
	/**
	 * @Route("/messages/unread/count/", name="messages_unread_count")
	 */
	public function getTotalUnreadMessagesAction() {
		$provider = $this->get ( 'fos_message.provider' );
		$unreadCount = $provider->getNbUnreadMessages ();
		return new JsonResponse ( array (
				'success' => true,
				'unreadCount' => $unreadCount 
		) );
	}
	
	/**
	 * @Route("/messages/threads/information/", name="messages_threads_information")
	 */
	public function getThreadsInformationAction() {
		$threads = $this->getThreads ();
		return new JsonResponse ( $threads );
	}
}