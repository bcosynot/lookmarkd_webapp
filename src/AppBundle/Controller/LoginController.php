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
		$user = $this->getUser();
		
		if (null === $user->getEmail () || ! (null !== $user->getEmail () && strlen ( $user->getEmail () ) > 0 && strpos ( $user->getEmail (), '@' ))) {
			return $this->redirectToRoute ( 'missingEmail' );
		} else {
		}
		return array ();
		// ...
	}
	
	/**
	 * @Route("/login/missing/email", name="missingEmail")
	 */
	public function missingEmailAction(Request $request) {
		$user = $this->getUser();
		$form = $this->createFormBuilder($user)
						->add('email','email')
						->add('save','submit', array('label'=>'All done!','attr' => array('class'=>'btn btn-lg btn-green subscribe-submit'),))
						->getForm();
		
		$form->handleRequest($request);
		if($form->isValid()) {
			$this->get('fos_user.user_manager')->updateUser($user);
		}
		return $this->render('controller/login/missing_email.html.twig', array('userId'=>$user->getId(),'form'=>$form->createView(),));
	}
}
