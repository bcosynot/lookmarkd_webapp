<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller {
	/**
	 * @Route("/login/success/", name="loginSuccess")
	 */
	public function loginSuccessAction() {
		$securityContext = $this->container->get ( 'security.authorization_checker' );
		$logger = $this->get('logger');
		$logger->info('inside login success');
		if ($securityContext->isGranted ( 'IS_AUTHENTICATED_REMEMBERED' ) || $securityContext->isGranted ( 'ROLE_USER' )
				|| $securityContext->isGranted('ROLE_PREVIOUS_ADMIN')) {
			$user = $this->getUser ();
			$logger->info('authenticated:'.$user->getUsername());
			$this->get('social_profile_util')->updateSocialStatisticsIfNecessary($user);
			if (null != $user && null === $user->getEmail () || ! (null !== $user->getEmail () && strlen ( $user->getEmail () ) > 0 && strpos ( $user->getEmail (), '@' ))) {
				$logger->info('missingemail');
				return $this->redirectToRoute ( 'missingEmail' );
			} else if(null != $user && null === $user->getUserType()) {
				$logger->info('missing usertype');
				return $this->redirectToRoute ( 'missing_user_type' );
			}else {
				$logger->info('dashboard');
				return $this->redirectToRoute ( 'dashboard' );
			}
		} else {
			$logger->info('going back to homepage');
			return $this->redirectToRoute ( 'homepage' );
		}
	}
	
	/**
	 * @Route("/login/missing/email", name="missingEmail")
	 */
	public function missingEmailAction(Request $request) {
		$securityContext = $this->container->get ( 'security.authorization_checker' );
		if ($securityContext->isGranted ( 'IS_AUTHENTICATED_REMEMBERED' )) {
			$user = $this->getUser ();
			$user = $this->getUser ();
			$form = $this->createFormBuilder ( $user )->add ( 'email', 'Symfony\Component\Form\Extension\Core\Type\EmailType' )->add ( 'save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array (
					'label' => 'All done!',
					'attr' => array (
							'class' => 'btn btn-lg btn-green subscribe-submit' 
					) 
			) )->getForm ();
			
			$form->handleRequest ( $request );
			if ($form->isValid ()) {
				$this->get ( 'fos_user.user_manager' )->updateUser ( $user );
				$email = \Swift_Message::newInstance ()
							->setSubject ( 'Welcome to Lookmarkd!' )
							->setFrom ( array('hello@lookmarkd.com'=>'Lookmarkd') )
							->setTo ($user->getEmail())
							->setBody ( $this->renderView('email/welcome.html.twig'),'text/html' );
				$this->get('mailer')->send($email);
				return $this->redirectToRoute('loginSuccess');
			}
			return $this->render ( 'controller/login/missing_email.html.twig', array (
					'userId' => $user->getId (),
					'form' => $form->createView () 
			) );
		} else {
			return $this->redirectToRoute ( 'homepage' );
		}
	}
	
	
	/**
	 * @Route("/login/missing/user_type", name="missing_user_type")
	 */
	public function missingUserTypeAction() {
		return $this->render('controller/login/user_type.html.twig');
	}
	
	/**
	 * @Route("/login/missing/user_type/set/{type}", name="set_missing_user_type")
	 * @param integer $type The user type. @see User
	 */
	public function setMissingUserTypeAction($type) {
		$user = $this->getUser();
		$user->setUserType($type);
		$this->get ( 'fos_user.user_manager' )->updateUser ( $user );
		return $this->redirectToRoute('loginSuccess');
	}
}
