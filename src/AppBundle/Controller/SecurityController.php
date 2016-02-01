<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\User;

class SecurityController extends Controller
{
    /**
     * @Route("/brand/login", name="brand_login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'controller/security/brand_login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * @Route("/brand/login/check", name="brand_login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
    * @Route("/brand/login/success", name="brand_login_success")
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
				$logger->info('campaign create');
				return $this->redirectToRoute ( 'campaign_create' );
			}
		}
    }
}
