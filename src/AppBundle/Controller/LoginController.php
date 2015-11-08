<?php

namespace AppBundle\Controller;

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
		if ($securityContext->isGranted ( 'IS_AUTHENTICATED_REMEMBERED' ) || $securityContext->isGranted ( 'ROLE_USER' )) {
			$user = $this->getUser ();
			$logger->info('authenticated:'.$user->getUsername());
			if (null != $user && null === $user->getEmail () || ! (null !== $user->getEmail () && strlen ( $user->getEmail () ) > 0 && strpos ( $user->getEmail (), '@' ))) {
				$logger->info('missingemail');
				return $this->redirectToRoute ( 'missingEmail' );
			} else {
				$logger->info('dashboard');
				return $this->redirectToRoute ( 'dashboard_influencer' );
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
			$form = $this->createFormBuilder ( $user )->add ( 'email', 'email' )->add ( 'save', 'submit', array (
					'label' => 'All done!',
					'attr' => array (
							'class' => 'btn btn-lg btn-green subscribe-submit' 
					) 
			) )->getForm ();
			
			$form->handleRequest ( $request );
			if ($form->isValid ()) {
				$this->get ( 'fos_user.user_manager' )->updateUser ( $user );
			}
			return $this->render ( 'controller/login/missing_email.html.twig', array (
					'userId' => $user->getId (),
					'form' => $form->createView () 
			) );
		} else {
			return $this->redirectToRoute ( 'homepage' );
		}
	}
}
