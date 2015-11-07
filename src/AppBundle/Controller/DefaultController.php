<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
    	$securityContext = $this->container->get('security.authorization_checker');
    	if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
    		$this->get('logger')->info('auth');
    		return $this->redirectToRoute('loginSuccess');
    	}
    	
        return $this->render('controller/default/index.html.twig');
    }
}
