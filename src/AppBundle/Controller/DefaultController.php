<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
	/**
	 * @Route("/", name="homepage")
	 */
	public function indexAction() {
		$securityContext = $this->container->get ( 'security.authorization_checker' );
		if ($securityContext->isGranted ( 'IS_AUTHENTICATED_REMEMBERED' ) && ! ($securityContext->isGranted ( 'IS_AUTHENTICATED_ANONYMOUSLY' ))) {
			$this->get ( 'logger' )->info ( 'auth' );
			return $this->redirectToRoute ( 'loginSuccess' );
		}
		
		return $this->render ( 'controller/default/index.html.twig' );
	}
	
	/**
	 * @Route("/influencer/how-it-works", name="how_it_works_influencer")
	 */
	public function howItWorksInfluencerAction() {	
		return $this->render ( 'controller/default/how_it_works_influencer.html.twig' );
	}
	
	/**
	 * @Route("/brand/how-it-works", name="how_it_works_brand")
	 */
	public function howItWorksBrandAction() {
		return $this->render ( 'controller/default/how_it_works_brand.html.twig' );
	}

	/**
	 * @Route("/login-form", name="ajax-login-form")
	 */
	public function loginForForAJAXAction() {
		return $this->render ( 'controller/default/login-form.html.twig' );
	}

	/**
	 * @Route("/tos-privacy", name="tos_and_privacy_policy")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
	public function tosAndPrivacyPolicyAction() {
		return $this->render('controller/default/tos_and_privacy_policy.html.twig');
	}
}
